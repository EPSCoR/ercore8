<?php

namespace Drupal\ercore_core;

use Drupal\ercore\ErcoreStartDate;

/**
 * Class ErcoreEngagementBuild.
 *
 * @package Drupal\ercore_core
 */
class ErcoreEngagementBuild {

  /**
   * Data types which form row headers.
   *
   * @return array
   *   Return array of data types.
   */
  public static function dataTypes() {
    return [
      '5' => 'total',
      '6' => 'male',
      '7' => 'female',
      '8' => 'minority',
    ];
  }

  /**
   * Builds data array for engagement data block.
   *
   * @return array
   *   Returns array of objects.
   */
  public static function buildDataArray() {
    $dataArray = [];
    foreach (self::dataTypes() as $type) {
      $dataArray[$type] = new ErcoreEngagement();
      $dataArray[$type]->setName('total');
    }
    return $dataArray;
  }

  /**
   * Builds aggregation array for engagement data block.
   *
   * @return array
   *   Returns array of objects.
   */
  public static function buildAggregationArray() {
    $dataArray = [];
    foreach (self::dataTypes() as $type) {
      $dataArray[$type] = [
        'ari' => [
          'stu' => 0,
          'fac' => 0,
        ],
        'pui' => [
          'stu' => 0,
          'fac' => 0,
        ],
        'msi' => [
          'stu' => 0,
          'fac' => 0,
        ],
        'k12' => [
          'dir' => 0,
          'ttr' => 0,
          'tch' => 0,
        ],
        'other' => 0,
        'total' => 0,
      ];
    }
    return $dataArray;
  }

  /**
   * Build Node ID array.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function getNodeIds() {
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'ercore_event')
      ->condition('status', 1)
      ->condition('field_ercore_ev_reminders', 1);
    return $query->execute();
  }

  /**
   * Build data object.
   *
   * @return array
   *   Array of Users.
   */
  public static function getNodes() {
    $ids = self::getNodeIds();
    $nodes = [];
    foreach ($ids as $id) {
      $node = \Drupal::entityTypeManager()->getStorage('node')->load($id);
      if (!$node->get('field_ercore_ev_date_start')
        ->isEmpty() && !$node->get('field_ercore_ev_engagement')->isEmpty()
      ) {
        $start_var = $node->get('field_ercore_ev_date_start')->value;
        $start = strtotime($start_var);
        if (!$node->get('field_ercore_ev_date_end')->isEmpty()) {
          $end_var = $node->get('field_ercore_ev_date_end')->value;
          $end = strtotime($end_var);
        }
        else {
          $end = ErcoreStartDate::endUnix();
        }
        $engagement = $node->get('field_ercore_ev_engagement')->entity;
        $nodes[$id] = [
          'start' => $start,
          'end' => $end,
          'engagement' => $engagement,
        ];
      }
    }
    return $nodes;
  }

