<?php

namespace Drupal\ercore_core;

use Drupal\ercore\ercoreStartDate;
use Drupal\ercore_core\ErcoreParticipantBuild;

/**
 * Class ErcoreOutputsBuild.
 *
 * @package Drupal\ercore_core
 */
class ErcoreOutputs {

  /**
   * Builds data array for participant data block.
   *
   * @return array
   *   Returns array of objects.
   */
  public static function buildDataArray() {
    return [
      'patents' => [
        'awarded' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'pending' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'licensed' => [
          'current' => 0,
          'cumulative' => 0,
        ],
      ],
      'proposals' => [
        'submitted' => [
          'current' => [
            'number' => 0,
            'funds' => 0,
          ],
          'cumulative' => [
            'number' => 0,
            'funds' => 0,
          ],
        ],
        'awarded' => [
          'current' => [
            'number' => 0,
            'funds' => 0,
          ],
          'cumulative' => [
            'number' => 0,
            'funds' => 0,
          ],
        ],
        'pending' => [
          'current' => [
            'number' => 0,
            'funds' => 0,
          ],
          'cumulative' => [
            'number' => 0,
            'funds' => 0,
          ],
        ],
      ],
      'publications' => [
        'primary' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'partial' => [
          'current' => 0,
          'cumulative' => 0,
        ],
      ],
      'hired' => [
        'male' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'female' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'minority' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'disabled' => [
          'current' => 0,
          'cumulative' => 0,
        ],
      ],
      'post-doc' => [
        'male' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'female' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'minority' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'disabled' => [
          'current' => 0,
          'cumulative' => 0,
        ],
      ],
      'graduate' => [
        'male' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'female' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'minority' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'disabled' => [
          'current' => 0,
          'cumulative' => 0,
        ],
      ],
      'undergraduate' => [
        'male' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'female' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'minority' => [
          'current' => 0,
          'cumulative' => 0,
        ],
        'disabled' => [
          'current' => 0,
          'cumulative' => 0,
        ],
      ],
    ];
  }

  /**
   * Build array of IDs.
   *
   * @param string $type
   *   Type of node to filter by.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function getNodeIds($type) {
    $query = \Drupal::entityQuery('node')
      ->condition('type', $type)
      ->condition('status', 1);
    return $query->execute();
  }

  /**
   * Build patents data.
   *
   * @return array
   *   Array of node data.
   */
  public static function getPatents() {
    $ids = self::getNodeIds('ercore_patent');
    $nodes = [];
    $licensed = '';
    $pending = '';
    $awarded = '';
    foreach ($ids as $id) {
      $node = \Drupal::entityTypeManager()->getStorage('node')->load($id);
      if (!$node->get('field_ercore_pt_license')->isEmpty()) {
        $licensed_var = $node->get('field_ercore_pt_license')->value;
        $licensed = ErcoreStartDate::dateArgumentToUnix($licensed_var);
      }
      if (!$node->get('field_ercore_pt_award')->isEmpty()) {
        $awarded_var = $node->get('field_ercore_pt_award')->value;
        $awarded = ErcoreStartDate::dateArgumentToUnix($awarded_var);
      }
      if (!$node->get('field_ercore_pt_provisional')->isEmpty()) {
        $pending_var = $node->get('field_ercore_pt_provisional')->value;
        $pending = ErcoreStartDate::dateArgumentToUnix($pending_var);
      }
      $nodes[] = [
        'licensed' => $licensed,
        'awarded' => $awarded,
        'pending' => $pending,
      ];
    }
    return $nodes;
  }

  /**
   * Build proposals data.
   *
   * @return array
   *   Array of node data.
   */
  public static function getProposals() {
    $ids = self::getNodeIds('ercore_proposal');
    $nodes = [];
    $amount = 0;
    $pending = '';
    $submitted = '';
    $awarded = [
      'start' => '',
      'end' => '',
    ];
    $denied = FALSE;
    foreach ($ids as $id) {
      $node = \Drupal::entityTypeManager()->getStorage('node')->load($id);
      if (!$node->get('field_ercore_pp_award_start')->isEmpty()) {
        $start = $node->get('field_ercore_pp_award_start')->value;
        $awarded['start'] = ErcoreStartDate::dateArgumentToUnix($start);
        if (!$node->get('field_ercore_pp_award_end')->isEmpty()) {
          $end = $node->get('field_ercore_pp_award_end')->value;
          $awarded['end'] = ErcoreStartDate::dateArgumentToUnix($end);
        }
        if (!$node->get('field_ercore_pp_award_amount')->isEmpty()) {
          $amount = $node->get('field_ercore_pp_award_amount')->value;
        }
        if (!$node->get('field_ercore_pp_proposal_submit')->isEmpty()) {
          $submitted_var = $node->get('field_ercore_pp_proposal_submit')->value;
          $submitted = ErcoreStartDate::dateArgumentToUnix($submitted_var);
        }
        if (!$node->get('field_ercore_pp_proposal_pending')->isEmpty()) {
          $pending_var = $node->get('field_ercore_pp_proposal_pending')->value;
          $pending = ErcoreStartDate::dateArgumentToUnix($pending_var);
        }
        if (!$node->get('field_ercore_pp_proposal_denied')->isEmpty()) {
          $denied = TRUE;
        }
        $nodes[] = [
          'amount' => $amount,
          'submitted' => $submitted,
          'awarded' => $awarded,
          'pending' => $pending,
          'denied' => $denied,
        ];
      }
    }
    return $nodes;
  }

