<?php

namespace Drupal\ercore_core\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\ercore_core\ErcoreExcel;
use Drupal\ercore_core\ErcoreSalary;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
    $spreadsheet = self::ercoreSalaryData(ErcoreExcel::getFile($file_path));
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

  /**
   * Process Salary Data.
   *
   * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
   *   Receives template for data to be added to.
   *
   * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
   *   Return spreadsheet with data.
   */
  public function ercoreSalaryData(Spreadsheet $spreadsheet) {
    $salary_data = ErcoreSalary::filterUserIds();
    $row = 7;
    foreach ($salary_data as $university => $participants) {
      $row_count = count($participants);
      $spreadsheet->getActiveSheet()->insertNewRowBefore($row + 1, $row_count + 1);
      foreach ($participants as $participant) {
        $data_row = [
          '0' => $participant['institution'],
          '1' => $participant['department'],
          '2' => $participant['name'],
        ];
        $spreadsheet->getActiveSheet()
          ->fromArray($data_row, NULL, 'A' . $row);
        $row++;
      }
      $spreadsheet->getActiveSheet()
        ->mergeCells('A' . $row . ':C' . $row)
        ->mergeCells('D' . $row . ':G' . $row)
        ->mergeCells('H' . $row . ':K' . $row)
        ->getStyle('A' . $row)->getAlignment()->setHorizontal('left');
      $spreadsheet->getActiveSheet()
        ->getStyle('A' . $row)->getFill()->setFillType('solid');
      $spreadsheet->getActiveSheet()
        ->getStyle('D' . $row)->getFill()->setFillType('solid');
      $spreadsheet->getActiveSheet()
        ->getStyle('H' . $row)->getFill()->setFillType('solid');
      $spreadsheet->getActiveSheet()
        ->getStyle('L' . $row)->getFill()->setFillType('solid');
      $spreadsheet->getActiveSheet()
        ->getStyle('A' . $row)->getFill()->getStartColor()->setARGB('D3D3D3');
      $spreadsheet->getActiveSheet()
        ->getStyle('D' . $row)->getFill()->getStartColor()->setARGB('D3D3D3');
      $spreadsheet->getActiveSheet()
        ->getStyle('H' . $row)->getFill()->getStartColor()->setARGB('D3D3D3');
      $spreadsheet->getActiveSheet()
        ->getStyle('L' . $row)->getFill()->getStartColor()->setARGB('D3D3D3');
      $spreadsheet->getActiveSheet()
        ->setCellValue('A' . ($row), 'Total for ' . $university);
      $row++;
    }
    $spreadsheet->getActiveSheet()
      ->removeRow($row)
      ->removeRow($row);
    return $spreadsheet;
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
