OBModules.TermsOfUse = new function () {
  this.init = function () {
    OB.Callbacks.add('ready', 0, OBModules.TermsOfUse.initMenu);
  }

  this.initMenu = function () {
    OB.UI.addSubMenuItem('admin', 'Terms of Use', 'terms_of_use', OBModules.TermsOfUse.open, 150, 'terms_module');
  }

  this.open = function () {
    OB.UI.replaceMain('modules/terms_of_use/terms_of_use.html');
  }
}
