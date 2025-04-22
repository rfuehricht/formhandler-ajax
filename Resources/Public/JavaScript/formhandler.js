document.addEventListener('DOMContentLoaded', function () {

  document.body.addEventListener('htmx:afterRequest', evt => {

    if (evt.detail.target.dataset.formhandlerAction === 'file-remove') {
      evt.detail.elt.remove();
    }
  });


});
