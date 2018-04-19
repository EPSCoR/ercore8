<?php

namespace Drupal\ercore_event;

use Drupal\file\Entity\File;

/**
 * Class ErcoreImportEngagement.
 */
class ErcoreImportEngagement {

  /**
   * Constructor.
   */
  public function __construct() {
  }

  /**
   * Receives and updates engagement.
   *
   * @param array $engagement
   *   Receives engagement to update.
   */
  public function processEngagement(array $engagement) {
    $fid = NULL;
    $pid = NULL;
    if (isset($engagement[0]['target_id'])) {
      $pid = $engagement[0]['target_id'];
    }
    if (!isset($engagement[0]['subform']['field_ercore_ee_excel'])) {
      return;
    }
    $fid = $engagement[0]['subform']['field_ercore_ee_excel'][0]['fids'][0];
    $file_uri = File::load($fid)->getFileUri();
    $data = parseFile($file_uri);
    ksm($data);
  }

  /**
   * Uses PHPExcel to parse .xls file.
   *
   * @param int $file_uri
   *   Field Collection item object to access files and fields.
   *
   * @return array
   *   Returns data array from Excel file.
   */
  private function parseFile($file_uri) {
    module_load_include('inc', 'phpexcel');
    $data = phpexcel_import($file_uri);
    return $data;
   // ksm($data);
 /*   $obj_reader = PHPExcel_IOFactory::createReader('Excel5');
    $obj_php_excel = $obj_reader->load($path);
    $worksheet = $obj_php_excel->getActiveSheet();

    // Makes sure that it's the expected excel sheet.
    if ($worksheet->getCellByColumnAndRow(2, 1)
        ->getValue() != "External Engagement Reporting Sheet"
    ) {
      return;
    }
    $instcodes = array('1' => 'ari', '2' => 'pui', '3' => 'msi', '4' => 'k12i');
    $personcodes1 = array(
      '1' => 'tec',
      '2' => 'stud',
      '3' => 'tec',
    );
    $personcodes2 = array(
      '1' => 'fac',
      '2' => 'stu',
      '3' => 'fac',
    );
    $gendercodes = array('m' => 'm', 'f' => 'f', '' => 'u');
    $minoritycodes = array('y' => 'mn');

    // Clear out all of the values in preparation for new values.
    foreach (array(
               'ari_fac',
               'ari_stu',
               'pui_fac',
               'pui_stu',
               'msi_fac',
               'msi_stu',
               'k12i_tec',
               'k12i_stud',
               'k12i_stut',
               'oth',
             ) as $prefix) {
      foreach (array("t", "m", "f", "u", "mn") as $attr) {
        $field_collection_item->{"field_ercore_ee_{$prefix}_{$attr}"}['und'][0]['value'] = 0;
      }
    }

    $highestrow = $worksheet->getHighestRow();
    // Last filled out row of the template...
    for ($y = 14; $y <= $highestrow; $y++) {
      // 14 is the start of the data row; get() function is defined below.
      $name = $worksheet->getCellByColumnAndRow(1, $y)->getValue();
      $inst_code = $worksheet->getCellByColumnAndRow(2, $y)->getValue();
      $inst = _ercore_get($instcodes, $inst_code);
      $personcodes = $inst == 'k12i' ? $personcodes1 : $personcodes2;
      $person_code = $worksheet->getCellByColumnAndRow(3, $y)->getValue();
      $person = _ercore_get($personcodes, $person_code);
      $gender = _ercore_get($gendercodes, strtolower($worksheet->getCellByColumnAndRow(4, $y)
        ->getValue()));
      $minority = _ercore_get($minoritycodes, strtolower($worksheet->getCellByColumnAndRow(5, $y)
        ->getValue()));
      $paid = strtolower($worksheet->getCellByColumnAndRow(6, $y)
        ->getValue());
      // Has no bearing on this form.
      if (!$name && !$inst_code && !$person_code && !$minority) {
        // If the information dries up, just assume this is the end of the list.
        break;
      }

      // We can't count paid participants...
      if (substr($paid, 0, 1) != 'y') {
        // Someone might put in "yes" and not just "y"...
        if (!$person || !$inst) {
          $col = "oth";
        }
        else {
          $col = $inst . '_' . $person;
        }

        if ($gender) {
          $field_collection_item->{"field_ercore_ee_{$col}_{$gender}"}['und'][0]['value']++;
        }
        else {
          $field_collection_item->{"field_ercore_ee_{$col}_u"}['und'][0]['value']++;
        }
        if ($minority) {
          $field_collection_item->{"field_ercore_ee_{$col}_mn"}['und'][0]['value']++;
        }
      }
    }
    $vars = $file->filename;

    watchdog('ercore', $vars, WATCHDOG_INFO);
    drupal_set_message(t('The attachment was processed and the External
    Engagements have been filled out. Please verify that the counts are
    correct.'));*/
  }

}
