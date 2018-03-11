<?php

/**
 * @file
 * File for the ERCore Reporting page.
 */

use Drupal\ercore\ercoreStartDate;
use Drupal\Core\Link;
use Drupal\Core\Url;

module_load_include('inc', 'phpexcel');

/**
 * Constructs the epscor accomplishments page.
 *
 * Our menu maps this function to the path '/accomplishments'.
 */
function ercore_accomplishments_callback() {
  $dates = new ercoreStartDate();
  $select_list = $dates->ercoreSelectList();
  $date_year_range = $dates->startYear . ':+1';
  $zone = $dates->zone;
  $argument_date_format = $dates->argumentFormat;
  $default_dates = $dates->startEndDates();


  $form = [];
  $form['reporting-year'] = [
    '#type' => 'fieldset',
    '#title' => t('Reporting Year'),
    '#tree' => TRUE,
    '#attributes' => [
      'class' => [
        'fieldset-class',
      ],
    ],
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  ];
  $form['reporting-year']['range'] = [
    '#type' => 'select',
    '#title' => t('Reporting Period'),
    '#options' => $select_list,
    '#default_value' => 0,
    '#ajax' => [
      'callback' => 'ercore_change_reporting_year',
      'wrapper' => 'ercore_summary_table',
      'method' => 'replace',
      'effect' => 'fade',
    ],
  ];

  $form['dates'] = [
    '#type' => 'fieldset',
    '#title' => t('Date range'),
    '#tree' => TRUE,
    '#attributes' => [
      'class' => [
        'fieldset-class',
      ],
    ],
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  ];

  $form['dates']['start_date'] = [
    '#type' => 'date_popup',
    '#title' => t('Start Date'),
    '#date_format' => $argument_date_format,
    '#default_value' => $default_dates['start'],
    '#date_timezone' => $zone,
    '#date_year_range' => $date_year_range,
    '#date_label_position' => 'none',
  ];
  $form['dates']['end_date'] = [
    '#type' => 'date_popup',
    '#title' => t('End Date'),
    '#date_format' => $argument_date_format,
    '#default_value' => $default_dates['end'],
    '#date_timezone' => $zone,
    '#date_year_range' => $date_year_range,
    '#date_label_position' => 'none',
  ];
  $form['dates']['submit'] = [
    '#type' => 'submit',
    '#value' => t('Save'),
    '#ajax' => [
      'callback' => 'ercore_change_date_range',
      'wrapper' => 'ercore_summary_table',
      'method' => 'replace',
      'effect' => 'fade',
    ],
  ];
  $form['dates']['reset'] = [
    '#type' => 'submit',
    '#value' => t('Reset'),
    '#ajax' => [
      'callback' => 'ercore_change_date_range',
      'wrapper' => 'ercore_summary_table',
      'method' => 'replace',
      'effect' => 'fade',
    ],
  ];
  $form['table'] = [
    '#theme' => 'ercore_summary_table',
    '#prefix' => '<div id="ercore_summary_table">',
    '#suffix' => '</div>',
  ];
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
  $summary_options = [
    'ercore_collaboration' => [
      'name' => 'Collaborations',
      'path' => 'collaborations',
      'field' => 'field_field_ercore_cn_dates',
    ],
    'ercore_proposal' => [
      'name' => 'Grants and Proposals*',
      'path' => 'proposals',
      'field' => 'All',
    ],
    'ercore_engagement' => [
      'name' => 'External Engagements',
      'path' => 'external-engagements',
      'field' => 'field_field_ercore_ev_date',
    ],
    'ercore_institution' => [
      'name' => 'Institutions',
      'path' => 'institutions',
      'field' => 'All',
    ],
    'ercore_other_product' => [
      'name' => 'Other Research Products',
      'path' => 'other-research-products',
      'field' => 'field_field_ercore_op_date',
    ],
    'ercore_patent' => [
      'name' => 'Patents',
      'path' => 'patents',
      'field' => 'field_field_ercore_pt_award',
    ],
    'ercore_presentation' => [
      'name' => 'Presentation',
      'path' => 'presentations',
      'field' => 'field_field_ercore_ps_date',
    ],
    'ercore_publication' => [
      'name' => 'Publications',
      'path' => 'publications',
      'field' => 'field_field_ercore_pb_date',
    ],
    'ercore_honor' => [
      'name' => 'Honors and Awards',
      'path' => 'honors',
      'field' => 'field_field_ercore_hn_date',
    ],
    'ercore_event' => [
      'name' => 'Calendar Events',
      'path' => 'calendar',
      'field' => 'field_field_ercore_ev_date',
    ],
    'ercore_highlight' => [
      'name' => 'Highlights',
      'path' => 'highlghts',
      'field' => 'field_field_ercore_hi_date',
    ],
    'ercore_participant' => [
      'name' => 'Participants',
      'path' => 'participants',
      'field' => 'field_field_ercore_us_part_date',
    ],
  ];

  $ranges = $variables['ranges'];
  $short_date = 'm/d/Y';

  $summary_table = ['#theme' => 'table'];
  $summary_table['#header'][] = "Categories of Accomplishments";
  $summary_table['#header'][] = "Inception<br />through<br />" . date($short_date);
  foreach ($ranges as $date_key => $date_value) {
    $summary_table['#header'][] = date($short_date, $date_value[0]) . "<br />through<br />" . date($short_date, $date_value[1]);
  }
  foreach ($summary_options as $sum_key => $sum_type) {
    $field_value = $sum_type['field'];
    $data = [];

    $view_name = 'data_' . $sum_key;
    $view = views_get_view_result($view_name, 'count');
    $data[] = ercore_format_label($sum_type, $ranges);
    if (isset($view)) {
      $data[] = count($view);
    }
    if (is_[$ranges]) {
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

  if (!isset($variables['ranges'][0])) {
    $date_label = NULL;
    $range_display = 'Date range is undefined.';
  }
  else {
    $range_display = 'Date range is ' . ercore_displayed_date_ranges($variables['ranges']) . '.';
  }

  $path = ['/ercore/reporting/download/'];
  $title = 'Download EPSCoR Reporting Core Tables';
  $table_link = ercore_admin_table_link($title, $path, $ranges);

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
  $summary['table'] = $summary_table;

  $summary['asterisk'] = [
    '#tag' => 'p',
    '#attributes' => [
      'class' => 'reporting asterisk',
    ],
    '#value' => "* Grant & Proposal counts include all grants regardless of status.",
    '#theme' => 'html_tag',
    '#access' => ['access ercore excel sheets'],
  ];
  $summary['linking'] = [
    '#tag' => 'p',
    '#attributes' => [
      'class' => 'table-header table-c data-link',
    ],
    '#value' => $table_link,
    '#theme' => 'html_tag',
    '#access' => ['access ercore excel sheets'],

  ];
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
  $dates = new ercoreStartDate();
  $report_title = $link['name'];
  $report_link = $link['path'];

  if (isset($ranges[0][0])) {
    $start = date($dates->argumentFormat, $ranges[0][0]);
    $end = date($dates->argumentFormat, $ranges[0][1]);
    $option = [
      'query' => [
        'start-date[value][date]' => $start,
        'end-date[value][date]' => $end,
      ],
      'attributes' => [
        'class' => [
          'reporting-section',
        ],
      ],
    ];
  }
  else {
    $option = [
      'attributes' => [
        'class' => [
          'reporting-section',
        ],
      ],
    ];
  }
  $url = Url::fromUri($report_link, $option);
  $link = Link::fromTextAndUrl($report_title, $url);

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
