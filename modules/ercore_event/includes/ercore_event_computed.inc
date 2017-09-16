<?php

/**
 * @file
 * Defines ERCore Event computed fields.
 */

/**
 * Implements computed_field_field_ercore_ee_ari_fac_t_compute().
 *
 * Generates total ARI Faculty value for field_ercore_ee_ari_fac_t.
 */
function computed_field_field_ercore_ee_ari_fac_t_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_ari_fac_f'][0]['value'] +
    $fields['field_ercore_ee_ari_fac_m'][0]['value'] +
    $fields['field_ercore_ee_ari_fac_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_ari_stu_t_compute().
 *
 * Generates total ARI Student value for field_ercore_ee_ari_stu_t.
 */
function computed_field_field_ercore_ee_ari_stu_t_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_ari_stu_f'][0]['value'] +
    $fields['field_ercore_ee_ari_stu_m'][0]['value'] +
    $fields['field_ercore_ee_ari_stu_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_k12_dir_t_compute().
 *
 * Generates total K12 Direct value for field_ercore_ee_k12_dir_t.
 */
function computed_field_field_ercore_ee_k12_dir_t_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_k12_dir_f'][0]['value'] +
    $fields['field_ercore_ee_k12_dir_m'][0]['value'] +
    $fields['field_ercore_ee_k12_dir_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_k12_ttr_t_compute().
 *
 * Generates total K12 Teach Training value for field_ercore_ee_k12_ttr_t.
 */
function computed_field_field_ercore_ee_k12_ttr_t_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_k12_ttr_f'][0]['value'] +
    $fields['field_ercore_ee_k12_ttr_m'][0]['value'] +
    $fields['field_ercore_ee_k12_ttr_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_k12_tch_t_compute().
 *
 * Generates total K12 Teacher value for field_ercore_ee_k12_tch_t.
 */
function computed_field_field_ercore_ee_k12_tch_t_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_k12_tch_f'][0]['value'] +
    $fields['field_ercore_ee_k12_tch_m'][0]['value'] +
    $fields['field_ercore_ee_k12_tch_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_msi_fac_t_compute().
 *
 * Generates total MSI Faculty value for field_ercore_ee_msi_fac_t.
 */
function computed_field_field_ercore_ee_msi_fac_t_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_msi_fac_f'][0]['value'] +
    $fields['field_ercore_ee_msi_fac_m'][0]['value'] +
    $fields['field_ercore_ee_msi_fac_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_msi_stu_t_compute().
 *
 * Generates total MSI Student value for field_ercore_ee_msi_stu_t.
 */
function computed_field_field_ercore_ee_msi_stu_t_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_msi_stu_f'][0]['value'] +
    $fields['field_ercore_ee_msi_stu_m'][0]['value'] +
    $fields['field_ercore_ee_msi_stu_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_other_t_compute().
 *
 * Generates total Other value for field_ercore_ee_other_t.
 */
function computed_field_field_ercore_ee_other_t_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_other_f'][0]['value'] +
    $fields['field_ercore_ee_other_m'][0]['value'] +
    $fields['field_ercore_ee_other_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_pui_fac_t_compute().
 *
 * Generates total PUI Faculty value for field_ercore_ee_pui_fac_t.
 */
function computed_field_field_ercore_ee_pui_fac_t_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_pui_fac_f'][0]['value'] +
    $fields['field_ercore_ee_pui_fac_m'][0]['value'] +
    $fields['field_ercore_ee_pui_fac_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_pui_stu_t_compute().
 *
 * Generates total PUI Student value for field_ercore_ee_pui_stu_t.
 */
function computed_field_field_ercore_ee_pui_stu_t_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_pui_stu_f'][0]['value'] +
    $fields['field_ercore_ee_pui_stu_m'][0]['value'] +
    $fields['field_ercore_ee_pui_stu_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_t_t_compute().
 *
 * Generates total value for field_ercore_ee_t_t.
 */
function computed_field_field_ercore_ee_t_t_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_ari_fac_f'][0]['value'] +
    $fields['field_ercore_ee_ari_fac_m'][0]['value'] +
    $fields['field_ercore_ee_ari_fac_u'][0]['value'] +
    $fields['field_ercore_ee_ari_stu_f'][0]['value'] +
    $fields['field_ercore_ee_ari_stu_m'][0]['value'] +
    $fields['field_ercore_ee_ari_stu_u'][0]['value'] +
    $fields['field_ercore_ee_k12_dir_f'][0]['value'] +
    $fields['field_ercore_ee_k12_dir_m'][0]['value'] +
    $fields['field_ercore_ee_k12_dir_u'][0]['value'] +
    $fields['field_ercore_ee_k12_ttr_f'][0]['value'] +
    $fields['field_ercore_ee_k12_ttr_m'][0]['value'] +
    $fields['field_ercore_ee_k12_ttr_u'][0]['value'] +
    $fields['field_ercore_ee_k12_tch_f'][0]['value'] +
    $fields['field_ercore_ee_k12_tch_m'][0]['value'] +
    $fields['field_ercore_ee_k12_tch_u'][0]['value'] +
    $fields['field_ercore_ee_msi_fac_f'][0]['value'] +
    $fields['field_ercore_ee_msi_fac_m'][0]['value'] +
    $fields['field_ercore_ee_msi_fac_u'][0]['value'] +
    $fields['field_ercore_ee_msi_stu_f'][0]['value'] +
    $fields['field_ercore_ee_msi_stu_m'][0]['value'] +
    $fields['field_ercore_ee_msi_stu_u'][0]['value'] +
    $fields['field_ercore_ee_other_f'][0]['value'] +
    $fields['field_ercore_ee_other_m'][0]['value'] +
    $fields['field_ercore_ee_other_u'][0]['value'] +
    $fields['field_ercore_ee_pui_fac_f'][0]['value'] +
    $fields['field_ercore_ee_pui_fac_m'][0]['value'] +
    $fields['field_ercore_ee_pui_fac_u'][0]['value'] +
    $fields['field_ercore_ee_pui_stu_f'][0]['value'] +
    $fields['field_ercore_ee_pui_stu_m'][0]['value'] +
    $fields['field_ercore_ee_pui_stu_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_t_f_compute().
 *
 * Generates total Female value for field_ercore_ee_t_f.
 */
function computed_field_field_ercore_ee_t_f_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_ari_fac_f'][0]['value'] +
    $fields['field_ercore_ee_ari_stu_f'][0]['value'] +
    $fields['field_ercore_ee_k12_dir_f'][0]['value'] +
    $fields['field_ercore_ee_k12_ttr_f'][0]['value'] +
    $fields['field_ercore_ee_k12_tch_f'][0]['value'] +
    $fields['field_ercore_ee_msi_fac_f'][0]['value'] +
    $fields['field_ercore_ee_msi_stu_f'][0]['value'] +
    $fields['field_ercore_ee_other_f'][0]['value'] +
    $fields['field_ercore_ee_pui_fac_f'][0]['value'] +
    $fields['field_ercore_ee_pui_stu_f'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_t_t_compute().
 *
 * Generates total Male value for field_ercore_ee_t_t.
 */
function computed_field_field_ercore_ee_t_m_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_ari_fac_m'][0]['value'] +
    $fields['field_ercore_ee_ari_stu_m'][0]['value'] +
    $fields['field_ercore_ee_k12_dir_m'][0]['value'] +
    $fields['field_ercore_ee_k12_ttr_m'][0]['value'] +
    $fields['field_ercore_ee_k12_tch_m'][0]['value'] +
    $fields['field_ercore_ee_msi_fac_m'][0]['value'] +
    $fields['field_ercore_ee_msi_stu_m'][0]['value'] +
    $fields['field_ercore_ee_other_m'][0]['value'] +
    $fields['field_ercore_ee_pui_fac_m'][0]['value'] +
    $fields['field_ercore_ee_pui_stu_m'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_t_u_compute().
 *
 * Generates total Undeclared value for field_ercore_ee_t_u.
 */
function computed_field_field_ercore_ee_t_u_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_ari_fac_u'][0]['value'] +
    $fields['field_ercore_ee_ari_stu_u'][0]['value'] +
    $fields['field_ercore_ee_k12_dir_u'][0]['value'] +
    $fields['field_ercore_ee_k12_ttr_u'][0]['value'] +
    $fields['field_ercore_ee_k12_tch_u'][0]['value'] +
    $fields['field_ercore_ee_msi_fac_u'][0]['value'] +
    $fields['field_ercore_ee_msi_stu_u'][0]['value'] +
    $fields['field_ercore_ee_other_u'][0]['value'] +
    $fields['field_ercore_ee_pui_fac_u'][0]['value'] +
    $fields['field_ercore_ee_pui_stu_u'][0]['value'];
  return $value;
}

/**
 * Implements computed_field_field_ercore_ee_t_mn_compute().
 *
 * Generates total Under-represented Minority value for field_ercore_ee_t_mn.
 */
function computed_field_field_ercore_ee_t_mn_compute($entity_type_manager, $entity, $fields, $delta) {
  $value =
    $fields['field_ercore_ee_ari_fac_f'][0]['value'] +
    $fields['field_ercore_ee_ari_fac_m'][0]['value'] +
    $fields['field_ercore_ee_ari_fac_u'][0]['value'] +
    $fields['field_ercore_ee_ari_stu_f'][0]['value'] +
    $fields['field_ercore_ee_ari_stu_m'][0]['value'] +
    $fields['field_ercore_ee_ari_stu_u'][0]['value'] +
    $fields['field_ercore_ee_k12_dir_f'][0]['value'] +
    $fields['field_ercore_ee_k12_dir_m'][0]['value'] +
    $fields['field_ercore_ee_k12_dir_u'][0]['value'] +
    $fields['field_ercore_ee_k12_ttr_f'][0]['value'] +
    $fields['field_ercore_ee_k12_ttr_m'][0]['value'] +
    $fields['field_ercore_ee_k12_ttr_u'][0]['value'] +
    $fields['field_ercore_ee_k12_tch_f'][0]['value'] +
    $fields['field_ercore_ee_k12_tch_m'][0]['value'] +
    $fields['field_ercore_ee_k12_tch_u'][0]['value'] +
    $fields['field_ercore_ee_msi_fac_f'][0]['value'] +
    $fields['field_ercore_ee_msi_fac_m'][0]['value'] +
    $fields['field_ercore_ee_msi_fac_u'][0]['value'] +
    $fields['field_ercore_ee_msi_stu_f'][0]['value'] +
    $fields['field_ercore_ee_msi_stu_m'][0]['value'] +
    $fields['field_ercore_ee_msi_stu_u'][0]['value'] +
    $fields['field_ercore_ee_other_f'][0]['value'] +
    $fields['field_ercore_ee_other_m'][0]['value'] +
    $fields['field_ercore_ee_other_u'][0]['value'] +
    $fields['field_ercore_ee_pui_fac_f'][0]['value'] +
    $fields['field_ercore_ee_pui_fac_m'][0]['value'] +
    $fields['field_ercore_ee_pui_fac_u'][0]['value'] +
    $fields['field_ercore_ee_pui_stu_f'][0]['value'] +
    $fields['field_ercore_ee_pui_stu_m'][0]['value'] +
    $fields['field_ercore_ee_pui_stu_u'][0]['value'];
  return $value;
}
