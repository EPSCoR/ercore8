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
  static public $fieldFormat = 'd/m/Y';

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
   * Returns end date in Unix format.
   *
   * @returns int
   *   Returns unix timestamp formatted end date, one year from today.
   */
  public static function endDateUnix() {
    return strtotime(date(self::$argumentFormat, time()) . " + 365 day");
  }

  /**
   * Returns end date as DrupalDateTime.
   *
   * @returns DrupalDateTime
   *   Returns DrupalDateTime end date, one year from today.
   */
  public static function endDate() {
    return DrupalDateTime::createFromTimestamp(self::endDateUnix());
  }

  /**
   * Returns end date formatting to argument format.
   *
   * @returns string
   *   Returns string of end date, one year from today.
   */
  public static function endString() {
    return self::endDate()->format(self::$argumentFormat);
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
   * Generates range start.
   *
   * @return array
   *   Returns date array for forms.
   */
  public static function ercoreDateRangeStart() {
    $today_month = date('m');
    $reporting_month = self::reportingMonth();
    $start_date = self::startYearMonth();
    if ($today_month < $reporting_month) {
      $current_start = DrupalDateTime::createFromFormat(self::$argumentFormat, (date('Y') - 1) . '-' . $reporting_month . '-01');
    }
    else {
      $current_start = DrupalDateTime::createFromFormat(self::$argumentFormat, date('Y') . '-' . $reporting_month . '-01');
    }
    if ($start_date > $current_start) {
      $current_start = $start_date;
    }
    return $current_start;
  }

  /**
   * Generates dates for views and displays.
   *
   * @return array
   *   Returns date array for forms.
   */
  public static function ercoreCurrentRangeArgument() {
    $month = self::reportingMonth();
    $start_date = self::startYearMonth();
    $today_month = date('m');
    if ($today_month < $month) {
      $current_range['start'] = (date('Y') - 1) . '-' . $month;
      $current_range['end'] = date('Y') . '-' . $month;
    }
    else {
      $current_range['start'] = date('Y') . '-' . $month;
      $current_range['end'] = (date('Y') + 1) . '-' . $month;
    }
    if ($start_date > $current_range['start']) {
      $current_range['start'] = $start_date;
      $current_range['end'] = date('Y') . '-' . $month;
    }
    return $current_range;
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
   * Generates an array of reporting periods (ercore-accomplishments.inc).
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
        date(self::$argumentFormat, $value[0]),
        date(self::$argumentFormat, $value[1]),
      ];
    }
    return $select_list;
  }

  /**
   * Generates a date ranges of reporting period. (ercore-accomplishments.inc).
   *
   * @return array
   *   Returns date array for reporting page.
   */
  public static function ercoreGetReportingRanges() {
    $ranges = [];
    if (!count($ranges)) {
      $current_month = date('n');
      $adjusted_date = time(0, 0, 0, $current_month - self::reportingMonth() + 7);
      // +half a year into the future (6) +1 offset.
      $current_year = date('Y', $adjusted_date);
      for ($year = $current_year; $year >= self::startYear(); $year--) {
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
    $last_day = date('t', strtotime($last_month . '/1/' . $year));

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

}
