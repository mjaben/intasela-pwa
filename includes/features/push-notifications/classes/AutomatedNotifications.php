<?php

namespace Intasela\PWA\Features\PushNotifications;

use Intasela\PWA\Features\PushNotifications\Notifications;
use Intasela\PWA\Helpers\Utils;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class AutomatedNotifications {
    public function __construct() {
        // Core WordPress Content Hooks
        add_action( 'transition_post_status', [$this, 'handleNewContent'], 10, 3 );
        add_action( 'comment_post', [$this, 'handleNewComment'], 10, 3 );

        // FluentCommunity Hooks
        if ( defined( 'FLUENT_COMMUNITY_PLUGIN_VERSION' ) ) {
            add_action( 'fluent_community/feed/created', [$this, 'handleFluentNewPost'], 10, 1 );
            add_action( 'fluent_community/comment_added', [$this, 'handleFluentNewComment'], 10, 3 );
            add_action( 'fluent_community/feed_mentioned', [$this, 'handleFluentFeedMentioned'], 10, 2 );
        }

        // FluentMessaging Hooks (Chat)
        add_action( 'fluent_messaging/after_add_message', [$this, 'handleFluentNewMessage'], 10, 1 );
    }

    /**
     * Handle standard WordPress post published.
     */
    public function handleNewContent( $new_status, $old_status, $post ) {
        if ( $new_status !== 'publish' || $old_status === 'publish' ) {
            return;
        }

        if ( Utils::getSetting( 'pushAutomationNewContent' ) !== 'on' ) {
            return;
        }

        $allowed_post_types = \Intasela\PWA\Features\PushNotifications::getContentPostTypes();
        if ( !in_array( $post->post_type, $allowed_post_types ) ) {
            return;
        }

        $image = get_the_post_thumbnail_url( $post->ID, 'full' );
        
        $notificationData = [
            'title' => esc_html__( 'New Post Published', 'intasela-pwa' ),
            'body'  => $post->post_title,
            'data'  => [ 'url' => get_permalink( $post->ID ) ],
        ];

        if ( $image ) {
            $notificationData['image'] = $image;
        }

        Notifications::sendPushNotification( 'everyone', $notificationData );
    }

    /**
     * Handle standard WordPress new comment (reply).
     */
    public function handleNewComment( $comment_ID, $comment_approved, $commentdata ) {
        if ( Utils::getSetting( 'pushAutomationNewComment' ) !== 'on' ) {
            return;
        }

        // Only send if it's a reply to another comment
        if ( empty( $commentdata['comment_parent'] ) ) {
            return;
        }

        $parent_comment = get_comment( $commentdata['comment_parent'] );
        if ( !$parent_comment || empty( $parent_comment->user_id ) ) {
            return;
        }

        // Don't notify if user replies to themselves
        if ( $parent_comment->user_id == $commentdata['user_id'] ) {
            return;
        }

        $notificationData = [
            'title' => esc_html__( 'New Reply to Your Comment', 'intasela-pwa' ),
            'body'  => sprintf( esc_html__( '%s replied to your comment.', 'intasela-pwa' ), $commentdata['comment_author'] ),
            'data'  => [ 'url' => get_comment_link( $comment_ID ) ],
        ];

        Notifications::sendPushNotification( (int) $parent_comment->user_id, $notificationData );
    }

    /**
     * Handle FluentCommunity new post in a space.
     */
    public function handleFluentNewPost( $feed ) {
        if ( Utils::getSetting( 'pushAutomationFcNewPost' ) !== 'on' ) {
            return;
        }

        if ( !$feed || empty( $feed->space_id ) ) {
            return;
        }

        // Find users in the space
        try {
            $space_id = $feed->space_id;
            $users = \FluentCommunity\App\Models\XProfile::whereHas('spaces', function ($query) use ($space_id) {
                $query->withoutGlobalScopes()->where('space_id', $space_id);
            })->pluck('user_id')->toArray();
        } catch ( \Exception $e ) {
            return; // Fallback if schema differs
        }

        if ( empty( $users ) ) {
            return;
        }

        // Exclude the author
        $users = array_diff( $users, [$feed->user_id] );
        if ( empty( $users ) ) {
            return;
        }

        $author = get_userdata( $feed->user_id );
        $author_name = $author ? $author->display_name : 'Someone';

        $space_title = isset( $feed->space->title ) ? $feed->space->title : 'Space';

        $notificationData = [
            'title' => sprintf( esc_html__( 'New Post in %s', 'intasela-pwa' ), $space_title ),
            'body'  => sprintf( esc_html__( '%s created a new post.', 'intasela-pwa' ), $author_name ),
            'data'  => [ 'url' => method_exists($feed, 'getPermalink') ? $feed->getPermalink() : '' ],
        ];

        Notifications::sendPushNotification( array_values( $users ), $notificationData );
    }

    /**
     * Handle FluentCommunity mentions in a feed.
     */
    public function handleFluentFeedMentioned( $feed, $mentioned_users ) {
        if ( Utils::getSetting( 'pushAutomationFcMemberMention' ) !== 'on' ) {
            return;
        }

        if ( empty( $mentioned_users ) ) {
            return;
        }

        $author = get_userdata( $feed->user_id );
        $author_name = $author ? $author->display_name : 'Someone';

        $userIds = [];
        foreach ( $mentioned_users as $u ) {
            if ( is_object($u) ) {
                $userIds[] = isset($u->ID) ? $u->ID : (isset($u->id) ? $u->id : 0);
            } elseif ( is_array($u) ) {
                $userIds[] = isset($u['ID']) ? $u['ID'] : (isset($u['id']) ? $u['id'] : 0);
            } elseif ( is_numeric($u) ) {
                $userIds[] = $u;
            }
        }

        // Clean up user IDs
        $userIds = array_diff( array_unique( $userIds ), [$feed->user_id, 0] );

        if ( empty( $userIds ) ) {
            return;
        }

        $notificationData = [
            'title' => esc_html__( 'You were mentioned', 'intasela-pwa' ),
            'body'  => sprintf( esc_html__( '%s mentioned you in a post.', 'intasela-pwa' ), $author_name ),
            'data'  => [ 'url' => method_exists($feed, 'getPermalink') ? $feed->getPermalink() : '' ],
        ];

        Notifications::sendPushNotification( array_values( $userIds ), $notificationData );
    }

    /**
     * Handle FluentCommunity new comment.
     */
    public function handleFluentNewComment( $comment, $feed, $mentions ) {
        $author = get_userdata( $comment->user_id );
        $author_name = $author ? $author->display_name : 'Someone';
        $postUrl = method_exists($feed, 'getPermalink') ? $feed->getPermalink() : '';

        // Track who has been notified to prevent duplicate notifications from multiple triggers
        $notifiedUsers = [$comment->user_id]; // Exclude the comment author immediately

        // 1. Mentions inside the comment
        if ( Utils::getSetting( 'pushAutomationFcMemberMention' ) === 'on' && !empty( $mentions ) ) {
            $mentionedUserIds = [];
            foreach ( $mentions as $u ) {
                if ( is_object($u) ) {
                    $mentionedUserIds[] = isset($u->ID) ? $u->ID : (isset($u->id) ? $u->id : 0);
                } elseif ( is_array($u) ) {
                    $mentionedUserIds[] = isset($u['ID']) ? $u['ID'] : (isset($u['id']) ? $u['id'] : 0);
                } elseif ( is_numeric($u) ) {
                    $mentionedUserIds[] = $u;
                }
            }
            
            $mentionedUserIds = array_diff( array_unique( $mentionedUserIds ), $notifiedUsers, [0] );

            if ( !empty( $mentionedUserIds ) ) {
                $mentionData = [
                    'title' => esc_html__( 'You were mentioned', 'intasela-pwa' ),
                    'body'  => sprintf( esc_html__( '%s mentioned you in a comment.', 'intasela-pwa' ), $author_name ),
                    'data'  => [ 'url' => $postUrl ],
                ];
                Notifications::sendPushNotification( array_values( $mentionedUserIds ), $mentionData );
                $notifiedUsers = array_merge( $notifiedUsers, $mentionedUserIds );
            }
        }

        // 2. Notify Parent Commenter (Reply)
        if ( Utils::getSetting( 'pushAutomationFcMemberReply' ) === 'on' && !empty( $comment->parent_id ) ) {
            try {
                $parent = \FluentCommunity\App\Models\Comment::find( $comment->parent_id );
                if ( $parent && !in_array( $parent->user_id, $notifiedUsers ) ) {
                    $replyData = [
                        'title' => esc_html__( 'New Reply to your Comment', 'intasela-pwa' ),
                        'body'  => sprintf( esc_html__( '%s replied to your comment.', 'intasela-pwa' ), $author_name ),
                        'data'  => [ 'url' => $postUrl ],
                    ];
                    Notifications::sendPushNotification( (int) $parent->user_id, $replyData );
                    $notifiedUsers[] = $parent->user_id;
                }
            } catch ( \Exception $e ) {}
        }

        // 3. Notify Post Author
        if ( Utils::getSetting( 'pushAutomationFcAuthorComment' ) === 'on' ) {
            if ( !in_array( $feed->user_id, $notifiedUsers ) ) {
                $authorData = [
                    'title' => esc_html__( 'New Comment on your Post', 'intasela-pwa' ),
                    'body'  => sprintf( esc_html__( '%s commented on your post.', 'intasela-pwa' ), $author_name ),
                    'data'  => [ 'url' => $postUrl ],
                ];
                Notifications::sendPushNotification( (int) $feed->user_id, $authorData );
                $notifiedUsers[] = $feed->user_id;
            }
        }
    }

    /**
     * Handle FluentMessaging new chat message.
     */
    public function handleFluentNewMessage( $message ) {
        if ( Utils::getSetting( 'pushAutomationFcNewMessage' ) !== 'on' ) {
            return;
        }

        // Only process direct/group messages, avoid spamming large community chat rooms
        if ( !empty( $message->thread->space_id ) ) {
            return;
        }

        $sender_id = $message->user_id;
        
        // Find all active recipients in this thread, excluding the sender
        $recipientIds = \FluentMessaging\App\Models\ThreadUser::where( 'thread_id', $message->thread_id )
            ->where( 'user_id', '!=', $sender_id )
            ->where( 'status', 'active' )
            ->pluck( 'user_id' )
            ->toArray();

        if ( empty( $recipientIds ) ) {
            return;
        }

        $author = get_userdata( $sender_id );
        $author_name = $author ? $author->display_name : 'Someone';

        $notificationData = [
            'title' => esc_html__( 'New Chat Message', 'intasela-pwa' ),
            'body'  => sprintf( esc_html__( '%s sent you a message.', 'intasela-pwa' ), $author_name ),
            'data'  => [ 'url' => \FluentCommunity\App\Services\Helper::baseUrl( 'chat' ) ],
        ];

        Notifications::sendPushNotification( $recipientIds, $notificationData );
    }
}
