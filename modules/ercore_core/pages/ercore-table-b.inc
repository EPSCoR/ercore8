<?php
/**
 * @file
 * File for the ERCore NSF Table B.
 */

require_once drupal_get_path('module', 'ercore_admin') . "/includes/ercore-admin-var.inc";
require_once drupal_get_path('module', 'ercore_admin') . '/includes/classes/ercore-participant-grouping.inc';
/**
 * Display NSF Table B data in preparation for exporting to Excel.
 *
 * @return array
 *    Returns form array for page display.
 */
function nsf_table_b_callback() {
  $form = array();
  $theme_variable = 'ercore_table_b';
  // Used within the following include.
  include_once drupal_get_path('module', 'ercore_admin') . "/includes/ercore-admin-form-filter.inc";
  $form['new_hire'] = array(
    '#tag' => 'p',
    '#attributes' => array(
      'class' => 'table-footer table-b',
    ),
    '#value' => '*New Hires: This column will not display results unless a valid
        date range is chosen.<br /> ** The Advisory Board row is not the total
        of rows above, but an independent row.',
    '#theme' => 'html_tag',
  );
  return $form;
}

/**
 * Data table header array.
 *
 * @return array
 *   Array of Project Roles.
 */
function ercore_table_b_headers() {
  $header = array();
  $header['senior'] = array(
    'data' => 'Senior Project Role',
    'class' => array('ercore', 'type'),
  );
  $header['total'] = array(
    'data' => 'Total Individuals',
    'class' => array('ercore', 'total'),
  );
  $header['male'] = array(
    'data' => 'Male',
    'class' => array('ercore', 'male'),
  );
  $header['female'] = array(
    'data' => 'Female',
    'class' => array('ercore', 'female'),
  );
  $header['black'] = array(
    'data' => 'Black or African American',
    'class' => array('ercore', 'black'),
  );
  $header['hispanic'] = array(
    'data' => 'Hispanic',
    'class' => array('ercore', 'hispanic'),
  );
  $header['other'] = array(
    'data' => 'Other Ethnicity',
    'class' => array('ercore', 'other'),
  );
  $header['disabilities'] = array(
    'data' => 'Disabilities',
    'class' => array('ercore', 'disability'),
  );
  $header['new'] = array(
    'data' => 'New Hires*',
    'class' => array('ercore', 'new-hire'),
  );
  return $header;
}
/**
 * Building Data Objects for NSF Table B.
 *
 * @param int $nid
 *    Node ID of Institution.
 * @param string $date_range
 *    Optional date range filter from hook menu.
 *
 * @return array $institution_data
 *   Returns data array of results.
 */
function ercore_table_b_data(&$nid, &$date_range) {
  $non_displayed_values = ErcoreParticipantGroup::ercoreNoNewValues();
  if (!isset($date_range[0])) {
    $empty = TRUE;
    $range_array = NULL;
    $date_argument = 'all';
  }
  else {
    $range_array = $date_range;
    $empty = FALSE;
    $date_argument = ercore_admin_download_path($date_range);
  }

  $rii = FALSE;
  // Build data objects.
  if ($nid == 'all') {

    // RII Total Data.
    $rii = TRUE;
    $advisory_view = views_get_view_result('ercore_export_table_b_totals', 'panel_pane_2', $date_argument);
    $advisory_data = new ErcoreParticipantGroup();
    $advisory_data->name = 'Advisory Board(s)**';
    foreach ($advisory_view as $advisory_row) {
      $type = $advisory_row->field_field_ercore_us_sen_role[0]['rendered']['#markup'];
      if (isset($advisory_row->field_field_ercore_us_hired_date[0]['raw']) && $empty == FALSE && !in_array($type, $non_displayed_values)) {
        $hired = $advisory_row->field_field_ercore_us_hired_date[0]['raw']['value'];
        $new = $advisory_data->ercoreNewDateCallback($hired, $date_range);
      }
      else {
        $new = FALSE;
      }
      $advisory_data = $advisory_data->ercoreParticipantGroupData($advisory_data, $advisory_row, $new);

    }
  }

  $view = views_get_view_result('ercore_export_table_b_data_objects', 'panel_pane_1', $nid, $date_argument);
  $institution_data = new ErcoreParticipantCollection();
  $institution_data->ercoreCollectionData($institution_data, $view, $range_array);
  if ($rii == TRUE) {
    $institution_data->advisory = $advisory_data;
  }
  return $institution_data;
}

