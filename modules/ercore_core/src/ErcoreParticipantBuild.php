<?php

namespace Drupal\ercore_core;

use Drupal\ercore\ercoreStartDate;

/**
 * Class ErcoreParticipant.
 *
 * @package Drupal\ercore_core
 */
class ErcoreParticipantBuild {

  /**
   * Type for internal function.
   *
   * @return array
   *   Array of participant type for internal function.
   */
  public static function ercoreNoNewValues() {
    return [
      'technical' => 'Technical support staff',
      'non-technical' => 'Non-technical support staff',
      'graduate' => 'Graduate student',
      'undergraduate' => 'Undergraduate student',
    ];
  }

  /**
   * Data types which form row headers.
   *
   * @return array
   *   Return array of data types.
   */
  public static function dataTypes() {
    return [
      'faculty' => 'Faculty participant (or equivalent)',
      'technical' => 'Technical support staff',
      'non-technical' => 'Non-technical support staff',
      'post-doc' => 'Post Doc',
      'graduate' => 'Graduate student',
      'undergraduate' => 'Undergraduate student',
      'rii' => 'RII Leadership Team',
    ];
  }

  /**
   * Builds data array for participant data block.
   *
   * @return array
   *   Returns array of objects.
   */
  public static function buildDataArray() {
    $dataArray = [];
    foreach (self::dataTypes() as $key => $type) {
      $dataArray[$key] = new ErcoreParticipantColumn();
      $dataArray[$key]->setName($type);
    }
    return $dataArray;
  }

  /**
   * Build salary object.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function getParticipatingInstitutions() {
    $query = \Drupal::entityQuery('node')
      ->condition('field_ercore_inst_participating', 1)
      ->execute();
    $institutions = [];
    foreach ($query as $institution) {
      $node = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->load($institution);
      $institutions[$institution] = $node->label();
    }
    return $institutions;
  }

  /**
   * Get array of User IDs.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function getUserIds() {
    $query = \Drupal::entityQuery('user');
    return $query->execute();
  }

  /**
   * Build user objects.
   *
   * @return array
   *   Array of Users.
   */
  public static function getUsers() {
    $ids = self::getUserIds();
    $users = [];
    foreach ($ids as $id) {
      $user = \Drupal::entityTypeManager()->getStorage('user')->load($id);
      if (!$user->get('field_ercore_user_start')->isEmpty()) {
        $role = '';
        if (!$user->get('field_ercore_senior_role')->isEmpty()) {
          $role = $user->get('field_ercore_senior_role')->getString();
        }
        if (!empty($role) && $role !== 'evaluation') {
          $user_start = $user->get('field_ercore_user_start')->getValue();
          if (!$user->get('field_ercore_user_end')->isEmpty()) {
            $end_var = $user->get('field_ercore_user_end')->value;
            $user_end = ErcoreStartDate::dateArgumentToUnix($end_var);
          }
          else {
            $user_end = ErcoreStartDate::endUnix();
          }
          $institution = $user
            ->get('field_ercore_user_partic_inst')
            ->first()
            ->get('entity')
            ->getTarget()
            ->getValue();
          $institution_id = $institution->id();
          $institution_name = $institution->getTitle();
          $name = $user->getUsername();
          $hired = '';
          if (!$user->get('field_ercore_user_hired_date')->isEmpty()) {
            $hired_var = $user->get('field_ercore_user_hired_date')->value;
            $hired = ErcoreStartDate::dateArgumentToUnix($hired_var);
          }
          if (!$user->get('field_ercore_user_doc_act')->isEmpty()) {
            $doctoral_var = $user->get('field_ercore_user_doc_act')->value;
            $doctoral = ErcoreStartDate::dateArgumentToUnix($doctoral_var);
          }
          if (!$user->get('field_ercore_user_master_act')->isEmpty()) {
            $masters_var = $user->get('field_ercore_user_master_act')->value;
            $masters = ErcoreStartDate::dateArgumentToUnix($masters_var);
          }
          if (!$user->get('field_ercore_user_under_act')->isEmpty()) {
            $undergraduate_var = $user->get('field_ercore_user_under_act')->value;
            $undergraduate = ErcoreStartDate::dateArgumentToUnix($undergraduate_var);
          }
          $department = '';
          if (!$user->get('field_ercore_user_department')->isEmpty()) {
            $department_value = $user->get('field_ercore_user_department')
              ->first()
              ->getValue();
            $department = $department_value['value'];
          }
          $realname = $user->get('field_ercore_user_name');
          if (!$realname->isEmpty()) {
            $real = $realname->getValue();
            $name = implode(' ', array_filter($real[0]));
          }
          $leadership = 0;
          if (!$user->get('field_ercore_user_lead_team')->isEmpty()) {
            $onTeam = $user->get('field_ercore_user_lead_team')
              ->first()
              ->getValue();
            if (!in_array($role, array_keys(self::ercoreNoNewValues())) && $onTeam['value'] == 1) {
              $leadership = 1;
            }
          }
          // Demographics.
          $prefer = 0;
          $veteran = '0';
          $gender = '';
          $race = '';
          $ethnicity = '';
          $disability = 'None';
          if (!$user->get('field_ercore_prefer_no_answer')->isEmpty()) {
            $prefer = $user->get('field_ercore_prefer_no_answer')
              ->first()
              ->getValue();
            $prefer = $prefer['value'];
          }
          if ($prefer != 1) {
            if (!$user->get('field_ercore_user_gender')->isEmpty()) {
              $gender = $user->get('field_ercore_user_gender')
                ->first()
                ->getString();
            }
            if (!$user->get('field_ercore_user_race')->isEmpty()) {
              $race = $user->get('field_ercore_user_race')
                ->first()
                ->getString();
            }
            if (!$user->get('field_ercore_user_ethnicity')->isEmpty()) {
              $ethnicity = $user->get('field_ercore_user_ethnicity')
                ->first()
                ->getString();
            }
            if (!$user->get('field_ercore_user_disabilities')->isEmpty()) {
              $disability = $user->get('field_ercore_user_disabilities')
                ->first()
                ->getString();
            }
            if (!$user->get('field_ercore_user_veteran')->isEmpty()) {
              $veteran = $user->get('field_ercore_user_veteran')
                ->first()
                ->getValue();
              $veteran = $veteran['value'];
            }
          }
          $new = FALSE;
          if (!empty($hired) && !in_array($role, array_keys(self::ercoreNoNewValues()))) {
            $new = self::newDateCallback($hired);
          }
          $users[$id] = [
            'id' => $id,
            'name' => $name,
            'institution_id' => $institution_id,
            'institution' => $institution_name,
            'role' => $role,
            'gender' => $gender,
            'race' => $race,
            'veteran' => $veteran,
            'ethnicity' => $ethnicity,
            'disability' => $disability,
            'leadership' => $leadership,
            'department' => $department,
            'start' => ErcoreStartDate::dateArgumentToUnix($user_start[0]['value']),
            'end' => $user_end,
            'new' => $new,
            'hired' => $hired,
            'doctoral' => $doctoral,
            'masters' => $masters,
            'undergraduate' => $undergraduate,
          ];
        }
      }
    }
    return $users;
  }

