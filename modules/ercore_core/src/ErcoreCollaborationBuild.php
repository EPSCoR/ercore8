<?php

namespace Drupal\ercore_core;

use Drupal\ercore\ErcoreStartDate;

/**
 * Class ErcoreCollaborationBuild.
 *
 * @package Drupal\ercore_core
 */
class ErcoreCollaborationBuild {

  /**
   * Data types which form row headers.
   *
   * @return array
   *   Return array of data types.
   */
  public static function dataTypes() {
    return [
      'academic' => 'Academic Research Institutions',
      'undergrad' => 'Primarily Undergraduate Institutions',
      'black' => 'Historically Black Colleges and Universities',
      'hispanic' => 'Hispanic Serving Institutions',
      'tribal' => 'Tribal Colleges and Universities',
      'lab' => 'National Laboratories',
      'industry' => 'Industry',
      'none' => 'None/Other',
      'totals' => 'Totals',
    ];
  }

  /**
   * Builds data array for participant data block.
   *
   * @return array
   *   Returns array of objects.
   */
  public static function buildDataArray() {
    $dataArray = [];
    foreach (self::dataTypes() as $key => $type) {
      $dataArray[$key] = new ErcoreCollaboration();
      $dataArray[$key]->setName($type);
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
      ->condition('type', 'ercore_collaboration')
      ->condition('status', 1);
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
      if (!$node->get('field_ercore_collaboration_start')->isEmpty()) {
        $collaboration_start = $node->get('field_ercore_collaboration_start')->getValue();
        if (!$node->get('field_ercore_collaboration_end')->isEmpty()) {
          $end = $node->get('field_ercore_collaboration_end')->getValue();
          $collaboration_end = ErcoreStartDate::dateArgumentToUnix($end[0]['value']);
        }
        else {
          $collaboration_end = ErcoreStartDate::endUnix();
        }
        if (!$node->get('field_ercore_cn_collaborator')->isEmpty()) {
          $nodes[$id] = [
            'start' => ErcoreStartDate::dateArgumentToUnix($collaboration_start[0]['value']),
            'end' => $collaboration_end,
            'count' => 0,
          ];
          $externals = $node->get('field_ercore_cn_collaborator')->getValue();
          foreach ($externals as $external) {
            $pid = $external['target_id'];
            $type = '';
            $category = '';
            $collaborator = \Drupal::entityTypeManager()
              ->getStorage('paragraph')
              ->load($pid);
            if (!$collaborator->get('field_ercore_cr_inst')->isEmpty()) {
              $institution = $collaborator->get('field_ercore_cr_inst')->entity;
              if (!empty($institution)) {
                if (!$institution->get('field_ercore_inst_type')->isEmpty()) {
                  $type = $institution->get('field_ercore_inst_type')->value;
                }
                if (!$institution->get('field_ercore_inst_category')
                  ->isEmpty()
                ) {
                  $category = $institution->get('field_ercore_inst_category')->value;
                }
              }
              $nodes[$id]['data'][$category][$type][] = $pid;
              $nodes[$id]['count'] += 1;
            }
          }
        }
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
        || ($node['start'] <= $dates['end'] && empty($node['end']))) {
        $filtered[$nid] = $node;
      }
    }
    return $filtered;
  }

  /**
   * Counts external collaborators.
   *
   * @param bool $entire_range
   *   Use cumulative date or filtered.
   *
   * @return int
   *   Count of external collaborators.
   */
  public static function countExternals($entire_range = FALSE) {
    $count = 0;
    $nodes = self::filteredNodes($entire_range);
    foreach ($nodes as $node) {
      $count += $node['count'];
    }
    return $count;
  }

  /**
   * Gets all Participant data.
   */
  public static function getData() {
    $data = self::buildDataArray();
    $nodes = self::filteredNodes();
    foreach ($nodes as $nid => $node) {
      foreach ($node['data'] as $key => $external) {
      }
      $data[$key]->groupData($external);
      $data['totals']->groupData($external);
    }
    return $data;
  }

}
