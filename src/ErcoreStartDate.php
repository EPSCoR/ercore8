<?php

namespace Drupal\ercore;

use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class ErcoreStartDate.
 *
 * @package Drupal\ercore
 */
class ErcoreStartDate {

  /**
   * ERCore start datetime value.
   *
   * @var \Drupal\Core\Datetime\DrupalDateTime
   */
  public $start = '';

  /**
   * ERCore end datetime value.
   *
   * @var \Drupal\Core\Datetime\DrupalDateTime
   */
  public $end = '';

  /**
   * ERCore year variable.
   *
   * @var int
   */
  public $year = '';

  /**
   * ERCore format variable.
   *
   * @var string
   */
  public $argumentFormat = 'Y-m-d';

  /**
   * ErcoreStartDate constructor.
   */
  public function __construct() {
    $start = \Drupal::config('ercore.settings')->get('ercore_epscor_start');
    $this->start = DrupalDateTime::createFromFormat($this->argumentFormat, $start);
    $exploded = explode('-', $start);
    $this->year = $exploded[0];
  }

  /**
   * Returns the basic start date.
   *
   * @returns DrupalDateTime
   *   Returns base start time date object.
   */
  public function startDate() {
    return $this->start;
  }

  /**
   * Generates start date year for processing elsewhere.
   *
   * @return int
   *   Returns Start year.
   */
  public function startYear() {
    return $this->year;
  }

  /**
   * Generates start and end dates for views and displays YYYY-MM-DD.
   *
   * @return array
   *   Returns start/end dates in specific format for forms.
   */
  public function startEndDates() {
    //$default_date['start'] = date_format($default, $argument_date_format);
   // $default_date['end'] = date($argument_date_format, strtotime('+1 year'));
    //return $default_date;
  }

}
