<?php

namespace Drupal\ercore_core\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller routines for page example routes.
 */
class ERCoreCoreExportController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  protected function getModuleName() {
    return 'ercore_core';
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ercore_core_data_export';
  }

  /**
   * ERCore Accomplishments.
   */
  public function ercoreAccomplishments() {
    return ['#markup' => 'Accomplishment exports go here.'];
  }

  /**
   * ERCore Salary Support.
   */
  public function ercoreSalarySupport() {
    include_once drupal_get_path('module', 'ercore_core') . '/pages/ercore-table-a.inc';
    return nsf_table_a_callback();
  }

  /**
   * ERCore Participants.
   */
  public function ercoreParticipants() {
    include_once drupal_get_path('module', 'ercore_core') . '/pages/ercore-table-b.inc';
    return nsf_table_b_callback();
  }

  /**
   * ERCore Collaborations.
   */
  public function ercoreCollaborations() {
    include_once drupal_get_path('module', 'ercore_core') . '/pages/ercore-table-c.inc';
    return nsf_table_c_callback();
  }

  /**
   * ERCore Engagements.
   */
  public function ercoreEngagements() {
    include_once drupal_get_path('module', 'ercore_core') . '/pages/ercore-table-d.inc';
    return nsf_table_d_callback();
  }

  /**
   * ERCore Outputs.
   */
  public function ercoreOutputs() {
    include_once drupal_get_path('module', 'ercore_core') . '/pages/ercore-table-e.inc';
    return nsf_table_e_callback();
  }

}
