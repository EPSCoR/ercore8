<?php

namespace Drupal\ercore_core;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Processing files for ERCore.
 */
class ErcoreExcel {

  /**
   * Creating the basic file.
   */
  public function index() {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Hello World !');
    $writer = new Xlsx($spreadsheet);
    $writer->save('hello-world.xlsx');
  }

  /**
   * Load file and returns spreadsheet.
   *
   * @param string $file_name
   *   Supplied file path to read.
   *
   * @return \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
   *   The source worksheet.
   */
  public function loadFile($file_name) {
   // $file_path = self::getFilePath($file_name);
   // $type = IOFactory::identify($file_path);
    /** @var \PhpOffice\PhpSpreadsheet\Reader\BaseReader $reader */
 //   $reader = IOFactory::createReader($type);
    /** @var \PhpOffice\PhpSpreadsheet\Spreadsheet $workbook */
  //  $workbook = $reader->load($file_path);
  //  return $workbook->getSheet(0);
  }

  /**
   * Gets file name and returns path.
   *
   * @param string $file_name
   *   Receives file path.
   *
   * @return string
   *   Returns full file path.
   */
  public function getFilePath($file_name) {
   // return drupal_get_path('module', 'ercore_core') . '/files/' . $file_name;
  }

}
