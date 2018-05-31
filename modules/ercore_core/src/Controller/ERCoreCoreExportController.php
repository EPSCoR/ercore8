<?php

namespace Drupal\ercore_core\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\ercore_core\ErcoreCollaborationBuild;
use Drupal\ercore_core\ErcoreExcel;
use Drupal\ercore_core\ErcoreOutputs;
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
    $spreadsheet->setActiveSheetIndexByName('C - Collaborations');
    $spreadsheet = self::ercoreCollaborationData($spreadsheet);
    $spreadsheet->setActiveSheetIndexByName('E - Outputs');
    $spreadsheet = self::ercoreOutputsData($spreadsheet);
// "D - External Engagement"
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
      $spreadsheet->getActiveSheet()
        ->insertNewRowBefore($row + 1, $row_count + 1);
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
            ->getStyle('J' . $row)
            ->getFill()
            ->getStartColor()
            ->setARGB('D3D3D3');
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
    $spreadsheet = self::ercoreCollaborationData(ErcoreExcel::getFile($file_path));
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

  /**
   * Process Collaboration Data - Table C.
   *
   * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
   *   Receives template for data to be added to.
   *
   * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
   *   Return spreadsheet with data.
   */
  public function ercoreCollaborationData(Spreadsheet $spreadsheet) {
    $table_rows = ErcoreCollaborationBuild::getData();
    $row = 5;
    foreach ($table_rows as $table_row) {
      $spreadsheet->getActiveSheet()
        ->setCellValue('B' . $row, $table_row->localInstitutions);
      $spreadsheet->getActiveSheet()
        ->setCellValue('C' . $row, $table_row->localCollaborators);
      $spreadsheet->getActiveSheet()
        ->setCellValue('D' . $row, $table_row->domesticInstitutions);
      $spreadsheet->getActiveSheet()
        ->setCellValue('E' . $row, $table_row->domesticCollaborators);
      $spreadsheet->getActiveSheet()
        ->setCellValue('F' . $row, $table_row->foreignInstitutions);
      $spreadsheet->getActiveSheet()
        ->setCellValue('G' . $row, $table_row->foreignCollaborators);
      $row++;
    }
    return $spreadsheet;
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
    $spreadsheet = self::ercoreOutputsData(ErcoreExcel::getFile($file_path));
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

  /**
   * Process Outputs Data - Table E.
   *
   * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
   *   Receives template for data to be added to.
   *
   * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
   *   Return spreadsheet with data.
   */
  public function ercoreOutputsData(Spreadsheet $spreadsheet) {
    $data = ErcoreOutputs::getData();
    // Patents.
    $spreadsheet->getActiveSheet()
      ->setCellValue('B4', $data['patents']['awarded']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D4', $data['patents']['awarded']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B5', $data['patents']['pending']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D5', $data['patents']['pending']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B6', $data['patents']['licensed']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D6', $data['patents']['licensed']['cumulative']);
    // Proposals.
    $spreadsheet->getActiveSheet()
      ->setCellValue('B8', $data['proposals']['submitted']['current']['number']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('C8', $data['proposals']['submitted']['current']['funds']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D8', $data['proposals']['submitted']['cumulative']['number']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('E8', $data['proposals']['submitted']['cumulative']['funds']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B9', $data['proposals']['awarded']['current']['number']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('C9', $data['proposals']['awarded']['current']['funds']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D9', $data['proposals']['awarded']['cumulative']['number']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('E9', $data['proposals']['awarded']['cumulative']['funds']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B10', $data['proposals']['pending']['current']['number']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('C10', $data['proposals']['pending']['current']['funds']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D10', $data['proposals']['pending']['cumulative']['number']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('E10', $data['proposals']['pending']['cumulative']['funds']);
    // Publications.
    $spreadsheet->getActiveSheet()
      ->setCellValue('B12', $data['publications']['primary']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D12', $data['publications']['primary']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B13', $data['publications']['partial']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D13', $data['publications']['partial']['cumulative']);
    // New Hires.
    $spreadsheet->getActiveSheet()
      ->setCellValue('B15', $data['new-hires']['male']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D15', $data['new-hires']['male']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B16', $data['new-hires']['female']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D16', $data['new-hires']['female']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B17', $data['new-hires']['minority']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D17', $data['new-hires']['minority']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B18', $data['new-hires']['disabled']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D18', $data['new-hires']['disabled']['cumulative']);
    // Post-Docs.
    $spreadsheet->getActiveSheet()
      ->setCellValue('B20', $data['post-doc']['male']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D20', $data['post-doc']['male']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B21', $data['post-doc']['female']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D21', $data['post-doc']['female']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B22', $data['post-doc']['minority']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D22', $data['post-doc']['minority']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B23', $data['post-doc']['disabled']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D23', $data['post-doc']['disabled']['cumulative']);
    // Graduate.
    $spreadsheet->getActiveSheet()
      ->setCellValue('B25', $data['graduate']['male']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D25', $data['graduate']['male']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B26', $data['graduate']['female']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D26', $data['graduate']['female']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B27', $data['graduate']['minority']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D27', $data['graduate']['minority']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B28', $data['graduate']['disabled']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D28', $data['graduate']['disabled']['cumulative']);
    // Undergraduate.
    $spreadsheet->getActiveSheet()
      ->setCellValue('B30', $data['undergraduate']['male']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D30', $data['undergraduate']['male']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B31', $data['undergraduate']['female']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D31', $data['undergraduate']['female']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B32', $data['undergraduate']['minority']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D32', $data['undergraduate']['minority']['cumulative']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('B33', $data['undergraduate']['disabled']['current']);
    $spreadsheet->getActiveSheet()
      ->setCellValue('D33', $data['undergraduate']['disabled']['cumulative']);
    return $spreadsheet;
  }

}
