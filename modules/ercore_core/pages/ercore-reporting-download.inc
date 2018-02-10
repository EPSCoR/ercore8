<?php
/**
 * @file
 * File for the ERCore Reporting download page.
 */

require_once libraries_get_path('PHPExcel') . '/Classes/PHPExcel.php';
require_once drupal_get_path('module', 'ercore_admin') . '/includes/ercore-admin-var.inc';

/**
 * Excel export callback for output data.
 *
 * @param array $date_range
 *   Hook_menu argument sent to Views.
 *
 * @throws \PHPExcel_Reader_Exception
 *   Error messages for PHPExcel errors.
 */
function ercore_reporting_download_callback($date_range) {
  require_once drupal_get_path('module', 'ercore_admin') . '/pages/ercore-table-a-download.inc';
  require_once drupal_get_path('module', 'ercore_admin') . '/pages/ercore-table-b-download.inc';
  require_once drupal_get_path('module', 'ercore_admin') . '/pages/ercore-table-c-download.inc';
  require_once drupal_get_path('module', 'ercore_admin') . '/pages/ercore-table-d-download.inc';
  require_once drupal_get_path('module', 'ercore_admin') . '/pages/ercore-table-e-download.inc';

  if ($date_range != NULL) {
    $date_range = trim($date_range);
    $file_name = 'Content-Disposition: attachment;filename="' . 'reporting_' . $date_range . '.xls' . '"';
  }
  else {
    $file_name = 'Content-Disposition: attachment;filename="' . 'reporting.xls' . '"';
  }

  $objphpexcel = ercore_table_a_download_callback_data($date_range);

  $tables['b'] = ercore_table_b_download_callback_data($date_range);
  $tables['c'] = ercore_table_c_download_callback_data($date_range);
  $tables['d'] = ercore_table_d_download_callback_data($date_range);
  $tables['e'] = ercore_table_e_download_callback_data($date_range);

  // Copy worksheets from $objPHPExcel2 to $objPHPExcel1.
  foreach ($tables as $table) {
    foreach ($table->getAllSheets() as $sheet) {
      $objphpexcel->addExternalSheet($sheet);
    }
  }

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
