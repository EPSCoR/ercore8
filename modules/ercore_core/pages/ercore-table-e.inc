<?php
/**
 * @file
 * File for the ERCore NSF Table E.
 */

include_once drupal_get_path('module', 'ercore_admin') . "/includes/ercore-admin-var.inc";

/**
 * Display NSF Table E data in preparation for exporting to Excel.
 *
 * @return array
 *    Returns form array for page display.
 */
function nsf_table_e_callback() {
  $form = array();
  $theme_variable = 'ercore_table_e';
  // Used within the following include.
  include_once drupal_get_path('module', 'ercore_admin') . "/includes/ercore-admin-form-filter.inc";
  return $form;
}

/**
 * This theme function NSF Table E generates the table.
 *
 * @param array $variables
 *    A nested a array of date ranges.
 */
function ercore_table_e($variables) {
  $default_range = ercore_start_end_dates();
  $date_range = $variables['ranges'];
  $title = 'Download NSF Table E';
  if (isset($date_range[0])) {
    $range_display = 'Date range is ' . ercore_displayed_date_ranges($variables['ranges']) . '.';
    $range = $date_range;
    $date_argument = ercore_admin_download_path($date_range);
  }
  else {
    $range_display = 'Default date range is ' . ercore_displayed_date_ranges($default_range) . '.';
    $range = $default_range;
    $date_argument = ercore_admin_download_path($default_range);
  }

  $path = array('/ercore/views/outputs/download/');
  $table_link = ercore_admin_table_link($title, $path, $range);
  $summary['linking'] = array(
    '#tag' => 'p',
    '#attributes' => array(
      'class' => 'table-header table-e data-link',
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

  $summary['data_wrapper']['data_patents'] = array(
    '#tag' => 'div',
    '#attributes' => array(
      'class' => 'table-e-patents  table-e',
    ),
    '#value' => views_embed_view('ercore_table_e_patents', 'panel_pane_1', $date_argument),
    '#theme' => 'html_tag',
  );
  $summary['data_wrapper']['data_proposals'] = array(
    '#tag' => 'div',
    '#attributes' => array(
      'class' => 'table-e-proposals table-e',
    ),
    '#value' => views_embed_view('ercore_table_e_proposals', 'panel_pane_1', $date_argument),
    '#theme' => 'html_tag',
  );
  $summary['data_wrapper']['data_publications'] = array(
    '#tag' => 'div',
    '#attributes' => array(
      'class' => 'table-e-publications table-e',
    ),
    '#value' => views_embed_view('ercore_table_e_publications', 'panel_pane_1', $date_argument),
    '#theme' => 'html_tag',
  );
  $summary['data_wrapper']['data_participants'] = array(
    '#tag' => 'div',
    '#attributes' => array(
      'class' => 'table-e-participants table-e',
    ),
    '#value' => views_embed_view('ercore_table_e_users', 'panel_pane_1', $date_argument),
    '#theme' => 'html_tag',
  );
  return render($summary);
}
