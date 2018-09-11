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
   * Argument format.
   *
   * @var string
   */
  static public $argumentFormat = 'Y-m-d';

  /**
   * Display format.
   *
   * @var string
   */
  static public $displayFormat = 'F j, Y';

  /**
   * Field format.
   *
   * @var string
   */
  static public $fieldFormat = 'm/d/Y';

  /**
   * Returns the basic start date string.
   *
   * @returns string
   *   Returns base start time date object.
   */
  public static function startString() {
    return \Drupal::config('ercore.settings')->get('ercore_epscor_start');
  }

  /**
   * Returns reporting month.
   *
   * @returns int
   *   Returns integer of reporting month.
   */
  public static function reportingMonth() {
    return \Drupal::config('ercore.settings')->get('ercore_reporting_month');
  }

  /**
   * Returns the start date.
   *
   * @returns DrupalDateTime
   *   Returns base start time date object.
   */
  public static function startDate() {
    return DrupalDateTime::createFromFormat(self::$argumentFormat, self::startString());
  }

  /**
   * Returns the start date in unix format.
   *
   * @returns int
   *   Returns base start time date object.
   */
  public static function startUnix() {
    return self::startDate()->format('U');
  }

  /**
   * Returns the start date in $field format.
   *
   * @returns string
   *   Returns start time in $field format.
   */
  public static function startField() {
    return self::startDate()->format(self::$fieldFormat);
  }

  /**
   * Returns the start date in $display format.
   *
   * @returns string
   *   Returns start date in $display format.
   */
  public static function startDisplay() {
    return self::startDate()->format(self::$displayFormat);
  }

  /**
   * Start date value in Year-Month format.
   *
   * @returns string
   *   Returns string of start Year-Month.
   */
  public static function startYearMonth() {
    return self::startDate()->format('Y-m');
  }

  /**
   * Start date value in Year format.
   *
   * @returns int
   *   Returns string of start Year
   */
  public static function startYear() {
    return self::startDate()->format('Y');
  }

  /**
   * Returns end date as DrupalDateTime.
   *
   * @returns DrupalDateTime
   *   Returns DrupalDateTime end date, one year from today.
   */
  public static function endDate() {
    return DrupalDateTime::createFromFormat(self::$argumentFormat, self::endString());
  }

  /**
   * Returns end date in Unix format.
   *
   * @returns int
   *   Returns unix timestamp formatted end date, six years from today.
   */
  public static function endUnix() {
    return self::endDate()->format('U');
  }

  /**
   * Returns end date formatting to argument format.
   *
   * @returns string
   *   Returns string of end date, one year from today.
   */
  public static function endString() {
    return \Drupal::config('ercore.settings')->get('ercore_epscor_end');
  }

  /**
   * Returns the end date in $field format.
   *
   * @returns string
   *   Returns end time in $field format.
   */
  public static function endField() {
    return self::endDate()->format(self::$fieldFormat);
  }

  /**
   * Returns the end date in $display format.
   *
   * @returns string
   *   Returns end date in $display format.
   */
  public static function endDisplay() {
    return self::endDate()->format(self::$displayFormat);
  }

  /**
   * End date value in Year-Month format.
   *
   * @returns string
   *   Returns string of end Year-Month.
   */
  public static function endYearMonth() {
    return self::endDate()->format('Y-m');
  }

  /**
   * End date value in Year format.
   *
   * @returns int
   *   Returns string of end Year
   */
  public static function endYear() {
    return self::endDate()->format('Y');
  }

  /**
   * Returns today's date in Unix format.
   *
   * @returns int
   *   Returns unix timestamp formatted date.
   */
  public static function todayUnix() {
    return strtotime(date(self::$argumentFormat, time()));
  }

  /**
   * Generates start and end dates for views and displays YYYY-MM-DD.
   *
   * @return array
   *   Returns start/end dates as date objects.
   */
  public static function startEndDates() {
    $date['start'] = self::startString();
    $date['end'] = self::endString();
    return $date;
  }

  /**
   * Generates start and end dates for fields DD/MM/YYYY.
   *
   * @return array
   *   Returns start/end dates as date objects.
   */
  public static function fieldStartEndDates() {
    $date['start'] = self::startField();
    $date['end'] = self::endField();
    return $date;
  }

  /**
   * Generates start and end dates for views and displays YYYY-MM-DD.
   *
   * @return array
   *   Returns start/end dates in specific format for forms.
   */
  public static function startEndDatesString() {
    $date['start'] = self::startString();
    $date['end'] = self::endString();
    return $date;
  }

  /**
   * Generates start-end dates as views arguments.
   *
   * @return string
   *   Returns start/end dates in string YYYY-MM-DD--YYYY-MM-DD.
   */
  public static function startEndDatesUrlString() {
    $dates = self::startString() . '--' . self::endString();
    return $dates;
  }

  /**
   * Default Time Zone.
   *
   * @returns string
   *   Returns default time zone value.
   */
  public static function zone() {
    return \Drupal::config('system.date')->get('timezone.default');
  }

  /**
   * Generates start and end dates for views and displays YYYY-MM.
   *
   * @return array
   *   Returns start/end dates in specific format for forms.
   */
  public static function adminStartEndDates() {
    $default_date['start'] = self::startYearMonth();
    $default_date['end'] = self::endYearMonth();
    return $default_date;
  }

  /**
   * Generates start and end dates for display.
   *
   * @return array
   *   Returns start/end dates in specific format for forms.
   */
  public static function startEndDatesDisplay() {
    $date['start'] = self::startDisplay();
    $date['end'] = self::endDisplay();
    return $date;
  }

  /**
   * Generates start and end dates with unix timestamps.
   *
   * @return array
   *   Returns start/end dates in specific format for forms.
   */
  public static function startEndDatesUnix() {
    $date['start'] = self::startUnix();
    $date['end'] = self::endUnix();
    return $date;
  }

  /**
   * Generates an array of reporting periods (ercore-accomplishments.inc).
   *
   * @return array
   *   Returns select list array for use ERCoreDateFilter selection.
   */
  public static function ercoreSelectList() {
    // Returns the list of available date ranges.
    $ranges = self::ercoreGetReportingRanges();
    // A reporting period selected or default.
    $select_list = [
      'Select',
    ];
    foreach ($ranges as $key => $value) {
      $select_list[] = date(self::$displayFormat, $value[0]) . ' to ' . date(self::$displayFormat, $value[1]);
    }
    return $select_list;
  }

  /**
   * Generates an array of reporting periods.
   *
   * @return array
   *   Returns select list array for use on NSF tables and summary form.
   */
  public static function ercoreSelectListArguments() {
    // Returns the list of available date ranges.
    $ranges = self::ercoreGetReportingRanges();
    // A reporting period selected or default.
    $select_list[0] = [
      self::startString(),
      self::endString(),
    ];
    foreach ($ranges as $key => $value) {
      $select_list[] = [
        'start' => date(self::$argumentFormat, $value[0]),
        'end' => date(self::$argumentFormat, $value[1]),
      ];
    }
    return $select_list;
  }

  /**
   * Generates an array of reporting periods in Unix format.
   *
   * @return array
   *   Returns select list array for date comparisons.
   */
  public static function ercoreSelectListUnix() {
    // Returns the list of available date ranges.
    $ranges = self::ercoreGetReportingRanges();
    // A reporting period selected or default.
    $select_list[0] = self::startEndDatesUnix();
    foreach ($ranges as $key => $value) {
      $select_list[] = [
        'start' => $value[0],
        'end' => $value[1],
      ];
    }
    return $select_list;
  }

  /**
   * Generates a date ranges of reporting period.
   *
   * @return array
   *   Returns date array for reporting page.
   */
  public static function ercoreGetReportingRanges() {
    $ranges = [];
    if (!count($ranges)) {
      for ($year = self::endYear(); $year >= self::startYear(); $year--) {
        $ranges[] = self::generateReportingRange($year);
      }
    }
    return $ranges;
  }

  /**
   * This returns a date range as a pair of unix timestamps in an array.
   *
   * @param string $year
   *   Receives date value.
   *
   * @return array
   *   Returns date array for internal function.
   */
  public static function generateReportingRange($year) {
    $last_month = self::reportingMonth() - 1;
    $last_day = date('t', strtotime($last_month . '/1/' . ($year + 1)));
    if ($year == self::startYear()) {
      $second = $last_month . '-' . $last_day . '-' . (self::startYear() + 1);
      $second_year = DrupalDateTime::createFromFormat('n-j-Y', $second);
      return [
        self::startUnix(),
        $second_year->format('U'),
      ];
    }
    else {
      $first = (self::reportingMonth() - 0) . '-1-' . $year;
      $next = $last_month . '-' . $last_day . '-' . ($year + 1);
      $date1 = DrupalDateTime::createFromFormat('n-j-Y', $first);
      $date2 = DrupalDateTime::createFromFormat('n-j-Y', $next);
      return [
        $date1->format('U'),
        $date2->format('U'),
      ];
    }
  }

  /**
   * Receives a date in Argument format, returns Unix.
   *
   * @param string $date
   *   Receive date to be processed.
   *
   * @return int
   *   Returns Unix date integer.
   */
  public static function dateArgumentToUnix($date) {
    return DrupalDateTime::createFromFormat(self::$argumentFormat, $date)->format('U');
  }

  /**
   * Receives a date in Argument format, returns Field Format.
   *
   * @param string $date
   *   Receive date to be processed.
   *
   * @return int
   *   Returns Unix date integer.
   */
  public static function dateArgumentToField($date) {
    return DrupalDateTime::createFromFormat(self::$argumentFormat, $date)->format(self::$fieldFormat);
  }

  /**
   * Is this thje default date range.
   *
   * @returns bool
   *   Returns boolean of range.
   */
  public static function isDefaultRange() {
    $config = \Drupal::config('ercore.settings');
    $temp = \Drupal::service('user.private_tempstore')->get('ercore_core');
    if ($temp->get('ercore_filter_start') === $config->get('ercore_epscor_start') &&
      $temp->get('ercore_filter_end') === $config->get('ercore_epscor_end')) {
      return TRUE;
    }
    return FALSE;
  }

}
