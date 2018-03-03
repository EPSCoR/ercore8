<?php

/**
 * @file
 * File for the ERCore Table A Download pages.
 */

use Drupal\ercore\ercoreStartDate;

module_load_include('inc', 'phpexcel');

/**
 * Excel export callback for output data.
 *
 * @param string $date_range
 *   Hook_menu argument sent to Views.
 *
 * @throws \PHPExcel_Reader_Exception
 *   Error messages for PHPExcel errors.
 */
function ercore_table_a_download_callback($date_range) {
  if ($date_range == '' || $date_range == NULL) {
    $passing_value = NULL;
  }
  else {
    $passing_value = $date_range;
  }
  $date_string = $passing_value;
  if ($date_range != NULL) {
    $file_name = 'Content-Disposition: attachment;filename="' . 'salary-support_' . $date_string . '.xls' . '"';
  }
  else {
    $file_name = 'Content-Disposition: attachment;filename="' . 'salary-support.xls' . '"';
  }

  $objphpexcel = ercore_table_a_download_callback_data($date_range);
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
function ercore_table_a_download_callback_data(&$date_range, $sheet = 0) {

  if ($date_range == '' || $date_range == NULL) {
    $passing_value = NULL;
  }
  else {
    $passing_value = $date_range;
  }
  $date_string = $passing_value;

  $title = 'A - Salary Support';
  $template_path = drupal_get_path('module', 'ercore_core') . "/excel-templates/salary-support-template.xls";

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

  // Add some data.
  $objphpexcel->setActiveSheetIndex($sheet);

  // Add some data.
  $worksheet = $objphpexcel->getActiveSheet();

  return $objphpexcel;
}