  /**
   * Build publications data.
   *
   * @return array
   *   Array of node data.
   */
  public static function getPublications() {
    $ids = self::getNodeIds('ercore_publication');
    $nodes = [];
    $published = '';
    $rii = '';
    foreach ($ids as $id) {
      $node = \Drupal::entityTypeManager()->getStorage('node')->load($id);
      if (!$node->get('field_ercore_pb_date')->isEmpty()) {
        $published_var = $node->get('field_ercore_pb_date')->value;
        $published = ErcoreStartDate::dateArgumentToUnix($published_var);
        if (!$node->get('field_ercore_pb_rii_support')->isEmpty()) {
          $rii = $node->get('field_ercore_pb_rii_support')->value;
        }
        $nodes[] = [
          'rii' => $rii,
          'published' => $published,
        ];
      }
    }
    return $nodes;
  }

  /**
   * Build Patents object.
   *
   * @param array $data
   *   Boolean to identify period or cumulative date range.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function filteredPatents(array $data) {
    $nodes = self::getPatents();
    foreach ($nodes as $node) {
      if (!empty($node['licensed'])) {
        $data['patents']['licensed']['current'] += self::outputDateFilter($node['licensed'], FALSE);
        $data['patents']['licensed']['cumulative'] += self::outputDateFilter($node['licensed'], TRUE);
      }
      if (!empty($node['awarded'])) {
        $data['patents']['awarded']['current'] += self::outputDateFilter($node['awarded'], FALSE);
        $data['patents']['awarded']['cumulative'] += self::outputDateFilter($node['awarded'], TRUE);
      }
      if (!empty($node['pending'])) {
        $data['patents']['pending']['current'] += self::outputDateFilter($node['pending'], FALSE);
        $data['patents']['pending']['cumulative'] += self::outputDateFilter($node['pending'], TRUE);
      }
    }
    return $data;
  }

  /**
   * Build Proposal object.
   *
   * @param array $data
   *   Boolean to identify period or cumulative date range.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function filteredProposals(array $data) {
    $nodes = self::getProposals();
    foreach ($nodes as $node) {
      if ($node['denied'] !== TRUE) {
        if (!empty($node['submitted'])) {
          if (self::outputDateFilter($node['submitted'], FALSE) === 1) {
            $data['proposals']['submitted']['current']['number']++;
            $data['proposals']['submitted']['current']['funds'] += $node['amount'];
          }
          if (self::outputDateFilter($node['submitted'], TRUE) === 1) {
            $data['proposals']['submitted']['cumulative']['number']++;
            $data['proposals']['submitted']['cumulative']['funds'] += $node['amount'];
          }
        }
        if (!empty($node['pending'])) {
          if (self::outputDateFilter($node['pending'], FALSE) === 1) {
            $data['proposals']['pending']['current']['number']++;
            $data['proposals']['pending']['current']['funds'] += $node['amount'];
          }
          if (self::outputDateFilter($node['pending'], TRUE) === 1) {
            $data['proposals']['pending']['cumulative']['number']++;
            $data['proposals']['pending']['cumulative']['funds'] += $node['amount'];
          }
        }
        if (!empty($node['awarded'])) {
          if (self::outputDateRangeFilter($node['awarded'], FALSE) === 1) {
            $data['proposals']['awarded']['current']['number']++;
            $data['proposals']['awarded']['current']['funds'] += $node['amount'];
          }
          if (self::outputDateRangeFilter($node['awarded'], TRUE) === 1) {
            $data['proposals']['awarded']['cumulative']['number']++;
            $data['proposals']['awarded']['cumulative']['funds'] += $node['amount'];
          }
        }
      }
    }
    return $data;
  }

  /**
   * Build Publications object.
   *
   * @param array $data
   *   Boolean to identify period or cumulative date range.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function filteredPublications(array $data) {
    $nodes = self::getPublications();
    foreach ($nodes as $node) {
      if ($node['rii'] === '0') {
        $data['publications']['primary']['current'] += self::outputDateFilter($node['published'], FALSE);
        $data['publications']['primary']['cumulative'] += self::outputDateFilter($node['published'], TRUE);
      }
      if ($node['rii'] === '1') {
        $data['publications']['partial']['current'] += self::outputDateFilter($node['published'], FALSE);
        $data['publications']['partial']['cumulative'] += self::outputDateFilter($node['published'], TRUE);
      }
    }
    return $data;
  }

  /**
   * Build Publications object.
   *
   * @param array $data
   *   Boolean to identify period or cumulative date range.
   * @param string $type
   *   Date value used to separate by graph.
   *
   * @return array
   *   Array of User IDs.
   */
  public static function filteredUsers(array $data, $type) {
    $users = ErcoreParticipantBuild::getUsers();
    foreach ($users as $user) {
      $filter_date = NULL;
      $dates = NULL;
      $count = FALSE;
      $count_c = FALSE;
      if ($type === 'post-doc') {
        if ($user['role'] === 'post-doc') {
          $dates = [
            'start' => $user['start'],
            'end' => $user['end'],
          ];
          if (self::outputDateRangeFilter($dates, FALSE) == 1) {
            $count = TRUE;
          }
          if (self::outputDateRangeFilter($dates, TRUE) == 1) {
            $count_c = TRUE;
          }
        }
      }
      else {
        if ($type === 'undergraduate' && $user['role'] === 'undergraduate') {
          $filter_date = $user[$type];
        }
        elseif ($type === 'hired' && ($user['role'] === 'faculty' || $user['role'] === 'post-doc')) {
          $filter_date = $user[$type];
        }
        elseif ($type === 'graduate' && ($user['role'] === 'graduate')) {
          $filter_date = $user['masters'];
          if (!empty($user['doctoral'])) {
            $filter_date = $user['doctoral'];
          }
        }
        if (!empty($filter_date)) {
          if (self::outputDateFilter($filter_date, FALSE) == 1) {
            $count = TRUE;
          }
          if (self::outputDateFilter($filter_date, TRUE) == 1) {
            $count_c = TRUE;
          }
        }
      }
      if ($count === TRUE || $count_c === TRUE) {
        $user_status = [
          'type' => $type,
          'name' => $user['name'],
          'current' => $count,
          'cumulative' => $count_c,
          'Male' => FALSE,
          'Female' => FALSE,
          'minority' => FALSE,
          'disabled' => FALSE,
        ];
        $in = [
          'American Indian or Alaskan Native',
          'Black or African American',
          'Pacific Islander',
          'Native Hawaiian',
        ];
        if (!empty($user['race']) && in_array($user['race'], $in)) {
          $user_status['minority'] = TRUE;
        }
        if (!empty($user['gender'])) {
          $user_status[$user['gender']] = TRUE;
        }
        if (!empty($user['disability']) && $user['disability'] !== 'None') {
          $user_status['disabled'] = TRUE;
        }
        $data[$type] = self::countUsers($data[$type], $user_status);
      }
    }
    return $data;
  }

