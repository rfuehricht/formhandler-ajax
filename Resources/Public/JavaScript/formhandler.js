document.addEventListener('DOMContentLoaded', function () {

  const formhandlerInit = function () {

    const actionButtons = document.querySelectorAll('button[data-formhandler-action]');
    if (actionButtons) {
      actionButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
          e.preventDefault();

          const action = button.dataset.formhandlerAction;
          if (action === 'remove') {
            fetch('/?eID=formhandler-remove-file', {
              method: 'POST',
              body: JSON.stringify({
                token: button.closest('form').querySelector('input[name$="[randomId]"]').value,
                field: button.dataset.field,
                hash: button.dataset.filehash
              })
            })
              .then(function (response) {
                if (response.status === 200) {
                  const removeAfterSelector = button.dataset.removeAfter;
                  if (removeAfterSelector) {
                    const toRemove = button.closest(button.dataset.removeAfter);
                    if (toRemove) {
                      toRemove.remove();
                    }
                  } else {
                    button.parentElement.remove();
                  }
                }

              })
          }
        })
      });
    }

  }

  formhandlerInit();


});
