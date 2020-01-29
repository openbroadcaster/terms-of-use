<?php

class TermsOfUse extends OBFController {
  public function __construct() {
    parent::__construct();
    $this->model = $this->load->model('TermsOfUse');
  }

  public function terms_load () {
    return $this->model('terms_load');
  }

  public function terms_update () {
    $this->user->require_permission('terms_module');

    return $this->model('terms_update', $this->data['terms']);
  }

  public function terms_display () {
    $terms_agreed = $this->user->get_setting('terms_agreed');
    return $this->model('terms_display', $terms_agreed);
  }

  public function terms_agree () {
    return $this->model('terms_agree', $this->user->param('id'));
  }
}
