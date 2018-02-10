<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore\Form\ERCoreAdmin.
 */

use Drupal\Core\Form\ConfigFormBase;
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
      'ercore.adminsettings',
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
    $config = $this->config('ercore.adminsettings');

    $form['ercore_epscor_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('EPSCoR Grant Number'),
      '#description' => $this->t('The EPSCoR Grant Number for display and Forms.'),
      '#default_value' => $config->get('ercore_epscor_number'),
    ];
    $form['ercore_epscor_start'] = array(
      '#title' => t('Grant Start Date'),
      '#type' => 'date',
      '#default_value' => $config->get('ercore_epscor_start'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('ercore.adminsettings')
      ->set('ercore_epscor_number', $form_state->getValue('ercore_epscor_number'))
      ->set('ercore_epscor_start', $form_state->getValue('ercore_epscor_start'))
      ->save();
  }

}