  /**
   * Callback to check if date falls within range (new).
   *
   * @param int $hired
   *   Hired data of user.
   *
   * @return bool
   *   Returns boolean value based on date validation.
   */
  public static function newDateCallback($hired) {
    $dates = ercore_get_filter_dates();
    return (($dates['start'] <= $hired) && ($dates['end'] >= $hired));
  }

  /**
   * Filtered users.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function getFilteredUsers() {
    $dates = ercore_get_filter_dates();
    $filtered = [];
    $users = self::getUsers();
    foreach ($users as $uid => $user) {
      if (($user['start'] <= $dates['end'] && $user['end'] >= $dates['start'])
        || ($user['start'] <= $dates['end'] && empty($user['end']))
      ) {
        $filtered[] = $user;
      }
    }
    return $filtered;
  }

  /**
   * Gets all Participant data.
   */
  public static function getData() {
    $data = [];
    $users = self::getFilteredUsers();
    $institutions = self::getParticipatingInstitutions();
    foreach ($institutions as $id => $institution) {
      $data[$id] = [
        'name' => $institution,
        'data' => self::buildDataArray(),
      ];
    }
    $data[0] = [
      'name' => 'Totals',
      'data' => self::buildDataArray(),
    ];
    foreach ($users as $user) {
      $data[$user['institution_id']]['data'][$user['role']]->groupData($user);
      $data[0]['data'][$user['role']]->groupData($user);
      if ($user['leadership'] === 1) {
        $data[$user['institution_id']]['data']['rii']->groupData($user);
        $data[0]['data']['rii']->groupData($user);
      }
    }
    return $data;
  }

}
