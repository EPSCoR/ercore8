<?php
/**
 * @file
 * File for the ERCore Table C Download pages.
 */

require_once libraries_get_path('PHPExcel') . '/Classes/PHPExcel.php';
require_once drupal_get_path('module', 'ercore_core') . "/includes/ercore-admin-var.inc";
require_once drupal_get_path('module', 'ercore_core') . "/includes/classes/ercore-collaboration-data.inc";

/**
 * Excel export callback for collaboration data.
 *
 * @param string $date_range
 *   Hook_menu argument sent to Views.
 *
 * @throws \PHPExcel_Reader_Exception
 *   Error messages for PHPExcel errors.
 */
function ercore_table_c_download_callback($date_range) {
  if ($date_range == NULL) {
    $date_string = NULL;
  }
  else {
    $date_string = $date_range;
  }

  if (isset($date_string)) {
    $file_name = 'Content-Disposition: attachment;filename="' . 'Collaborations_' . $date_string . '.xls' . '"';
  }
  else {
    $file_name = 'Content-Disposition: attachment;filename="' . 'Collaborations.xls' . '"';
  }
  $objphpexcel = ercore_table_c_download_callback_data($date_range);

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
function ercore_table_c_download_callback_data(&$date_range, $sheet = 0) {
  if ($date_range == NULL) {
    $date_string = NULL;
  }
  else {
    $date_string = $date_range;
  }

  $title = 'C - Collaborations';
  $template_path = drupal_get_path('module', 'ercore_core') . "/excel-templates/collaborations-template.xls";

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

  $collection = ercore_table_c_data_build($date_string);
  ercore_table_c_cells($objphpexcel->getActiveSheet(), $collection, $row);

  return $objphpexcel;
}

/**
 * NSF Table C Data object build.
 *
 * @param string $date_string
 *   Date string from Table C Display.
 *
 * @return object mixed
 *   Data object form NSF Table C.
 */
function ercore_table_c_data_build(&$date_string) {
  $categories = array(
    'academic' => 'Academic Research Institutions',
    'undergrad' => 'Primarily Undergraduate Institutions',
    'black' => 'Historically Black Colleges and Universities',
    'hispanic' => 'Hispanic Serving Institutions',
    'tribal' => 'Tribal Colleges and Universities',
    'lab' => 'National Laboratories',
    'industry' => 'Industry',
    'none' => 'None/Other',
  );
  foreach ($categories as $key => $category) {
    $data = views_get_view_result('ercore_table_c_export', 'panel_pane_1', $key, $date_string);
    $new_object[$key] = new ErcoreCollaboration();
    $new_object[$key]->ercoreCollaborationBuild($new_object, $data);
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
function ercore_table_c_cells($worksheet, &$collection, &$row) {
  foreach ($collection as $collection_data) {
    $worksheet->setCellValue('B' . $row, $collection_data->withinInst);
    $worksheet->setCellValue('C' . $row, $collection_data->withinColl);
    $worksheet->setCellValue('D' . $row, $collection_data->extInst);
    $worksheet->setCellValue('E' . $row, $collection_data->extColl);
    $worksheet->setCellValue('F' . $row, $collection_data->forInst);
    $worksheet->setCellValue('G' . $row, $collection_data->forColl);
    $row++;
  }
}
