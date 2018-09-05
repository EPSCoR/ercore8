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
    $form['date_filter'] = \Drupal::formBuilder()
      ->getForm('Drupal\ercore_core\Form\ERCoreDateFilter');
    $form['data_table'] = [
      '#type' => 'fieldset',
      '#title' => t('Table E Results'),
      '#open' => TRUE,
    ];
    $form['data_table']['description'] = self::formatResults();
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
    // Patents.
    $patents = [
      'awarded' => [
        [
          'data' => 'Awarded',
          'header' => TRUE,
        ],
        $rows['patents']['awarded']['current'],
        $rows['patents']['awarded']['cumulative'],
      ],
      'pending' => [
        [
          'data' => 'Pending',
          'header' => TRUE,
        ],
        $rows['patents']['pending']['current'],
        $rows['patents']['pending']['cumulative'],
      ],
      'licensed' => [
        [
          'data' => 'Licensed',
          'header' => TRUE,
        ],
        $rows['patents']['licensed']['current'],
        $rows['patents']['licensed']['cumulative'],
      ],
    ];
    $results['patents'] = [
      '#theme' => 'table',
      '#caption' => 'Patents',
      '#header' => [
        'Category',
        'Total for Current Reporting Period',
        'Cumulative Total for the Award',
      ],
      '#rows' => $patents,
      '#attributes' => [
        'class' => [
          'ercore-data-table',
        ],
      ],
    ];
    // Proposals.
    $proposals = [
      'submitted' => [
        [
          'data' => 'Submitted',
          'header' => TRUE,
        ],
        $rows['proposals']['submitted']['current']['number'],
        $rows['proposals']['submitted']['current']['funds'],
        $rows['proposals']['submitted']['cumulative']['number'],
        $rows['proposals']['submitted']['cumulative']['funds'],
      ],
      'awarded' => [
        [
          'data' => 'Awarded',
          'header' => TRUE,
        ],
        $rows['proposals']['awarded']['current']['number'],
        $rows['proposals']['awarded']['current']['funds'],
        $rows['proposals']['awarded']['cumulative']['number'],
        $rows['proposals']['awarded']['cumulative']['funds'],
      ],
      'pending' => [
        [
          'data' => 'Pending',
          'header' => TRUE,
        ],
        $rows['proposals']['pending']['current']['number'],
        $rows['proposals']['pending']['current']['funds'],
        $rows['proposals']['pending']['cumulative']['number'],
        $rows['proposals']['pending']['cumulative']['funds'],
      ],
    ];
    $results['proposals'] = [
      '#theme' => 'table',
      '#caption' => 'Proposals / Grants / Contracts',
      '#header' => [
        'Category',
        'Current Number',
        'Current Funds Requested',
        'Cumulative Number',
        'Cumulative Funds Requested',
      ],
      '#rows' => $proposals,
      '#attributes' => [
        'class' => [
          'ercore-data-table',
        ],
      ],
    ];
    // Publications.
    $publications = [
      'primary' => [
        [
          'data' => 'Primary RII Support',
          'header' => TRUE,
        ],
        $rows['publications']['primary']['current'],
        $rows['publications']['primary']['cumulative'],
      ],
      'partial' => [
        [
          'data' => 'Partial RII Support',
          'header' => TRUE,
        ],
        $rows['publications']['partial']['current'],
        $rows['publications']['partial']['cumulative'],
      ],
    ];
    $results['publications'] = [
      '#theme' => 'table',
      '#caption' => 'Published Publications',
      '#header' => [
        'Category',
        'Total for Current Reporting Period',
        'Cumulative Total for the Award',
      ],
      '#rows' => $publications,
      '#attributes' => [
        'class' => [
          'ercore-data-table',
        ],
      ],
    ];
    // New Hires.
    $hired = [
      'male' => [
        [
          'data' => 'Male',
          'header' => TRUE,
        ],
        $rows['hired']['male']['current'],
        $rows['hired']['male']['cumulative'],
      ],
      'female' => [
        [
          'data' => 'Female',
          'header' => TRUE,
        ],
        $rows['hired']['female']['current'],
        $rows['hired']['female']['cumulative'],

      ],
      'minority' => [
        [
          'data' => 'Underrepresented Minority',
          'header' => TRUE,
        ],
        $rows['hired']['minority']['current'],
        $rows['hired']['minority']['cumulative'],
      ],
      'disabled' => [
        [
          'data' => 'Disabled',
          'header' => TRUE,
        ],
        $rows['hired']['disabled']['current'],
        $rows['hired']['disabled']['cumulative'],
      ],
    ];
    $results['new_hires'] = [
      '#theme' => 'table',
      '#caption' => 'New Hires',
      '#header' => [
        'Category',
        'Total for Current Reporting Period',
        'Cumulative Total for the Award',

      ],
      '#rows' => $hired,
      '#attributes' => [
        'class' => [
          'ercore-data-table',
        ],
      ],
    ];
    // Post Docs.
    $postdoc = [
      'male' => [
        [
          'data' => 'Male',
          'header' => TRUE,
        ],
        $rows['post-doc']['male']['current'],
        $rows['post-doc']['male']['cumulative'],
      ],
      'female' => [
        [
          'data' => 'Female',
          'header' => TRUE,
        ],
        $rows['post-doc']['female']['current'],
        $rows['post-doc']['female']['cumulative'],

      ],
      'minority' => [
        [
          'data' => 'Underrepresented Minority',
          'header' => TRUE,
        ],
        $rows['post-doc']['minority']['current'],
        $rows['post-doc']['minority']['cumulative'],
      ],
      'disabled' => [
        [
          'data' => 'Disabled',
          'header' => TRUE,
        ],
        $rows['post-doc']['disabled']['current'],
        $rows['post-doc']['disabled']['cumulative'],
      ],
    ];
    $results['postdocs'] = [
      '#theme' => 'table',
      '#caption' => 'Post Docs',
      '#header' => [
        'Category',
        'Total for Current Reporting Period',
        'Cumulative Total for the Award',
      ],
      '#rows' => $postdoc,
      '#attributes' => [
        'class' => [
          'ercore-data-table',
        ],
      ],
    ];
    // Graduate.
    $graduate = [
      'male' => [
        [
          'data' => 'Male',
          'header' => TRUE,
        ],
        $rows['graduate']['male']['current'],
        $rows['graduate']['male']['cumulative'],
      ],
      'female' => [
        [
          'data' => 'Female',
          'header' => TRUE,
        ],
        $rows['graduate']['female']['current'],
        $rows['graduate']['female']['cumulative'],

      ],
      'minority' => [
        [
          'data' => 'Underrepresented Minority',
          'header' => TRUE,
        ],
        $rows['graduate']['minority']['current'],
        $rows['graduate']['minority']['cumulative'],
      ],
      'disabled' => [
        [
          'data' => 'Disabled',
          'header' => TRUE,
        ],
        $rows['graduate']['disabled']['current'],
        $rows['graduate']['disabled']['cumulative'],
      ],
    ];
    $results['graduate'] = [
      '#theme' => 'table',
      '#caption' => 'Graduate Students',
      '#header' => [
        'Category',
        'Total for Current Reporting Period',
        'Cumulative Total for the Award',
      ],
      '#rows' => $graduate,
      '#attributes' => [
        'class' => [
          'ercore-data-table',
        ],
      ],
    ];
    // Undergraduate.
    $undergraduate = [
      'male' => [
        [
          'data' => 'Male',
          'header' => TRUE,
        ],
        $rows['undergraduate']['male']['current'],
        $rows['undergraduate']['male']['cumulative'],
      ],
      'female' => [
        [
          'data' => 'Female',
          'header' => TRUE,
        ],
        $rows['undergraduate']['female']['current'],
        $rows['undergraduate']['female']['cumulative'],

      ],
      'minority' => [
        [
          'data' => 'Underrepresented Minority',
          'header' => TRUE,
        ],
        $rows['undergraduate']['minority']['current'],
        $rows['undergraduate']['minority']['cumulative'],
      ],
      'disabled' => [
        [
          'data' => 'Disabled',
          'header' => TRUE,
        ],
        $rows['undergraduate']['disabled']['current'],
        $rows['undergraduate']['disabled']['cumulative'],
      ],
    ];
    $results['undergraduate'] = [
      '#theme' => 'table',
      '#caption' => 'Undergraduate Students',
      '#header' => [
        'Category',
        'Total for Current Reporting Period',
        'Cumulative Total for the Award',
      ],
      '#rows' => $undergraduate,
      '#attributes' => [
        'class' => [
          'ercore-data-table',
        ],
      ],
    ];
    return $results;
  }

}
