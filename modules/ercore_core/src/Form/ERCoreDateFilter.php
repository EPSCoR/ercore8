<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore\Form\ERCoreDateFilter.
 */

use Drupal\Core\Form\FormBase;
use Drupal\ercore\ErcoreStartDate;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ERCoreDateFilter.
 *
 * Defines ERCore Date Filter form object to be used in blocks.
 *
 * @package Drupal\ercore\Form
 */
class ERCoreDateFilter extends FormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'user.private_tempstore',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ercore_date_filter';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attached']['library'][] = 'ercore_core/ercore-core-filter.library';
    // Add our CSS and tiny JS to hide things when they should be hidden.
    $this->temp = \Drupal::service('user.private_tempstore')
      ->get('ercore_core');
    $temp_range = $this->temp->get('ercore_chosen_range');
    $filter_type = $this->temp->get('ercore_filter_type');
    $temp_start = $this->temp->get('ercore_filter_start');
    $temp_end = $this->temp->get('ercore_filter_end');
    $temp_value_start = $this->temp->get('ercore_value_start');
    if (!isset($temp_value_start)) {
      $this->temp->set('ercore_value_start', ErcoreStartDate::startUnix());
    }
    $temp_value_end = $this->temp->get('ercore_value_end');
    if (!isset($temp_value_end)) {
      $this->temp->set('ercore_value_end', ErcoreStartDate::endUnix());
    }
    if (isset($temp_start)) {
      $start = $temp_start;
    }
    else {
      $start = ErcoreStartDate::startString();
    }
    if (isset($temp_end)) {
      $end = $temp_end;
    }
    else {
      $end = ErcoreStartDate::endString();
    }
    if (!isset($filter_type)) {
      $filter_type = 0;
    }
    $select_list = ErcoreStartDate::ercoreSelectList();

    if (isset($temp_range)) {
      $chosen_range = $temp_range;
    }
    else {
      $chosen_range = 0;
    }
    $form['filter_type'] = [
      '#type' => 'radios',
      '#title' => t('Filter Type'),
      '#options' => [
        0 => t('Program Year'),
        1 => t('Custom Dates'),
      ],
      '#default_value' => $filter_type,
      '#required' => TRUE,
    ];
    $form['reporting-year'] = [
      '#type' => 'fieldset',
      '#title' => t('Reporting Period'),
      '#open' => TRUE,
      '#states' => [
        'visible' => [
          ':input[name="filter_type"]' => ['value' => 0],
        ],
      ],
    ];
    $form['reporting-year']['range'] = [
      '#type' => 'select',
      '#title' => t('Reporting Period'),
      '#options' => $select_list,
      '#default_value' => $chosen_range,
    ];
    $form['ercore_dates'] = [
      '#type' => 'fieldset',
      '#title' => t('Dates'),
      '#open' => TRUE,
      '#attributes' => [
        'id' => 'range-form-container',
      ],
      '#states' => [
        'visible' => [
          ':input[name="filter_type"]' => ['value' => 1],
        ],
      ],
    ];
    $form['ercore_dates']['start_date'] = [
      '#type' => 'date',
      '#title' => t('Start Date'),
      '#default_value' => $start,
    ];
    $form['ercore_dates']['end_date'] = [
      '#type' => 'date',
      '#title' => t('End Date'),
      '#default_value' => $end,
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => t('Save Filter'),
      '#submit' => ['::handleSaveFilter'],
    ];
    $form['actions']['reset'] = [
      '#type' => 'submit',
      '#value' => t('Reset Filter'),
      '#submit' => ['::handleResetFilter'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $start = $form_state->getValue('start_date');
    $end = $form_state->getValue('end_date');
    if ($start > $end) {
      $form_state->setErrorByName('end_date', $this->t('The End Date must be greater than the Start Date'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function handleSaveFilter(array &$form, FormStateInterface $form_state) {
    $filter_type = $form_state->getValue('filter_type');
    $this->temp->set('ercore_filter_type', $filter_type);
    if ($filter_type === "1") {
      $this->temp->delete('ercore_chosen_range');
      $start = $form_state->getValue('start_date');
      if (!empty($start)) {
        $this->temp->set('ercore_filter_start', $form_state->getValue('start_date'));
        $this->temp->set('ercore_value_start', ErcoreStartDate::dateArgumentToUnix($start));
      }
      else {
        $this->temp->set('ercore_filter_start', ErcoreStartDate::startString());
        $this->temp->set('ercore_value_start', ErcoreStartDate::startUnix());
      }
      $end = $form_state->getValue('end_date');
      if (!empty($end)) {
        $this->temp->set('ercore_filter_end', $form_state->getValue('end_date'));
        $this->temp->set('ercore_value_end', ErcoreStartDate::dateArgumentToUnix($end));
      }
      else {
        $this->temp->set('ercore_filter_end', ErcoreStartDate::endString());
        $this->temp->set('ercore_value_end', ErcoreStartDate::endUnix());
      }
    }
    else {
      $this->temp->set('ercore_chosen_range', $form_state->getValue('range'));
      $this->temp->delete('ercore_filter_start');
      $this->temp->delete('ercore_filter_end');
    }
    drupal_set_message('Filter saved.');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // We don't use this, but the interface requires us to implement it.
  }

  /**
   * Utility submit function to reset stored values.
   *
   * @param array $form
   *   FormAPI form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   FormAPI form state.
   */
  public function handleResetFilter(array &$form, FormStateInterface $form_state) {
    $this->temp->set('ercore_chosen_range', 0);
    $this->temp->set('ercore_filter_start', ErcoreStartDate::startString());
    $this->temp->set('ercore_filter_end', ErcoreStartDate::endString());
    $this->temp->set('ercore_value_start', ErcoreStartDate::startUnix());
    $this->temp->set('ercore_value_end', ErcoreStartDate::endUnix());
    drupal_set_message('Filter reset.');
  }

}
