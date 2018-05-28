<?php

namespace Drupal\ercore_core\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\ercore_core\ErcoreExcel;
use Drupal\ercore_core\ErcoreParticipantBuild;
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
    $spreadsheet->setActiveSheetIndexByName('A - Salary Support');
    $spreadsheet = self::ercoreSalaryData($spreadsheet);
    $spreadsheet->setActiveSheetIndexByName('B - Participants');
    $spreadsheet = self::ercoreParticipantData($spreadsheet);
    /*"
string(18) "C - Collaborations"
string(23) "D - External Engagement"
string(11) "E - Outputs"
string(16) "F - Expenditures"
string(16) "G - Cost sharing"
string(21) "H - Leveraged Support"*/
    // Modify stuff.
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

  /**
   * ERCore Collaborations - Table A.
   */
  public function ercoreSalaryExport() {
    $file_name = 'Salary-Support';
    $file_path = drupal_get_path('module', 'ercore_core') . '/files/Salary-Support.xls';
    $spreadsheet = self::ercoreSalaryData(ErcoreExcel::getFile($file_path));
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

  /**
   * Process Salary Data - Table A.
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
        ->setCellValue('A' . $row, 'Total for ' . $university);
      $row++;
    }
    $spreadsheet->getActiveSheet()
      ->removeRow($row)
      ->removeRow($row);
    return $spreadsheet;
  }

  /**
   * ERCore Participants - Table B.
   */
  public function ercoreParticipantExport() {
    $file_name = 'Participants';
    $file_path = drupal_get_path('module', 'ercore_core') . '/files/Participants.xls';
    $spreadsheet = ErcoreExcel::getFile($file_path);
    $spreadsheet = self::ercoreParticipantData(ErcoreExcel::getFile($file_path));
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

  /**
   * Process Participant Data - Table B.
   *
   * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
   *   Receives template for data to be added to.
   *
   * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
   *   Return spreadsheet with data.
   */
  public function ercoreParticipantData(Spreadsheet $spreadsheet) {
    $institutions = ErcoreParticipantBuild::getData();
    $row = 4;
    $row_count = count($institutions) * 7;
    $spreadsheet->getActiveSheet()->insertNewRowBefore($row + 1, $row_count);
    foreach ($institutions as $institution) {
      $spreadsheet->getActiveSheet()
        ->mergeCells('A' . $row . ':A' . ($row + 6));
      $spreadsheet->getActiveSheet()
        ->setCellValue('A' . $row, $institution['name']);
      foreach ($institution['data'] as $type) {
        $spreadsheet->getActiveSheet()
          ->setCellValue('B' . $row, $type->name);
        $spreadsheet->getActiveSheet()
          ->setCellValue('C' . $row, $type->total);
        $spreadsheet->getActiveSheet()
          ->setCellValue('D' . $row, $type->male);
        $spreadsheet->getActiveSheet()
          ->setCellValue('E' . $row, $type->female);
        $spreadsheet->getActiveSheet()
          ->setCellValue('F' . $row, $type->black);
        $spreadsheet->getActiveSheet()
          ->setCellValue('G' . $row, $type->hispanic);
        $spreadsheet->getActiveSheet()
          ->setCellValue('H' . $row, $type->other);
        $spreadsheet->getActiveSheet()
          ->setCellValue('I' . $row, $type->disabled);
        $roles = ErcoreParticipantBuild::ercoreNoNewValues();
        if (!in_array($type->name, $roles)) {
          $spreadsheet->getActiveSheet()
            ->setCellValue('J' . $row, $type->new);
        }
        else {
          $spreadsheet->getActiveSheet()
            ->setCellValue('J' . $row, 'n/a');
          $spreadsheet->getActiveSheet()
            ->getStyle('J' . $row)->getFill()->setFillType('solid');
          $spreadsheet->getActiveSheet()
            ->getStyle('J' . $row)->getFill()->getStartColor()->setARGB('D3D3D3');
        }
        $row++;
      }
    }
    $spreadsheet->getActiveSheet()
      ->removeRow($row)
      ->removeRow($row);
    $advisory = ['0', '0', '0', '0', '0', '0', '0', '0'];
    $spreadsheet->getActiveSheet()->fromArray($advisory, NULL, 'C' . $row);
    return $spreadsheet;
  }

  /**
   * ERCore Collaborations - Table C.
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
   * ERCore Engagements - Table D.
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
   * ERCore Outputs - Table E.
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
