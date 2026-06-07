export function initCopy() {
  const clipboardButtons = document.querySelectorAll('[data-clipboard-content]');

  clipboardButtons.forEach((button) => {
    button.addEventListener('click', function () {
      const content = this.getAttribute('data-clipboard-content');

      // Copy to clipboard
      navigator.clipboard
        .writeText(content)
        .then(() => {
          // Show success state
          const defaultIcon = this.querySelector('.clipboard-default');
          const successIcon = this.querySelector('.clipboard-success');

          defaultIcon.classList.add('hidden');
          successIcon.classList.remove('hidden');
          button.setAttribute('data-shown', 'true');

          // Reset after 2 seconds
          setTimeout(() => {
            defaultIcon.classList.remove('hidden');
            successIcon.classList.add('hidden');
            button.removeAttribute('data-shown');
          }, 2000);
        })
        .catch((err) => {
          console.error('Failed to copy text: ', err);
        });
    });
  });
}
