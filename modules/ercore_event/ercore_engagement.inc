<?php

/**
 * @file
 * Defines ERCore Event content and field types.
 */

/**
 * Class ercore_engagement.
 *
 * @package ercore\engagement
 */
class ErcoreEngagement {
  public $type = '';
  public $ariFac = '0';
  public $ariStu = '0';
  public $uiFac = '0';
  public $uiStu = '0';
  public $msiFac = '0';
  public $msiStu = '0';
  public $k12T = '0';
  public $k12Sd = '0';
  public $k12St = '0';
  public $other = '0';
  public $total = '0';

  /**
   * Constructor.
   */
  public function __construct() {

  }

  /**
   * Builds Engagement data object with data.
   *
   * @param object $object
   *   Receives Engagement data object for data placement.
   * @param array $data
   *   Receives data for placement in data object.
   *
   * @return object
   *   Returns engagement data object.
   */
  public function ercoreEngagementBuild(&$object, array &$data) {
    foreach ($data as $data_row) {
      if ($object->type == 'Project Total') {
        // Total fields.
        $this->ariFac += $data_row->field_field_ercore_ee_ari_fac_t[0]['raw']['value'];
        $this->ariStu += $data_row->field_field_ercore_ee_ari_stu_t[0]['raw']['value'];
        $this->uiFac += $data_row->field_field_ercore_ee_pui_fac_t[0]['raw']['value'];
        $this->uiStu += $data_row->field_field_ercore_ee_pui_stu_t[0]['raw']['value'];
        $this->msiFac += $data_row->field_field_ercore_ee_msi_fac_t[0]['raw']['value'];
        $this->msiStu += $data_row->field_field_ercore_ee_msi_stu_t[0]['raw']['value'];
        $this->k12T += $data_row->field_field_ercore_ee_k12i_tec_t[0]['raw']['value'];
        $this->k12Sd += $data_row->field_field_ercore_ee_k12i_stud_t[0]['raw']['value'];
        $this->k12St += $data_row->field_field_ercore_ee_k12i_stut_t[0]['raw']['value'];
        $this->other += $data_row->field_field_ercore_ee_oth_t[0]['raw']['value'];
        $this->total += $data_row->field_field_ercore_ee_t_t[0]['raw']['value'];
      }
      elseif ($object->type == 'Male') {
        // Male fields.
        $this->ariFac += $data_row->field_field_ercore_ee_ari_fac_m[0]['raw']['value'];
        $this->ariStu += $data_row->field_field_ercore_ee_ari_stu_m[0]['raw']['value'];
        $this->uiFac += $data_row->field_field_ercore_ee_pui_fac_m[0]['raw']['value'];
        $this->uiStu += $data_row->field_field_ercore_ee_pui_stu_m[0]['raw']['value'];
        $this->msiFac += $data_row->field_field_ercore_ee_msi_fac_m[0]['raw']['value'];
        $this->msiStu += $data_row->field_field_ercore_ee_msi_stu_m[0]['raw']['value'];
        $this->k12T += $data_row->field_field_ercore_ee_k12i_tec_m[0]['raw']['value'];
        $this->k12Sd += $data_row->field_field_ercore_ee_k12i_stud_m[0]['raw']['value'];
        $this->k12St += $data_row->field_field_ercore_ee_k12i_stut_m[0]['raw']['value'];
        $this->other += $data_row->field_field_ercore_ee_oth_m[0]['raw']['value'];
        $this->total += $data_row->field_field_ercore_ee_m_t[0]['raw']['value'];
      }
      elseif ($object->type == 'Female') {
        // Female fields.
        $this->ariFac += $data_row->field_field_ercore_ee_ari_fac_f[0]['raw']['value'];
        $this->ariStu += $data_row->field_field_ercore_ee_ari_stu_f[0]['raw']['value'];
        $this->uiFac += $data_row->field_field_ercore_ee_pui_fac_f[0]['raw']['value'];
        $this->uiStu += $data_row->field_field_ercore_ee_pui_stu_f[0]['raw']['value'];
        $this->msiFac += $data_row->field_field_ercore_ee_msi_fac_f[0]['raw']['value'];
        $this->msiStu += $data_row->field_field_ercore_ee_msi_stu_f[0]['raw']['value'];
        $this->k12T += $data_row->field_field_ercore_ee_k12i_tec_f[0]['raw']['value'];
        $this->k12Sd += $data_row->field_field_ercore_ee_k12i_stud_f[0]['raw']['value'];
        $this->k12St += $data_row->field_field_ercore_ee_k12i_stut_f[0]['raw']['value'];
        $this->other += $data_row->field_field_ercore_ee_oth_f[0]['raw']['value'];
        $this->total += $data_row->field_field_ercore_ee_f_t[0]['raw']['value'];
      }
      else {
        // Minority fields.
        $this->ariFac += $data_row->field_field_ercore_ee_ari_fac_mn[0]['raw']['value'];
        $this->ariStu += $data_row->field_field_ercore_ee_ari_stu_mn[0]['raw']['value'];
        $this->uiFac += $data_row->field_field_ercore_ee_pui_fac_mn[0]['raw']['value'];
        $this->uiStu += $data_row->field_field_ercore_ee_pui_stu_mn[0]['raw']['value'];
        $this->msiFac += $data_row->field_field_ercore_ee_msi_fac_mn[0]['raw']['value'];
        $this->msiStu += $data_row->field_field_ercore_ee_msi_stu_mn[0]['raw']['value'];
        $this->k12T += $data_row->field_field_ercore_ee_k12i_tec_mn[0]['raw']['value'];
        $this->k12Sd += $data_row->field_field_ercore_ee_k12i_stud_mn[0]['raw']['value'];
        $this->k12St += $data_row->field_field_ercore_ee_k12i_stut_mn[0]['raw']['value'];
        $this->other += $data_row->field_field_ercore_ee_oth_mn[0]['raw']['value'];
        $this->total += $data_row->field_field_ercore_ee_um_t[0]['raw']['value'];
      }
    }
    return $object;
  }

}
