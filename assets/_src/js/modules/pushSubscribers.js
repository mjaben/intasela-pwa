const $daftplugAdmin = document.getElementById('daftplugAdmin');

class SubscriberManager {
  constructor(container) {
    this.container = container;
    this.thead = container.querySelector('table thead');
    this.tbody = container.querySelector('table tbody');
    this.sendNotificationButton = container.querySelector('#send-notification-button');
    this.pagination = container.querySelector('#pagination');
    this.prevBtn = container.querySelector('#prevButton');
    this.nextBtn = container.querySelector('#nextButton');
    this.totalDisplay = container.querySelector('#totalSubscribers');
    this.currentPage = 1;
    this.totalPages = 1;
    this.isLoading = false;
  }

  init() {
    this.setupEventListeners();
    this.loadSubscribers(1);
  }

  setupEventListeners() {
    this.prevBtn?.addEventListener('click', () => this.handlePageChange('prev'));
    this.nextBtn?.addEventListener('click', () => this.handlePageChange('next'));
    this.container.addEventListener('click', (e) => this.handleSubscriberActions(e));
  }

  async handlePageChange(direction) {
    if (this.isLoading) return;

    const newPage = direction === 'prev' ? this.currentPage - 1 : this.currentPage + 1;
    if (newPage < 1 || newPage > this.totalPages) return;

    this.currentPage = newPage;
    await this.loadSubscribers(this.currentPage);
  }

  async loadSubscribers(page) {
    try {
      const url = new URL(`${wpApiSettings.root}intasela-pwa/v1/push-subscribers/fetch`);
      url.searchParams.append('page', page);

      const response = await fetch(url, {
        method: 'GET',
        credentials: 'same-origin',
        headers: {
          'X-WP-Nonce': wpApiSettings.nonce,
        },
      });

      if (!response.ok) throw new Error('Failed to load subscribers');

      const result = await response.json();
      if (result.status === 'success') {
        this.updateSubscribersList(result.data);
        this.updatePagination(result.data);
      }
    } catch (error) {
      console.error('Error loading subscribers:', error);
    }
  }

  updateSubscribersList(data) {
    if (!Array.isArray(data.subscribers) || data.subscribers.length === 0) {
      this.tbody.innerHTML = `
        <tr>
          <td colspan="5">
            <div class="p-5 min-h-56 flex flex-col justify-center items-center text-center">
              <svg class="w-48 mx-auto" viewBox="0 0 178 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="19.5" y="28.5" width="139" height="39" rx="7.5" fill="currentColor" class="fill-white"></rect>
                <rect x="19.5" y="28.5" width="139" height="39" rx="7.5" stroke="currentColor" class="stroke-gray-100"></rect>
                <rect x="27" y="36" width="24" height="24" rx="12" fill="currentColor" class="fill-gray-100"></rect>
                <rect x="59" y="39" width="60" height="6" rx="3" fill="currentColor" class="fill-gray-100"></rect>
                <rect x="59" y="51" width="92" height="6" rx="3" fill="currentColor" class="fill-gray-100"></rect>
                <g filter="url(#filter1)">
                  <rect x="12" y="6" width="154" height="40" rx="8" class="fill-white" shape-rendering="crispEdges"></rect>
                  <rect x="12.5" y="6.5" width="153" height="39" rx="7.5" stroke="currentColor" class="stroke-gray-100" shape-rendering="crispEdges"></rect>
                  <rect x="20" y="14" width="24" height="24" rx="12" fill="currentColor" class="fill-gray-200"></rect>
                  <rect x="52" y="17" width="60" height="6" rx="3" fill="currentColor" class="fill-gray-200"></rect>
                  <rect x="52" y="29" width="106" height="6" rx="3" fill="currentColor" class="fill-gray-200"></rect>
                </g>
                <defs>
                  <filter id="filter1" x="0" y="0" width="178" height="64" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                    <feOffset dy="6"></feOffset>
                    <feGaussianBlur stdDeviation="6"></feGaussianBlur>
                    <feComposite in2="hardAlpha" operator="out"></feComposite>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"></feColorMatrix>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1187_14810"></feBlend>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1187_14810" result="shape"></feBlend>
                  </filter>
                </defs>
              </svg>
              <div class="max-w-sm mx-auto">
                <p class="mt-2 text-base font-medium text-gray-800">
                  ${wp.i18n.__('No Subscribers', 'intasela-pwa')}
                </p>
                <p class="text-sm text-gray-500">
                  ${wp.i18n.__('There are no push notification subscribers yet.', 'intasela-pwa')}
                </p>
              </div>
            </div>
          </td>
        </tr>
      `;

      this.totalDisplay.textContent = '0';
      this.thead?.classList.add('hidden');
      this.pagination?.classList.remove('inline-flex');
      this.pagination?.classList.add('hidden');
      this.sendNotificationButton?.classList.remove('inline-flex');
      this.sendNotificationButton?.classList.add('hidden');

      return;
    }

    this.tbody.innerHTML = data.subscribers.map((sub) => this.createSubscriberRow(sub)).join('');
    this.thead?.classList.remove('hidden');
    this.sendNotificationButton?.classList.remove('hidden');
    this.sendNotificationButton?.classList.add('inline-flex');

    if (this.totalDisplay) {
      this.totalDisplay.textContent = data.total.toLocaleString();
    }
  }

