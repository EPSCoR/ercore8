<?php

namespace Drupal\ercore_core;

/**
 * Class ErcoreEngagement.
 *
 * @package Drupal\ercore_core
 */
class ErcoreEngagement {
  public $type = '';
  public $ariFac = '0';
  public $ariStu = '0';
  public $puiFac = '0';
  public $puiStu = '0';
  public $msiFac = '0';
  public $msiStu = '0';
  public $k12ttr = '0';
  public $k12tch = '0';
  public $k12dir = '0';
  public $other = '0';
  public $total = '0';

  /**
   * Constructor.
   */
  public function __construct() {

  }

  /**
   * Sets name of object.
   *
   * @param string $type
   *   Name to set name value as.
   */
  public function setName($type) {
    $this->type = $type;
  }

}
