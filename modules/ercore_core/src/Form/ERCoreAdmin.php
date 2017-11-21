<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore_core\Form\ERCoreAdmin.
 */

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ERCoreAdmin.
 *
 * Defines ERCore admin page.
 *
 * @package Drupal\ercore_core\Form
 */
class ERCoreAdmin extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ercore_core.adminsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ercore_core_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ercore_core.adminsettings');

    $form['ercore_core_epscor_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('EPSCoR Grant Number'),
      '#description' => $this->t('The EPSCoR Grant Number for display and Forms.'),
      '#default_value' => $config->get('ercore_core_epscor_number'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('ercore_core.adminsettings')
      ->set('ercore_core_epscor_number', $form_state->getValue('ercore_core_epscor_number'))
      ->save();
  }

}
