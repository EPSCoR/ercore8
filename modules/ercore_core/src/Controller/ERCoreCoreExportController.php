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
   * ERCore Salary Support.
   */
  public function ercoreSalarySupport() {
    return [
      '#markup' => '<p>Salary form</p>',
    ];
  }

  /**
   * ERCore Participants.
   */
  public function ercoreParticipants() {
    return [
      '#markup' => '<p>Participants form</p>',
    ];
  }

  /**
   * ERCore Collaborations.
   */
  public function ercoreCollaborations() {
    return [
      '#markup' => '<p>Collaborations form</p>',
    ];
  }

  /**
   * ERCore Engagements.
   */
  public function ercoreEngagements() {
    return [
      '#markup' => '<p>Engagements form</p>',
    ];
  }

  /**
   * ERCore Outputs.
   */
  public function ercoreOutputs() {
    return [
      '#markup' => '<p>Outputs form</p>',
    ];
  }

}
