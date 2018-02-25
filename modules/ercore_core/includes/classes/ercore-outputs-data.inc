<?php

/**
 * @file
 * ERcore Outputs Class for the ERCore Admin module.
 */

require_once drupal_get_path('module', 'ercore_copre') . '/includes/ercore-admin-var.inc';

/**
 * Class defines outputs node export object.
 */
class ErcoreOutputs {
  public $type = '';
  public $subType = '';
  public $value1 = 0;
  public $value2 = 0;
  public $value3 = 0;
  public $value4 = 0;

  /**
   * Constructor.
   */
  public function __construct() {

  }

  /**
   * Builds Outputs data object with data.
   *
   * @param object $object
   *   Receives outputs data object for data placement.
   * @param array $data
   *   Receives data for placement in data object.
   *
   * @return object $object
   *   Returns outputs data object.
   */
  public function ercoreOutputsBuild(&$object, &$data, &$date_range) {
    // Three step default date to compensate for yyyy/mm date format rounding.
    $default_string = ercore_start_end_dates();
    $zone = \Drupal::config('system.date')->get('timezone.default');
    $date['start'] = $default_string['start'] . ' 00:00:00 ' . $zone;
    $date['end'] = $default_string['end'] . ' 00:00:00 ' . $zone;
    $default_array = ercore_admin_date_array_to_unix($date);
    $default_array = ercore_admin_date_array_converter($default_array);
    $within = NULL;

    foreach ($data as $data_row) {
      $current = FALSE;
      // Patent data build.
      if ($object->type == 'Patent') {
        // Patent data, subType Pending.
        if ($object->subType == 'Pending') {
          if (isset($data_row->field_field_ercore_pt_provisional[0]['raw'])) {
            $within = $data_row->field_field_ercore_pt_provisional[0]['raw']['value'];
          }
        }
        // Patent data, subType Awarded.
        elseif ($object->subType == 'Awarded') {
          if (isset($data_row->field_field_ercore_pt_award[0]['raw'])) {
            $within = $data_row->field_field_ercore_pt_award[0]['raw']['value'];
          }
        }
        // Patent data, subType Licensed.
        else {
          if (isset($data_row->field_field_ercore_pt_date[0]['raw'])) {
            $within = $data_row->field_field_ercore_pt_date[0]['raw']['value'];
          }
        }
        $current = TRUE;
        // Compare date ranges.
        $this->value2++;
      }

      // Proposal data build.
      elseif ($object->type == 'Proposal') {
        // Proposal data, subType Pending.
        if ($object->subType == 'Submitted') {
          if (isset($data_row->field_field_ercore_pp_proposal_submit[0]['raw'])) {
            $within = $data_row->field_field_ercore_pp_proposal_submit[0]['raw']['value'];
          }
        }
        // Patent data, subType Awarded.
        elseif ($object->subType == 'Awarded') {
          if (isset($data_row->field_field_ercore_pp_proposal_date[0]['raw'])) {
            $within = $data_row->field_field_ercore_pp_proposal_date[0]['raw']['value'];
          }
        }
        // Patent data, subType Pending.
        else {
          if (isset($data_row->field_field_ercore_pp_proposal_pending[0]['raw'])) {
            $within = $data_row->field_field_ercore_pp_proposal_pending[0]['raw']['value'];
          }
        }
        if ($this->ercoreOutputsDateCallback($within, $date_range) == TRUE && $date_range != $default_array) {
          $this->value1++;
          if (isset($data_row->field_field_ercore_pp_award_req_dec[0]['raw'])) {
            $this->value2 = $this->value2 + $data_row->field_field_ercore_pp_award_req_dec[0]['raw']['value'];
          }
        }
        $this->value3++;
        if (isset($data_row->field_field_ercore_pp_award_req_dec[0]['raw'])) {
          $this->value4 = $this->value4 + $data_row->field_field_ercore_pp_award_req_dec[0]['raw']['value'];
        }
      }
      // Publication data build.
      elseif ($object->type == 'Publication') {
        if (isset($data_row->field_field_ercore_pb_date[0]['raw'])) {
          $within = $data_row->field_field_ercore_pb_date[0]['raw']['value'];
        }
        // Publication data, subType Primary.
        if ($object->subType == 'Primary' && $data_row->field_field_ercore_pb_rii_support[0]['raw']['value'] == '0') {
          $current = TRUE;
          // Compare date ranges.
          $this->value2++;
        }

        // Publication data, subType Partial.
        if ($object->subType == 'Partial' && $data_row->field_field_ercore_pb_rii_support[0]['raw']['value'] == '1') {
          $current = TRUE;
          // Compare date ranges.
          $this->value2++;
        }
      }
      else {
        if ($object->type == 'new-hire') {
          if (isset($data_row->field_field_ercore_us_hired_date[0]['raw'])) {
            $within = $data_row->field_field_ercore_us_hired_date[0]['raw']['value'];
          }
        }
        elseif ($object->type == 'post-doc') {
          if (isset($data_row->field_field_ercore_us_part_date[0]['raw'])) {
            $within = $data_row->field_field_ercore_us_part_date[0]['raw'];
          }
        }
        elseif ($object->type == 'graduate') {
          if (isset($data_row->field_field_ercore_us_masters_act[0]['raw'])) {
            $within = $data_row->field_field_ercore_us_masters_act[0]['raw']['value'];
          }
        }
        else {
          if (isset($data_row->field_field_ercore_us_under_act[0]['raw'])) {
            $within = $data_row->field_field_ercore_us_under_act[0]['raw']['value'];
          }
        }
        if (isset($data_row->field_field_ercore_us_gender[0]['raw'])) {
          $gender = $data_row->field_field_ercore_us_gender[0]['raw']['value'];
        }
        else {
          $gender = NULL;
        }
        if (isset($data_row->field_field_ercore_us_race[0]['raw']['value'])) {
          $race = $data_row->field_field_ercore_us_race[0]['raw']['value'];
        }
        else {
          $race = NULL;
        }
        if (isset($data_row->field_field_ercore_us_ethnicity[0]['raw']['value'])) {
          $ethnicity = $data_row->field_field_ercore_us_ethnicity[0]['raw']['value'];
        }
        else {
          $ethnicity = NULL;
        }
        if (isset($data_row->field_field_ercore_us_disabilities[0]['rendered'])) {
          $disabled_value = TRUE;
        }
        else {
          $disabled_value = FALSE;
        }
        $urm = array(
          'American Indian',
          'Black',
          'Alaskan Native',
          'Native Hawaiian',
          'Pacific Islander',
        );

        if ($object->subType == 'Male' && $gender == '0') {
          $current = TRUE;
          $this->value2++;
        }
        if ($object->subType == 'Female' && $gender == '1') {
          $current = TRUE;
          $this->value2++;
        }
        if ($object->subType == 'Under-represented minority') {
          if (in_array($race, $urm) || $ethnicity == '0') {
            $current = TRUE;
            $this->value2++;
          }
        }
        if ($object->subType == 'Disabled' && $disabled_value == TRUE) {
          if ($data_row->field_field_ercore_us_disabilities[0]['rendered']['#markup'] != 'None') {
            $current = TRUE;
            $this->value2++;
          }
        }
      }
      if ($current == TRUE && $this->ercoreOutputsDateCallback($within, $date_range) == TRUE) {

        $this->value1++;
      }
    }

    return $object;
  }

  /**
   * Date Callback for validating a date within a range.
   *
   * @param string $within_date
   *   Receives date string for validation.
   * @param array $dates
   *   Receives date array for validation against string.
   *
   * @return bool boolean
   *   Returns boolean value based on date validation.
   */
  public static function ercoreOutputsDateCallback(&$within_date, &$dates) {
    if ($within_date == NULL) {
      return FALSE;
    }
    else {
      if (isset($within_date['value'])) {
        $begin = strtotime($within_date['value']);
        $end = strtotime($within_date['value2']);
        $range1 = $dates[0][0];
        $range2 = $dates[0][1];
        if ($begin == $end && $begin <= $range2) {
          $within = TRUE;
        }
        elseif ($begin <= $range2 && $end >= $range1) {
          $within = TRUE;
        }
        else {
          $within = FALSE;
        }
        return $within;
      }
      else {
        $zone = \Drupal::config('system.date')->get('timezone.default');
        $test = $within_date;
        $within_date = strtotime($within_date . $zone);
        return (($dates[0][0]) <= $within_date && ($dates[0][1]) >= $within_date);
      }
    }
  }

}
