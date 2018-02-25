<?php

/**
 * @file
 * File for the ERCore Table D Download pages.
 */

module_load_include('inc', 'phpexcel');
require_once drupal_get_path('module', 'ercore_core') . "/includes/ercore-admin-var.inc";
require_once drupal_get_path('module', 'ercore_core') . "/includes/classes/ercore-engagement-data.inc";

/**
 * Excel export callback for engagement data.
 *
 * @param string $date_range
 *   Hook_menu argument sent to Views.
 *
 * @throws \PHPExcel_Reader_Exception
 *   Error messages for PHPExcel errors.
 */
function ercore_table_d_download_callback($date_range) {

  if (isset($date_range)) {
    $file_name = 'Content-Disposition: attachment;filename="' . 'External-Engagements_' . $date_range . '.xls' . '"';
  }
  else {
    $file_name = 'Content-Disposition: attachment;filename="' . 'External-Engagements.xls' . '"';
  }
  $objphpexcel = ercore_table_d_download_callback_data($date_range);

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
 * Excel export callback for engagement data.
 *
 * @param string $date_range
 *   Hook_menu argument sent to Views.
 
 * @returns
 *   Returns
 *
 * @throws \PHPExcel_Reader_Exception
 *   Error messages for PHPExcel errors.
 */
function ercore_table_d_download_callback_data(&$date_range, $sheet = 0) {

  $title = 'D - External Engagements';
  $template_path = drupal_get_path('module', 'ercore_core') . "/excel-templates/external-engagement-template.xls";

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
    ->setSubject("Office 2007 XLSX Document")
    ->setDescription("Exported data from $author")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Data export file");

  // Rename worksheet.
  $objphpexcel->getActiveSheet()
    ->setTitle($title);

  // Prep top add some data.
  $row = 5;

  // Add some data.
  $objphpexcel->setActiveSheetIndex($sheet);

  // Add some data.
  $worksheet = $objphpexcel->getActiveSheet();

  if ($date_range == '') {
    $date_range = NULL;
  }
  $collection = ercore_table_d_data_build($date_range);
  ercore_table_d_cells($objphpexcel->getActiveSheet(), $collection, $row);
  return $objphpexcel;
}

/**
 * Generates the NSF Table D data array for print.
 *
 * @param string $dates
 *    Receives date array from display for print data build.
 *
 * @return object mixed
 *    Table D build object.
 */
function ercore_table_d_data_build(&$dates) {
  $categories = array(
    'total' => 'Project Total',
    'male' => 'Male',
    'female' => 'Female',
    'urm' => 'Under-represented Minorities',
  );
  $data = views_get_view_result('ercore_table_d_export', 'panel_pane_1', $dates);
  foreach ($categories as $key => $category) {
    $new_object[$key] = new ErcoreEngagement();
    $new_object[$key]->type = $category;
    $new_object[$key]->ercoreEngagementBuild($new_object[$key], $data);
  }
  return $new_object;
}

/**
 * Data formatting for placement in Participant data export.
 *
 * @param array $worksheet
 *    Data array of Excel object.
 * @param array $collection
 *    Array of Object data.
 * @param int $row
 *    Integer for placing data in correct Excel row.
 */
function ercore_table_d_cells($worksheet, &$collection, &$row) {
  foreach ($collection as $collection_data) {
    $worksheet->setCellValue('B' . $row, $collection_data->ariFac);
    $worksheet->setCellValue('C' . $row, $collection_data->ariStu);
    $worksheet->setCellValue('D' . $row, $collection_data->uiFac);
    $worksheet->setCellValue('E' . $row, $collection_data->uiStu);
    $worksheet->setCellValue('F' . $row, $collection_data->msiFac);
    $worksheet->setCellValue('G' . $row, $collection_data->msiStu);
    $worksheet->setCellValue('H' . $row, $collection_data->k12T);
    $worksheet->setCellValue('I' . $row, $collection_data->k12Sd);
    $worksheet->setCellValue('J' . $row, $collection_data->k12St);
    $worksheet->setCellValue('K' . $row, $collection_data->other);
    $worksheet->setCellValue('L' . $row, $collection_data->total);
    $row++;
  }
}
