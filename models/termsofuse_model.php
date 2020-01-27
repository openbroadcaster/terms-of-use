<?php

class TermsOfUseModel extends OBFModel {
  public function terms_load () {
    $this->db->where('name', 'terms_of_use');
    $terms = $this->db->get_one('settings');

    if (empty($terms)) {
      return [false, 'No terms found in database. Possible database error or no terms of use have been saved yet.'];
    }

    return [true, 'Terms loaded.', $terms['value']];
  }

  public function terms_update ($terms) {
    $this->db->where('name', 'terms_of_use');
    if (empty($this->db->get_one('settings'))) {
      // TOU record doesn't exist in settings yet, so insert a new one.
      $this->db->insert('settings', [
        'name'  => 'terms_of_use',
        'value' => $terms
      ]);
      $this->db->insert('settings', [
        'name'  => 'terms_of_use_time',
        'value' => time()
      ]);
    } else {
      // TOU record exists, update existing setting.
      $this->db->where('name', 'terms_of_use');
      $this->db->update('settings', [
        'name'  => 'terms_of_use',
        'value' => $terms
      ]);
      $this->db->where('name', 'terms_of_use_time');
      $this->db->update('settings', [
        'name'  => 'terms_of_use_time',
        'value' => time()
      ]);
    }

    return [true, 'Successfully updated Terms of Use.'];
  }

  public function terms_display ($terms_agreed) {
    $this->db->where('name', 'terms_of_use_time');
    $terms_updated = $this->db->get_one('settings');

    if (empty($terms_updated) || $terms_agreed > $terms_updated['value']) {
      return [false, 'Already agreed to terms or no terms defined in database.'];
    }

    $this->db->where('name', 'terms_of_use');
    $terms = $this->db->get_one('settings');
    return [true, 'Please agree to the terms before continuing.', $terms['value']];
  }

  public function terms_agree ($user_id) {
    $this->db->where('user_id', $user_id);
    $this->db->where('setting', 'terms_agreed');
    if (empty($this->db->get_one('users_settings'))) {
      // Not agreed to TOU before, insert new setting.
      $this->db->insert('users_settings', [
        'user_id' => $user_id,
        'setting' => 'terms_agreed',
        'value'   => time()
      ]);
    } else {
      // Agreed to updated TOU, update setting.
      $this->db->where('user_id', $user_id);
      $this->db->where('setting', 'terms_agreed');
      $this->db->update('users_settings', [
        'user_id' => $user_id,
        'setting' => 'terms_agreed',
        'value'   => time()
      ]);
    }

    return [true, 'Successfully agreed to terms.'];
  }
}
