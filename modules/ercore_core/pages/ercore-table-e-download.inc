<?php

/**
 * @file
 * File for the ERCore Table E Download pages.
 */

use Drupal\ercore\ercoreStartDate;

module_load_include('inc', 'phpexcel');
require_once drupal_get_path('module', 'ercore_core') . "/includes/classes/ercore-outputs-data.inc";

/**
 * Excel export callback for output data.
 *
 * @param string $date_range
 *   Hook_menu argument sent to Views.
 *
 * @throws \PHPExcel_Reader_Exception
 *   Error messages for PHPExcel errors.
 */
function ercore_table_e_download_callback($date_range) {
  $default_array = ercore_admin_view_start_end_dates();
  $default_range = ercore_admin_download_path($default_array);

  $passing_value = $date_range;
  if ($date_range == NULL) {
    $date_range = $passing_value;
  }
  $date_string = $passing_value;

  $date_array = ercore_admin_date_argument_to_array($passing_value);

  if ($default_range != $date_range) {
    $file_name = 'Content-Disposition: attachment;filename="' . 'Outputs_' . $date_string . '.xls' . '"';
  }
  else {
    $file_name = 'Content-Disposition: attachment;filename="' . 'Outputs.xls' . '"';
  }
  $objphpexcel = ercore_table_e_download_callback_data($date_range);

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
function ercore_table_e_download_callback_data(&$date_range, $sheet = 0) {
  $default_array = ercore_admin_view_start_end_dates();
  $default_range = ercore_admin_download_path($default_array);

  $passing_value = $default_range;

  if ($date_range == NULL) {
    $date_range = $passing_value;
  }
  $passing_string = $date_range;

  $date_array = ercore_admin_date_argument_to_array($passing_string);
  $title = 'E - Outputs';
  $template_path = drupal_get_path('module', 'ercore_core') . "/excel-templates/outputs-template.xls";

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

  // Patent Data.
  $row = 4;
  $section = 'patent';
  $patent_collection = ercore_table_e_data_patent_build($date_array);
  ercore_table_e_cells($objphpexcel->getActiveSheet(), $patent_collection, $section, $row);

  // Proposal Data.
  $row = 8;
  $section = 'proposal';
  $proposal_collection = ercore_table_e_data_proposal_build($date_array);
  ercore_table_e_cells($objphpexcel->getActiveSheet(), $proposal_collection, $section, $row);

  // Publication Data.
  $row = 12;
  $section = 'publication';
  $publication_collection = ercore_table_e_data_publication_build($date_array);
  ercore_table_e_cells($objphpexcel->getActiveSheet(), $publication_collection, $section, $row);

  // New Hire Data.
  $row = 15;
  $section = 'new-hire';
  $new_hire_collection = ercore_table_e_data_participant_build($date_array, $section);
  ercore_table_e_cells($objphpexcel->getActiveSheet(), $new_hire_collection, $section, $row);

  // Post Doc Data.
  $row = 20;
  $section = 'post-doc';
  $postdoc_collection = ercore_table_e_data_participant_build($date_array, $section);
  ercore_table_e_cells($objphpexcel->getActiveSheet(), $postdoc_collection, $section, $row);

  // Graduate Data.
  $row = 25;
  $section = 'graduate';
  $grad_collection = ercore_table_e_data_participant_build($date_array, $section);
  ercore_table_e_cells($objphpexcel->getActiveSheet(), $grad_collection, $section, $row);

  // Under-granduate Data.
  $row = 30;
  $section = 'under-graduate';
  $undergrad_collection = ercore_table_e_data_participant_build($date_array, $section);
  ercore_table_e_cells($objphpexcel->getActiveSheet(), $undergrad_collection, $section, $row);

  return $objphpexcel;

}

/**
 * Returns patent data array for Excel document.
 *
 * @param array $date_array
 *    Dates of selected range.
 *
 * @return object $new_object
 *    Returns ercore_outputs object for Excel.
 */
function ercore_table_e_data_patent_build(&$date_array) {
  // Default Date Range.
  $default_build_date = ercore_admin_view_start_end_dates();
  // Date String.
  $date_for_view = ercore_admin_download_path($default_build_date);
  // Unix Date Array.
  $date_for_object = $date_array;
  // Array of Views Displays.
  $types = array(
    'panel_pane_2' => 'Awarded',
    'panel_pane_1' => 'Pending',
    'panel_pane_3' => 'Licensed',
  );

  foreach ($types as $display => $type) {

    $data = views_get_view_result('ercore_table_e_patents', $display, $date_for_view);

    $patent_object[$type] = new ErcoreOutputs();
    $patent_object[$type]->type = 'Patent';
    $patent_object[$type]->subType = $type;
    $patent_object[$type]->ercoreOutputsBuild($patent_object[$type], $data, $date_for_object);
  }
  return $patent_object;
}

/**
 * Returns proposal data array for Excel document.
 *
 * @param array $date_array
 *    Dates of selected range.
 *
 * @return object $new_object
 *    Returns ercore_outputs object for Excel.
 */
function ercore_table_e_data_proposal_build(&$date_array) {
  $default_build_date = ercore_admin_view_start_end_dates();
  // Date String.
  $date_for_view = ercore_admin_download_path($default_build_date);
  // Unix Date Array.
  $date_for_object = $date_array;
  // Array of Views Displays.
  $types = array(
    'panel_pane_1' => 'Submitted',
    'panel_pane_4' => 'Awarded',
    'panel_pane_2' => 'Pending',
  );

  foreach ($types as $display => $type) {

    $data = views_get_view_result('ercore_table_e_proposals', $display, $date_for_view);
    $proposal_object[$type] = new ErcoreOutputs();
    $proposal_object[$type]->type = 'Proposal';
    $proposal_object[$type]->subType = $type;
    $proposal_object[$type]->ercoreOutputsBuild($proposal_object[$type], $data, $date_for_object);
  }
  return $proposal_object;
}

/**
 * Returns publication data array for Excel document.
 *
 * @param array $date_array
 *    Dates of selected range.
 *
 * @return object $new_object
 *    Returns ercore_outputs object for Excel.
 */
function ercore_table_e_data_publication_build(&$date_array) {
  $default_build_date = ercore_admin_view_start_end_dates();
  // Date String.
  $date_for_view = ercore_admin_download_path($default_build_date);
  // Unix Date Array.
  $date_for_object = $date_array;

  $data = views_get_view_result('ercore_table_e_publications', 'panel_pane_1', $date_for_view);

  $types = array(
    'primary' => 'Primary',
    'partial' => 'Partial',
  );
  foreach ($types as $key => $type) {
    $publication_object[$type] = new ErcoreOutputs();
    $publication_object[$type]->type = 'Publication';
    $publication_object[$type]->subType = $type;
    $publication_object[$type]->ercoreOutputsBuild($publication_object[$type], $data, $date_for_object);
  }
  return $publication_object;
}

/**
 * Returns Participant data arrays for Excel document.
 *
 * @param array $date_array
 *    Dates of selected range.
 * @param string $section
 *    Section Variable to set values for processing.
 *
 * @return object $participant_object
 *    Returns ercore_outputs object for Excel.
 */
function ercore_table_e_data_participant_build(&$date_array, &$section) {
  if ($section == 'new-hire') {
    $view_display = 'panel_pane_1';
  }
  elseif ($section == 'post-doc') {
    $view_display = 'panel_pane_2';
  }
  elseif ($section == 'graduate') {
    $view_display = 'panel_pane_3';
  }
  else {
    $view_display = 'panel_pane_4';
  }
  $default_build_date = ercore_admin_view_start_end_dates();
  // Date String.
  $date_for_view = ercore_admin_download_path($default_build_date);
  // Unix Date Array.
  $date_for_object = $date_array;
  // Array of Views Displays.
  $types = array(
    'male' => 'Male',
    'female' => 'Female',
    'urm' => 'Under-represented minority',
    'disabled' => 'Disabled',
  );
  $data = views_get_view_result('ercore_table_e_users', $view_display, $date_for_view);
  foreach ($types as $key => $type) {
    $participant_object[$type] = new ErcoreOutputs();
    $participant_object[$type]->type = $section;
    $participant_object[$type]->subType = $type;
    $participant_object[$type]->ercoreOutputsBuild($participant_object[$type], $data, $date_for_object);
  }
  return $participant_object;
}

/**
 * Data formatting for placement in Participant data export.
 *
 * @param array $worksheet
 *    Data array of Excel object.
 * @param array $collection
 *    Array of Object data.
 * @param string $section
 *    String variable identifying section for different processing.
 * @param int $row
 *    Integer for placing data in correct Excel row.
 */
function ercore_table_e_cells($worksheet, &$collection, &$section, &$row) {
  foreach ($collection as $collection_data) {
    if ($section == 'proposal') {
      $worksheet->setCellValue('B' . $row, $collection_data->value1);
      $worksheet->setCellValue('C' . $row, $collection_data->value2);
      $worksheet->setCellValue('D' . $row, $collection_data->value3);
      $worksheet->setCellValue('E' . $row, $collection_data->value4);
    }
    else {
      $worksheet->setCellValue('B' . $row, $collection_data->value1);
      $worksheet->setCellValue('D' . $row, $collection_data->value2);
    }
    $row++;
  }
}
