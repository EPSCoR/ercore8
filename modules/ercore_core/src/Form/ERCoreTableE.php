<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore\Form\ERCoreTableE.
 */

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ercore_core\ErcoreOutputs;
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
    $rows = ErcoreOutputs::getData();
    $results = '<h2>NSF Table E Data</h2>';
    $results .= '<table class="ercore-table-b"><caption>Patents</caption>';
    $results .= '<thead><tr><th>Category</th><th>Total for Current Reporting Period</th><th>Cumulative Total for the Award</th></tr></thead><tbody>';
    $results .= '<tr><th>Awarded</th><td>' . $rows['patents']['awarded']['current'] . '</td><td>' . $rows['patents']['awarded']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Pending</th><td>' . $rows['patents']['pending']['current'] . '</td><td>' . $rows['patents']['pending']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Licensed</th><td>' . $rows['patents']['licensed']['current'] . '</td><td>' . $rows['patents']['licensed']['cumulative'] . '</td></tr>';
    $results .= '</tbody></table>';

    $results .= '<table class="ercore-table-b"><caption>Proposals / Grants / Contracts</caption>';
    $results .= '<thead><tr><th>Category</th><th>Current Number</th><th>Current Funds Requested</th><th>Cumulative Number</th><th>Cumulative Funds Requested</th></tr></thead><tbody>';
    $results .= '<tr><th>Submitted</th><td>' . $rows['proposals']['submitted']['current']['number'] . '</td><td>' . $rows['proposals']['submitted']['current']['funds'] . '</td><td>' . $rows['proposals']['submitted']['cumulative']['number'] . '</td><td>' . $rows['proposals']['submitted']['cumulative']['funds'] . '</td></tr>';
    $results .= '<tr><th>Awarded</th><td>' . $rows['proposals']['awarded']['current']['number'] . '</td><td>' . $rows['proposals']['awarded']['current']['funds'] . '</td><td>' . $rows['proposals']['awarded']['cumulative']['number'] . '</td><td>' . $rows['proposals']['awarded']['cumulative']['funds'] . '</td></tr>';
    $results .= '<tr><th>Pending</th><td>' . $rows['proposals']['pending']['current']['number'] . '</td><td>' . $rows['proposals']['pending']['current']['funds'] . '</td><td>' . $rows['proposals']['pending']['cumulative']['number'] . '</td><td>' . $rows['proposals']['pending']['cumulative']['funds'] . '</td></tr>';
    $results .= '</tbody></table>';

    $results .= '<table class="ercore-table-b"><caption>Published Publications</caption>';
    $results .= '<thead><tr><th>Category</th><th>Total for Current Reporting Period</th><th>Cumulative Total for the Award</th></tr></thead><tbody>';
    $results .= '<tr><th>Primary RII Support</th><td>' . $rows['publications']['primary']['current'] . '</td><td>' . $rows['publications']['primary']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Partial RII Support</th><td>' . $rows['publications']['partial']['current'] . '</td><td>' . $rows['publications']['partial']['cumulative'] . '</td></tr>';
    $results .= '</tbody></table>';

    $results .= '<table class="ercore-table-b"><caption>New Hires</caption>';
    $results .= '<thead><tr><th>Category</th><th>Total for Current Reporting Period</th><th>Cumulative Total for the Award</th></tr></thead><tbody>';
    $results .= '<tr><th>Male</th><td>' . $rows['new-hires']['male']['current'] . '</td><td>' . $rows['new-hires']['male']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Female</th><td>' . $rows['new-hires']['female']['current'] . '</td><td>' . $rows['new-hires']['female']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Underrepresented Minority</th><td>' . $rows['new-hires']['minority']['current'] . '</td><td>' . $rows['new-hires']['minority']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Disabled</th><td>' . $rows['new-hires']['disabled']['current'] . '</td><td>' . $rows['new-hires']['disabled']['cumulative'] . '</td></tr>';
    $results .= '</tbody></table>';

    $results .= '<table class="ercore-table-b"><caption>Post Docs</caption>';
    $results .= '<thead><tr><th>Category</th><th>Total for Current Reporting Period</th><th>Cumulative Total for the Award</th></tr></thead><tbody>';
    $results .= '<tr><th>Male</th><td>' . $rows['post-doc']['male']['current'] . '</td><td>' . $rows['post-doc']['male']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Female</th><td>' . $rows['post-doc']['female']['current'] . '</td><td>' . $rows['post-doc']['female']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Underrepresented Minority</th><td>' . $rows['post-doc']['minority']['current'] . '</td><td>' . $rows['post-doc']['minority']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Disabled</th><td>' . $rows['post-doc']['disabled']['current'] . '</td><td>' . $rows['post-doc']['disabled']['cumulative'] . '</td></tr>';
    $results .= '</tbody></table>';

    $results .= '<table class="ercore-table-b"><caption>Graduate Students</caption>';
    $results .= '<thead><tr><th>Category</th><th>Total for Current Reporting Period</th><th>Cumulative Total for the Award</th></tr></thead><tbody>';
    $results .= '<tr><th>Male</th><td>' . $rows['graduate']['male']['current'] . '</td><td>' . $rows['graduate']['male']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Female</th><td>' . $rows['graduate']['female']['current'] . '</td><td>' . $rows['graduate']['female']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Underrepresented Minority</th><td>' . $rows['graduate']['minority']['current'] . '</td><td>' . $rows['graduate']['minority']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Disabled</th><td>' . $rows['graduate']['disabled']['current'] . '</td><td>' . $rows['graduate']['disabled']['cumulative'] . '</td></tr>';
    $results .= '</tbody></table>';

    $results .= '<table class="ercore-table-b"><caption>Undergraduate Students</caption>';
    $results .= '<thead><tr><th>Category</th><th>Total for Current Reporting Period</th><th>Cumulative Total for the Award</th></tr></thead><tbody>';
    $results .= '<tr><th>Male</th><td>' . $rows['undergraduate']['male']['current'] . '</td><td>' . $rows['undergraduate']['male']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Female</th><td>' . $rows['undergraduate']['female']['current'] . '</td><td>' . $rows['undergraduate']['female']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Underrepresented Minority</th><td>' . $rows['undergraduate']['minority']['current'] . '</td><td>' . $rows['undergraduate']['minority']['cumulative'] . '</td></tr>';
    $results .= '<tr><th>Disabled</th><td>' . $rows['undergraduate']['disabled']['current'] . '</td><td>' . $rows['undergraduate']['disabled']['cumulative'] . '</td></tr>';
    $results .= '</tbody></table>';
    return $results;
  }

}
