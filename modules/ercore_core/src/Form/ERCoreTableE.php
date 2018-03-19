<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore\Form\ERCoreTableE.
 */

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ercore\ErcoreStartDate;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class ERCoreTableE.
 *
 * Defines ERCore Table E.
 *
 * @package Drupal\ercore\Form
 */
class ERCoreTableE extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ERCoreTableE';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $url = Url::fromRoute('ercore_core.outputs_export');
    $link = Link::fromTextAndUrl('Download NSF Table E.', $url);
    $form['#attached']['library'][] = 'ercore_core/ercore-core-exports.library';
    $form['date_filter'] = \Drupal::formBuilder()->getForm('Drupal\ercore_core\Form\ERCoreDateFilter');
    $form['data_table'] = [
      '#type' => 'fieldset',
      '#title' => t('Table E Results'),
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
