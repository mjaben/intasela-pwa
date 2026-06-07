import { initApexcharts } from '../components/apexcharts.js';

const $daftplugAdmin = document.getElementById('daftplugAdmin');
const jsVars = window[`intasela_pwa_admin_js_vars`] || {};

class PwaUsersDataManager {
  constructor() {
    this.usersData = null;
    this.chart = null;

    // UI elements
    this.activeUsersElement = $daftplugAdmin.querySelector('#activePwaUsers');
    this.chartContainer = $daftplugAdmin.querySelector('#pwaInstallsChart');
    
  }

  init() {
    initApexcharts();
    this.loadData();
  }

  async loadData() {
    try {
      const response = await fetch(`${wpApiSettings.root}intasela-pwa/v1/pwa-users/fetch`, {
        credentials: 'same-origin',
        headers: {
          'X-WP-Nonce': wpApiSettings.nonce,
        },
      });

      if (!response.ok) throw new Error('Network response was not ok');

      const result = await response.json();
      if (result.status === 'success') {
        this.usersData = result.data;
        this.updateUI();
      }
    } catch (error) {
      console.error('Error loading PWA users data:', error);
    }
  }

  prepareInstallationsData() {
    const today = new Date();
    today.setHours(23, 59, 59, 999);

    // Build a map of DB results keyed by "YYYY-MM-DD"
    const dbMap = new Map();
    if (this.usersData?.installations?.length) {
      this.usersData.installations.forEach((item) => {
        dbMap.set(item.date, parseInt(item.count));
      });
    }

    // Always produce all 30 days, filling gaps with 0
    const result = [];
    for (let i = 29; i >= 0; i--) {
      const d = new Date(today);
      d.setDate(d.getDate() - i);
      const key = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
      result.push({
        date: d.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }),
        shortDate: d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }),
        count: dbMap.get(key) || 0,
      });
    }
    return result;
  }

  updateUI() {
    this.updateActiveUsersCount(this.usersData.activeUsers);
    const installations = this.prepareInstallationsData();
    this.chart = this.createChart(
      installations.map((i) => i.shortDate),
      installations.map((i) => i.count),
      installations
    );
    
  }

  updateActiveUsersCount(active) {
    if (this.activeUsersElement) {
      this.activeUsersElement.textContent = active.toLocaleString();
    }
  }

  

  createChart(dates, counts, installations) {
    const emptyData = counts.every((c) => c === 0);
    const chartOptions = {
      chart: {
        type: 'line',
        height: 40,
        sparkline: { enabled: true },
        toolbar: { show: false },
        zoom: { enabled: false },
      },
      series: [
        {
          name: wp.i18n.__('PWA Installs', 'intasela-pwa'),
          data: counts,
        },
      ],
      colors: ['#2563eb'],
      markers: {
        size: 0,
        hover: { size: 4 },
      },
      stroke: {
        curve: 'smooth',
        width: 2,
        colors: ['#2563eb'],
      },
      xaxis: {
        type: 'category',
        categories: dates, // short label
        crosshairs: {
          show: false,
        },
        tooltip: {
          enabled: false,
        },
        labels: {
          style: {
            colors: '#9ca3af',
            fontSize: '13px',
            fontFamily: 'Inter, ui-sans-serif',
            fontWeight: 400,
          },
        },
      },
      yaxis: {
        min: emptyData ? 0 : undefined,
        max: emptyData ? 10 : undefined,
        labels: {
          align: 'left',
          style: {
            colors: '#9ca3af',
            fontSize: '12px',
            fontFamily: 'Inter, ui-sans-serif',
            fontWeight: 400,
          },
          formatter: (val) => (val >= 1000 ? `${val / 1000}k` : val),
        },
      },
      tooltip: {
        custom: ({ series, seriesIndex, dataPointIndex }) => {
          if (dataPointIndex == null || dataPointIndex < 0 || dataPointIndex >= installations.length) {
            return '';
          }
          const dateLabel = installations[dataPointIndex].date;
          const installCount = series[seriesIndex][dataPointIndex] || 0;

          return `
            <div class="ms-0.5 mb-2 bg-white border border-gray-200 text-gray-800 rounded-lg shadow-md min-w-32">
              <div class="apexcharts-tooltip-title font-semibold !text-sm !bg-white !border-gray-200 text-gray-800 rounded-t-lg">
                ${dateLabel}
              </div>
              <div class="apexcharts-tooltip-series-group !flex !justify-between order-1 text-[12px]">
                <span class="flex items-center">
                  <span class="apexcharts-tooltip-marker !w-2.5 !h-2.5 !me-1.5 !rounded-sm" style="background: #2563eb"></span>
                  <div class="apexcharts-tooltip-text">
                    <div class="apexcharts-tooltip-y-group !py-0.5">
                      <span class="apexcharts-tooltip-text-y-value !font-medium text-gray-500 !ms-auto">
                        ${wp.i18n.__('PWA Installs', 'intasela-pwa')}:
                      </span>
                    </div>
                  </div>
                </span>
                <span class="apexcharts-tooltip-text-y-label text-gray-500 ms-2">
                  ${installCount}
                </span>
              </div>
            </div>
          `;
        },
      },
    };

    const chart = new ApexCharts(this.chartContainer, chartOptions);
    chart.render();
    return chart;
  }
}

export function initPwaUsersData() {
  const pwaUsersDataManager = new PwaUsersDataManager();
  pwaUsersDataManager.init();
}
