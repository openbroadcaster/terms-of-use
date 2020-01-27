OBModules.TermsOfUse = new function () {
  this.init = function () {
    OB.Callbacks.add('ready', 0, OBModules.TermsOfUse.initMenu);
    OB.Callbacks.add('ready', 1000, OBModules.TermsOfUse.termsDisplay);
  }

  this.initMenu = function () {
    OB.UI.addSubMenuItem('admin', 'Terms of Use', 'terms_of_use', OBModules.TermsOfUse.open, 150, 'terms_module');
  }

  this.open = function () {
    OB.UI.replaceMain('modules/terms_of_use/terms_of_use.html');

    OB.API.post('termsofuse', 'terms_load', {}, function (response) {
      if (!response.status) {
        $('#terms_message').obWidget('error', response.msg);
        return false;
      }

      $('#terms_html').val(response.data);
    })
  }

  this.termsUpdate = function () {
    OB.API.post('termsofuse', 'terms_update', { terms: $('#terms_html').val() }, function (response) {
      $('#terms_message').obWidget(response.status ? 'success' : 'error', response.msg);
    });

    // Attach event listener to hide success message when editing Terms of Use a second time.
    tinymce.activeEditor.on('keyup', function () { $('#terms_message').obWidget('hide'); });
  }

  this.termsDisplay = function () {
    OB.API.post('termsofuse', 'terms_display', {}, function (response) {
      if (response.status) {
        OB.UI.openModalWindow('modules/terms_of_use/terms_of_use_modal.html');
        $('#terms_modal_html').html(response.data);
      }
    })
  }

  this.termsAgree = function () {
    OB.API.post('termsofuse', 'terms_agree', {}, function (response) {
      OB.UI.closeModalWindow();
    });
  }
}
