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
        }
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
        $space_slug = isset( $feed->space->slug ) ? $feed->space->slug : '';

        $notificationData = [
            'title' => sprintf( esc_html__( 'New Post in %s', 'intasela-pwa' ), $space_title ),
            'body'  => sprintf( esc_html__( '%s created a new post.', 'intasela-pwa' ), $author_name ),
            'data'  => [ 'url' => \FluentCommunity\App\Services\Helper::baseUrl( 'space/' . $space_slug . '/post/' . $feed->id ) ],
        ];

        Notifications::sendPushNotification( array_values( $users ), $notificationData );
    }

    /**
     * Handle FluentCommunity new comment.
     */
    public function handleFluentNewComment( $comment, $feed, $mentions ) {
        if ( Utils::getSetting( 'pushAutomationFcNewComment' ) !== 'on' ) {
            return;
        }

        $author = get_userdata( $comment->user_id );
        $author_name = $author ? $author->display_name : 'Someone';

        $usersToNotify = [];

        // Notify the post author
        if ( $feed->user_id != $comment->user_id ) {
            $usersToNotify[] = $feed->user_id;
        }

        // Notify parent comment author if it's a reply
        if ( !empty( $comment->parent_id ) ) {
            try {
                $parent = \FluentCommunity\App\Models\Comment::find( $comment->parent_id );
                if ( $parent && $parent->user_id != $comment->user_id ) {
                    $usersToNotify[] = $parent->user_id;
                }
            } catch ( \Exception $e ) {}
        }

        $usersToNotify = array_unique( $usersToNotify );

        if ( empty( $usersToNotify ) ) {
            return;
        }

        $space_slug = isset( $feed->space->slug ) ? $feed->space->slug : '';

        $notificationData = [
            'title' => esc_html__( 'New Comment on Post', 'intasela-pwa' ),
            'body'  => sprintf( esc_html__( '%s commented on a post.', 'intasela-pwa' ), $author_name ),
            'data'  => [ 'url' => \FluentCommunity\App\Services\Helper::baseUrl( 'space/' . $space_slug . '/post/' . $feed->id ) ],
        ];

        Notifications::sendPushNotification( array_values( $usersToNotify ), $notificationData );
    }
}
