<?php

/**
 * @file
 * ERcore Participant Aggregation Class file for the ERCore Admin module.
 */

/**
 * Class defines participant group object.
 */
class ErcoreParticipantGroup {
  public $name = '';
  public $total = '0';
  public $male = '0';
  public $female = '0';
  public $black = '0';
  public $hispanic = '0';
  public $other = '0';
  public $disabled = '0';
  public $new = '0';

  /**
   * Constructor.
   */
  public function __construct() {

  }

  /**
   * Type for internal function.
   *
   * @return array $ercore_no_new_values
   *   Array of participant type for internal function.
   */
  public static function ercoreNoNewValues() {
    $ercore_no_new_values = array(
      'Technical support staff',
      'Non-technical support staff',
      'Graduate student',
      'Undergraduate student',
    );
    return $ercore_no_new_values;
  }

  /**
   * Placement of data from Views in Participant data object.
   *
   * @param object $group
   *   Group object for data placment.
   * @param array $view_row
   *   Data array from Views module.
   * @param bool $new
   *   Boolean value determines placement within data structure.
   *
   * @return object $group
   *   Returns data object for use.
   */
  public function ercoreParticipantGroupData(&$group, &$view_row, $new) {

    $this->total++;

    if (isset($view_row->field_field_ercore_us_gender[0])) {
      if ($view_row->field_field_ercore_us_gender[0]['rendered']['#markup'] == 'Male') {
        $this->male++;
      }
    }
    // Female.
    if (isset($view_row->field_field_ercore_us_gender[0])) {
      if ($view_row->field_field_ercore_us_gender[0]['rendered']['#markup'] == 'Female') {
        $this->female++;
      }
    }
    // Black.
    if (isset($view_row->field_field_ercore_us_race[0])) {
      if ($view_row->field_field_ercore_us_race[0]['raw']['safe_value'] == 'Black or African American') {
        $this->black++;
      }
    }
    // Hispanic.
    if (isset($view_row->field_field_ercore_us_ethnicity[0])) {
      if ($view_row->field_field_ercore_us_ethnicity[0]['rendered']['#markup'] == 'Hispanic or Latino') {
        $this->hispanic++;
      }
    }
    // Other.
    if (isset($view_row->field_field_ercore_us_race[0])) {
      if ($view_row->field_field_ercore_us_race[0]['raw']['safe_value'] == 'American Indian or Alaskan Native') {
        $this->other++;
      }
      elseif ($view_row->field_field_ercore_us_race[0]['raw']['safe_value'] == 'Pacific Islander') {
        $this->other++;
      }
      elseif ($view_row->field_field_ercore_us_race[0]['raw']['safe_value'] == 'Native Hawaiian') {
        $this->other++;
      }
    }
    // Disabled.
    if (isset($view_row->field_field_ercore_us_disabilities[0])) {
      if ($view_row->field_field_ercore_us_disabilities[0]['raw']['safe_value'] != 'None') {
        $this->disabled++;
      }
    }
    // New Participant within supplied date range.
    if ($new == TRUE) {
      $this->new++;
    }
    return $group;
  }

  /**
   * Date Callback for validating a date within a range.
   *
   * @param string $hired
   *   Receives date string for validation.
   * @param array $dates
   *   Receives date array for validation against string.
   *
   * @return bool boolean
   *   Returns boolean value based on date validation.
   */
  public static function ercoreNewDateCallback(&$hired, &$dates) {
    $hired = strtotime($hired);
    return (($dates[0][0] <= $hired) && ($dates[0][1] >= $hired));
  }

}

/**
 * Class defines participant group object.
 */
class ErcoreParticipantCollection {

  /**
   * Construct.
   */
  public function __construct() {
    $this->faculty = new ErcoreParticipantGroup();
    $this->faculty->name = 'Faculty participant (or equivalent)';
    $this->technical = new ErcoreParticipantGroup();
    $this->technical->name = 'Technical support staff';
    $this->nontechnical = new ErcoreParticipantGroup();
    $this->nontechnical->name = 'Non-technical support staff';
    $this->postdoc = new ErcoreParticipantGroup();
    $this->postdoc->name = 'Post Doc';
    $this->graduate = new ErcoreParticipantGroup();
    $this->graduate->name = 'Graduate student';
    $this->undergraduate = new ErcoreParticipantGroup();
    $this->undergraduate->name = 'Undergraduate student';
    $this->rii = new ErcoreParticipantGroup();
    $this->rii->name = 'RII Leadership Team';
  }

  /**
   * Placement of data from Views in Participant Collection data object.
   *
   * @param object $collection
   *   Group object for data placment.
   * @param array $view
   *   Data array from Views module.
   * @param array $dates
   *   Dates to determines placement within data structure.
   *
   * @return object $group
   *   Returns data object for use.
   */
  public function ercoreCollectionData(&$collection, &$view, &$dates) {
    $non_displayed_values = ErcoreParticipantGroup::ercoreNoNewValues();
    foreach ($view as $view_row) {
      // New Participant validation.
      $new = FALSE;
      if (isset($view_row->field_field_ercore_us_hired_date[0])) {
        if (isset($dates) && $dates != 'empty') {
          if (isset($view_row->field_field_ercore_us_hired_date[0])) {
            $zone = variable_get('date_default_timezone');
            $hired = $view_row->field_field_ercore_us_hired_date[0]['raw']['value'] . ' ' . $zone;

            $new = ErcoreParticipantGroup::ercoreNewDateCallback($hired, $dates);
          }
        }
      }
      if (!in_array($view_row->field_field_ercore_us_sen_role[0]['rendered']['#markup'], $non_displayed_values) && isset($view_row->field_field_ercore_us_leadership_team[0]['raw']) && $view_row->field_field_ercore_us_leadership_team[0]['raw']['value'] == 1) {
        $collection->rii->ercoreParticipantGroupData($this->rii, $view_row, $new);
      }
      else {

        // Faculty.
        if ($view_row->field_field_ercore_us_sen_role[0]['raw']['value'] == 0) {
          $collection->faculty->ercoreParticipantGroupData($this->faculty, $view_row, $new);
        }
        // Technical.
        if ($view_row->field_field_ercore_us_sen_role[0]['raw']['value'] == 1) {
          $collection->technical->ercoreParticipantGroupData($this->technical, $view_row, $new);
        }
        // Non-technical.
        if ($view_row->field_field_ercore_us_sen_role[0]['raw']['value'] == 2) {
          $collection->nontechnical->ercoreParticipantGroupData($this->nontechnical, $view_row, $new);
        }
        if ($view_row->field_field_ercore_us_sen_role[0]['raw']['value'] == 3) {
          $collection->postdoc->ercoreParticipantGroupData($this->postdoc, $view_row, $new);
        }
        if ($view_row->field_field_ercore_us_sen_role[0]['raw']['value'] == 4) {
          $collection->graduate->ercoreParticipantGroupData($this->graduate, $view_row, $new);
        }
        if ($view_row->field_field_ercore_us_sen_role[0]['raw']['value'] == 5) {
          $collection->undergraduate->ercoreParticipantGroupData($this->undergraduate, $view_row, $new);
        }
      }
    }
    return $collection;
  }

}
