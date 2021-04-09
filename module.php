<?php

class TermsOfUseModule extends OBFModule {
  public $name = 'Terms of Use v1.0';
  public $description = 'Customized Terms of Use';

  public function callbacks () {

  }

  public function install () {
    $this->db->insert('users_permissions', [
      'category'    => 'terms of use',
      'description' => 'edit terms of service shown to users',
      'name'        => 'terms_module'
    ]);

    return true;
  }

  public function uninstall () {
    $this->db->where('name','terms_module');
    $permission = $this->db->get_one('users_permissions');

    $this->db->where('permission_id', $permission['id']);
    $this->db->delete('users_permissions_to_groups');

    $this->db->where('id', $permission['id']);
    $this->db->delete('users_permissions');

    return true;
  }
}
