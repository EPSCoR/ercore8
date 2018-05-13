<?php

namespace Drupal\ercore_event;

use Drupal\file\Entity\File;
use Drupal\paragraphs\Entity\Paragraph;

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
      if (!isset($engagement[0]['subform']['field_ercore_ee_excel'])) {
        return;
      }
      $paragraph = Paragraph::load($pid);
      $fid = $engagement[0]['subform']['field_ercore_ee_excel'][0]['fids'][0];
      $file_uri = File::load($fid)->getFileUri();
      $rows = $this->parseFile($file_uri);
      $values = new ErcoreEngagement();
      foreach ($rows as $row) {
        $values->addEngagements($row);
      }
      $this->setEngagementCounts($paragraph, $values);
    }
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
   * @param \Drupal\paragraphs\Entity\Paragraph $paragraph
   *   The values parsed from the excel file.
   * @param \Drupal\ercore_event\ErcoreEngagement $values
   *   Engagement data to be saved.
   */
  private function setEngagementCounts(Paragraph $paragraph, ErcoreEngagement $values) {
    $paragraph->set('field_ercore_ee_disable_file_alt', '1');
    $paragraph->set('field_ercore_ee_ari_fac_f', $values->ariFacF);
    $paragraph->set('field_ercore_ee_ari_fac_m', $values->ariFacM);
    $paragraph->set('field_ercore_ee_ari_fac_mn', $values->ariFacMn);
    $paragraph->set('field_ercore_ee_ari_fac_u', $values->ariFacU);
    $paragraph->set('field_ercore_ee_ari_stu_f', $values->ariStuF);
    $paragraph->set('field_ercore_ee_ari_stu_m', $values->ariStuM);
    $paragraph->set('field_ercore_ee_ari_stu_mn', $values->ariStuMn);
    $paragraph->set('field_ercore_ee_ari_stu_u', $values->ariStuU);
    $paragraph->set('field_ercore_ee_pui_fac_f', $values->puiFacF);
    $paragraph->set('field_ercore_ee_pui_fac_m', $values->puiFacM);
    $paragraph->set('field_ercore_ee_pui_fac_mn', $values->puiFacMn);
    $paragraph->set('field_ercore_ee_pui_fac_u', $values->puiFacU);
    $paragraph->set('field_ercore_ee_pui_stu_f', $values->puiStuF);
    $paragraph->set('field_ercore_ee_pui_stu_m', $values->puiStuM);
    $paragraph->set('field_ercore_ee_pui_stu_mn', $values->puiStuMn);
    $paragraph->set('field_ercore_ee_pui_stu_u', $values->puiStuU);
    $paragraph->set('field_ercore_ee_msi_fac_f', $values->msiFacF);
    $paragraph->set('field_ercore_ee_msi_fac_m', $values->msiFacM);
    $paragraph->set('field_ercore_ee_msi_fac_mn', $values->msiFacMn);
    $paragraph->set('field_ercore_ee_msi_fac_u', $values->msiFacU);
    $paragraph->set('field_ercore_ee_msi_stu_f', $values->msiStuF);
    $paragraph->set('field_ercore_ee_msi_stu_m', $values->msiStuM);
    $paragraph->set('field_ercore_ee_msi_stu_mn', $values->msiStuMn);
    $paragraph->set('field_ercore_ee_msi_stu_u', $values->msiStuU);
    $paragraph->set('field_ercore_ee_other_f', $values->otherF);
    $paragraph->set('field_ercore_ee_other_m', $values->otherM);
    $paragraph->set('field_ercore_ee_other_mn', $values->otherMn);
    $paragraph->set('field_ercore_ee_other_u', $values->otherU);
    $paragraph->set('field_ercore_ee_k12_dir_f', $values->k12DirF);
    $paragraph->set('field_ercore_ee_k12_dir_m', $values->k12DirM);
    $paragraph->set('field_ercore_ee_k12_dir_mn', $values->k12DirMn);
    $paragraph->set('field_ercore_ee_k12_dir_u', $values->k12DirU);
    $paragraph->set('field_ercore_ee_k12_tch_f', $values->k12TchF);
    $paragraph->set('field_ercore_ee_k12_tch_m', $values->k12TchM);
    $paragraph->set('field_ercore_ee_k12_tch_mn', $values->k12TchMn);
    $paragraph->set('field_ercore_ee_k12_tch_u', $values->k12TchU);
    $paragraph->set('field_ercore_ee_k12_ttr_f', $values->k12TtrF);
    $paragraph->set('field_ercore_ee_k12_ttr_m', $values->k12TtrM);
    $paragraph->set('field_ercore_ee_k12_ttr_mn', $values->k12TtrMn);
    $paragraph->set('field_ercore_ee_k12_ttr_u', $values->k12TtrU);
    $paragraph->save();
  }

}
