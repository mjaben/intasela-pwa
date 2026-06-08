document.addEventListener('DOMContentLoaded', function () {
  const installPromptJsVars = window['intasela_pwa_install_prompt_js_vars'] || {};

  let deferredInstallPrompt = null;

  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredInstallPrompt = e;
  });

  window.addEventListener('appinstalled', () => {
    deferredInstallPrompt = null;
  });

  const svg = {
    vertThreeDots: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M480-160q-33 0-56.5-23.5T400-240q0-33 23.5-56.5T480-320q33 0 56.5 23.5T560-240q0 33-23.5 56.5T480-160Zm0-240q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm0-240q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Z"/></svg>',
    horizThreeDots: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/></svg>',
    iosShare: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M240-40q-33 0-56.5-23.5T160-120v-440q0-33 23.5-56.5T240-640h80q17 0 28.5 11.5T360-600q0 17-11.5 28.5T320-560h-80v440h480v-440h-80q-17 0-28.5-11.5T600-600q0-17 11.5-28.5T640-640h80q33 0 56.5 23.5T800-560v440q0 33-23.5 56.5T720-40H240Zm200-727-36 36q-12 12-28 11.5T348-732q-11-12-11.5-28t11.5-28l104-104q12-12 28-12t28 12l104 104q11 11 11 27.5T612-732q-12 12-28.5 12T555-732l-35-35v407q0 17-11.5 28.5T480-320q-17 0-28.5-11.5T440-360v-407Z"/></svg>',
    plusInBox: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M440-440v120q0 17 11.5 28.5T480-280q17 0 28.5-11.5T520-320v-120h120q17 0 28.5-11.5T680-480q0-17-11.5-28.5T640-520H520v-120q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640v120H320q-17 0-28.5 11.5T280-480q0 17 11.5 28.5T320-440h120ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>',
    tapFinger: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M419-80q-28 0-52.5-12T325-126L124-381q-8-9-7-21.5t9-20.5q20-21 48-25t52 11l74 45v-328q0-17 11.5-28.5T340-760q17 0 29 11.5t12 28.5v400q0 23-20.5 34.5T320-286l-36-22 104 133q6 7 14 11t17 4h221q33 0 56.5-23.5T720-240v-160q0-17-11.5-28.5T680-440H501q-17 0-28.5-11.5T461-480q0-17 11.5-28.5T501-520h179q50 0 85 35t35 85v160q0 66-47 113T640-80H419Zm83-260Zm-23-260q-17 0-28.5-11.5T439-640q0-2 5-20 8-14 12-28.5t4-31.5q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 17 4 31.5t12 28.5q3 5 4 10t1 10q0 17-11 28.5T202-600q-11 0-20.5-6T167-621q-13-22-20-47t-7-52q0-83 58.5-141.5T340-920q83 0 141.5 58.5T540-720q0 27-7 52t-20 47q-5 9-14 15t-20 6Z"/></svg>',
    hamburgerMenu: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M160-240q-17 0-28.5-11.5T120-280q0-17 11.5-28.5T160-320h640q17 0 28.5 11.5T840-280q0 17-11.5 28.5T800-240H160Zm0-200q-17 0-28.5-11.5T120-480q0-17 11.5-28.5T160-520h640q17 0 28.5 11.5T840-480q0 17-11.5 28.5T800-440H160Zm0-200q-17 0-28.5-11.5T120-680q0-17 11.5-28.5T160-720h640q17 0 28.5 11.5T840-680q0 17-11.5 28.5T800-640H160Z"/></svg>',
    upload: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M240-160q-33 0-56.5-23.5T160-240v-80q0-17 11.5-28.5T200-360q17 0 28.5 11.5T240-320v80h480v-80q0-17 11.5-28.5T760-360q17 0 28.5 11.5T800-320v80q0 33-23.5 56.5T720-160H240Zm200-486-75 75q-12 12-28.5 11.5T308-572q-11-12-11.5-28t11.5-28l144-144q6-6 13-8.5t15-2.5q8 0 15 2.5t13 8.5l144 144q12 12 11.5 28T652-572q-12 12-28.5 12.5T595-571l-75-75v286q0 17-11.5 28.5T480-320q-17 0-28.5-11.5T440-360v-286Z"/></svg>',
    safari:
      '<svg style="width:1.5rem;height:1.5rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5120 5120"><linearGradient x2="0" y2="100%" id="a"><stop offset="0" stop-color="#19d7ff"/><stop offset="1" stop-color="#1e64f0"/></linearGradient><circle cx="2560" cy="2560" r="2240" fill="url(#a)"/><path fill="red" d="M4090 1020 2370 2370l4e2 4e2z"/><path fill="#fff" d="M1020 4090l1350-1720 4e2 4e2z"/><path stroke="#fff" stroke-width="30" d="M2560 540v330m0 3370v330m350-4e3-57 325m-586 3318-57 327M3250 662l-113 310M1984 4138l-113 310m339-3878 57 325m586 3318 57 327M1870 662l113 310m1152 3166 113 310M1552 810l166 286m1685 2918 165 286M1265 1010l212 253m2166 2582 212 253M1015 1258l253 212m2582 2168 253 212M813 1548l286 165m2920 1685 286 165M665 1866l310 113m3166 1150 310 113M574 2202l326 58m3320 588 325 57M545 2555h330m3370 0h330M575 2905l325-57m3320-586 325-57M668 3245l310-113m3165-1152 310-113M815 3563l286-165m2920-1685 286-165M1016 3850l253-212m2580-2166 253-212M1262 41e2l212-253m2166-2582 212-253M1552 43e2l166-286m1685-2918 165-286M2384 548l16 180m320 3656 16 180M2038 610l47 174m950 3544 47 174M1708 730l76 163m1550 3326 77 163M1404 904l103 148m2106 3006 103 148M1135 1130l127 127m2596 2596 127 127M910 14e2l148 103m3006 2107 146 1e2M734 1703l163 76m3326 1550 163 77M614 2033l174 47m3544 950 174 47M553 2380l180 16m3656 320 180 16m-4014 0 180-16m3656-320 180-16M614 3077l174-47m3544-950 174-47M734 3407l163-76m3326-1550 163-76M910 3710l148-103m3006-2107 146-1e2M1404 4206l103-148m2105-3006 104-148M1708 4380l77-163M3335 890l77-163M2038 45e2l47-174m950-3544 47-174m-698 3952 16-180m320-3656 16-180"/></svg>',
    googleChrome:
      '<svg style="width:1.5rem;height:1.5rem;" xmlns="http://www.w3.org/2000/svg" viewBox="-10 -10 276 276"><linearGradient id="a" x1="145" x2="34" y1="253" y2="61" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#1e8e3e"/><stop offset="1" stop-color="#34a853"/></linearGradient><linearGradient id="b" x1="111" x2="222" y1="254" y2="62" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#fcc934"/><stop offset="1" stop-color="#fbbc04"/></linearGradient><linearGradient id="c" x1="17" x2="239" y1="80" y2="80" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#d93025"/><stop offset="1" stop-color="#ea4335"/></linearGradient><circle cx="128" cy="128" r="64" fill="#fff"/><path fill="url(#a)" d="M96 183.4A63.7 63.7 0 0 1 72.6 160L17.2 64A128 128 0 0 0 128 256l55.4-96A64 64 0 0 1 96 183.4Z"/><path fill="url(#b)" d="M192 128a63.7 63.7 0 0 1-8.6 32L128 256A128 128 0 0 0 238.9 64h-111a64 64 0 0 1 64 64Z"/><circle cx="128" cy="128" r="52" fill="#1a73e8"/><path fill="url(#c)" d="M96 72.6a63.7 63.7 0 0 1 32-8.6h110.8a128 128 0 0 0-221.7 0l55.5 96A64 64 0 0 1 96 72.6Z"/></svg>',
    copy: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M360-240q-33 0-56.5-23.5T280-320v-480q0-33 23.5-56.5T360-880h360q33 0 56.5 23.5T800-800v480q0 33-23.5 56.5T720-240H360Zm0-80h360v-480H360v480ZM200-80q-33 0-56.5-23.5T120-160v-520q0-17 11.5-28.5T160-720q17 0 28.5 11.5T200-680v520h400q17 0 28.5 11.5T640-120q0 17-11.5 28.5T600-80H200Zm160-240v-480 480Z"/></svg>',
    pasteGo: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M727-240H520q-17 0-28.5-11.5T480-280q0-17 11.5-28.5T520-320h207l-36-36q-11-11-11-27.5t12-28.5q11-11 28-11t28 11l104 104q12 12 12 28t-12 28L748-148q-12 12-28 11.5T692-149q-11-12-11.5-28t11.5-28l35-35ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h167q11-35 43-57.5t70-22.5q40 0 71.5 22.5T594-840h166q33 0 56.5 23.5T840-760v200q0 17-11.5 28.5T800-520q-17 0-28.5-11.5T760-560v-200h-80v80q0 17-11.5 28.5T640-640H320q-17 0-28.5-11.5T280-680v-80h-80v560h160q17 0 28.5 11.5T400-160q0 17-11.5 28.5T360-120H200Zm280-640q17 0 28.5-11.5T520-800q0-17-11.5-28.5T480-840q-17 0-28.5 11.5T440-800q0 17 11.5 28.5T480-760Z"/></svg>',
    installDesktop: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M320-160v-40H160q-33 0-56.5-23.5T80-280v-480q0-33 23.5-56.5T160-840h280q17 0 28.5 11.5T480-800q0 17-11.5 28.5T440-760H160v480h640v-80q0-17 11.5-28.5T840-400q17 0 28.5 11.5T880-360v80q0 33-23.5 56.5T800-200H640v40q0 17-11.5 28.5T600-120H360q-17 0-28.5-11.5T320-160Zm320-393v-247q0-17 11.5-28.5T680-840q17 0 28.5 11.5T720-800v247l76-75q11-11 27.5-11.5T852-628q11 11 11 28t-11 28L708-428q-12 12-28 12t-28-12L508-572q-11-11-11.5-27.5T508-628q11-11 28-11t28 11l76 75Z"/></svg>',
    installMobile: '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M280-40q-33 0-56.5-23.5T200-120v-720q0-33 23.5-56.5T280-920h240q17 0 28.5 11.5T560-880q0 17-11.5 28.5T520-840H280v40h240q17 0 28.5 11.5T560-760q0 17-11.5 28.5T520-720H280v480h400v-40q0-17 11.5-28.5T720-320q17 0 28.5 11.5T760-280v160q0 33-23.5 56.5T680-40H280Zm0-120v40h400v-40H280Zm400-392v-248q0-17 11.5-28.5T720-840q17 0 28.5 11.5T760-800v248l76-76q11-11 28-11t28 11q11 11 11 28t-11 28L748-428q-12 12-28 12t-28-12L548-572q-11-11-11-28t11-28q11-11 28-11t28 11l76 76ZM280-800v-40 40Zm0 640v40-40Z"/></svg>',
    fileSave: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="m680-272-36-36q-11-11-28-11t-28 11q-11 11-11 28t11 28l104 104q12 12 28 12t28-12l104-104q11-11 11-28t-11-28q-11-11-28-11t-28 11l-36 36v-127q0-17-11.5-28.5T720-439q-17 0-28.5 11.5T680-399v127ZM600-80h240q17 0 28.5 11.5T880-40q0 17-11.5 28.5T840 0H600q-17 0-28.5-11.5T560-40q0-17 11.5-28.5T600-80Zm-360-80q-33 0-56.5-23.5T160-240v-560q0-33 23.5-56.5T240-880h247q16 0 30.5 6t25.5 17l194 194q11 11 17 25.5t6 30.5v48q0 17-11.5 28.5T720-519q-17 0-28.5-11.5T680-559v-41H540q-25 0-42.5-17.5T480-660v-140H240v560h200q17 0 28.5 11.5T480-200q0 17-11.5 28.5T440-160H240Zm0-80v-560 560Z"/></svg>',
    mouseClick: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M120-560h40q17 0 28.5 11.5T200-520q0 17-11.5 28.5T160-480h-40q-17 0-28.5-11.5T80-520q0-17 11.5-28.5T120-560Zm68 216 28-28q12-12 28-11.5t28 11.5q12 12 12.5 28.5T273-315l-28 28q-12 12-28.5 11.5T188-288q-11-12-11.5-28t11.5-28Zm28-324-28-28q-12-12-11.5-28t11.5-28q12-12 28.5-12.5T245-753l28 28q12 12 11.5 28.5T272-668q-12 11-28 11.5T216-668Zm476 480L530-350l-30 90q-2 7-7.5 10.5T481-246q-6 0-11.5-4t-7.5-11l-86-286q-2-8 .5-16t7.5-13q5-5 13-7.5t16-.5l288 86q7 2 10.5 7.5T715-479q0 6-3 11.5t-10 7.5l-90 32 160 160q12 12 12 28t-12 28l-24 24q-12 12-28 12t-28-12ZM400-760v-40q0-17 11.5-28.5T440-840q17 0 28.5 11.5T480-800v40q0 17-11.5 28.5T440-720q-17 0-28.5-11.5T400-760Zm207 35 29-29q11-11 27.5-11.5T692-754q11 11 11.5 27.5T693-698l-29 30q-11 12-27.5 11.5T608-668q-12-12-12.5-28.5T607-725Z"/></svg>',
    appsGrid: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M638-468 468-638q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l170-170q6-6 13-8.5t15-2.5q8 0 15 2.5t13 8.5l170 170q6 6 8.5 13t2.5 15q0 8-2.5 15t-8.5 13L694-468q-6 6-13 8.5t-15 2.5q-8 0-15-2.5t-13-8.5Zm-518-92v-240q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v240q0 17-11.5 28.5T400-520H160q-17 0-28.5-11.5T120-560Zm400 400v-240q0-17 11.5-28.5T560-440h240q17 0 28.5 11.5T840-400v240q0 17-11.5 28.5T800-120H560q-17 0-28.5-11.5T520-160Zm-400 0v-240q0-17 11.5-28.5T160-440h240q17 0 28.5 11.5T440-400v240q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-440h160v-160H200v160Zm467 48 113-113-113-113-113 113 113 113Zm-67 352h160v-160H600v160Zm-400 0h160v-160H200v160Zm160-400Zm194-65ZM360-360Zm240 0Z"/></svg>',
    directionDown: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M200-120q-17 0-28.5-11.5T160-160q0-17 11.5-28.5T200-200h560q17 0 28.5 11.5T800-160q0 17-11.5 28.5T760-120H200Zm280-177q-8 0-15-2.5t-13-8.5L308-452q-11-11-11-28t11-28q11-11 28-11t28 11l76 76v-368q0-17 11.5-28.5T480-840q17 0 28.5 11.5T520-800v368l76-76q11-11 28-11t28 11q11 11 11 28t-11 28L508-308q-6 6-13 8.5t-15 2.5Z"/></svg>',
    addToHomeScreen: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M320-40q-33 0-56.5-23.5T240-120v-120q0-17 11.5-28.5T280-280q17 0 28.5 11.5T320-240h400v-480H320q0 17-11.5 28.5T280-680q-17 0-28.5-11.5T240-720v-120q0-33 23.5-56.5T320-920h400q33 0 56.5 23.5T800-840v720q0 33-23.5 56.5T720-40H320Zm0-120v40h400v-40H320Zm80-344L204-308q-11 11-28 11t-28-11q-11-11-11-28t11-28l196-196H240q-17 0-28.5-11.5T200-600q0-17 11.5-28.5T240-640h200q17 0 28.5 11.5T480-600v200q0 17-11.5 28.5T440-360q-17 0-28.5-11.5T400-400v-104Zm-80-296h400v-40H320v40Zm0 0v-40 40Zm0 640v40-40Z"/></svg>',
    noInstallSupport: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M792-56 56-792q-11-11-11-28t11-28q11-11 28-11t28 11l736 736q11 11 11 28t-11 28q-11 11-28 11t-28-11ZM200-703l80 80v383h384l96 96v24q0 33-23.5 56.5T680-40H280q-33 0-56.5-23.5T200-120v-583Zm80 543v40h400v-40H280Zm0 0v40-40Zm79-560q-17 0-28-11.5T320-760q0-17 11.5-28.5T360-800h320v-40H260q-17 0-28.5-11.5T220-880q0-17 11.5-28.5T260-920h420q33 0 56.5 23.5T760-840v480q0 17-11.5 28.5T720-320q-17 0-28.5-11.5T680-360v-360H359Zm98-80Z"/></svg>',
  };

  const getContrastTextColor = (backgroundColor) => {
    const temp = document.createElement('div');
    temp.style.backgroundColor = backgroundColor;
    temp.style.display = 'none';
    document.body.appendChild(temp);

    const computedColor = window.getComputedStyle(temp).backgroundColor;
    document.body.removeChild(temp);

    const [r, g, b] = computedColor.match(/\d+/g).map(Number);
    const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;

    return luminance > 0.5 ? '#000000' : '#ffffff';
  };

  const addParamToUrl = (paramName, paramValue = '', url = window.location.href) => {
    const urlObject = new URL(url);
    if (paramValue === '') {
      urlObject.searchParams.append(paramName, '');
      return urlObject.href.replace(`${paramName}=`, paramName);
    }
    urlObject.searchParams.set(paramName, paramValue);
    return urlObject.href;
  };

  class IntaselaPWAInstallPrompt extends HTMLElement {
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
      this.styles = new Set();
    }

    async connectedCallback() {
      this.render();
      this.handleRemove();
      this.handleClipboard();
      this.handleNativeInstall();

      if (!this.hasAttribute('loaded')) {
        await this.handleCheckInstallCapabilities();
        this.setAttribute('loaded', '');
        this.handleUpdateContent();
      }
    }

    static show() {
      let prompt = document.querySelector('intasela-pwa-install-prompt');

      if (!prompt) {
        prompt = document.createElement('intasela-pwa-install-prompt');
        document.body.appendChild(prompt);

        requestAnimationFrame(() => {
          const installPrompt = prompt.shadowRoot.querySelector('.install-prompt');
          document.documentElement.style.paddingRight = `${window.innerWidth - document.documentElement.offsetWidth}px`;
          document.documentElement.style.overflow = 'hidden';
          installPrompt.classList.add('visible');
        });
      }

      return prompt;
    }

    injectStyles(css) {
      this.styles.add(css);
    }

    handleRemove() {
      const closeIcon = this.shadowRoot.querySelector('.install-prompt-close');
      const closeButton = this.shadowRoot.querySelector('.install-prompt-footer_close');
      const backdrop = this.shadowRoot.querySelector('.install-prompt');

      const handleClose = () => {
        backdrop.classList.remove('visible');
        backdrop.addEventListener(
          'transitionend',
          () => {
            document.documentElement.style.removeProperty('overflow');
            document.documentElement.style.paddingRight = '';
            this.remove();
          },
          { once: true }
        );
      };

      closeIcon.addEventListener('click', handleClose);
      closeButton.addEventListener('click', handleClose);
      backdrop.addEventListener('click', (e) => {
        if (e.target === backdrop) handleClose();
      });
    }

    handleClipboard() {
      const copyButtons = this.shadowRoot.querySelectorAll('[data-clipboard-content]');
      copyButtons.forEach((button) => {
        button.addEventListener('click', async () => {
          const content = button.getAttribute('data-clipboard-content');
          const defaultIcon = button.querySelector('.clipboard-default');
          const successIcon = button.querySelector('.clipboard-success');
          const tooltip = button.querySelector('.tooltip');

          try {
            await navigator.clipboard.writeText(content);
            defaultIcon.style.display = 'none';
            successIcon.style.display = 'block';
            tooltip.classList.add('visible');
            button.disabled = true;

            setTimeout(() => {
              defaultIcon.style.display = 'block';
              successIcon.style.display = 'none';
              tooltip.classList.remove('visible');
              button.disabled = false;
            }, 2000);
          } catch (err) {
            console.error('Failed to copy:', err);
          }
        });
      });
    }

    async handleCheckInstallCapabilities() {
      return new Promise((resolve) => {
        // If we already have the prompt, resolve immediately
        if (deferredInstallPrompt) {
          resolve(true);
          return;
        }

        // Set a timeout for the check — 4 s gives production servers enough time
        // to fully evaluate the manifest and service worker before we give up.
        const timeout = setTimeout(() => resolve(false), 4000);

        // Listen for the event
        window.addEventListener(
          'beforeinstallprompt',
          (e) => {
            e.preventDefault();
            clearTimeout(timeout);
            deferredInstallPrompt = e;
            resolve(true);
          },
          { once: true }
        );
      });
    }

    handleUpdateContent() {
      const contentContainer = this.shadowRoot.querySelector('.install-prompt-body');
      if (contentContainer) {
        // Content will call injectStyles as needed
        contentContainer.innerHTML = this.renderContent();

        // Update the style tag with all accumulated styles
        const styleTag = this.shadowRoot.querySelector('style');
        styleTag.textContent = Array.from(this.styles).join('\n');

        this.handleClipboard();
        this.handleNativeInstall();
      }
    }

    handleNativeInstall() {
      const nativeButton = this.shadowRoot.querySelector('#native-install-btn');
      if (nativeButton && deferredInstallPrompt) {
        nativeButton.addEventListener('click', async () => {
          try {
            await deferredInstallPrompt.prompt();
            const result = await deferredInstallPrompt.userChoice;
            deferredInstallPrompt = null;

            if (result.outcome === 'accepted') {
              this.remove();
            }
          } catch (error) {
            console.error('Native installation failed:', error);
            this.handleUpdateContent();
          }
        });
      }
    }

    renderAppIcon() {
      if (!installPromptJsVars.iconUrl) return '';

      this.injectStyles(`
      .install-prompt-body-appinfo_icon {
        border-radius: 9999px;
        border: 1px solid #e5e7eb;
        -ms-flex-negative: 0;
            flex-shrink: 0;
        height: 55px;
        width: 55px;
        display: inline-block;
      }
    `);

      const appName = installPromptJsVars.appName;

      return `
      <img 
        class="install-prompt-body-appinfo_icon" 
        src="${installPromptJsVars.iconUrl}" 
        alt="${appName}"
        onerror="this.style.display='none'"
      >
    `;
    }

    renderAppName() {
      this.injectStyles(`
      .install-prompt-body-appinfo_appname {
        font-size: 1rem;
        line-height: 1.5rem;
        font-weight: 500;
        color: #1f2937;
        display: -webkit-box;
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
      }
    `);

      const appName = installPromptJsVars.appName;
      return appName
        ? `
      <div class="install-prompt-body-appinfo_appname">${appName}</div>
    `
        : '';
    }

    renderAppDescription() {
      this.injectStyles(`
      .install-prompt-body-appinfo_description {
        font-size: 0.75rem;
        line-height: 1rem;
        font-weight: 400;
        color: #6b7280;
        margin-top: 0.12rem;
        display: -webkit-box;
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
      }
    `);

      const description = installPromptJsVars.description;
      return description
        ? `
      <div class="install-prompt-body-appinfo_description">${description}</div>
    `
        : '';
    }

    renderAppInfo() {
      this.injectStyles(`
      .install-prompt-body-appinfo {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        background: #f3f4f6;
        padding: 0.5rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
      }

      .install-prompt-body-appinfo_texts {
        padding-left: 0.5rem;
      }
    `);

      return `
      <div class="install-prompt-body-appinfo">
        ${this.renderAppIcon()}
        <div class="install-prompt-body-appinfo_texts">
          ${this.renderAppName()}
          ${this.renderAppDescription()}
        </div>
      </div>
    `;
    }

    renderCopyInstallUrlButton() {
      this.injectStyles(`
      .install-prompt-body-instructions_step_copy {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        -webkit-column-gap: 0.5rem;
           -moz-column-gap: 0.5rem;
                column-gap: 0.5rem;
        font-size: 0.875rem;
        line-height: 0.875rem;
        padding: 10px 13px;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        background-color: #ffffff;
        color: #1f2937;
        -webkit-box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
                box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        outline: none;
        -webkit-transition: all .1s ease;
        -o-transition: all .1s ease;
        transition: all .1s ease;
        cursor: pointer;
        margin-top: 0.5rem;
      }

      .install-prompt-body-instructions_step_copy:hover,
      .install-prompt-body-instructions_step_copy:focus {
        background-color: #f9fafb;
      }

      .install-prompt-body-instructions_step_copy_url {
        -o-text-overflow: ellipsis;
           text-overflow: ellipsis;
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
        max-width: 15rem;
      }

      .install-prompt-body-instructions_step_copy_icons {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
        border-left: 1px solid #e5e7eb;
        -webkit-padding-start: 0.75rem;
                padding-inline-start: 0.75rem;
      }

      .install-prompt-body-instructions_step_copy_svg {
        width: 1rem;
        height: 1rem;
      }

      .install-prompt-body-instructions_step_copy_svg.clipboard-success {
        display: none;
        width: 1rem;
        height: 1rem;
        color: #2563eb;
      }

      .install-prompt-body-instructions_step_copy_tooltip {
        display: none;
        opacity: 0;
        visibility: hidden;
        position: absolute;
        top: -2rem;
        -webkit-transition: all 0.1s ease;
        -o-transition: all 0.1s ease;
        transition: all 0.1s ease;
        z-index: 10;
        padding: 0.25rem 0.5rem;
        background-color: #111827;
        font-size: 0.75rem;
        line-height: 1rem;
        font-weight: 500;
        color: #ffffff;
        border-radius: 0.5rem;
        -webkit-box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
                box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        cursor: default;
      }

      .install-prompt-body-instructions_step_copy_tooltip.visible {
        visibility: visible;
        opacity: 1;
      }
    `);

      const startPagePath = installPromptJsVars.startPagePath;
      return startPagePath
        ? `
      <button type="button" class="install-prompt-body-instructions_step_copy" data-clipboard-content="${addParamToUrl('performInstallation', 'true', installPromptJsVars.homeUrl + startPagePath)}">
        <span class="install-prompt-body-instructions_step_copy_url">
          ${installPromptJsVars.homeUrl + startPagePath}
        </span>
        <span class="install-prompt-body-instructions_step_copy_icons">
          <svg class="install-prompt-body-instructions_step_copy_svg clipboard-default" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
          </svg>
          <svg class="install-prompt-body-instructions_step_copy_svg clipboard-success" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="install-prompt-body-instructions_step_copy_tooltip" role="tooltip">
          ${wp.i18n.__('Copied', 'intasela-pwa')}
        </span>
      </button>
    `
        : '';
    }

    renderLoadingInstallCheck() {
      this.injectStyles(`
      .install-prompt-loading {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
            -ms-flex-direction: column;
                flex-direction: column;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
      }

      .install-prompt-loading-spinner {
        width: 2rem;
        height: 2rem;
        border: 3px solid #f3f4f6;
        border-top-color: #1f2937;
        border-radius: 50%;
        -webkit-animation: spinner 0.6s linear infinite;
                animation: spinner 0.6s linear infinite;
      }

      @-webkit-keyframes spinner {
        to {
          -webkit-transform: rotate(360deg);
                  transform: rotate(360deg);
        }
      }

      @keyframes spinner {
        to {
          -webkit-transform: rotate(360deg);
                  transform: rotate(360deg);
        }
      }

      .install-prompt-loading-text {
        margin-top: 1rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        color: #374151;
      }
    `);

      return `
      <div class="install-prompt-loading">
        <div class="install-prompt-loading-spinner"></div>
        <div class="install-prompt-loading-text">${wp.i18n.__('Checking installation capabilities...', 'intasela-pwa')}</div>
      </div>
    `;
    }

    renderNativeInstallButton() {
      const themeColor = installPromptJsVars.themeColor ?? '#000000';
      const textColor = getContrastTextColor(themeColor);

      this.injectStyles(`
      .install-prompt-native-button {
        width: 100%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        font-weight: 500;
        font-size: 0.875rem;
        line-height: 1.25rem;
        border-radius: 0.5rem;
        color: ${textColor};
        background-color: ${themeColor};
        -webkit-transition: all 0.1s ease;
        -o-transition: all 0.1s ease;
        transition: all 0.1s ease;
        cursor: pointer;
        outline: none;
        border: none;
        margin-top: 1.5rem;
      }

      .install-prompt-native-button:hover {
        opacity: 0.8;
      }

      .install-prompt-native-button:focus {
        outline: 2px solid #60a5fa;
        outline-offset: 2px;
      }

      .install-prompt-native-button svg {
        width: 1.25rem;
        height: 1.25rem;
      }
    `);

      const { device, os, browser } = window.IntaselaPWAUADetector;
      let btnIconSvg = '';
      let btnIconText = wp.i18n.__('Click to Install', 'intasela-pwa');

      if (device.isSmartphone || device.isTablet) {
        btnIconSvg = svg.installMobile;
        btnIconText = wp.i18n.__('Tap to Install', 'intasela-pwa');
      } else if (device.isDesktop) {
        btnIconSvg = svg.installDesktop;
      }

      return `
      <button type="button" class="install-prompt-native-button" id="native-install-btn">
        ${btnIconSvg}
        ${btnIconText}
      </button>
    `;
    }

    renderContent() {
      if (!this.hasAttribute('loaded')) {
        return `
        ${this.renderLoadingInstallCheck()}
      `;
      }

      return deferredInstallPrompt
        ? `
        ${this.renderAppInfo()}
        ${this.renderNativeInstallButton()}
      `
        : `
        ${this.renderAppInfo()}
        ${this.renderManualInstallInstructions()}
      `;
    }

    renderStep(stepNumber, title = '', description = '', icon = '', extraHtml = '') {
      this.injectStyles(`
      .install-prompt-body-instructions_step {
        position: relative;
        -webkit-padding-start: 2.8rem;
                padding-inline-start: 2.8rem;
        padding-bottom: 2.2rem;
        counter-increment: step 1;
      }

      .install-prompt-body-instructions_step:last-child {
        padding-bottom: 0px;
      }

      .install-prompt-body-instructions_step-icon {
        position: absolute;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        inset-inline-start: 0px;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
        width: 2rem;
        height: 2rem;
        color: #1f2937;
        border-radius: 9999px;
        background-color: #f3f4f6;
      }

      .install-prompt-body-instructions_step-icon svg {
        width: 1.25rem;
        height: 1.25rem;
        -ms-flex-negative: 0;
            flex-shrink: 0;
      }

      .install-prompt-body-instructions_step-icon:empty::before {
        content: counter(step);
        font-size: 0.75rem;
        line-height: 1rem;
        font-weight: 600;
      }

      .install-prompt-body-instructions_step {
        counter-increment: step;
      }

      .install-prompt-body-instructions_step:last-child::after {
        display: none;
      }

      .install-prompt-body-instructions_step::after {
        content: '';
        position: absolute;
        top: 2.5rem;
        bottom: 0.5rem;
        inset-inline-start: 0.95rem;
        width: 1px;
        -webkit-transform: translateX(0.5px);
            -ms-transform: translateX(0.5px);
                transform: translateX(0.5px);
        background-color: #e5e7eb;
      }

      .install-prompt-body-instructions_step_title {
        display: block;
        font-weight: 600;
        font-size: 0.875rem;
        line-height: 1.25rem;
        color: #1f2937;
      }

      .install-prompt-body-instructions_step_description {
        font-size: 0.8rem;
        color: #6b7280;
        line-height: 1.1rem;
        margin: 0;
        padding: 0;
        margin-top: 0.2rem;
      }
    `);

      const iconHtml = icon ? `<div class="install-prompt-body-instructions_step-icon">${icon}</div>` : `<div class="install-prompt-body-instructions_step-icon"></div>`;

      return `
      <li class="install-prompt-body-instructions_step">
        ${iconHtml}
        <span class="install-prompt-body-instructions_step_title">
           ${stepNumber}. ${title}
        </span>
        <p class="install-prompt-body-instructions_step_description">
          ${description}
        </p>
        ${extraHtml}
      </li> 
    `;
    }

    renderManualInstallInstructions() {
      this.injectStyles(`
      .install-prompt-body-instructions {
        list-style: none;
        margin: 0;
        margin-top: 1.5rem;
        padding: 0;
      }
    `);

      const { device, os, browser } = window.IntaselaPWAUADetector;
      let steps = [];
      let stepNumber = 1;

      const renderStep = (...args) => {
        steps.push(this.renderStep(stepNumber, ...args));
        stepNumber++;
      };

      if (device.isSmartphone || device.isTablet) {
        if (os.isAndroid) {
          if (browser.isChrome) {
            renderStep(wp.i18n.__('Tap the Menu Icon', 'intasela-pwa'), wp.i18n.__('Tap the menu icon (three dots), located at the top-right of your screen.', 'intasela-pwa'), svg.vertThreeDots);
            renderStep(wp.i18n.__('Select "Add to Home Screen"', 'intasela-pwa'), wp.i18n.__('Tap the "Add to Home Screen" option from the menu.', 'intasela-pwa'), svg.addToHomeScreen);
            renderStep(wp.i18n.__('Confirm by Tapping "Add"', 'intasela-pwa'), wp.i18n.__('Tap the "Add" text on the browser installation dialog.', 'intasela-pwa'), svg.tapFinger);
          } else if (browser.isFirefox) {
            renderStep(wp.i18n.__('Tap the Menu Icon', 'intasela-pwa'), wp.i18n.__('Tap the menu icon (three dots), located at the top-right of your screen.', 'intasela-pwa'), svg.vertThreeDots);
            renderStep(wp.i18n.__('Select "Install"', 'intasela-pwa'), wp.i18n.__('Tap the "Install" option from the menu.', 'intasela-pwa'), svg.addToHomeScreen);
            renderStep(wp.i18n.__('Confirm by Tapping "Add to Home Screen"', 'intasela-pwa'), wp.i18n.__('Tap the "Add to Home Screen" button on the browser installation dialog.', 'intasela-pwa'), svg.tapFinger);
          } else if (browser.isOpera) {
            renderStep(wp.i18n.__('Tap the Menu Icon', 'intasela-pwa'), wp.i18n.__('Tap the menu icon (three dots), located at the top-right of your screen.', 'intasela-pwa'), svg.vertThreeDots);
            renderStep(wp.i18n.__('Select "Home Screen"', 'intasela-pwa'), wp.i18n.__('Tap the "Install" option from the menu.', 'intasela-pwa'), svg.installMobile);
            renderStep(wp.i18n.__('Confirm by Tapping "Add"', 'intasela-pwa'), wp.i18n.__('Tap the "Add" text on the browser installation dialog.', 'intasela-pwa'), svg.tapFinger);
          } else if (browser.isEdge) {
            renderStep(wp.i18n.__('Tap the Menu Icon', 'intasela-pwa'), wp.i18n.__('Tap the menu icon (three horizontal lines) located at the bottom-right of your screen.', 'intasela-pwa'), svg.hamburgerMenu);
            renderStep(wp.i18n.__('Select "Add to Phone"', 'intasela-pwa'), wp.i18n.__('Tap the "Add to Phone" option from the menu', 'intasela-pwa'), svg.installMobile);
            renderStep(wp.i18n.__('Confirm by Tapping "Install"', 'intasela-pwa'), wp.i18n.__('Tap the "Install" text on the browser installation dialog.', 'intasela-pwa'), svg.tapFinger);
          } else {
            renderStep(wp.i18n.__('Copy the Page URL', 'intasela-pwa'), wp.i18n.__("Click the button below to copy the page's URL.", 'intasela-pwa'), svg.copy, this.renderCopyInstallUrlButton());
            renderStep(wp.i18n.__('Open the Google Chrome Browser', 'intasela-pwa'), wp.i18n.__('Launch the Google Chrome web browser from your home screen.', 'intasela-pwa'), svg.googleChrome);
            renderStep(wp.i18n.__('Paste and Open the URL', 'intasela-pwa'), wp.i18n.__("Paste the copied URL into Google Chrome's address bar and open the page.", 'intasela-pwa'), svg.pasteGo);
          }
        } else if (os.isIos) {
          if (browser.isSafari) {
            renderStep(wp.i18n.__('Tap the Menu button', 'intasela-pwa'), wp.i18n.__('Open Safari menu (three horizontal dots) located at the bottom-right of the address bar.', 'intasela-pwa'), svg.horizThreeDots);
            renderStep(wp.i18n.__('Select "Share"', 'intasela-pwa'), wp.i18n.__('Tap the "Share" option, which is the first item in the menu at the top-center of your screen.', 'intasela-pwa'), svg.iosShare);
            renderStep(wp.i18n.__('Tap the More button', 'intasela-pwa'), wp.i18n.__('Tap the "More" button (three horizontal dots) located at the bottom-right of the share dialog.', 'intasela-pwa'), svg.horizThreeDots);
            renderStep(wp.i18n.__('Select "Add to Home Screen"', 'intasela-pwa'), wp.i18n.__('Tap the "Add to Home Screen" option, represented by the plus [+] icon.', 'intasela-pwa'), svg.plusInBox);
            renderStep(wp.i18n.__('Confirm by Tapping "Add"', 'intasela-pwa'), wp.i18n.__('Tap the "Add" button at the top-right corner of your screen.', 'intasela-pwa'), svg.tapFinger);
          } else if (browser.isChrome) {
            renderStep(wp.i18n.__('Tap the Share Icon', 'intasela-pwa'), wp.i18n.__('Tap the share icon located at the top-right of your browser address bar.', 'intasela-pwa'), svg.iosShare);
            renderStep(wp.i18n.__('Tap the More button', 'intasela-pwa'), wp.i18n.__('Tap the "More" button (three horizontal dots) located at the bottom-right of the share dialog.', 'intasela-pwa'), svg.horizThreeDots);
            renderStep(wp.i18n.__('Select "Add to Home Screen"', 'intasela-pwa'), wp.i18n.__('Tap the "Add to Home Screen" option, represented by the plus [+] icon.', 'intasela-pwa'), svg.plusInBox);
            renderStep(wp.i18n.__('Confirm by Tapping "Add"', 'intasela-pwa'), wp.i18n.__('Tap the "Add" button at the top-right corner of your screen.', 'intasela-pwa'), svg.tapFinger);
          } else if (browser.isFirefox) {
            renderStep(wp.i18n.__('Tap the Menu Icon', 'intasela-pwa'), wp.i18n.__('Tap the menu icon (three horizontal lines) located at the bottom-right of your screen.', 'intasela-pwa'), svg.hamburgerMenu);
            renderStep(wp.i18n.__('Tap the Share Icon', 'intasela-pwa'), wp.i18n.__('Tap the share icon in the dialog overlay that the browser opens.', 'intasela-pwa'), svg.iosShare);
            renderStep(wp.i18n.__('Tap the More button', 'intasela-pwa'), wp.i18n.__('Tap the "More" button (three horizontal dots) located at the bottom-right of the share dialog.', 'intasela-pwa'), svg.horizThreeDots);
            renderStep(wp.i18n.__('Select "Add to Home Screen"', 'intasela-pwa'), wp.i18n.__('Tap the "Add to Home Screen" option, represented by the plus [+] icon.', 'intasela-pwa'), svg.plusInBox);
            renderStep(wp.i18n.__('Confirm by Tapping "Add"', 'intasela-pwa'), wp.i18n.__('Tap the "Add" button at the top-right corner of your screen.', 'intasela-pwa'), svg.tapFinger);
          } else if (browser.isOpera) {
            renderStep(wp.i18n.__('Tap the Menu Icon', 'intasela-pwa'), wp.i18n.__('Tap the menu icon (three dots), located at the bottom-right of your screen.', 'intasela-pwa'), svg.vertThreeDots);
            renderStep(wp.i18n.__('Tap the Share Icon', 'intasela-pwa'), wp.i18n.__('Tap the share icon located at the top of the dialog overlay that browser opens.', 'intasela-pwa'), svg.upload);
            renderStep(wp.i18n.__('Tap the More button', 'intasela-pwa'), wp.i18n.__('Tap the "More" button (three horizontal dots) located at the bottom-right of the share dialog.', 'intasela-pwa'), svg.horizThreeDots);
            renderStep(wp.i18n.__('Select "Add to Home Screen"', 'intasela-pwa'), wp.i18n.__('Tap the "Add to Home Screen" option, represented by the plus [+] icon.', 'intasela-pwa'), svg.plusInBox);
            renderStep(wp.i18n.__('Confirm by Tapping "Add"', 'intasela-pwa'), wp.i18n.__('Tap the "Add" button at the top-right corner of your screen.', 'intasela-pwa'), svg.tapFinger);
          } else if (browser.isEdge) {
            renderStep(wp.i18n.__('Tap the Menu Icon', 'intasela-pwa'), wp.i18n.__('Tap the menu icon (three horizontal lines) located at the bottom-right of your screen.', 'intasela-pwa'), svg.hamburgerMenu);
            renderStep(wp.i18n.__('Tap the Share Icon', 'intasela-pwa'), wp.i18n.__('Tap the share icon in the dialog overlay that the browser opens.', 'intasela-pwa'), svg.upload);
            renderStep(wp.i18n.__('Tap the More button', 'intasela-pwa'), wp.i18n.__('Tap the "More" button (three horizontal dots) located at the bottom-right of the share dialog.', 'intasela-pwa'), svg.horizThreeDots);
            renderStep(wp.i18n.__('Select "Add to Home Screen"', 'intasela-pwa'), wp.i18n.__('Tap the "Add to Home Screen" option, represented by the plus [+] icon.', 'intasela-pwa'), svg.plusInBox);
            renderStep(wp.i18n.__('Confirm by Tapping "Add"', 'intasela-pwa'), wp.i18n.__('Tap the "Add" button at the top-right corner of your screen.', 'intasela-pwa'), svg.tapFinger);
          } else if (browser.isDuckduckgo) {
            renderStep(wp.i18n.__('Tap the Share Icon', 'intasela-pwa'), wp.i18n.__("Tap the share icon located at the right side of the browser's address bar.", 'intasela-pwa'), svg.upload);
            renderStep(wp.i18n.__('Tap the More button', 'intasela-pwa'), wp.i18n.__('Tap the "More" button (three horizontal dots) located at the bottom-right of the share dialog.', 'intasela-pwa'), svg.horizThreeDots);
            renderStep(wp.i18n.__('Select "Add to Home Screen"', 'intasela-pwa'), wp.i18n.__('Tap the "Add to Home Screen" option, represented by the plus [+] icon.', 'intasela-pwa'), svg.plusInBox);
            renderStep(wp.i18n.__('Confirm by Tapping "Add"', 'intasela-pwa'), wp.i18n.__('Tap the "Add" button at the top-right corner of your screen.', 'intasela-pwa'), svg.tapFinger);
          } else {
            renderStep(wp.i18n.__('Copy the Page URL', 'intasela-pwa'), wp.i18n.__("Click the button below to copy the page's URL.", 'intasela-pwa'), svg.copy, this.renderCopyInstallUrlButton());
            renderStep(wp.i18n.__('Open the Safari Browser', 'intasela-pwa'), wp.i18n.__('Launch the Safari web browser from your home screen.', 'intasela-pwa'), svg.safari);
            renderStep(wp.i18n.__('Paste and Open the URL', 'intasela-pwa'), wp.i18n.__("Paste the copied URL into Safari's address bar and open the page.", 'intasela-pwa'), svg.pasteGo);
          }
        } else {
          renderStep(wp.i18n.__('Installation Not Supported', 'intasela-pwa'), wp.i18n.__('Your operating system does not support web app installation. Please try accessing the website on an Android or iOS mobile device.', 'intasela-pwa'), svg.noInstallSupport);
        }
      } else if (device.isDesktop) {
        if (browser.isChrome) {
          renderStep(wp.i18n.__('Tap the Menu Icon', 'intasela-pwa'), wp.i18n.__('Tap the menu icon (three dots) in the top-right corner of your browser window.', 'intasela-pwa'), svg.vertThreeDots);
          renderStep(wp.i18n.__('Expand "Cast, save and share"', 'intasela-pwa'), wp.i18n.__('Hover over the "Cast, Save, and Share" menu item to expand its options.', 'intasela-pwa'), svg.fileSave);
          renderStep(wp.i18n.__('Select "Install page as app..."', 'intasela-pwa'), wp.i18n.__('Click on "Install page as app..." from the menu.', 'intasela-pwa'), svg.installDesktop);
          renderStep(wp.i18n.__('Confirm by Clicking "Install"', 'intasela-pwa'), wp.i18n.__('Click the "Install" button in the browser\'s installation dialog.', 'intasela-pwa'), svg.mouseClick);
        } else if (browser.isEdge) {
          renderStep(wp.i18n.__('Tap the Menu Icon', 'intasela-pwa'), wp.i18n.__('Tap the menu icon (three dots) in the top-right corner of your browser window.', 'intasela-pwa'), svg.horizThreeDots);
          renderStep(wp.i18n.__('Expand "Apps"', 'intasela-pwa'), wp.i18n.__('Hover over the "Apps" menu item to expand its options.', 'intasela-pwa'), svg.appsGrid);
          renderStep(wp.i18n.__('Select "Install this site as app"', 'intasela-pwa'), wp.i18n.__('Click on "Install this site as app" from the menu.', 'intasela-pwa'), svg.directionDown);
          renderStep(wp.i18n.__('Confirm by Clicking "Install"', 'intasela-pwa'), wp.i18n.__('Click the "Install" button in the browser\'s installation dialog.', 'intasela-pwa'), svg.mouseClick);
        } else {
          renderStep(wp.i18n.__('Copy the Page URL', 'intasela-pwa'), wp.i18n.__("Click the button below to copy the page's URL.", 'intasela-pwa'), svg.copy, this.renderCopyInstallUrlButton());
          renderStep(wp.i18n.__('Open the Google Chrome Browser', 'intasela-pwa'), wp.i18n.__('Launch the Google Chrome web browser from your start menu.', 'intasela-pwa'), svg.googleChrome);
          renderStep(wp.i18n.__('Paste and Open the URL', 'intasela-pwa'), wp.i18n.__("Paste the copied URL into Google Chrome's address bar and open the page.", 'intasela-pwa'), svg.pasteGo);
        }
      } else {
        renderStep(wp.i18n.__('Installation Not Supported', 'intasela-pwa'), wp.i18n.__('Your device does not support web app installation. Please try accessing the website on a mobile or desktop device.', 'intasela-pwa'), svg.noInstallSupport);
      }

      return steps.length ? `<ul class="install-prompt-body-instructions">${steps.join('')}</ul>` : '';
    }

    render() {
      this.injectStyles(`
      .install-prompt {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 99999999999999999999;
        background: rgba(0, 0, 0, 0);
        -webkit-backdrop-filter: blur(0px);
                backdrop-filter: blur(0px);
        -webkit-transition: all 0.2s ease-out;
        -o-transition: all 0.2s ease-out;
        transition: all 0.2s ease-out;
        opacity: 0;
        visibility: hidden;
      }

      .install-prompt.visible {      
        background: rgba(0, 0, 0, 0.7);
        -webkit-backdrop-filter: blur(5px);
                backdrop-filter: blur(5px);
        opacity: 1;
        visibility: visible;
      }

      .install-prompt-container {
        position: fixed;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, calc(-50% + 20px));
            -ms-transform: translate(-50%, calc(-50% + 20px));
                transform: translate(-50%, calc(-50% + 20px));
        background: white;
        border-radius: 10px;
        -webkit-box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 32rem;
        width: 95%;
        overflow: hidden;
        opacity: 0;
        -webkit-transition: all 0.15s ease-out;
        -o-transition: all 0.15s ease-out;
        transition: all 0.15s ease-out;
        z-index: 999999999999999999999;
      }

      .install-prompt.visible .install-prompt-container {
        -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
        opacity: 1;
      }

      .install-prompt-header {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding: 0.75rem 1rem;
        gap: 1.5rem;
        -webkit-box-pack: justify;
            -ms-flex-pack: justify;
                justify-content: space-between;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        border-bottom: 1px solid #e5e7eb;
      }

      .install-prompt-header-texts_title {
        font-size: 1rem;
        line-height: 1.5rem;
        font-weight: 500;
        color: #1f2937;
        display: -webkit-box;
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
      }

      .install-prompt-close {
        display: -webkit-inline-box;
        display: -ms-inline-flexbox;
        display: inline-flex;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        width: 2rem;
        height: 2rem;
        color: #1f2937;
        background: #f3f4f6;
        border-radius: 9999px;
        outline: none;
        border: none;
        cursor: pointer;
        -webkit-transition: all 0.1s ease;
        -o-transition: all 0.1s ease;
        transition: all 0.1s ease;
        -ms-flex-negative: 0;
            flex-shrink: 0;
      }

      .install-prompt-close:hover {
        background: #e5e7eb;
      }

      .install-prompt-close-icon {
        display: block;
        width: 1rem;
        height: 1rem;
        -ms-flex-negative: 0;
            flex-shrink: 0;
        vertical-align: middle;
      }

      .install-prompt-body {
        padding: 1.5rem 1rem;
        overflow-y: auto;
        max-height: 34rem;
      }

      .install-prompt-body::-webkit-scrollbar {
        width: .5rem;
      }

      .install-prompt-body::-webkit-scrollbar-thumb {
        background-color: rgb(209 213 219 / 1);
        border-radius: 9999px;
      }

      .install-prompt-body::-webkit-scrollbar-track {
        background-color: rgb(243 244 246 / 1);
      }

      .install-prompt-footer {
        display: none;
        padding: 0.25rem;
        border-top: 1px solid #e5e7eb;
      }

      .install-prompt-footer_close {
        width: 100%;
        display: -webkit-inline-box;
        display: -ms-inline-flexbox;
        display: inline-flex;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        -webkit-column-gap: 0.375rem;
           -moz-column-gap: 0.375rem;
                column-gap: 0.375rem;
        padding: 0.75rem 1rem;
        font-weight: 500;
        font-size: 0.75rem;
        line-height: 1rem;
        border-radius: 0.5rem;
        background-color: #ffffff;
        color: #1f2937;
        -webkit-transition: all 0.1s ease;
        -o-transition: all 0.1s ease;
        transition: all 0.1s ease;
        cursor: pointer;
        outline: none;
        border: none;
      }

      .install-prompt-footer_close:hover {
        background-color: #f3f4f6;
      }
        
      .install-prompt-footer_close:focus {
        outline: none;
        border: none;
        background-color: #f3f4f6;
      }

      @media (max-width: 700px) {
       .install-prompt-container {
          width: 100%;
          max-width: 100%;
          top: unset;
          bottom: 0;
          left: 0;
          border-top-left-radius: 1rem;
          border-top-right-radius: 1rem;
          border-bottom-left-radius: 0;
          border-bottom-right-radius: 0;
          -webkit-box-shadow: none;
                  box-shadow: none;
          opacity: 1;
          -webkit-transform: translateY(100%);
              -ms-transform: translateY(100%);
                  transform: translateY(100%);
        } 

        .install-prompt.visible .install-prompt-container {
          -webkit-transform: translateY(0);
              -ms-transform: translateY(0);
                  transform: translateY(0);
        }
      }
    `);

      const content = this.renderContent();
      const promptTitle = installPromptJsVars.installationPromptsText ?? wp.i18n.__('Install Web App', 'intasela-pwa');
      const combinedStyles = Array.from(this.styles).join('\n');

      this.shadowRoot.innerHTML = `
      <style>${combinedStyles}</style>
      <div class="install-prompt">
        <div class="install-prompt-container">
          <div class="install-prompt-header">
            <div class="install-prompt-header-texts">
              <div class="install-prompt-header-texts_title">${promptTitle}</div>
            </div>
            <button type="button" class="install-prompt-close" aria-label="Close">
              <svg class="install-prompt-close-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
            </button>
          </div>
          <div class="install-prompt-body">
            ${content}
          </div>
          <div class="install-prompt-footer">
            <button type="button" class="install-prompt-footer_close">
              ${wp.i18n.__('Close Dialog', 'intasela-pwa')}
            </button>
          </div>
        </div>
      </div>
    `;
    }
  }

  // Expose for code that runs outside this DOMContentLoaded scope.
  window.IntaselaPWAInstallPrompt = IntaselaPWAInstallPrompt;
});
