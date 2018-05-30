<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore\Form\ERCoreTableC.
 */

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ercore_core\ErcoreCollaborationBuild;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class ERCoreTableC.
 *
 * Defines ERCore Table C.
 *
 * @package Drupal\ercore\Form
 */
class ERCoreTableC extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ERCoreTableC';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $url = Url::fromRoute('ercore_core.collaborations_export');
    $link = Link::fromTextAndUrl('Download NSF Table C.', $url);
    $form['#attached']['library'][] = 'ercore_core/ercore-core-exports.library';
    $form['date_filter'] = \Drupal::formBuilder()
      ->getForm('Drupal\ercore_core\Form\ERCoreDateFilter');
    $form['data_table'] = [
      '#type' => 'fieldset',
      '#title' => t('Table C Results'),
      '#open' => TRUE,
    ];
    $form['data_table']['description'] = [
      '#markup' => self::formatResults(),
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
    $rows = ErcoreCollaborationBuild::getData();
    $results = '';
    $results .= '<table class="ercore-table-b"><caption>NSF Table C Data</caption>';
    $results .= '<thead><tr><th>Categories</th><th>Local Institutions</th><th>Local Collaborators</th><th>Domestic Institutions</th><th>Domestic Collaborators</th><th>Foreign Institutions</th><th>Foreign Collaborators</th></tr></thead><tbody>';
    foreach ($rows as $row) {
      $results .= '<tr><th>' . $row->type . '</th>';
      $results .= '<td>' . $row->localInstitutions . '</td>';
      $results .= '<td>' . $row->localCollaborators . '</td>';
      $results .= '<td>' . $row->domesticInstitutions . '</td>';
      $results .= '<td>' . $row->domesticCollaborators . '</td>';
      $results .= '<td>' . $row->foreignInstitutions . '</td>';
      $results .= '<td>' . $row->foreignCollaborators . '</td></tr>';
    }
    $results .= '</tbody></table>';
    return $results;
  }

}
