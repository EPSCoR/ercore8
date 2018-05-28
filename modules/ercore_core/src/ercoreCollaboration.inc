<?php

namespace Drupal\ercore_core;

use Drupal\ercore\ercoreStartDate;

/**
 * Class defines node export object.
 */
class ErcoreCollaboration {
  public $type = '';
  public $withinInst = '0';
  public $withinColl = '0';
  public $extInst = '0';
  public $extColl = '0';
  public $forInst = '0';
  public $forColl = '0';

  /**
   * All users with salary support checked.
   *
   * @var array
   */
  public $allIds = [];

  /**
   * Filtered users with salary support checked.
   *
   * @var array
   */
  public $filteredIds = [];

  /**
   * Filter dates to use for exports.
   *
   * @var array
   */
  public $range = [];

  /**
   * Constructor.
   */
  public function __construct() {

  }

  /**
   * Builds Collaboration data object with data.
   *
   * @param object $object
   *   Receives collaboration data object for data placement.
   * @param array $data
   *   Receives data for placement in data object.
   *
   * @return object
   *   Returns collaboration data object.
   */
  public function ercoreCollaborationBuild(&$object, array &$data) {
    $within_inst = [];
    $ext_inst = [];
    $for_inst = [];
    foreach ($data as $row) {
      if ($row->field_field_ercore_in_type[0]['raw']['value'] == 'local') {
        $this->withinColl++;
        $within_inst[] = $row->node_field_data_field_ercore_cr_inst_ref_nid;
      }
      elseif ($row->field_field_ercore_in_type[0]['raw']['value'] == 'domestic') {
        $this->extColl++;
        $ext_inst[] = $row->node_field_data_field_ercore_cr_inst_ref_nid;
      }
      else {
        $this->forColl++;
        $for_inst[] = $row->node_field_data_field_ercore_cr_inst_ref_nid;
      }
    }
    $this->withinInst = count(array_unique($within_inst));
    $this->extInst = count(array_unique($ext_inst));
    $this->forInst = count(array_unique($for_inst));
    return $object;
  }

  /**
   * Build salary object.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function getNodeIds() {
    $query = \Drupal::entityQuery('node');
    $query->condition('field_ercore_user_fac_support', 1);
    return $query->execute();
  }

  /**
   * Build salary object.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function getUserIds() {
    $query = \Drupal::entityQuery('user');
    $query->condition('field_ercore_user_fac_support', 1);
    return $query->execute();
  }

  /**
   * Build salary object.
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
        $users[$id] = [
          'id' => $node->id(),
          'name' => $node,
          'start' => ErcoreStartDate::dateArgumentToUnix($collaboration_start[0]['value']),
          'end' => $collaboration_end,
        ];
      }
    }
    return $nodes;
  }

  /**
   * Build salary object.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function filterUserIds() {
    $dates = ercore_get_filter_dates();
    $filtered = [];
    $nodes = self::getNodes();
    foreach ($nodes as $nid => $node) {
      if (($node['start'] <= $dates['end'] && $node['end'] >= $dates['start'])
        || ($node['start'] <= $dates['end'] && empty($node['end']))) {
        $filtered[$node][] = $node;
      }
    }
    return $filtered;
  }

}
