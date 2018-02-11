<?php

/**
 * @file
 * Administrative variables for ERCore Admin module.
 */

/**
 * Generates start and end dates for views and displays YYYY-MM-DD.
 *
 * @return array
 *   Returns start/end dates in specific format for forms.
 */
function ercore_start_end_dates() {
  $ercore_date = \Drupal::config('ercore.settings')->get('ercore_epscor_start');
  $argument_date_format = 'Y-m-d';
  $default = date_create($ercore_date);
  $default_date['start'] = date_format($default, $argument_date_format);
  $default_date['end'] = date($argument_date_format, strtotime('+1 year'));
  return $default_date;
}

/**
 * Generates start and end dates for views and displays YYYY-MM.
 *
 * @return array
 *   Returns start/end dates in specific format for forms.
 */
function ercore_admin_view_start_end_dates() {
  $ercore_date = \Drupal::config('ercore.settings')->get('ercore_epscor_start');
  $argument_date_format = 'Y-m';
  $default = date_create($ercore_date);
  $default_date['start'] = date_format($default, $argument_date_format);
  $default_date['end'] = date($argument_date_format, strtotime('+1 year'));
  return $default_date;
}

/**
 * Generates start and end dates for views and displays Month Day, Year.
 *
 * @return array
 *   Returns start/end dates for display purposes.
 */
function ercore_start_end_dates_displayed() {
  $ercore_date = \Drupal::config('ercore.settings')->get('ercore_epscor_start');
  $argument_date_format = \Drupal::config('ercore.settings')->get('ercore_admin_date_display');
  $default = date_create($ercore_date);
  $dates['start'] = date_format($default, $argument_date_format);
  $dates['end'] = date($argument_date_format, strtotime('+1 year'));
  $new_dates = $dates['start'] . ' to ' . $dates['end'];
  return $new_dates;
}

/**
 * Generates start/end date array for forms.
 *
 * @return array
 *   Returns default date range array with Unix timestamps.
 */
function ercore_admin_default_start_end_dates() {
  $default_range = ercore_start_end_dates();
  $default_date_array = ercore_admin_date_array_to_unix($default_range);
  return $default_date_array;
}

/**
 * Change format of date array for display purposes.
 *
 * @param array $dates
 *   Receives $date array for reformatting.
 *
 * @return string
 *   Returns date string or Boolean FALSE.
 */
function ercore_displayed_date_ranges(array &$dates) {
  $display_date_format = \Drupal::config('ercore.settings')->get('ercore_admin_date_display');
  if (isset($dates[0])) {
    $new_dates = date($display_date_format, $dates[0][0]) . ' to ' . date($display_date_format, $dates[0][1]);
  }
  elseif (isset($dates['start'])) {
    $new_dates = date($display_date_format, strtotime($dates['start'] . '-01')) . ' to ' . date($display_date_format, strtotime($dates['end'] . '-01'));
  }
  else {
    $new_dates = NULL;
  }
  return $new_dates;
}

/**
 * Generates dates for views and displays.
 *
 * @return array
 *   Returns date array for forms.
 */
