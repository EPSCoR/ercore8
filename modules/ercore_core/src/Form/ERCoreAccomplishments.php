<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore\Form\ERCoreAccomplishments.
 */

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ercore\ErcoreStartDate;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class ERCoreAccomplishments.
 *
 * Defines ERCore Accomplishments.
 *
 * @package Drupal\ercore\Form
 */
class ERCoreAccomplishments extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ERCoreAccomplishments';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $url = Url::fromRoute('ercore_core.accomplishments_export');
    $link = Link::fromTextAndUrl('Download EPSCoR Reporting Core Tables.', $url);
    $form['#attached']['library'][] = 'ercore_core/ercore-core-exports.library';
    $form['date_filter'] = \Drupal::formBuilder()->getForm('Drupal\ercore_core\Form\ERCoreDateFilter');
    $form['data_table'] = [
      '#type' => 'fieldset',
      '#title' => t('Accomplishments Data'),
      '#open' => TRUE,
    ];
    $form['data_table']['description'] = [
      '#markup' => 'Results will go here.',
    ];
    $form['export_link'] = [
      '#markup' => '<p class="epscor-download">' . $link->toString() . '</p>',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // We don't use this, but the interface requires us to implement it.
  }

}