/**
 * Data formatting for placement in Participant data export.
 *
 * @param object $collection
 *    Data object prepared for data entry.
 *
 * @return array $data
 *   Returns Collection object for NSF Table B data.
 */
function ercore_table_b_cells(&$collection) {
  $non_displayed_values = ErcoreParticipantGroup::ercoreNoNewValues();

  $data = array();
  $row = 1;
  foreach ($collection as $row_data) {
    $data[$row]['data']['name'] = array(
      'data' => $row_data->name,
      'class' => array('ercore', 'type'),
    );
    $data[$row]['data']['total'] = array(
      'data' => $row_data->total,
      'class' => array('ercore', 'total'),
    );
    $data[$row]['data']['male'] = array(
      'data' => $row_data->male,
      'class' => array('ercore', 'male'),
    );
    $data[$row]['data']['female'] = array(
      'data' => $row_data->female,
      'class' => array('ercore', 'female'),
    );
    $data[$row]['data']['black'] = array(
      'data' => $row_data->black,
      'class' => array('ercore', 'black'),
    );
    $data[$row]['data']['hispanic'] = array(
      'data' => $row_data->hispanic,
      'class' => array('ercore', 'hispanic'),
    );
    $data[$row]['data']['other'] = array(
      'data' => $row_data->other,
      'class' => array('ercore', 'other'),
    );
    $data[$row]['data']['disabled'] = array(
      'data' => $row_data->disabled,
      'class' => array('ercore', 'disability'),
    );
    if (!in_array($row_data->name, $non_displayed_values)) {
      $data[$row]['data']['new'] = array(
        'data' => $row_data->new,
        'class' => array('ercore', 'new-hire', 'hired'),
      );
    }
    else {
      $data[$row]['data']['new'] = array(
        'data' => 'n/a',
        'class' => array('ercore', 'new-hire', 'no-hires'),
      );
    }
    $data[$row]['class'] = array(drupal_html_class($row_data->name));
    $row++;

  }
  return $data;
}

/**
 * This theme function (see theme.inc) generates the summary table.
 *
 * @param array $variables
 *    A nested a array of date ranges.
 *
 * @return array $summary
 *   Returns data array of results.
 */
function ercore_table_b($variables) {
  $date_range = $variables['ranges'];
  $data = views_get_view_result('ercore_export_table_b_institutions', 'panel_pane_1');
  $header = ercore_table_b_headers();
  $title = 'Download NSF Table B';
  if (isset($date_range[0])) {
    $range_display = 'Date range is ' . ercore_displayed_date_ranges($variables['ranges']) . '.';
    $range = $date_range;
  }
  else {
    $range = array();
    $range_display = 'Date range is undefined.';
  }
  $path = array('/ercore/views/participants/download/');
  $table_link = ercore_admin_table_link($title, $path, $range);
  $summary['linking'] = array(
    '#tag' => 'p',
    '#attributes' => array(
      'class' => 'table-header table-b data-link',
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
  foreach ($data as $institution) {
    $institution_name = $institution->node_title;
    $nid = $institution->nid;
    $collection = ercore_table_b_data($nid, $date_range);
    $data = ercore_table_b_cells($collection);

    $summary['table_' . $institution_name] = array(
      '#theme' => 'table',
      '#caption' => $institution_name,
      '#header' => $header,
      '#rows' => $data,
      '#attributes' => array(
        'class' => array(
          'ercore-table',
          'table-b',
        ),
        'id' => 'ercore-table-b-' . drupal_html_class($institution_name),
      ),
    );
  }
  $rii_nid = 'all';
  $rii_collection = ercore_table_b_data($rii_nid, $date_range);
  $rii_data = ercore_table_b_cells($rii_collection);
  $summary['table_rii'] = array(
    '#theme' => 'table',
    '#caption' => 'RII Totals',
    '#header' => $header,
    '#rows' => $rii_data,
    '#attributes' => array(
      'class' => array(
        'ercore-table',
        'table-b',
        'rii-table',
      ),
      'id' => 'ercore-table-b-rii',
    ),
  );

  return render($summary);
}
