<?php

namespace Drupal\ercore_core;

/**
 * Class ErcoreCollaboration.
 *
 * @package Drupal\ercore_core
 */
class ErcoreCollaboration {
  public $type = '';
  public $localInstitutions = '0';
  public $localCollaborators = '0';
  public $domesticInstitutions = '0';
  public $domesticCollaborators = '0';
  public $foreignInstitutions = '0';
  public $foreignCollaborators = '0';

  /**
   * Constructor.
   */
  public function __construct() {

  }

  /**
   * Sets type of object.
   *
   * @param string $type
   *   Name to set name value as.
   */
  public function setName($type) {
    $this->type = $type;
  }

  /**
   * Placement of data from query in Participant data object.
   *
   * @param array $data_row
   *   Data array query.
   */
  public function groupData(array $data_row) {
    if (isset($data_row['local'])) {
      $this->localInstitutions++;
      $this->localCollaborators += count($data_row['local']);
    }
    if (isset($data_row['domestic'])) {
      $this->domesticInstitutions++;
      $this->domesticCollaborators += count($data_row['domestic']);
    }
    if (isset($data_row['foreign'])) {
      $this->foreignInstitutions++;
      $this->foreignCollaborators += count($data_row['foreign']);
    }
  }

}
