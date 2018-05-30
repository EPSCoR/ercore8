<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore\Form\ERCoreTableB.
 */

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\ercore_core\ErcoreParticipantBuild;

/**
 * Class ERCoreTableB.
 *
 * Defines ERCore Table B.
 *
 * @package Drupal\ercore\Form
 */
class ERCoreTableB extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ERCoreTableB';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $url = Url::fromRoute('ercore_core.participants_export');
    $link = Link::fromTextAndUrl('Download NSF Table B.', $url);
    $data = $this->formatResults();
    $form['#attached']['library'][] = 'ercore_core/ercore-core-exports.library';
    $form['date_filter'] = \Drupal::formBuilder()->getForm('Drupal\ercore_core\Form\ERCoreDateFilter');
    $form['data_table'] = [
      '#type' => 'fieldset',
      '#title' => t('Table B Results'),
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
    $data = ErcoreParticipantBuild::getData();
    $results = '';
    foreach ($data as $institution) {
      $results .= '<table class="ercore-table-b"><caption>' . $institution['name'] . '</caption>';
      $results .= '<thead><tr><th>Senior Project Role</th><th>Total Individuals</th><th>Male</th><th>Female</th><th>Black or African American</th><th>Hispanic</th><th>Other Ethnicity</th><th>Disabilities</th><th>New Hires*</th></tr></thead><tbody>';
      foreach ($institution['data'] as $row) {
        $results .= '<tr><th>' . $row->name . '</th>';
        $results .= '<td>' . $row->total . '</td>';
        $results .= '<td>' . $row->male . '</td>';
        $results .= '<td>' . $row->female . '</td>';
        $results .= '<td>' . $row->black . '</td>';
        $results .= '<td>' . $row->hispanic . '</td>';
        $results .= '<td>' . $row->other . '</td>';
        $results .= '<td>' . $row->disabled . '</td>';
        $roles = ErcoreParticipantBuild::ercoreNoNewValues();
        if (!in_array($row->name, $roles)) {
          $results .= '<td>' . $row->new . '</td></tr>';
        }
        else {
          $results .= '<td class="grayed">n/a</td></tr>';
        }
        if (!next($institution['data'])) {
          if ($institution['name'] === 'Totals') {
            $results .= '<tr><th>Advisory Board(s)**</th><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td></tr>';
          }
          $results .= '</tbody></table>';
        }
      }
    }
    return $results;
  }

}
