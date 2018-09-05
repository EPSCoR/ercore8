<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore\Form\ERCoreAdmin.
 */

use Drupal\Core\Form\ConfigFormBase;
use Drupal\ercore\ErcoreStartDate;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ERCoreAdmin.
 *
 * Defines ERCore admin page.
 *
 * @package Drupal\ercore\Form
 */
class ERCoreAdmin extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ercore.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ercore_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ercore.settings');
    $form['ercore_epscor_start'] = [
      '#title' => t('Grant Start Date'),
      '#description' => $this->t('The start date for form processing and exports.'),
      '#type' => 'date',
      '#default_value' => $config->get('ercore_epscor_start'),
    ];
    $form['ercore_epscor_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('EPSCoR Grant Number'),
      '#description' => $this->t('EPSCoR or NSF Grant Number for display and exported forms.'),
      '#default_value' => $config->get('ercore_epscor_number'),
    ];
    $form['ercore_reporting_month'] = [
      '#type' => 'select',
      '#title' => $this->t('Reporting period start month'),
      '#description' => $this->t('Reporting month may differ from start month above.'),
      '#default_value' => $config->get('ercore_reporting_month'),
      '#options' => [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
      ],
    ];
    $form['ercore_grant_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Grant Type'),
      '#description' => $this->t('Grant type defines time period involved.'),
      '#default_value' => $config->get('ercore_grant_type'),
      '#options' => [
        '5' => 'Tier One',
        '3' => 'Tier Two',
      ],
    ];
    $form['ercore_grant_extension'] = [
      '#type' => 'select',
      '#title' => $this->t('Grant Extension'),
      '#description' => $this->t('Adjusts grant end date by extension.'),
      '#default_value' => $config->get('ercore_grant_extension'),
      '#options' => [
        '0' => 'No Extension',
        '6' => 'Six month extension',
        '12' => 'One year extension',
      ],
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $end = explode('-', $form_state->getValue('ercore_epscor_start'));
    $end[0] += $form_state->getValue('ercore_grant_type');
    $end[1] += $form_state->getValue('ercore_grant_extension');
    if ($end[1] >= 13) {
      $end[0] += 1;
      $end[1] = $end[1] - 12;
    }
    $end[1] = str_pad($end[1], 2, '0', STR_PAD_LEFT);
    $end = implode('-', $end);
    $this->config('ercore.settings')
      ->set('ercore_epscor_number', $form_state->getValue('ercore_epscor_number'))
      ->set('ercore_epscor_start', $form_state->getValue('ercore_epscor_start'))
      ->set('ercore_epscor_end', $end)
      ->set('ercore_grant_type', $form_state->getValue('ercore_grant_type'))
      ->set('ercore_grant_extension', $form_state->getValue('ercore_grant_extension'))
      ->set('ercore_reporting_month', $form_state->getValue('ercore_reporting_month'))
      ->save();
    self::resetFilters();
  }

  /**
   * Reset date filters to use new dates.
   */
  public function resetFilters() {
    $filter = \Drupal::service('user.private_tempstore')
      ->get('ercore_core');
    $filter->set('ercore_chosen_range', 0);
    $filter->set('ercore_filter_start', ErcoreStartDate::startString());
    $filter->set('ercore_filter_end', ErcoreStartDate::endString());
    drupal_set_message('Filters have been reset after base date update.');
  }

}
