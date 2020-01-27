<?php

class TermsOfUse extends OBFController {
  public function __construct() {
    parent::__construct();
    $this->model = $this->load->model('TermsOfUse');

    $this->user->require_permission('terms_module');
  }


}
