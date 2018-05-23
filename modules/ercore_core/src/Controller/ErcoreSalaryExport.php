<?php

namespace Drupal\ercore_core\Controller;

use Drupal\ercore_core\ErcoreExcel;
use Drupal\ercore_core\ErcoreSalary;

/**
 * Export Salary data.
 */
class ErcoreSalaryExport {

  /**
   * Export Excel file for Salary Support.
   */
  public static function exportExcel() {
    $file_name = 'Salary-Support';
    $file_path = drupal_get_path('module', 'ercore_core') . '/files/Salary-Support.xls';
    $spreadsheet = ErcoreExcel::getFile($file_path);
    $sheet = $spreadsheet->getActiveSheet();
    // Modify stuff.
    ErcoreExcel::returnFile($file_name, $spreadsheet);
  }

  /**
   * Prepare data to be exported.
   */
  private static function prepareData() {
    $data = ErcoreSalary::filterUserIds();
  }

}
