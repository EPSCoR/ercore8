<?php

namespace Drupal\ercore_event;

/**
 * Class ErcoreEngagement for counting values.
 *
 * @package Drupal\ercore_event
 */
class ErcoreEngagement {
  /**
   * ARI values for Engagements.
   *
   * @var int
   */
  public $ariFacF = 0;
  public $ariFacM = 0;
  public $ariFacMn = 0;
  public $ariFacU = 0;
  public $ariStuF = 0;
  public $ariStuM = 0;
  public $ariStuMn = 0;
  public $ariStuU = 0;

  /**
   * PUI values for Engagements.
   *
   * @var int
   */
  public $puiFacF = 0;
  public $puiFacM = 0;
  public $puiFacMn = 0;
  public $puiFacU = 0;
  public $puiStuF = 0;
  public $puiStuM = 0;
  public $puiStuMn = 0;
  public $puiStuU = 0;

  /**
   * MSI values for Engagements.
   *
   * @var int
   */
  public $msiFacF = 0;
  public $msiFacM = 0;
  public $msiFacMn = 0;
  public $msiFacU = 0;
  public $msiStuF = 0;
  public $msiStuM = 0;
  public $msiStuMn = 0;
  public $msiStuU = 0;

  /**
   * Other values for Engagements.
   *
   * @var int
   */
  public $otherF = 0;
  public $otherM = 0;
  public $otherMn = 0;
  public $otherU = 0;

  /**
   * K12 values for Engagements.
   *
   * @var int
   */
  public $k12DirF = 0;
  public $k12DirM = 0;
  public $k12DirMn = 0;
  public $k12DirU = 0;
  public $k12TchF = 0;
  public $k12TchM = 0;
  public $k12TchMn = 0;
  public $k12TchU = 0;
  public $k12TtrF = 0;
  public $k12TtrM = 0;
  public $k12TtrMn = 0;
  public $k12TtrU = 0;

  /**
   * Institution codes.
   *
   * @var array
   */
  private $instCodes = [
    '1' => 'ari',
    '2' => 'pui',
    '3' => 'msi',
    '4' => 'k12',
    '5' => 'other',
  ];

  /**
   * Person codes.
   *
   * @var array
   */
  private $personCode = [
    '1' => 'Fac',
    '2' => 'Stu',
    '3' => 'Fac',
    '4' => 'Stu',
  ];

  /**
   * Person codes for k12.
   *
   * @var array
   */
  private $k12Code = [
    '1' => 'Tch',
    '2' => 'Ttr',
    '3' => 'Tch',
    '4' => 'Ttr',
  ];

  /**
   * Constructor.
   */
  public function __construct() {

  }

  /**
   * Add engagement data to existing object.
   *
   * @param array $row
   *   Receives array of engagement data.
   */
  public function addEngagements(array $row) {
    if (!empty($row[6]) && strtoupper($row[6]) === 'Y') {
      return;
    }
    elseif (empty($row[2]) && empty($row[3]) && empty($row[4]) && empty($row[5]) && empty($row[6])) {
      return;
    }
    $inst = 'other';
    if (!empty($row[2])) {
      $inst = $this->instCodes[$row[2]];
    }
    $type = 'other';
    if ($inst === 'k12') {
      if (!empty($row[3])) {
        $type = $this->k12Code[$row[3]];
      }
    }
    else {
      if (!empty($row[3])) {
        $type = $this->personCode[$row[3]];
      }
    }
    $gender = 'U';
    if (!empty($row[4])) {
      $gender = strtoupper($row[4]);
    }
    if ($inst !== 'other') {
      $var = $inst . $type . $gender;
      $minority = $inst . 'Mn';
    }
    else {
      $var = $inst . $gender;
      $minority = $inst . 'Mn';
    }
    $this->$var = $this->$var + 1;
    if (!empty($row[5]) && $row[5] === 'y') {
      $this->$minority = $this->$minority + 1;
    }
  }

}
