<?php

/**
 * @file
 * File for the ERCore NSF Table A.
 */

/**
 * Display NSF Table A data in preparation for exporting to Excel.
 *
 * @return array
 *   Returns form array for page display.
 */
function nsf_table_a_callback() {
  $form = [];
  $theme_variable = 'ercore_table_a';
  // Used within the following include.
  include_once drupal_get_path('module', 'ercore_core') . '/includes/ercore-admin-form-filter.inc';
  return $form;
}

/**
 * This theme function (see theme.inc) generates the summary table.
 *
 * @param array $variables
 *   A nested a array of date ranges.
 *
 * @return array
 *   Returns render array of results.
 */
function ercore_table_a(array $variables) {
  $date_range = $variables['ranges'];
  $title = 'Download NSF Table A';
  if (isset($date_range[0])) {
    $range = $date_range;
    $range_display = 'Date range is ' . ercore_displayed_date_ranges($variables['ranges']) . '.';
  }
  else {
    $range = [];
    $range_display = 'Date range is undefined.';
  }

  $path = [
    '/ercore/views/salary-support/download/',
  ];
  $table_link = ercore_admin_table_link($title, $path, $range);
  $summary['linking'] = [
    '#tag' => 'p',
    '#attributes' => [
      'class' => 'table-header table-a data-link',
    ],
    '#value' => $table_link,
    '#theme' => 'html_tag',
    '#access' => [
      'access ercore excel sheets',
    ],
  ];
  $summary['range_display'] = [
    '#tag' => 'p',
    '#attributes' => [
      'class' => 'range-display',
    ],
    '#value' => $range_display,
    '#theme' => 'html_tag',
    '#access' => [
      'access ercore excel sheets',
    ],
  ];
  return render($summary);
}
