document.addEventListener('DOMContentLoaded', function () {

  document.body.addEventListener('htmx:afterRequest', evt => {

    if (evt.detail.target.dataset.formhandlerAction === 'file-remove') {
      if (evt.detail.target.dataset.removeSelector) {
        const elementToRemove = evt.detail.elt.closest(evt.detail.target.dataset.removeSelector);
        if (elementToRemove) {
          elementToRemove.remove();
        }
      } else {
        evt.detail.elt.remove();
      }
    }
  });


});
