<?php
/**
 * @file
 * File for the ERCore NSF Table D.
 */

include_once drupal_get_path('module', 'ercore_admin') . "/includes/ercore-admin-var.inc";

/**
 * Display NSF Table D data in preparation for exporting to Excel.
 *
 * @return array $form
 *    Returns form array for page display.
 */
function nsf_table_d_callback() {
  $form = array();
  $theme_variable = 'ercore_table_d';
  // Used within the following include.
  $form['help'] = array(
    '#tag' => 'div',
    '#attributes' => array(
      'class' => 'form-header',
    ),
    '#value' => "<h2>Data Headings</h2><p>This is a view meant only for admin. This data corresponds to the counts seen on the accomplishments table. Scroll to the bottom to download the excel sheet. Mouse over the node id (the number in blue) to see the title of the node.
For the sake of bevity, the headings display the names used internally by the system.</p>
<div class='row'><div class='col-md-6'><h3>Prefixes</h3>
<ul><li>ARI: Academic Research Institutions</li>
<li>UI: 'Primary Undergraduate Institutions</li>
<li>MSI: Minority Serving Institutions</li>
<li>K12: K-12 Institutions</li>
<li>Oth: Other</li>
<li>Total: Row Total</li>
</ul></div>
<div class='col-md-6'><h3>Suffixes</h3>
<ul>
<li>Fac: Faculty</li>
<li>Stu: Students</li>
<li>T: Teachers</li>
<li>SD: Students Reached Directly</li>
<li>ST: Students Reached via Teach Training</li></ul></div>",
    '#theme' => 'html_tag',
  );
  include_once drupal_get_path('module', 'ercore_admin') . "/includes/ercore-admin-form-filter.inc";
  return $form;
}

/**
 * This theme function generates the NSF Table D summary table.
 *
 * @param array $variables
 *    A nested a array of date ranges.
 *
 * @return array $data
 *   Returns Collection object for NSF Table B data.
 */
function ercore_table_d($variables) {
  $date_range = $variables['ranges'];
  $title = 'Download NSF Table D';
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
  $path = array('/ercore/views/external-engagement/download/');
  $table_link = ercore_admin_table_link($title, $path, $range);
  $summary['linking'] = array(
    '#tag' => 'p',
    '#attributes' => array(
      'class' => 'table-header table-d data-link',
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
      'id' => 'ercore_table_d',
    ),
    '#value' => views_embed_view('ercore_table_d_display', 'panel_pane_1', $date_argument),
    '#theme' => 'html_tag',
  );
  return render($summary);
}
