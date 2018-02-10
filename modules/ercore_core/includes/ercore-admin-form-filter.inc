<?php
/**
 * @file
 * Repetitive $form element.
 */

require_once drupal_get_path('module', 'ercore_admin') . '/includes/ercore-admin-var.inc';

$zone = variable_get('date_default_timezone');
$ercore_date = variable_get('ercore_start_date');
$argument_date_format = variable_get('date_format_ercore_date_format_filter');
$date_year_range = $ercore_date['year'] . ':+1';
$default_dates = ercore_start_end_dates();
$select_list = ercore_select_list();

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
    'wrapper' => "$theme_variable",
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
    'callback' => 'ercore_nsf_tables_change_date',
    'wrapper' => "$theme_variable",
    'method' => 'replace',
    'effect' => 'fade',
  ),
);
$form['dates']['reset'] = array(
  '#type' => 'submit',
  '#value' => t('Reset'),
  '#ajax' => array(
    'callback' => 'ercore_nsf_tables_change_date',
    'wrapper' => "$theme_variable",
    'method' => 'replace',
    'effect' => 'fade',
  ),
);
$form['table'] = array(
  '#theme' => "$theme_variable",
  '#prefix' => "<div id=\"$theme_variable\">",
  '#suffix' => '</div>',
);
