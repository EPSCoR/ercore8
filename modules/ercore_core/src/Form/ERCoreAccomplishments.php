<?php

namespace Drupal\ercore_core\Form;

/**
 * @file
 * Contains Drupal\ercore\Form\ERCoreAccomplishments.
 */

use Drupal\ercore\ErcoreStartDate;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\ercore_core\ErcoreCollaborationBuild;
use Drupal\ercore_core\ErcoreEngagementBuild;
use Drupal\ercore_core\ErcoreOutputs;
use Drupal\ercore_core\ErcoreParticipantBuild;
use Drupal\Core\Entity;

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
    $institutions = self::getInstitutions();
    $other = ErcoreOutputs::getData();
    $this->temp = \Drupal::service('user.private_tempstore')
      ->get('ercore_core');
    $filterStart = $this->temp->get('ercore_filter_start');
    $filterEnd = $this->temp->get('ercore_filter_end');
    $url = Url::fromRoute('ercore_core.accomplishments_export');
    $link = Link::fromTextAndUrl('Download EPSCoR Reporting Core Tables.', $url);
    $form['#attached']['library'][] = 'ercore_core/ercore-core-exports.library';
    $form['date_filter'] = \Drupal::formBuilder()->getForm('Drupal\ercore_core\Form\ERCoreDateFilter');
    $form['data'] = [
      '#theme' => 'table',
      '#caption' => 'Accomplishments Data',
      '#header' => [
        t('Categories of Accomplishments'),
        'Inception through ' . ErcoreStartDate::endField(),
      ],
      '#rows' => [
        'collaborations' => [
          Link::fromTextAndUrl('Collaborations', Url::fromUri('internal:/collaborations')),
          count(ErcoreCollaborationBuild::filteredNodes(TRUE)),
        ],
        'collaborators' => [
          Link::fromTextAndUrl('External Collaborators', Url::fromUri('internal:/collaborators')),
          ErcoreCollaborationBuild::countExternals(TRUE),
        ],
        'events' => [
          Link::fromTextAndUrl('Engagement Events', Url::fromUri('internal:/events')),
          count(ErcoreEngagementBuild::filteredNodes(TRUE)),
        ],
        'engagements' => [
          Link::fromTextAndUrl('External Engagements', Url::fromUri('internal:/engagements')),
          ErcoreEngagementBuild::countExternals(TRUE),
        ],
        'proposals' => [
          Link::fromTextAndUrl('Grants and Proposals', Url::fromUri('internal:/proposals')),
          $other['proposals']['submitted']['cumulative']['number'],
        ],
        'highlights' => [
          Link::fromTextAndUrl('Highlights', Url::fromUri('internal:/highlights')),
          self::getHighlights(TRUE),
        ],
        'honors' => [
          Link::fromTextAndUrl('Honors and Awards', Url::fromUri('internal:/honors')),
          self::getHonors(TRUE),
        ],
        'institutions' => [
          Link::fromTextAndUrl('Institutions', Url::fromUri('internal:/institutions')),
          $institutions,
        ],
        'others' => [
          Link::fromTextAndUrl('Other Research Products', Url::fromUri('internal:/other-research-products')),
          self::getOtherProducts(TRUE),
        ],
        'participants' => [
          Link::fromTextAndUrl('Participants', Url::fromUri('internal:/participants')),
          count(ErcoreParticipantBuild::getFilteredUsers(TRUE)),
        ],
        'patents' => [
          Link::fromTextAndUrl('Patents', Url::fromUri('internal:/patents')),
          $other['patents']['awarded']['cumulative'],
        ],
        'publications' => [
          Link::fromTextAndUrl('Publications', Url::fromUri('internal:/publications')),
          $other['publications']['primary']['cumulative'] + $other['publications']['partial']['cumulative'],
        ],
      ],
    ];
    if (!ErcoreStartDate::isDefaultRange()) {
      $form['data']['#header'][] = ErcoreStartDate::dateArgumentToField($filterStart) . ' to ' . ErcoreStartDate::dateArgumentToField($filterEnd);
      $form['data']['#rows']['collaborations'][] = count(ErcoreCollaborationBuild::filteredNodes(FALSE));
      $form['data']['#rows']['collaborators'][] = ErcoreCollaborationBuild::countExternals(FALSE);
      $form['data']['#rows']['events'][] = count(ErcoreEngagementBuild::filteredNodes(FALSE));
      $form['data']['#rows']['engagements'][] = ErcoreEngagementBuild::countExternals(FALSE);
      $form['data']['#rows']['proposals'][] = $other['proposals']['submitted']['current']['number'];
      $form['data']['#rows']['highlights'][] = self::getHighlights(FALSE);
      $form['data']['#rows']['honors'][] = self::getHonors(FALSE);
      $form['data']['#rows']['institutions'][] = $institutions;
      $form['data']['#rows']['others'][] = self::getOtherProducts(FALSE);
      $form['data']['#rows']['participants'][] = count(ErcoreParticipantBuild::getFilteredUsers(FALSE));
      $form['data']['#rows']['patents'][] = $other['patents']['awarded']['current'];
      $form['data']['#rows']['publications'][] = $other['publications']['primary']['current'] + $other['publications']['partial']['current'];
    }
    $form['export_link'] = [
      '#markup' => '<p class="epscor-download">' . $link->toString() . '</p>',
    ];

    return $form;
  }

  /**
   * Build Node ID array.
   *
   * @return int
   *   Institution count.
   */
  public static function getInstitutions() {
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'ercore_institution')
      ->condition('status', 1);
    return count($query->execute());
  }

  /**
   * Build Node ID array.
   *
   * @param bool $entire_range
   *   Use cumulative date or filtered.
   *
   * @return int
   *   Highlight count.
   */
  public static function getHighlights($entire_range = FALSE) {
    $count = 0;
    $filter = ercore_get_filter_dates();
    if ($entire_range === TRUE) {
      $filter = ercore_get_project_filter_dates();
    }
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'ercore_j_highlight')
      ->condition('status', 1);
    $ids = $query->execute();
    $node_storage = \Drupal::entityManager()->getStorage('node');
    foreach ($ids as $id) {
      $node = $node_storage->load($id);
      $date = ErcoreStartDate::dateArgumentToUnix($node->get('field_ercore_hi_date')->value);
      if ($filter['start'] <= $date && $date <= $filter['end']) {
        $count++;
      }
    }
    return $count;
  }

  /**
   * Build Node ID array.
   *
   * @param bool $entire_range
   *   Use cumulative date or filtered.
   *
   * @return int
   *   Honor count.
   */
  public static function getHonors($entire_range = FALSE) {
    $count = 0;
    $filter = ercore_get_filter_dates();
    if ($entire_range === TRUE) {
      $filter = ercore_get_project_filter_dates();
    }
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'ercore_j_honor')
      ->condition('status', 1);
    $ids = $query->execute();
    $node_storage = \Drupal::entityManager()->getStorage('node');
    foreach ($ids as $id) {
      $node = $node_storage->load($id);
      $date = ErcoreStartDate::dateArgumentToUnix($node->get('field_ercore_hn_date')->value);
      if ($filter['start'] <= $date && $date <= $filter['end']) {
        $count++;
      }
    }
    return $count;
  }


  /**
   * Build Node ID array.
   *
   * @param bool $entire_range
   *   Use cumulative date or filtered.
   *
   * @return int
   *   Other Product count.
   */
  public static function getOtherProducts($entire_range = FALSE) {
    $count = 0;
    $filter = ercore_get_filter_dates();
    if ($entire_range === TRUE) {
      $filter = ercore_get_project_filter_dates();
    }
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'ercore_other_product')
      ->condition('status', 1);
    $ids = $query->execute();
    $node_storage = \Drupal::entityManager()->getStorage('node');
    foreach ($ids as $id) {
      $node = $node_storage->load($id);
      $date = ErcoreStartDate::dateArgumentToUnix($node->get('field_ercore_op_date')->value);
      if ($filter['start'] <= $date && $date <= $filter['end']) {
        $count++;
      }
    }
    return $count;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // We don't use this, but the interface requires us to implement it.
  }

}
