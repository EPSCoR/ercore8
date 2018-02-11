<?php

/**
 * @file
 * File for the ERCore Reporting page.
 */

include_once drupal_get_path('module', 'ercore_admin') . "/includes/ercore-admin-var.inc";

/**
 * Constructs the epscor reporting page.
 *
 * Our menu maps this function to the path '/reporting'.
 */
function ercore_reporting_callback() {
  $zone = \Drupal::state()->get('date_default_timezone');
  $ercore_date = \Drupal::config('ercore.settings')->get('ercore_epscor_start');
  $argument_date_format = \Drupal::config('ercore.settings')
    ->get('ercore_admin_date_filter');
  $date_year_range = $ercore_date['year'] . ':+1';
  $default_dates = ercore_start_end_dates();
  $select_list = ercore_select_list();

  $form = array();
  $form['reporting-year'] = array(
    '#type' => 'fieldset',
    '#title' => t('Reporting Year'),
    '#tree' => TRUE,
    '#attributes' => array('class' => array('fieldset-class')),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['reporting-year']['range'] = array(
    '#type' => 'select',
    '#title' => t('Reporting Period'),
    '#options' => $select_list,
    '#default_value' => 0,
    '#ajax' => array(
      'callback' => 'ercore_change_reporting_year',
      'wrapper' => 'ercore_summary_table',
      'method' => 'replace',
      'effect' => 'fade',
    ),
  );

  $form['dates'] = array(
    '#type' => 'fieldset',
    '#title' => t('Date range'),
    '#tree' => TRUE,
    '#attributes' => array('class' => array('fieldset-class')),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['dates']['start_date'] = array(
    '#type' => 'date_popup',
    '#title' => t('Start Date'),
    '#date_format' => $argument_date_format,
    '#default_value' => $default_dates['start'],
    '#date_timezone' => $zone,
    '#date_year_range' => $date_year_range,
    '#date_label_position' => 'none',
  );
  $form['dates']['end_date'] = array(
    '#type' => 'date_popup',
    '#title' => t('End Date'),
    '#date_format' => $argument_date_format,
    '#default_value' => $default_dates['end'],
    '#date_timezone' => $zone,
    '#date_year_range' => $date_year_range,
    '#date_label_position' => 'none',
  );
  $form['dates']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
    '#ajax' => array(
      'callback' => 'ercore_change_date_range',
      'wrapper' => 'ercore_summary_table',
      'method' => 'replace',
      'effect' => 'fade',
    ),
  );
  $form['dates']['reset'] = array(
    '#type' => 'submit',
    '#value' => t('Reset'),
    '#ajax' => array(
      'callback' => 'ercore_change_date_range',
      'wrapper' => 'ercore_summary_table',
      'method' => 'replace',
      'effect' => 'fade',
    ),
  );
  $form['table'] = array(
    '#theme' => 'ercore_summary_table',
    '#prefix' => '<div id="ercore_summary_table">',
    '#suffix' => '</div>',
  );
  return $form;
}

/**
 * Theme function generates the summary table.
 *
 * @param array $variables
 *   A nested a array of date ranges.
 *
 * @return array
 *   Variables array.
 */
function ercore_summary_table(array $variables) {
  $default_dates = ercore_start_end_dates();
  $summary_options = array(
    'ercore_collaboration' => array(
      'name' => 'Collaborations',
      'path' => 'collaborations',
      'field' => 'field_field_ercore_cn_dates',
    ),
    'ercore_proposal' => array(
      'name' => 'Grants and Proposals*',
      'path' => 'proposals',
      'field' => 'All',
    ),
    'ercore_engagement' => array(
      'name' => 'External Engagements',
      'path' => 'external-engagements',
      'field' => 'field_field_ercore_ev_date',
    ),
    'ercore_institution' => array(
      'name' => 'Institutions',
      'path' => 'institutions',
      'field' => 'All',
    ),
    'ercore_other_product' => array(
      'name' => 'Other Research Products',
      'path' => 'other-research-products',
      'field' => 'field_field_ercore_op_date',
    ),
    'ercore_patent' => array(
      'name' => 'Patents',
      'path' => 'patents',
      'field' => 'field_field_ercore_pt_award',
    ),
    'ercore_presentation' => array(
      'name' => 'Presentation',
      'path' => 'presentations',
      'field' => 'field_field_ercore_ps_date',
    ),
    'ercore_publication' => array(
      'name' => 'Publications',
      'path' => 'publications',
      'field' => 'field_field_ercore_pb_date',
    ),
    'ercore_honor' => array(
      'name' => 'Honors and Awards',
      'path' => 'honors',
      'field' => 'field_field_ercore_hn_date',
    ),
    'ercore_event' => array(
      'name' => 'Calendar Events',
      'path' => 'calendar',
      'field' => 'field_field_ercore_ev_date',
    ),
    'ercore_highlight' => array(
      'name' => 'Highlights',
      'path' => 'highlghts',
      'field' => 'field_field_ercore_hi_date',
    ),
    'ercore_participant' => array(
      'name' => 'Participants',
      'path' => 'participants',
      'field' => 'field_field_ercore_us_part_date',
    ),
  );

  $ranges = $variables['ranges'];
  $short_date = 'm/d/Y';

  $summary_table = array('#theme' => 'table');
  $summary_table['#header'][] = "Categories of Accomplishments";
  $summary_table['#header'][] = "Inception<br />through<br />" . date($short_date);
  foreach ($ranges as $date_key => $date_value) {
    $summary_table['#header'][] = date($short_date, $date_value[0]) . "<br />through<br />" . date($short_date, $date_value[1]);
  }
  foreach ($summary_options as $sum_key => $sum_type) {
    $field_value = $sum_type['field'];
    $data = array();

    $view_name = 'data_' . $sum_key;
    $view = views_get_view_result($view_name, 'count');
    $data[] = ercore_format_label($sum_type, $ranges);
    if (isset($view)) {
      $data[] = count($view);
    }
    if (is_array($ranges)) {
      foreach ($ranges as $ranges_key => $dates) {
        $count = 0;
        foreach ($view as $view_row) {
          if ($field_value == 'All') {
            $count = $count + 1;
          }
          else {
            if (isset($view_row->$field_value)) {
              $field = $view_row->$field_value;
              $within = $field[0]['raw']['value'];
              if (ercore_reporting_date_callback($within, $dates)) {
                $count = $count + 1;
              }
            }
          }
        }
        $data[] = $count;
      }
    }

    $summary_table['#rows'][] = $data;
  }

  /* $default_string = ercore_start_end_dates();
  $default_dates = ercore_admin_date_array_to_unix($default_string);
   */

  if (!isset($variables['ranges'][0])) {
    $date_label = NULL;
    $range_display = 'Date range is undefined.';
  }
  else {
    $range_display = 'Date range is ' . ercore_displayed_date_ranges($variables['ranges']) . '.';
  }

  $path = array('/ercore/reporting/download/');
  $title = 'Download EPSCoR Reporting Core Tables';
  $table_link = ercore_admin_table_link($title, $path, $ranges);

  $summary['range_display'] = array(
    '#tag' => 'p',
    '#attributes' => array(
      'class' => 'range-display',
    ),
    '#value' => $range_display,
    '#theme' => 'html_tag',
    '#access' => array('access ercore excel sheets'),

  );
  $summary['table'] = $summary_table;

  $summary['asterisk'] = array(
    '#tag' => 'p',
    '#attributes' => array(
      'class' => 'reporting asterisk',
    ),
    '#value' => "* Grant & Proposal counts include all grants regardless of status.",
    '#theme' => 'html_tag',
    '#access' => array('access ercore excel sheets'),

  );
  $summary['linking'] = array(
    '#tag' => 'p',
    '#attributes' => array(
      'class' => 'table-header table-c data-link',
    ),
    '#value' => $table_link,
    '#theme' => 'html_tag',
    '#access' => array('access ercore excel sheets'),

  );
  return render($summary);
}

/**
 * ERCore Reporting submit callback.
 */
function ercore_reporting_callback_submit($form, &$form_state) {
  if ($form_state['clicked_button']['#id'] == 'edit-dates-reset') {
    unset($_SESSION['ercore_start_date']);
    unset($_SESSION['ercore_end_date']);
    unset($_SESSION['ercore_end_date']);
  }
  else {
    $start = strtotime($form['dates']['start_date']['#value']['date']);
    $end = strtotime($form['dates']['end_date']['#value']['date']);
    if ($start <= $end) {
      $_SESSION['ercore_start_date'] = $start;
      $_SESSION['ercore_end_date'] = $end;

    }
    else {
      drupal_set_message("Start date must be earlier than end date.", 'error');
    }
  }
}

/**
 * Receives link values and generates links.
 *
 * @param array $link
 *   Uses View to control access.
 * @param array $ranges
 *   Description.
 *
 * @return array
 *   Drupal link array.
 */
function ercore_format_label(array &$link, array &$ranges) {
  $argument_date_format = \Drupal::config('ercore.settings')
    ->get('ercore_admin_date_filter');
  $report_title = $link['name'];
  $report_link = $link['path'];

  if (isset($ranges[0][0])) {
    $start = date($argument_date_format, $ranges[0][0]);
    $end = date($argument_date_format, $ranges[0][1]);
    $destination = array(
      'query' => array(
        'start-date[value][date]' => $start,
        'end-date[value][date]' => $end,
      ),
    );
  }
  else {
    $destination = array('query' => NULL);
  }
  $link = l($report_title, $report_link, $destination, array('attributes' => array('class' => array('reporting-section'))));

  return $link;
}

/**
 * Date Callback for validating a date within a range.
 *
 * @param string $within_date
 *   Receives date string for validation.
 * @param array $dates
 *   Receives date array for validation against string.
 *
 * @return bool
 *   Returns boolean value based on date validation.
 */
function ercore_reporting_date_callback(&$within_date, array &$dates) {

  if ($within_date == NULL) {
    return FALSE;
  }
  else {
    $within_date = str_replace("T", " ", $within_date);
    $within_date = strtotime($within_date);
    return (($dates[0]) <= $within_date && ($dates[1]) >= $within_date);
  }
}
