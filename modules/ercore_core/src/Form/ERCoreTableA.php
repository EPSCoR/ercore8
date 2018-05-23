<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore_core\Form\ERCoreTableA.
 */

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\ercore_core\ErcoreSalary;

/**
 * Class ERCoreTableA.
 *
 * Defines ERCore Table A.
 *
 * @package Drupal\ercore\Form
 */
class ERCoreTableA extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ERCoreTableA';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $url = Url::fromRoute('ercore_core.salary_support_export');
    $link = Link::fromTextAndUrl('Download NSF Table A.', $url);
    $data = $this->formatResults();
    $form['#attached']['library'][] = 'ercore_core/ercore-core-exports.library';
    $form['date_filter'] = \Drupal::formBuilder()->getForm('Drupal\ercore_core\Form\ERCoreDateFilter');
    $form['data_table'] = [
      '#type' => 'fieldset',
      '#title' => t('Table A Results'),
      '#open' => TRUE,
    ];
    $form['data_table']['description'] = [
      '#markup' => $data,
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
   * Format Results.
   */
  public function formatResults() {
    $data = ErcoreSalary::filterUserIds();
    $results = '';
    foreach ($data as $name => $institution) {
      $results .= '<li><strong>' . $name . '</strong><ul>';
      foreach ($institution as $result) {
        $user = '/user/' . $result['id'];
        $name = Link::fromTextAndUrl($result['name'], Url::fromUserInput($user))
          ->toString()
          ->getGeneratedLink();
        $results .= '<li>' . $name . '</li>';
        if (!next($institution)) {
          $results .= '</ul></li>';
        }
      }
    }
    return '<ul>' . $results . '</ul>';
  }

}
