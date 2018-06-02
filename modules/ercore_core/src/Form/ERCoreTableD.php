<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore\Form\ERCoreTableD.
 */

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ercore_core\ErcoreEngagementBuild;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class ERCoreTableD.
 *
 * Defines ERCore Table D.
 *
 * @package Drupal\ercore\Form
 */
class ERCoreTableD extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ERCoreTableD';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $url = Url::fromRoute('ercore_core.engagements_export');
    $link = Link::fromTextAndUrl('Download NSF Table D.', $url);
    $form['#attached']['library'][] = 'ercore_core/ercore-core-exports.library';
    $form['date_filter'] = \Drupal::formBuilder()
      ->getForm('Drupal\ercore_core\Form\ERCoreDateFilter');
    $form['data_table'] = [
      '#type' => 'fieldset',
      '#title' => t('Table D Results'),
      '#open' => TRUE,
    ];
    $form['data_table']['data'] = [
      '#theme' => 'table',
      '#caption' => 'Engagements Data',
      '#header' => [
        t('Type'),
        t('ARI Faculty'),
        t('ARI Students'),
        t('PUI Faculty'),
        t('PUI Students'),
        t('MSI Faculty'),
        t('MSI Students'),
        t('K12 Teachers'),
        t('K12 Students Reached Directly'),
        t('K12 Students Via teach Training'),
        t('Other'),
        t('Total'),
      ],
      '#rows' => self::formatResults(),
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

  /**
   * Data types which form row headers.
   *
   * @return array
   *   Return array of data types.
   */
  public static function dataTypes() {
    return [
      'total' => t('Totals'),
      'male' => t('Male'),
      'female' => t('Female'),
      'minority' => t('Under-represented Minority'),
    ];
  }

  /**
   * Format Results.
   */
  public function formatResults() {
    $toRender = [];
    $data = ErcoreEngagementBuild::getData();
    $types = self::dataTypes();
    foreach ($types as $row => $type) {
      $toRender[$row] = [
        $type,
        $data[$row]->ariFac,
        $data[$row]->ariStu,
        $data[$row]->puiFac,
        $data[$row]->puiStu,
        $data[$row]->msiFac,
        $data[$row]->msiStu,
        $data[$row]->k12tch,
        $data[$row]->k12dir,
        $data[$row]->k12ttr,
        $data[$row]->other,
        $data[$row]->total,
      ];
    }
    return $toRender;
  }

}
