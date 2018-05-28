<?php

namespace Drupal\ercore_core;

/**
 * Class ErcoreParticipant.
 *
 * @package Drupal\ercore_core
 */
class ErcoreParticipantColumn {
  public $name = '';
  public $total = '0';
  public $male = '0';
  public $female = '0';
  public $black = '0';
  public $hispanic = '0';
  public $other = '0';
  public $disabled = '0';
  public $new = '0';

  /**
   * Sets name of object.
   *
   * @param string $name
   *   Name to set name value as.
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Placement of data from query in Participant data object.
   *
   * @param array $data_row
   *   Data array query.
   */
  public function groupData(array $data_row) {
    $this->total++;
    if ($data_row['gender'] === 'Male') {
      $this->male++;
    }
    // Female.
    if ($data_row['gender'] === 'Female') {
      $this->female++;
    }
    // Black.
    if ($data_row['race'] === 'Black or African American') {
      $this->black++;
    }
    // Hispanic.
    if ($data_row['ethnicity'] === 'Hispanic or Latino') {
      $this->hispanic++;
    }
    // Other.
    if ($data_row['race'] === 'American Indian or Alaskan Native' || $data_row['race'] === 'Pacific Islander' || $data_row['race'] == 'Native Hawaiian') {
      $this->other++;
    }
    // Disabled.
    if ($data_row['disability'] !== 'None') {
      $this->disabled++;
    }
    // New Participant within supplied date range.
    if ($data_row['new'] === TRUE) {
      $this->new++;
    }
  }

}
