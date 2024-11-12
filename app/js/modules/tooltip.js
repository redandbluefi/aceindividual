function initTooltip() {
  const tipButton = document.getElementById('tooltip');
  const shareDiv = document.getElementById('share-links');
  let text = '';

  function appendClassOnSuccess(button) {
    button.classList.add('copy-success');
    button.focus();
    setTimeout(() => {
      button.classList.remove('copy-success');
    }, 5000);
  }

  function fallbackCopyTextToClipboard(textParam, button) {
    const textArea = document.createElement('textarea');
    textArea.value = textParam;

    textArea.style.top = '0';
    textArea.style.left = '0';
    textArea.style.position = 'fixed';

    shareDiv.appendChild(textArea);

    textArea.focus();
    textArea.select();

    try {
      document.execCommand('copy');
      appendClassOnSuccess(button);
    } catch (err) {
      console.error('Could not copy text: ', err);
    }

    shareDiv.removeChild(textArea);
  }

  function copyTextToClipboard(textParam, button) {
    if (!navigator.clipboard) {
      fallbackCopyTextToClipboard(textParam, button);
      return;
    }
    navigator.clipboard
      .writeText(textParam)
      .then(() => {
        appendClassOnSuccess(button);
      })
      .catch((err) => {
        console.error('Could not copy text: ', err);
      });
  }

  if (tipButton) {
    tipButton.addEventListener('click', (event) => {
      text = tipButton.querySelector('.tooltip-link').innerHTML;
      copyTextToClipboard(text, tipButton);
      event.preventDefault();
    });
  }
}

export default initTooltip;