function ercore_this_date_range() {
  $reporting_month = \Drupal::config('ercore.settings')->get('ercore_reporting_month');
  $start_date = \Drupal::config('ercore.settings')->get('ercore_epscor_start');
  $start_date = new DateTime($start_date['year'] . '-' . $start_date['month'] . '-' . $start_date['day'] . ' 00:00:00');
  $today_month = date('m');
  if ($today_month < $reporting_month) {
    $current_start = new DateTime((date('Y') - 1) . '-' . $reporting_month . '-01 00:00:00');
  }
  else {
    $current_start = new DateTime(date('Y') . '-' . $reporting_month . '-01 00:00:00');
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
function ercore_admin_current_range_argument() {
  $argument_date_format = \Drupal::config('ercore.settings')->get('ercore_admin_date_filter');
  $reporting_month = \Drupal::config('ercore.settings')->get('ercore_reporting_month');
  $start_date = \Drupal::config('ercore.settings')->get('ercore_epscor_start');
  $start_date = $start_date['year'] . '-' . $start_date['month'];
  $today_month = date('m');
  if ($today_month < $reporting_month) {
    $current_range['start'] = (date('Y') - 1) . '-' . $reporting_month;
    $current_range['end'] = date('Y') . '-' . $reporting_month;
  }
  else {
    $current_range['start'] = date('Y') . '-' . $reporting_month;
    $current_range['end'] = (date('Y') + 1) . '-' . $reporting_month;
  }
  if ($start_date > $current_range['start']) {
    $current_range['start'] = $start_date;
    $current_range['end'] = date('Y') . '-' . $reporting_month;
  }

  return $current_range;
}

/**
 * Generates an array of reporting periods (ercore-reporting.inc).
 *
 * @return array
 *   Returns select list array for use on NSF tables and summary form.
 */
function ercore_select_list() {
  $display_date_format = \Drupal::config('ercore.settings')->get('ercore_admin_date_display');
  $ranges = ercore_get_reporting_ranges();
  // This returns the list of available date ranges...
  $range = ercore_get_reporting_range();
  // Get the select reporting period, defaults to current reporting period.
  $range_is_set = _reporting_range_is_set();
  // A reporting period selected or default.
  $select_list = array('Select');
  foreach ($ranges as $k => $v) {
    $select_list[] = date($display_date_format, $v[0]) . ' to ' . date($display_date_format, $v[1]);
    if ($range_is_set && $range == $v) {
      $selected = $k + 1;
    }
  }
  return $select_list;
}

/**
 * Generates a date ranges of reporting period. (ercore-reporting.inc).
 *
 * @return array
 *   Returns date array for reporting page.
 */
function ercore_get_reporting_ranges() {
  static $ranges = array();
  if (!count($ranges)) {
    $start_date = \Drupal::config('ercore.settings')->get('ercore_epscor_start');
    $reporting_month = intval(\Drupal::config('ercore.settings')->get('ercore_reporting_month'));
    $cur_month = date('n');
    $adjusted_date = mktime(0, 0, 0, $cur_month - $reporting_month + 7);
    // +half a year into the future (6) +1 offset.
    $cur_year = date('Y', $adjusted_date);
    $start_year = $start_date['year'];
    for ($y = $cur_year; $y >= $start_year; $y--) {
      $ranges[] = _generate_reporting_range($y);
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
function ercore_get_reporting_range($use_default = TRUE) {
  drupal_session_start();
  if (array_key_exists('ercore_start_date', $_SESSION) && array_key_exists('ercore_end_date', $_SESSION)) {
    return array($_SESSION['ercore_start_date'], $_SESSION['ercore_end_date']);
  }
  else {
    if ($use_default) {
      $reporting_month = intval(\Drupal::config('ercore.settings')->get('ercore_reporting_month'));
      $cur_month = date('n');
      $adjusted_date = mktime(0, 0, 0, $cur_month - $reporting_month - 5);
      $year = date('Y', $adjusted_date);
      return _generate_reporting_range($year);
    }
    else {
      return FALSE;
    }
  }
}

/**
 * This returns a date range as a pair of unix timestamps in an array.
 *
 * @param array $year
 *   Receives date value.
 *
 * @return array
 *   Returns date array for internal function.
 */
function _generate_reporting_range(array $year) {
  static $start_date;
  static $reporting_month;
  if (!isset($start_date)) {
    $start_date = \Drupal::config('ercore.settings')->get('ercore_epscor_start');
  }
  if (!isset($reporting_month)) {
    $reporting_month = intval(\Drupal::config('ercore.settings')->get('ercore_reporting_month'));
  }
  $last_month = $reporting_month - 1;
  $last_day = date('t', strtotime($last_month . '/1/' . $year));

  if ($year == $start_date['year']) {
    $second_year = array();
    $second_year['month'] = $last_month;
    $second_year['day'] = $last_day;
    $second_year['year'] = $start_date['year'] + 1;

    $date1 = implode('/', $start_date);
    $date2 = implode('/', $second_year);
    return array(
      ercore_admin_unix_date($date1),
      ercore_admin_unix_date($date2),
    );
  }
  else {
    $date1 = $reporting_month . '/1/' . $year;
    $next_year = $year + 1;
    $date2 = $last_month . '/' . $last_day . '/' . $next_year;

    return array(
      ercore_admin_unix_date($date1),
      ercore_admin_unix_date($date2),
    );
  }
}

/**
 * Receives php date and returns Unix timestamp.
 *
 * @param array $var
 *   Receives date value.
 *
 * @return array
 *   Returns unix date for internal function.
 */
function ercore_admin_unix_date(array &$var) {
  $zone = \Drupal::config('system.date')->get('timezone.default');
  $time = ' 00:00:00 ' . $zone;
  $new_time = strtotime($var . $time);
  return $new_time;
}

/**
 * Generates date ranges for reporting period. (ercore_change_date_range).
 */
function _summary_table_ranges() {
  if ($range = ercore_get_reporting_range(FALSE)) {
    return array($range);
  }
  else {
    return ercore_get_reporting_ranges();
  }
}

/**
 * Sets date ranges for other function (ercore_select_list).
 */
function _reporting_range_is_set() {
  return array_key_exists('ercore_start_date', $_SESSION) && array_key_exists('ercore_end_date', $_SESSION);
}

/**
 * Ajax callback: ercore-reporting.inc and ercore-admin-form-filter.inc.
 */
function ercore_change_reporting_year($form, $form_state) {
  $ranges = ercore_get_reporting_ranges();
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
function ercore_change_date_range($form, $form_state) {
  $ranges = array();
  if ($form_state['values']['op'] == t('Save')) {
    $s = strtotime($form_state['values']['dates']['start_date']);
    $e = strtotime($form_state['values']['dates']['end_date']);
    if ($s <= $e) {
      $_SESSION['ercore_start_date'] = $s;
      $_SESSION['ercore_end_date'] = $e;
      $_SESSION['default_reporting_form'] = TRUE;
      $ranges = array(array($s, $e));
    }
    else {
      drupal_set_message("Start date must be earlier than end date.", 'error');
    }
  }
  else {
    unset($_SESSION['ercore_start_date']);
    unset($_SESSION['ercore_end_date']);
    $_SESSION['default_reporting_form'] = FALSE;
    $ranges = _summary_table_ranges();
  }
  $form['table']['#ranges'] = $ranges;
  return $form['table'];
}

/**
 * Ajax callback function for ercore-admin-form-filter.inc.
 */
function ercore_nsf_tables_change_date($form, $form_state) {
  $ranges = array();
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
function ercore_admin_table_link(&$title, array &$path, array &$ranges) {
  $date = ercore_admin_download_path($ranges);
  $url = $path[0];
  $link = l($title, $url . $date, array('attributes' => array('class' => array('admin-table-link'))));

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
function ercore_admin_download_path(array &$ranges) {
  $argument_date_format = \Drupal::config('ercore.settings')->get('ercore_admin_date_filter');
  if (isset($ranges[0][0])) {
    $start = date($argument_date_format, $ranges[0][0]);
    $end = date($argument_date_format, $ranges[0][1]);
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
function ercore_admin_date_argument_to_array(&$date_range) {
  $zone = \Drupal::config('system.date')->get('timezone.default');
  $time = ' 00:00:00 ' . $zone;
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
function ercore_admin_date_array_converter(array &$date_range) {
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
function ercore_admin_date_array_to_unix(array &$date_range) {
  $new_range = array();
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
function ercore_date_range_check(&$date_within, &$date_range) {
  $date_within = strtotime($date_within);
  return (($date_range[0][0] <= $date_within) && ($date_range[0][1] >= $date_within));
}
