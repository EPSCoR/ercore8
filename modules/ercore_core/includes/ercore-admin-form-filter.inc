<?php

/**
 * @file
 * Repetitive $form element.
 */

use Drupal\ercore\ercoreStartDate;

$dates = new ercoreStartDate();
$select_list = $dates->ercoreSelectList();
$date_year_range = $dates->startYear . ':+1';

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
    'wrapper' => "$theme_variable",
    'method' => 'replace',
    'effect' => 'fade',
  ],
];

$form['dates'] = array(
  '#type' => 'details',
  '#title' => t('Dates'),
  '#description' => t('Manually set a date range.'),
  '#open' => FALSE,
);

$form['dates']['start_date'] = [
  '#type' => 'date',
  '#title' => t('Start Date'),
  '#date_format' => $dates->argumentFormat,
  '#default_value' => $dates->start,
  '#date_timezone' => $dates->zone,
  '#date_year_range' => $date_year_range,
  '#date_label_position' => 'none',
];
$form['dates']['end_date'] = [
  '#type' => 'date',
  '#title' => t('End Date'),
  '#date_format' => $dates->argumentFormat,
  '#default_value' => $dates->end,
  '#date_timezone' => $date->zone,
  '#date_year_range' => $date_year_range,
  '#date_label_position' => 'none',
];
$form['dates']['submit'] = [
  '#type' => 'submit',
  '#value' => t('Save'),
  '#ajax' => [
    'callback' => 'ercore_nsf_tables_change_date',
    'wrapper' => "$theme_variable",
    'method' => 'replace',
    'effect' => 'fade',
  ],
];
$form['dates']['reset'] = [
  '#type' => 'submit',
  '#value' => t('Reset'),
  '#ajax' => [
    'callback' => 'ercore_nsf_tables_change_date',
    'wrapper' => "$theme_variable",
    'method' => 'replace',
    'effect' => 'fade',
  ],
];
$form['table'] = [
  '#theme' => "$theme_variable",
  '#prefix' => "<div id=\"$theme_variable\">",
  '#suffix' => '</div>',
];
