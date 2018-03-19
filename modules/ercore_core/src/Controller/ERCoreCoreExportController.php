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
  public function ercoreSalaryExport() {
    return ['#markup' => 'Salary export exports go here.'];
  }

  /**
   * ERCore Participants.
   */
  public function ercoreParticipantExport() {
    return ['#markup' => 'Participant export exports go here.'];
  }

  /**
   * ERCore Collaborations.
   */
  public function ercoreCollaborationExport() {
    return ['#markup' => 'Collaborations export exports go here.'];
  }

  /**
   * ERCore Engagements.
   */
  public function ercoreEngagementExport() {
    return ['#markup' => 'Engagements export exports go here.'];
  }

  /**
   * ERCore Outputs.
   */
  public function ercoreOutputExport() {
    return ['#markup' => 'Outputs export exports go here.'];
  }

}
