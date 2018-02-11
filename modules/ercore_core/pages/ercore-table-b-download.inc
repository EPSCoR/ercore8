<?php
/**
 * @file
 * File for the ERCore Table B Downloads pages.
 */

require_once libraries_get_path('PHPExcel') . '/Classes/PHPExcel.php';
require_once drupal_get_path('module', 'ercore_admin') . '/includes/classes/ercore-participant-grouping.inc';
require_once drupal_get_path('module', 'ercore_admin') . '/includes/ercore-admin-var.inc';
/**
 * Excel export callback for participant data.
 *
 * @param string $date_range
 *   Hook_menu argument sent to Views.
 *
 * @throws \PHPExcel_Reader_Exception
 *   Error messages for PHPExcel errors.
 */
function ercore_table_b_download_callback($date_range) {
  if ($date_range == NULL) {
    $date_string = NULL;
  }
  else {
    $date_string = $date_range;
  }
  if (isset($date_string)) {
    $file_name = 'Content-Disposition: attachment;filename="' . 'Participants_' . $date_string . '.xls' . '"';
  }
  else {
    $file_name = 'Content-Disposition: attachment;filename="' . 'Participants.xls' . '"';
  }
  $objphpexcel = ercore_table_b_download_callback_data($date_range);

  // Redirect output to a client’s web browser (Excel5).
  header('Content-Type: application/vnd.ms-excel');
  header($file_name);
  header('Cache-Control: max-age=0');
  // If you're serving to IE 9, then the following may be needed.
  header('Cache-Control: max-age=1');

  // If you're serving to IE over SSL, then the following may be needed.
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  // Date in the past.
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
  // Always modified.
  header('Cache-Control: cache, must-revalidate');
  // HTTP/1.1.
  header('Pragma: public');
  // HTTP/1.0.
  $objwriter = PHPExcel_IOFactory::createWriter($objphpexcel, 'Excel5');
  $objwriter->save('php://output');
  exit;

}

/**
 * Excel export callback for output data.
 *
 * @param string $date_range
 *   Hook_menu argument sent to Views.
 * @param int $sheet
 *   Excel sheet for importing to different pages of external file.
 *
 * @return \PHPExcel Error messages for PHPExcel errors.
 *   Error messages for PHPExcel errors.
 *
 * @throws \PHPExcel_Exception
 *   Error messages for PHPExcel errors.
 */
function ercore_table_b_download_callback_data(&$date_range, $sheet = 0) {
  if ($date_range == NULL) {
    $date_string = NULL;
  }
  else {
    $date_string = $date_range;
  }

  $title = 'B - Participants';
  $template_path = drupal_get_path('module', 'ercore_admin') . "/excel-templates/participants-template.xls";

  // Error reporting.
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  $time_zone = \Drupal::config('system.date')->get('timezone.default');
  date_default_timezone_set("$time_zone");

  if (PHP_SAPI == 'cli') {
    die('This example should only be run from a Web Browser');
  }

  // Create new PHPExcel object.
  $objphpexcel = new PHPExcel();

  $author = \Drupal::config('system.site')->get('name');

  $objreader = PHPExcel_IOFactory::createReader('Excel5');
  if (isset($template_path)) {
    $objphpexcel = $objreader->load($template_path);
  }
  // Set document properties.
  $objphpexcel->getProperties()->setCreator("$author")
    ->setLastModifiedBy("$author")
    ->setTitle("Office 2007 XLSX $title export")
    ->setSubject("Office 2007 XLst Document")
    ->setDescription("Exported data from $author")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Data export file");

  // Rename worksheet.
  $objphpexcel->getActiveSheet()
    ->setTitle($title);

  // Prep top add some data.
  $base_row = 4;
  $base_row_plus = $base_row + 1;
  $row = $base_row;

  // Get Instituion Data.
  $data = views_get_view_result('ercore_export_table_b_institutions', 'panel_pane_1');
  $rii = new stdClass();
  $rii->node_title = 'RII Totals';
  $rii->nid = 'all';
  $data[] = $rii;

  $num_institutions = count($data);
  $rows_to_add = ($num_institutions * 7) - 2;

  // Add some data.
  $objphpexcel->setActiveSheetIndex($sheet);

  // Set correct row and cell count.
  $objphpexcel->getActiveSheet()
    ->insertNewRowBefore($base_row_plus, $rows_to_add);

  // Add some data.
  foreach ($data as $institution) {
    $nid = $institution->nid;

    $worksheet = $objphpexcel->getActiveSheet();

    $label = $institution->node_title;

    $worksheet->setCellValue('A' . $row, $label);
    // This merges the institution title cells on the left (may be unnecessary):
    $bottom_row = ($row + 6);

    $worksheet->mergeCells('A' . $row . ':A' . $bottom_row);

    $merge_cells_first = 'J' . ($row + 1) . ':J' . ($row + 2);
    $worksheet->getStyle($merge_cells_first)->applyFromArray(array(
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '808080'),
      ),
    ));
    $worksheet->mergeCells($merge_cells_first);

    $merge_cells_second = 'J' . ($row + 4) . ':J' . ($row + 5);
    $worksheet->getStyle($merge_cells_second)->applyFromArray(array(
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '808080'),
      ),
    ));
    $worksheet->mergeCells($merge_cells_second);
    if ($date_string != NULL) {
      $date_array = ercore_admin_date_argument_to_array($date_string);
    }
    else {
      $date_array = NULL;
    }
    // Include to allow access to ercore_table_b_data.
    include_once drupal_get_path('module', 'ercore_admin') . '/pages/ercore-table-b.inc';
    $collection = ercore_table_b_data($nid, $date_array);
    ercore_fill_cells($objphpexcel->getActiveSheet(), $collection, $row);
  }

  return $objphpexcel;

}

/**
 * Data formatting for placement in Participant data export.
 *
 * @param array $worksheet
 *    Data array of Excel object.
 * @param object $collection
 *    Data Object form data entry.
 * @param int $row
 *    Integer for placing data in correct Excel row.
 */
function ercore_fill_cells($worksheet, &$collection, &$row) {
  $non_displayed_values = ErcoreParticipantGroup::ercoreNoNewValues();

  foreach ($collection as $collection_data) {

    $worksheet->setCellValue('B' . $row, $collection_data->name);
    $worksheet->setCellValue('C' . $row, $collection_data->total);
    $worksheet->setCellValue('D' . $row, $collection_data->male);
    $worksheet->setCellValue('E' . $row, $collection_data->female);
    $worksheet->setCellValue('F' . $row, $collection_data->black);
    $worksheet->setCellValue('G' . $row, $collection_data->hispanic);
    $worksheet->setCellValue('H' . $row, $collection_data->other);
    $worksheet->setCellValue('I' . $row, $collection_data->disabled);

    if (!in_array($collection_data->name, $non_displayed_values)) {
      $worksheet->setCellValue('J' . $row, $collection_data->new);
    }
    $row++;
  }
}
