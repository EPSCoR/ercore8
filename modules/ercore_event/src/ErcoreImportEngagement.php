<?php

namespace Drupal\ercore_event;

use Drupal\file\Entity\File;
use Drupal\ercore_event\ErcoreEngagement;

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
    $rows = $this->parseFile($file_uri);
    $values = new ErcoreEngagement();
    foreach ($rows as $row) {
      $values->addEngagements($row);
    }
    $engagement[0]['subform'] = $this->setEngagementCounts($engagement[0]['subform'], $values);
    ksm($engagement);
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
    if (array_keys($data[0][0])[2] === 'External Engagement Reporting Sheet') {
      return array_slice($data[0], 12);
    }
  }

  /**
   * Save engagement entity.
   *
   * @param array $subform
   *   Engagement data to be saved.
   * @param \Drupal\ercore_event\ErcoreEngagement $values
   *   The values parsed from the excel file.
   *
   * @return array
   *   Return modified array.
   */
  private function setEngagementCounts(array $subform, ErcoreEngagement $values) {
    $subform['field_ercore_ee_ari_fac_f'][0]['value'] = $values->ariFacF;
    $subform['field_ercore_ee_ari_fac_m'][0]['value'] = $values->ariFacM;
    $subform['field_ercore_ee_ari_fac_mn'][0]['value'] = $values->ariFacMn;
    $subform['field_ercore_ee_ari_fac_u'][0]['value'] = $values->ariFacU;
    $subform['field_ercore_ee_ari_stu_f'][0]['value'] = $values->ariStuF;
    $subform['field_ercore_ee_ari_stu_m'][0]['value'] = $values->ariStuM;
    $subform['field_ercore_ee_ari_stu_mn'][0]['value'] = $values->ariStuMn;
    $subform['field_ercore_ee_ari_stu_u'][0]['value'] = $values->ariStuU;
    $subform['field_ercore_ee_pui_fac_f'][0]['value'] = $values->puiFacF;
    $subform['field_ercore_ee_pui_fac_m'][0]['value'] = $values->puiFacM;
    $subform['field_ercore_ee_pui_fac_mn'][0]['value'] = $values->puiFacMn;
    $subform['field_ercore_ee_pui_fac_u'][0]['value'] = $values->puiFacU;
    $subform['field_ercore_ee_pui_stu_f'][0]['value'] = $values->puiStuF;
    $subform['field_ercore_ee_pui_stu_m'][0]['value'] = $values->puiStuM;
    $subform['field_ercore_ee_pui_stu_mn'][0]['value'] = $values->puiStuMn;
    $subform['field_ercore_ee_pui_stu_u'][0]['value'] = $values->puiStuU;
    $subform['field_ercore_ee_msi_fac_f'][0]['value'] = $values->msiFacF;
    $subform['field_ercore_ee_msi_fac_m'][0]['value'] = $values->msiFacM;
    $subform['field_ercore_ee_msi_fac_mn'][0]['value'] = $values->msiFacMn;
    $subform['field_ercore_ee_msi_fac_u'][0]['value'] = $values->msiFacU;
    $subform['field_ercore_ee_msi_stu_f'][0]['value'] = $values->msiStuF;
    $subform['field_ercore_ee_msi_stu_m'][0]['value'] = $values->msiStuM;
    $subform['field_ercore_ee_msi_stu_mn'][0]['value'] = $values->msiStuMn;
    $subform['field_ercore_ee_msi_stu_u'][0]['value'] = $values->msiStuU;
    $subform['field_ercore_ee_other_f'][0]['value'] = $values->otherF;
    $subform['field_ercore_ee_other_m'][0]['value'] = $values->otherM;
    $subform['field_ercore_ee_other_mn'][0]['value'] = $values->otherMn;
    $subform['field_ercore_ee_other_u'][0]['value'] = $values->otherU;
    $subform['field_ercore_ee_k12_dir_f'][0]['value'] = $values->k12DirF;
    $subform['field_ercore_ee_k12_dir_m'][0]['value'] = $values->k12DirM;
    $subform['field_ercore_ee_k12_dir_mn'][0]['value'] = $values->k12DirMn;
    $subform['field_ercore_ee_k12_dir_u'][0]['value'] = $values->k12DirU;
    $subform['field_ercore_ee_k12_tch_f'][0]['value'] = $values->k12TchF;
    $subform['field_ercore_ee_k12_tch_m'][0]['value'] = $values->k12TchM;
    $subform['field_ercore_ee_k12_tch_mn'][0]['value'] = $values->k12TchMn;
    $subform['field_ercore_ee_k12_tch_u'][0]['value'] = $values->k12TchU;
    $subform['field_ercore_ee_k12_ttr_f'][0]['value'] = $values->k12TtrF;
    $subform['field_ercore_ee_k12_ttr_m,'][0]['value'] = $values->k12TtrM;
    $subform['field_ercore_ee_k12_ttr_mn'][0]['value'] = $values->k12TtrMn;
    $subform['field_ercore_ee_k12_ttr_u'][0]['value'] = $values->k12TtrU;
    return $subform;
  }

}
