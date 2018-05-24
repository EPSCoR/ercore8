<?php

namespace Drupal\ercore_core\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\ercore_core\ErcoreExcel;

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
    $file_name = 'Report';
    $file_path = drupal_get_path('module', 'ercore_core') . '/files/Report.xls';
    $spreadsheet = ErcoreExcel::getFile($file_path);
    $sheet = $spreadsheet->getActiveSheet();
    // Modify stuff.
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

  /**
   * ERCore Collaborations.
   */
  public function ercoreSalaryExport() {
    $file_name = 'Salary-Support';
    $file_path = drupal_get_path('module', 'ercore_core') . '/files/Salary-Support.xls';
    $spreadsheet = ErcoreExcel::getFile($file_path);
    $sheet = $spreadsheet->getActiveSheet();
    // Modify stuff.
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }
  
  /**
   * ERCore Participants.
   */
  public function ercoreParticipantExport() {
    $file_name = 'Participants';
    $file_path = drupal_get_path('module', 'ercore_core') . '/files/Participants.xls';
    $spreadsheet = ErcoreExcel::getFile($file_path);
    $sheet = $spreadsheet->getActiveSheet();
    // Modify stuff.
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

  /**
   * ERCore Collaborations.
   */
  public function ercoreCollaborationExport() {
    $file_name = 'Collaborations';
    $file_path = drupal_get_path('module', 'ercore_core') . '/files/Collaborations.xls';
    $spreadsheet = ErcoreExcel::getFile($file_path);
    $sheet = $spreadsheet->getActiveSheet();
    // Modify stuff.
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

  /**
   * ERCore Engagements.
   */
  public function ercoreEngagementExport() {
    $file_name = 'External-Engagement';
    $file_path = drupal_get_path('module', 'ercore_core') . '/files/External-Engagement.xls';
    $spreadsheet = ErcoreExcel::getFile($file_path);
    $sheet = $spreadsheet->getActiveSheet();
    // Modify stuff.
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

  /**
   * ERCore Outputs.
   */
  public function ercoreOutputsExport() {
    $file_name = 'Outputs';
    $file_path = drupal_get_path('module', 'ercore_core') . '/files/Outputs.xls';
    $spreadsheet = ErcoreExcel::getFile($file_path);
    $sheet = $spreadsheet->getActiveSheet();
    // Modify stuff.
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

}