  /**
   * Filter data by date.
   *
   * @param bool $entire_range
   *   Use cumulative date or filtered.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function filteredNodes($entire_range = FALSE) {
    $dates = ercore_get_filter_dates();
    if ($entire_range === TRUE) {
      $dates = ercore_get_project_filter_dates();
    }
    $filtered = [];
    $nodes = self::getNodes();
    foreach ($nodes as $nid => $node) {
      if (($node['start'] <= $dates['end'] && $node['end'] >= $dates['start'])
        || ($node['start'] <= $dates['end'] && empty($node['end']))
      ) {
        $filtered[] = $node['engagement'];
      }
    }
    return $filtered;
  }

  /**
   * Process engagements into a data array for aggregation.
   *
   * @param bool $entire_range
   *   Use cumulative date or filtered.
   *
   * @return array
   *   Return data array.
   */
  public static function getEngagements($entire_range = FALSE) {
    $engagements = self::buildAggregationArray();
    $entities = self::filteredNodes($entire_range);
    foreach ($entities as $entity) {
      // ARI Faculty.
      $engagements['total']['ari']['fac'] += $entity->get('field_ercore_ee_ari_fac_f')->value;
      $engagements['female']['ari']['fac'] += $entity->get('field_ercore_ee_ari_fac_f')->value;
      $engagements['total']['ari']['fac'] += $entity->get('field_ercore_ee_ari_fac_m')->value;
      $engagements['male']['ari']['fac'] += $entity->get('field_ercore_ee_ari_fac_m')->value;
      $engagements['total']['ari']['fac'] += $entity->get('field_ercore_ee_ari_fac_u')->value;
      $engagements['minority']['ari']['fac'] += $entity->get('field_ercore_ee_ari_fac_mn')->value;

      // ARI Student.
      $engagements['total']['ari']['stu'] += $entity->get('field_ercore_ee_ari_stu_f')->value;
      $engagements['female']['ari']['stu'] += $entity->get('field_ercore_ee_ari_stu_f')->value;
      $engagements['total']['ari']['stu'] += $entity->get('field_ercore_ee_ari_stu_m')->value;
      $engagements['male']['ari']['stu'] += $entity->get('field_ercore_ee_ari_stu_m')->value;
      $engagements['total']['ari']['stu'] += $entity->get('field_ercore_ee_ari_stu_u')->value;
      $engagements['minority']['ari']['stu'] += $entity->get('field_ercore_ee_ari_stu_mn')->value;
      // PUI Faculty.
      $engagements['total']['pui']['fac'] += $entity->get('field_ercore_ee_pui_fac_f')->value;
      $engagements['female']['pui']['fac'] += $entity->get('field_ercore_ee_pui_fac_f')->value;
      $engagements['total']['pui']['fac'] += $entity->get('field_ercore_ee_pui_fac_m')->value;
      $engagements['male']['pui']['fac'] += $entity->get('field_ercore_ee_pui_fac_m')->value;
      $engagements['total']['pui']['fac'] += $entity->get('field_ercore_ee_pui_fac_u')->value;
      $engagements['minority']['pui']['fac'] += $entity->get('field_ercore_ee_pui_fac_mn')->value;
      // PUI Student.
      $engagements['total']['pui']['stu'] += $entity->get('field_ercore_ee_pui_stu_f')->value;
      $engagements['female']['pui']['stu'] += $entity->get('field_ercore_ee_pui_stu_f')->value;
      $engagements['total']['pui']['stu'] += $entity->get('field_ercore_ee_pui_stu_m')->value;
      $engagements['male']['pui']['stu'] += $entity->get('field_ercore_ee_pui_stu_m')->value;
      $engagements['total']['pui']['stu'] += $entity->get('field_ercore_ee_pui_stu_u')->value;
      $engagements['minority']['pui']['stu'] += $entity->get('field_ercore_ee_pui_stu_mn')->value;
      // MSI Faculty.
      $engagements['total']['msi']['fac'] += $entity->get('field_ercore_ee_msi_fac_f')->value;
      $engagements['female']['msi']['fac'] += $entity->get('field_ercore_ee_msi_fac_f')->value;
      $engagements['total']['msi']['fac'] += $entity->get('field_ercore_ee_msi_fac_m')->value;
      $engagements['male']['msi']['fac'] += $entity->get('field_ercore_ee_msi_fac_m')->value;
      $engagements['total']['msi']['fac'] += $entity->get('field_ercore_ee_msi_fac_u')->value;
      $engagements['minority']['msi']['fac'] += $entity->get('field_ercore_ee_msi_fac_mn')->value;
      // MSI Student.
      $engagements['total']['msi']['stu'] += $entity->get('field_ercore_ee_msi_stu_f')->value;
      $engagements['female']['msi']['stu'] += $entity->get('field_ercore_ee_msi_stu_f')->value;
      $engagements['total']['msi']['stu'] += $entity->get('field_ercore_ee_msi_stu_m')->value;
      $engagements['male']['msi']['stu'] += $entity->get('field_ercore_ee_msi_stu_m')->value;
      $engagements['total']['msi']['stu'] += $entity->get('field_ercore_ee_msi_stu_u')->value;
      $engagements['minority']['msi']['stu'] += $entity->get('field_ercore_ee_msi_stu_mn')->value;
      // Other.
      $engagements['total']['other'] += $entity->get('field_ercore_ee_other_f')->value;
      $engagements['female']['other'] += $entity->get('field_ercore_ee_other_f')->value;
      $engagements['total']['other'] += $entity->get('field_ercore_ee_other_m')->value;
      $engagements['male']['other'] += $entity->get('field_ercore_ee_other_m')->value;
      $engagements['total']['other'] += $entity->get('field_ercore_ee_other_u')->value;
      $engagements['minority']['other'] += $entity->get('field_ercore_ee_other_mn')->value;
      // K12 TTR.
      $engagements['total']['k12']['ttr'] += $entity->get('field_ercore_ee_k12_ttr_f')->value;
      $engagements['female']['k12']['ttr'] += $entity->get('field_ercore_ee_k12_ttr_f')->value;
      $engagements['total']['k12']['ttr'] += $entity->get('field_ercore_ee_other_m')->value;
      $engagements['male']['k12']['ttr'] += $entity->get('field_ercore_ee_k12_ttr_m')->value;
      $engagements['total']['k12']['ttr'] += $entity->get('field_ercore_ee_k12_ttr_u')->value;
      $engagements['minority']['k12']['ttr'] += $entity->get('field_ercore_ee_k12_ttr_mn')->value;
      // K12 TCH.
      $engagements['total']['k12']['tch'] += $entity->get('field_ercore_ee_k12_tch_f')->value;
      $engagements['female']['k12']['tch'] += $entity->get('field_ercore_ee_k12_tch_f')->value;
      $engagements['total']['k12']['tch'] += $entity->get('field_ercore_ee_k12_tch_m')->value;
      $engagements['male']['k12']['tch'] += $entity->get('field_ercore_ee_k12_tch_m')->value;
      $engagements['total']['k12']['tch'] += $entity->get('field_ercore_ee_k12_tch_u')->value;
      $engagements['minority']['k12']['tch'] += $entity->get('field_ercore_ee_k12_tch_mn')->value;
      // k12 DIR.
      $engagements['total']['k12']['dir'] += $entity->get('field_ercore_ee_k12_dir_f')->value;
      $engagements['female']['k12']['dir'] += $entity->get('field_ercore_ee_k12_dir_f')->value;
      $engagements['total']['k12']['dir'] += $entity->get('field_ercore_ee_k12_dir_m')->value;
      $engagements['male']['k12']['dir'] += $entity->get('field_ercore_ee_k12_dir_m')->value;
      $engagements['total']['k12']['dir'] += $entity->get('field_ercore_ee_k12_dir_u')->value;
      $engagements['minority']['k12']['dir'] += $entity->get('field_ercore_ee_k12_dir_mn')->value;
    }
    return $engagements;
  }