  createSubscriberRow(subscriber) {
    return `
      <tr>
        <td class="size-px whitespace-nowrap">
          <div class="px-6 py-2.5">
            <div class="flex items-center gap-x-1.5">
              <img class="inline-block w-auto h-5 rounded" src="${subscriber.country_icon}" alt="${subscriber.country_name}" />
              <div class="grow">
                <span class="block text-sm text-gray-800">${subscriber.country_name}</span>
              </div>
            </div>
          </div>
        </td>
        <td class="size-px whitespace-nowrap">
          <div class="px-6 py-2.5">
            <div class="flex items-center gap-x-1.5">
              <img class="inline-block size-5" src="${subscriber.os_icon}" alt="${subscriber.os_name}" />
              <div class="grow space-y-1">
                <span class="block text-sm text-gray-800">${subscriber.os_name}</span>
              </div>
            </div>
          </div>
        </td>
        <td class="size-px whitespace-nowrap">
          <div class="px-6 py-2.5">
            <div class="flex items-center gap-x-1.5">
              <img class="inline-block size-5" src="${subscriber.browser_icon}" alt="${subscriber.browser_name}" />
              <div class="grow space-y-1">
                <span class="block text-sm text-gray-800">${subscriber.browser_name}</span>
              </div>
            </div>
          </div>
        </td>
        <td class="size-px whitespace-nowrap">
          <div class="px-6 py-2.5">
            <span class="text-sm text-gray-500">${subscriber.date}</span>
          </div>
        </td>
        <td class="size-px whitespace-nowrap">
          <div class="px-6 py-1.5">
            <div class="group/dropdown relative inline-flex" data-dp-dropdown='{"trigger": "click"}'>
              <button type="button" class="dp-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-gray-700 align-middle data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-indigo-600 transition-all text-sm">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
              </button>
              <div class="dp-dropdown-menu group-data-[open=true]/dropdown:opacity-100 group-data-[open=true]/dropdown:visible absolute w-max min-w-40 transition-opacity duration-300 invisible opacity-0 z-10 bg-white rounded-xl shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)]">
                <button type="button" class="w-full flex items-center gap-x-2 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-gray-100 focus:ring-2 focus:ring-indigo-500" data-action="delete" data-endpoint="${subscriber.endpoint}">
                  <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"></path>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                    <line x1="10" x2="10" y1="11" y2="17"></line>
                    <line x1="14" x2="14" y1="11" y2="17"></line>
                  </svg>
                  ${wp.i18n.__('Delete', 'intasela-pwa')}
                </button>
              </div>
            </div>
          </div>
        </td>
      </tr>
    `;
  }

  updatePagination(data) {
    this.totalPages = data.pages;

    if (this.totalPages > 1) {
      this.pagination?.classList.remove('hidden');
      this.pagination?.classList.add('inline-flex');
    } else {
      this.pagination?.classList.add('hidden');
      this.pagination?.classList.remove('inline-flex');
    }

    if (this.pagination && data.total > 0) {
      this.prevBtn.disabled = this.currentPage === 1;
      this.nextBtn.disabled = this.currentPage === this.totalPages;
      this.prevBtn.dataset.disabled = (this.currentPage === 1).toString();
      this.nextBtn.dataset.disabled = (this.currentPage === this.totalPages).toString();
    }
  }

  toggleLoadingState(isLoading) {
    this.container.style.opacity = isLoading ? '0.5' : '1';
    this.container.style.pointerEvents = isLoading ? 'none' : 'auto';
    this.prevBtn.disabled = isLoading;
    this.nextBtn.disabled = isLoading;
  }

  async handleSubscriberActions(event) {
    const button = event.target.closest('button[data-action]');
    if (!button) return;

    const action = button.dataset.action;
    const endpoint = button.dataset.endpoint;

    switch (action) {
      case 'delete':
        await this.removeSubscriber(endpoint);
        break;
    }
  }

  async removeSubscriber(endpoint) {
    if (!confirm(wp.i18n.__('Are you sure you want to remove this subscriber?', 'intasela-pwa'))) return;

    try {
      this.isLoading = true;
      this.toggleLoadingState(true);
      const response = await fetch(`${wpApiSettings.root}intasela-pwa/v1/push-subscription/remove`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ endpoint }),
      });

      if (response.ok) {
        await this.loadSubscribers(this.currentPage);
      } else {
        throw new Error('Failed to remove subscriber');
      }
    } catch (error) {
      console.error('Error removing subscriber:', error);
    } finally {
      this.isLoading = false;
      this.toggleLoadingState(false);
    }
  }
}

export function initPushSubscribers() {
  const pushSubscribers = $daftplugAdmin.querySelector('#pushNotificationsSubscribers');
  if (!pushSubscribers) return;

  const subscriberManager = new SubscriberManager(pushSubscribers);
  subscriberManager.init();
}
