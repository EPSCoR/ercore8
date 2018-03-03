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
   * Reporting month.
   *
   * @var int
   */
  public $reportingMonth = '';

  /**
   * Year.
   *
   * @var int
   */
  public $startYear = '';

  /**
   * Year-Month.
   *
   * @var string
   */
  public $startYearMonth = '';

  /**
   * Start date as string.
   *
   * @var string
   */
  public $startString = '';

  /**
   * End date as string.
   *
   * @var string
   */
  public $endString = '';

  /**
   * End date as Y-m string.
   *
   * @var string
   */
  public $endYearMonth = '';

  /**
   * Start date as string for display.
   *
   * @var string
   */
  public $startDisplay = '';

  /**
   * End date as string for display.
   *
   * @var string
   */
  public $endDisplay = '';

  /**
   * Start date as unix timestamp.
   *
   * @var string
   */
  public $startUnix = '';

  /**
   * End date as unix timestamp.
   *
   * @var string
   */
  public $endUnix = '';

  /**
   * Argument format.
   *
   * @var string
   */
  public $argumentFormat = 'Y-m-d';

  /**
   * Display format.
   *
   * @var string
   */
  public $displayFormat = 'F j, Y';

  /**
   * Time Zone.
   *
   * @var string
   */
  public $zone = '';

  /**
   * ErcoreStartDate constructor.
   */
  public function __construct() {
    $start = \Drupal::config('ercore.settings')->get('ercore_epscor_start');
    $this->reportingMonth = \Drupal::config('ercore.settings')
      ->get('ercore_reporting_month');
    $this->start = DrupalDateTime::createFromFormat($this->argumentFormat, $start);
    $exploded = explode('-', $start);
    $this->startYear = $exploded[0];
    $this->startYearMonth = $exploded[0] . '-' . $exploded[1];
    $this->startString = $start;
    $this->startUnix = $this->start->format('U');
    $this->endUnix = strtotime(date($this->argumentFormat, mktime()) . " + 365 day");
    $this->end = DrupalDateTime::createFromTimestamp($this->endUnix);
    $this->endYearMonth = $this->end->format('Y-m');
    $this->endString = $this->end->format($this->argumentFormat);
    $this->startDisplay = $this->start->format($this->displayFormat);
    $this->endDisplay = $this->end->format($this->displayFormat);
    $this->zone = \Drupal::config('system.date')->get('timezone.default');
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
   * Generates start and end dates for views and displays YYYY-MM-DD.
   *
   * @return array
   *   Returns start/end dates as date objects.
   */
  public function startEndDates() {
    $date['start'] = $this->start;
    $date['end'] = $this->end;
    return $date;
  }

  /**
   * Generates start and end dates for views and displays YYYY-MM-DD.
   *
   * @return array
   *   Returns start/end dates in specific format for forms.
   */
  public function startEndDatesString() {
    $date['start'] = $this->startString;
    $date['end'] = $this->endString;
    return $date;
  }

  /**
   * Generates start and end dates for views and displays YYYY-MM.
   *
   * @return array
   *   Returns start/end dates in specific format for forms.
   */
  public function adminStartEndDates() {
    $default_date['start'] = $this->startYearMonth;
    $default_date['end'] = $this->endYearMonth;
    return $default_date;
  }

  /**
   * Generates start and end dates for display.
   *
   * @return array
   *   Returns start/end dates in specific format for forms.
   */
  public function startEndDatesDisplay() {
    $date['start'] = $this->startDisplay;
    $date['end'] = $this->endDisplay;
    return $date;
  }

  /**
   * Generates start and end dates with unix timestamps.
   *
   * @return array
   *   Returns start/end dates in specific format for forms.
   */
  public function startEndDatesUnix() {
    $date['start'] = $this->startUnix;
    $date['end'] = $this->endUnix;
    return $date;
  }

  /**
   * Generates range start.
   *
   * @return array
   *   Returns date array for forms.
   */
  public function ercoreDateRangeStart() {
    $today_month = date('m');
    $reporting_month = $this->reportingMonth;
    $start_date = $this->startYearMonth;
    if ($today_month < $reporting_month) {
      $current_start = DrupalDateTime::createFromFormat($this->argumentFormat, (date('Y') - 1) . '-' . $reporting_month . '-01');
    }
    else {
      $current_start = DrupalDateTime::createFromFormat($this->argumentFormat, date('Y') . '-' . $reporting_month . '-01');
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
  public function ercoreCurrentRangeArgument() {
    $month = $this->reportingMonth;
    $start_date = $this->startYearMonth;
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
   *   Returns select list array for use on NSF tables and summary form.
   */
  public function ercoreSelectList() {
    $range_is_set = NULL;
    $temp_store = \Drupal::service('user.private_tempstore')
      ->get('ercore_core');
    // Returns the list of available date ranges.
    $ranges = $this->ercoreGetReportingRanges();
    // Gets the selected reporting period, defaults to current reporting period.
    $range = $this->ercoreGetReportingRange();
    // A reporting period selected or default.
    if (array_key_exists('set_range', $temp_store)) {
      $range_is_set = $temp_store['set_range'];
    }
    // A reporting period selected or default.
    $select_list = ['Select'];
    foreach ($ranges as $key => $value) {
      $select_list[] = date($this->displayFormat, $value[0]) . ' to ' . date($this->displayFormat, $value[1]);
      if (!empty($range_is_set) && $range == $value) {
        $selected = $key + 1;
      }
    }
    return $select_list;
  }

  /**
   * Generates a date ranges of reporting period. (ercore-accomplishments.inc).
   *
   * @return array
   *   Returns date array for reporting page.
   */
  public function ercoreGetReportingRanges() {
    static $ranges = [];
    if (!count($ranges)) {
      $current_month = date('n');
      $adjusted_date = mktime(0, 0, 0, $current_month - $this->reportingMonth + 7);
      // +half a year into the future (6) +1 offset.
      $current_year = date('Y', $adjusted_date);
      for ($year = $current_year; $year >= $this->startYear; $year--) {
        $ranges[] = $this->generateReportingRange($year);
      }
    }
    return $ranges;
  }

  /**
   * Generates a date range corresponding to the starting date.
   *
   * @param bool $use_default
   *   Defines reporting ranges if default is true.
   *
   * @return array
   *   Returns date array or boolean FALSE.
   */
  public function ercoreGetReportingRange($use_default = TRUE) {
    $temp_store = \Drupal::service('user.private_tempstore')
      ->get('ercore_core');
    if (array_key_exists('ercore_start_date', $temp_store) && array_key_exists('ercore_end_date', $temp_store)) {
      return [
        $temp_store['ercore_start_date'],
        $temp_store['ercore_end_date'],
      ];
    }
    else {
      if ($use_default) {
        $cur_month = date('n');
        $adjusted_date = mktime(0, 0, 0, $cur_month - $this->reportingMonth - 5);
        $year = date('Y', $adjusted_date);
        $range = $this->generateReportingRange($year);
        $temp_store->set('ercore_start_date', $range[0]);
        $temp_store->set('ercore_end_date', $range[1]);
        return $range;
      }
      else {
        return FALSE;
      }
    }
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
  public function generateReportingRange($year) {
    $last_month = $this->reportingMonth - 1;
    $last_day = date('t', strtotime($last_month . '/1/' . $year));

    if ($year == $this->startYear) {
      $second = $last_month . '-' . $last_day . '-' . ($this->startYear + 1);
      $second_year = DrupalDateTime::createFromFormat('n-j-Y', $second);
      return [
        $this->startUnix,
        $second_year->format('U'),
      ];
    }
    else {
      $first = ($this->reportingMonth - 0) . '-1-' . $year;
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
   * Generates date ranges for reporting period. (ercore_change_date_range).
   */
  public function summaryTableRanges() {
    if ($range = $this->ercoreGetReportingRange(FALSE)) {
      return array($range);
    }
    else {
      return $this->ercoreGetReportingRanges();
    }
  }

  /**
   * Ajax callback: ercore-reporting.inc and ercore-admin-form-filter.inc.
   */
  public function ercoreChangeReportingYear($form, $form_state) {
    $ranges = $this->ercoreGetReportingRanges();
    $selected = $form_state['input']['reporting-year']['range'] - 1;
    if ($selected == -1) {
      unset($_SESSION['ercore_start_date']);
      unset($_SESSION['ercore_end_date']);
    }
    else {
      $_SESSION['ercore_start_date'] = $ranges[$selected][0];
      $_SESSION['ercore_end_date'] = $ranges[$selected][1];
      $ranges = array($ranges[$selected]);
    }
    $form['table']['#ranges'] = $ranges;
    return $form['table'];
  }

  /**
   * Ajax callback function for ercore-reporting.inc.
   */
  public function ercoreChangeDateRange($form, $form_state) {
    $ranges = [];
    if ($form_state['values']['op'] == t('Save')) {
      $s = strtotime($form_state['values']['dates']['start_date']);
      $e = strtotime($form_state['values']['dates']['end_date']);
      if ($s <= $e) {
        $_SESSION['ercore_start_date'] = $s;
        $_SESSION['ercore_end_date'] = $e;
        $_SESSION['default_reporting_form'] = TRUE;
        $ranges = [[$s, $e]];
      }
      else {
        drupal_set_message("Start date must be earlier than end date.", 'error');
      }
    }
    else {
      unset($_SESSION['ercore_start_date']);
      unset($_SESSION['ercore_end_date']);
      $_SESSION['default_reporting_form'] = FALSE;
      $ranges = $this->summaryTableRanges();
    }
    $form['table']['#ranges'] = $ranges;
    return $form['table'];
  }

  /**
   * Ajax callback function for ercore-admin-form-filter.inc.
   */
  public function ercoreNsfTablesChangeDate($form, $form_state) {
    $ranges = [];
    if ($form_state['values']['op'] == t('Save')) {
      $s = strtotime($form_state['values']['dates']['start_date']);
      $e = strtotime($form_state['values']['dates']['end_date']);
      if ($s <= $e) {
        $_SESSION['ercore_start_date'] = $s;
        $_SESSION['ercore_end_date'] = $e;
        $ranges = array(array($s, $e));
      }
      else {
        drupal_set_message("Start date must be earlier than end date.", 'error');
      }
    }
    else {
      unset($_SESSION['ercore_start_date']);
      unset($_SESSION['ercore_end_date']);
      $ranges = NULL;
    }
    $form['table']['#ranges'] = $ranges;
    return $form['table'];
  }

  /**
   * Receives link values and generates links to PHPExcel exported reports.
   *
   * @param string $title
   *   Link Title.
   * @param array $path
   *   Path for linking.
   * @param array $ranges
   *   Date range for use with views and $forms.
   *
   * @return array
   *   Drupal link array.
   */
  public function ercoreAdminTableLink(&$title, array &$path, array &$ranges) {
    $date = $this->ercoreAdminDownloadPath($ranges);
    $url = $path[0] . $date;
    $link = Link::fromTextAndUrl($title, $url);
    return $link;
  }

  /**
   * Receives date array and generates date arguments for NSF Tables.
   *
   * @param array $ranges
   *   Description.
   *
   * @return string
   *   Returns date argument string for use in NSF Tables.
   */
  public function ercoreAdminDownloadPath(array &$ranges) {
    if (isset($ranges[0][0])) {
      $start = date($this->argumentFormat, $ranges[0][0]);
      $end = date($this->argumentFormat, $ranges[0][1]);
      $date = $start . '--' . $end;
    }
    elseif (isset($ranges['start'])) {
      $start = $ranges['start'];
      $end = $ranges['end'];
      $date = $start . '--' . $end;
    }
    else {
      $date = NULL;
    }
    return $date;
  }

  /**
   * Receives dater string, returns date array for NSF tables.
   *
   * @param string $date_range
   *   String of date values.
   *
   * @return array
   *   Returns unix date array for use in NSF Tables.
   */
  public function ercoreAdminDateArgumentToArray(&$date_range) {
    $time = ' 00:00:00 ' . $this->zone;
    $range = explode('--', $date_range);
    $new_range[0][0] = strtotime($range[0] . $time);
    $new_range[0][1] = strtotime($range[1] . $time);
    return $new_range;
  }

  /**
   * Receives Drupal date array, returns array with altered array structure.
   *
   * @param array $date_range
   *   Drupal date array.
   *
   * @return array
   *   Returns date array with altered format.
   */
  public function ercoreAdminDateArrayConverter(array &$date_range) {
    $new_range[0][0] = $date_range['start'];
    $new_range[0][1] = $date_range['end'];
    return $new_range;
  }

  /**
   * Receives Drupal data array and returns unix date array.
   *
   * @param array $date_range
   *   Array of date values.
   *
   * @return array
   *   Returns unix date array for use in NSF Tables.
   */
  public function ercoreAdminDateArrayToUnix(array &$date_range) {
    $new_range = [];
    foreach ($date_range as $key => $date) {
      $new_range[$key] = strtotime($date);
    }
    return $new_range;
  }

  /**
   * Date range callback to verify dates within a given range.
   *
   * @param string $date_within
   *   A date to compare to the $date_range.
   * @param string $date_range
   *   A $date_range to check $date_within against.
   *
   * @return bool
   *   Returns boolean value, is $date_within within $date_range
   */
  public function ercoreDateRangeCheck(&$date_within, &$date_range) {
    $date_within = strtotime($date_within);
    return (($date_range[0][0] <= $date_within) && ($date_range[0][1] >= $date_within));
  }

}
