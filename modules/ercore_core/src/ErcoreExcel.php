<?php

namespace Drupal\ercore_core;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Processing files for ERCore.
 */
class ErcoreExcel {

  /**
   * Creating the basic file.
   *
   * @param string $file_path
   *   File path to import.
   *
   * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
   *   Returns loaded file.
   */
  public static function getFile($file_path) {
    $type = IOFactory::identify($file_path);
    /** @var \PhpOffice\PhpSpreadsheet\Reader\BaseReader $reader */
    $reader = IOFactory::createReader($type);
    return $reader->load($file_path);
  }

  /**
   * Returns file for download.
   *
   * @param string $file_name
   *   File name to export.
   * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
   *   Spreadsheet to be downloaded.
   */
  public static function returnFile($file_name, Spreadsheet $spreadsheet) {
    $author = \Drupal::currentUser()->getDisplayName();
    $description = $file_name . ' Data Export - EPSCoR';
    $keywords = 'EPSCoR export ' . $file_name;
    $spreadsheet->getProperties()
      ->setCreator($author)
      ->setLastModifiedBy($author)
      ->setTitle($file_name)
      ->setDescription($description)
      ->setKeywords($keywords);
    $file_name = $file_name . '_' . self::dateArguments();
    $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
    $header = 'Content-Disposition: attachment; filename="' . $file_name . '.xls"';
    header('Content-Type: application/vnd.ms-excel');
    header($header);
    $writer->save("php://output");
  }

  /**
   * Generated date argument for file name.
   *
   * @return string
   *   Return argument string to append to file name.
   */
  public static function dateArguments() {
    $dates = ercore_get_filter_dates();
    return DrupalDateTime::createFromFormat('U', $dates['start'])->format('Ymd') . '-' . DrupalDateTime::createFromFormat('U', $dates['end'])->format('Ymd');
  }

}
