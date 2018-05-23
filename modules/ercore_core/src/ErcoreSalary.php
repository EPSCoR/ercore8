<?php

namespace Drupal\ercore_core;

use Drupal\Core\Entity\Entity;
use Drupal\ercore\ErcoreStartDate;

/**
 * Class defines export object.
 */
class ErcoreSalary {
  /**
   * All users with salary support checked.
   *
   * @var array
   */
  public $allIds = [];

  /**
   * Filtered users with salary support checked.
   *
   * @var array
   */
  public $filteredIds = [];

  /**
   * Filter dates to use for exports.
   *
   * @var array
   */
  public $range = [];

  /**
   * Constructor.
   */
  public function __construct() {
  }

  /**
   * Build salary object.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function getUserIds() {
    $query = \Drupal::entityQuery('user');
    $query->condition('field_ercore_user_fac_support', 1);
    return $query->execute();
  }

  /**
   * Build salary object.
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
        $user_start = $user->get('field_ercore_user_start')->getValue();
        $user_end = $user->get('field_ercore_user_end')->getValue();
        $institution = $user
          ->get('field_ercore_user_partic_inst')
          ->first()
          ->get('entity')
          ->getTarget()
          ->getValue();
        $institution_id = $institution->id();
        $institution_name = $institution->getTitle();
        $name = $user->getUsername();
        $realname = $user->get('field_ercore_user_name');
        if (!$realname->isEmpty()) {
          $real = $realname->getValue();
          $name = implode(' ', array_filter($real[0]));
        }
        if (empty($user_end[0]['value'])) {
          $user_end = ErcoreStartDate::endUnix();
        }
        else {
          $user_end = ErcoreStartDate::dateArgumentToUnix($user_end[0]['value']);
        }
        $users[$id] = [
          'id' => $id,
          'name' => $name,
          'institution_id' => $institution_id,
          'institution' => $institution_name,
          'start' => ErcoreStartDate::dateArgumentToUnix($user_start[0]['value']),
          'end' => $user_end,
        ];
      }
    }
    return $users;
  }

  /**
   * Build salary object.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function filterUserIds() {
    $dates = ercore_get_filter_dates();
    $filtered = [];
    $users = self::getUsers();
    foreach ($users as $uid => $user) {
      if (($user['start'] <= $dates['end'] && $user['end'] >= $dates['start'])
      || ($user['start'] <= $dates['end'] && empty($user['end']))) {
        $filtered[$user['institution']][] = $user;
      }
    }
    return $filtered;
  }

}
