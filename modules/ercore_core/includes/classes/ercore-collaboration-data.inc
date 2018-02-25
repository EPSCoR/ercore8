<?php

/**
 * @file
 * ERcore Collaboration Class for the ERCore Admin module.
 */

require_once drupal_get_path('module', 'ercore_core') . '/includes/ercore-admin-var.inc';

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
   * @return object $object
   *   Returns collaboration data object.
   */
  public function ercoreCollaborationBuild(&$object, &$data) {
    $within_inst = array();
    $ext_inst = array();
    $for_inst = array();
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

}
