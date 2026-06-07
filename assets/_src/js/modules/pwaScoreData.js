const $daftplugAdmin = document.getElementById('daftplugAdmin');
const jsVars = window[`intasela_pwa_admin_js_vars`] || {};

class PwaScoreDataManager {
  constructor() {
    this.scoreData = null;

    // UI elements
    this.pwaScoreResult = $daftplugAdmin.querySelector('#pwaScoreResult');
    this.pwaScoreProgressbar = $daftplugAdmin.querySelector('#pwaScoreProgressbar');
    this.pwaScoreActions = $daftplugAdmin.querySelector('#pwaScoreActions');
  }

  init() {
    
    this.loadData();
  }

  

  async loadData() {
    try {
      const response = await fetch(`${wpApiSettings.root}intasela-pwa/v1/pwa-score/fetch`, {
        credentials: 'same-origin',
        headers: {
          'X-WP-Nonce': wpApiSettings.nonce,
        },
      });

      if (!response.ok) throw new Error('Network response was not ok');

      const result = await response.json();
      if (result.status === 'success') {
        this.scoreData = result.data;
        this.generateScoreResult(this.scoreData.scoreResult);
        this.generateScoreProgressbar(this.scoreData.scorePercent, this.scoreData.scoreResult);
        
      }
    } catch (error) {
      console.error('Error loading PWA score data:', error);
    }
  }

  generateScoreProgressbar(scorePercent, scoreResult) {
    this.pwaScoreProgressbar.innerHTML = `
      <div class="flex items-center w-full h-2.5 bg-gradient-to-r from-red-500 via-yellow-400 via-90% to-green-400 rounded-full before:relative before:start-[--progressVal] before:w-2 before:h-5 before:bg-gray-700 before:border-2 before:border-white before:rounded-full" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="${scorePercent}" style="--progressVal: calc(${scorePercent}% - 0.5rem / 2);"></div>
    `;
  }

  generateScoreResult(scoreResult) {
    let resultColorClass;
    let resultIconClass;

    switch (scoreResult) {
      case 'Bad':
        resultColorClass = 'bg-red-100 text-red-800';
        resultIconClass = 'bg-red-500';
        break;
      case 'Average':
        resultColorClass = 'bg-orange-100 text-orange-800';
        resultIconClass = 'bg-orange-500';
        break;
      case 'Good':
        resultColorClass = 'bg-yellow-100 text-yellow-800';
        resultIconClass = 'bg-yellow-500';
        break;
      case 'Excellent':
        resultColorClass = 'bg-green-100 text-green-800';
        resultIconClass = 'bg-green-500';
        break;
      default:
        break;
    }

    this.pwaScoreResult.innerHTML = `
      <span class="py-1 ps-1.5 pe-2 inline-flex items-center gap-x-1.5 text-xs font-medium rounded-full ${resultColorClass}">
        <span class="inline-block shrink-0 size-2.5 rounded-full ${resultIconClass}"></span>
        <span>${scoreResult}</span>
      </span>
    `;
  }

  
}

export function initPwaScoreData() {
  const pwaScoreDataManager = new PwaScoreDataManager();
  pwaScoreDataManager.init();
}