  /**
   * Increment (count) users in data sub-arrays.
   *
   * @param array $typeArray
   *   Data array capturing data.
   * @param array $user
   *   User data array to use for counts.
   *
   * @return array
   *   Return modified array.
   */
  public static function countUsers(array $typeArray, array $user) {
    if ($user['current'] === TRUE) {
      if ($user['Male'] === TRUE) {
        $typeArray['male']['current']++;
      }
      elseif ($user['Female'] === TRUE) {
        $typeArray['female']['current']++;
      }
      if ($user['minority'] === TRUE) {
        $typeArray['minority']['current']++;
      }
      if ($user['disabled'] === TRUE) {
        $typeArray['disabled']['current']++;
      }
    }
    if ($user['cumulative'] === TRUE) {
      if ($user['Male'] === TRUE) {
        $typeArray['male']['cumulative']++;
      }
      elseif ($user['Female'] === TRUE) {
        $typeArray['female']['cumulative']++;
      }
      if ($user['minority'] === TRUE) {
        $typeArray['minority']['cumulative']++;
      }
      if ($user['disabled'] === TRUE) {
        $typeArray['disabled']['cumulative']++;
      }
    }
    return $typeArray;
  }

  /**
   * Filter Output Dates.
   *
   * @param int $date
   *   Date to be verified.
   * @param bool $cumulative
   *   Use cumulative dates or not.
   *
   * @return int
   *   Return status of date in range.
   */
  public static function outputDateFilter($date, $cumulative = FALSE) {
    $filter = ercore_get_filter_dates();
    if ($cumulative === TRUE) {
      $filter = ercore_get_cumulative_filter_dates();
    }
    if ($filter['start'] <= $date && $date <= $filter['end']) {
      return 1;
    }
    return 0;
  }

  /**
   * Filter Output Dates.
   *
   * @param array $dates
   *   Date to be verified.
   * @param bool $cumulative
   *   Use cumulative dates or not.
   *
   * @return int
   *   Return status of date in range.
   */
  public static function outputDateRangeFilter(array $dates, $cumulative = FALSE) {
    $filter = ercore_get_filter_dates();
    if ($cumulative === TRUE) {
      $filter = ercore_get_cumulative_filter_dates();
    }
    if (($dates['start'] <= $filter['end'] && $dates['end'] >= $filter['start'])
      || ($dates['start'] <= $filter['end'] && empty($dates['end']))
    ) {
      return 1;
    }
    return 0;
  }

  /**
   * Get processed data.
   */
  public static function getData() {
    $data = self::buildDataArray();
    $data = self::filteredPatents($data);
    $data = self::filteredProposals($data);
    $data = self::filteredPublications($data);
    $data = self::filteredUsers($data, 'hired');
    $data = self::filteredUsers($data, 'post-doc');
    $data = self::filteredUsers($data, 'graduate');
    $data = self::filteredUsers($data, 'undergraduate');
    return $data;
  }

}