  /**
   * Builds Engagement data object with data.
   *
   * @param bool $entire_range
   *   Use cumulative date or filtered.
   *
   * @return array
   *   Returns array of data objects.
   */
  public static function getData($entire_range = FALSE) {
    $data_array = self::buildDataArray();
    $engagements = self::getEngagements($entire_range);
    $types = self::dataTypes();
    foreach ($types as $type) {
      $data_array[$type]->ariFac += $engagements[$type]['ari']['fac'];
      $data_array[$type]->ariStu += $engagements[$type]['ari']['stu'];
      $data_array[$type]->puiFac += $engagements[$type]['pui']['fac'];
      $data_array[$type]->puiStu += $engagements[$type]['pui']['stu'];
      $data_array[$type]->msiFac += $engagements[$type]['msi']['fac'];
      $data_array[$type]->msiStu += $engagements[$type]['msi']['stu'];
      $data_array[$type]->ariFac += $engagements[$type]['ari']['fac'];
      $data_array[$type]->k12ttr += $engagements[$type]['k12']['ttr'];
      $data_array[$type]->k12tch += $engagements[$type]['k12']['tch'];
      $data_array[$type]->k12dir += $engagements[$type]['k12']['dir'];
      $data_array[$type]->other += $engagements[$type]['other'];

      $data_array[$type]->total += $engagements[$type]['ari']['fac'];
      $data_array[$type]->total += $engagements[$type]['ari']['stu'];
      $data_array[$type]->total += $engagements[$type]['pui']['fac'];
      $data_array[$type]->total += $engagements[$type]['pui']['stu'];
      $data_array[$type]->total += $engagements[$type]['msi']['fac'];
      $data_array[$type]->total += $engagements[$type]['msi']['stu'];
      $data_array[$type]->total += $engagements[$type]['ari']['fac'];
      $data_array[$type]->total += $engagements[$type]['k12']['ttr'];
      $data_array[$type]->total += $engagements[$type]['k12']['tch'];
      $data_array[$type]->total += $engagements[$type]['k12']['dir'];
      $data_array[$type]->total += $engagements[$type]['other'];
    }
    return $data_array;
  }

  /**
   * Counts external engagements.
   *
   * @param bool $entire_range
   *   Use cumulative date or filtered.
   *
   * @return int
   *   Count of external engagements.
   */
  public static function countExternals($entire_range = FALSE) {
    $engagements = self::getData($entire_range);
    return $engagements['total']->total;
  }

}
