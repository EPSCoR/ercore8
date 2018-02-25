<?php
/**
 * @file
 * File for the ERCore NSF Table C.
 */

require_once drupal_get_path('module', 'ercore_core') . "/includes/ercore-admin-var.inc";


/**
 * Display NSF Table C data in preparation for exporting to Excel.
 *
 * @return array $form
 *    Returns form array for page display.
 */
function nsf_table_c_callback() {
  $form = array();
  $theme_variable = 'ercore_table_c';
  // Used within the following include.
  include_once drupal_get_path('module', 'ercore_core') . "/includes/ercore-admin-form-filter.inc";
  return $form;
}

/**
 * This theme function (see theme.inc) generates the summary table.
 *
 * @param array $variables
 *    A nested a array of date ranges.
 *
 * @return array $summary
 *   Returns $summary form array
 */
function ercore_table_c($variables) {
  $date_range = $variables['ranges'];
  $title = 'Download NSF Table C';
  if (isset($date_range[0])) {
    $range = $date_range;
    $date_argument = ercore_admin_download_path($date_range);
    $range_display = 'Date range is ' . ercore_displayed_date_ranges($variables['ranges']) . '.';
  }
  else {
    $range = array();
    $date_argument = NULL;
    $range_display = 'Date range is undefined.';
  }

  $path = array('/ercore/views/collaborations/download/');
  $table_link = ercore_admin_table_link($title, $path, $range);
  $summary['linking'] = array(
    '#tag' => 'p',
    '#attributes' => array(
      'class' => 'table-header table-c data-link',
    ),
    '#value' => $table_link,
    '#theme' => 'html_tag',
    '#access' => array('access ercore excel sheets'),

  );
  $summary['range_display'] = array(
    '#tag' => 'p',
    '#attributes' => array(
      'class' => 'range-display',
    ),
    '#value' => $range_display,
    '#theme' => 'html_tag',
    '#access' => array('access ercore excel sheets'),

  );
  $summary['data'] = array(
    '#tag' => 'div',
    '#attributes' => array(
      'class' => 'table-wrapper',
      'id' => 'ercore_table_c',
    ),
    '#value' => views_embed_view('ercore_table_c_display', 'panel_pane_1', $date_argument),
    '#theme' => 'html_tag',
  );

  return render($summary);
}
