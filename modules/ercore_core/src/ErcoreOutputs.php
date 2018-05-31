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
      'new-hires' => [
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
  public static function filterPatents(array $data) {
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
  public static function filterProposals(array $data) {
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
  public static function filterPublications(array $data) {
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
   *
   * @return array
   *   Array of User IDs.
   */
  public static function filterUsers(array $data) {
    $users = ErcoreParticipantBuild::getUsers();
    foreach ($users as $user) {
      $hired = FALSE;
      $hired_c = FALSE;
      $dates = [
        'start' => $user['start'],
        'end' => $user['end'],
      ];
      $postdoc = FALSE;
      $postdoc_c = FALSE;
      if (!empty($user['role']) && $user['role'] === 'post-doc') {
        if (self::outputDateRangeFilter($dates, FALSE) == 1) {
          $postdoc = TRUE;
        }
        if (self::outputDateRangeFilter($dates, TRUE) == 1) {
          $postdoc_c = TRUE;
        }
      }
      $in = [
        'American Indian or Alaskan Native',
        'Black or African American',
        'Pacific Islander',
        'Native Hawaiian',
      ];
      $minority = FALSE;
      if (!empty($user['race']) && in_array($user['race'], $in)) {
        $minority = TRUE;
      }
      // Undergraduate.
      $under = FALSE;
      $under_c = FALSE;
      if (!empty($user['undergraduate'])) {
        if (self::outputDateFilter($user['undergraduate'], FALSE) === 1) {
          $under = TRUE;
          $under_c = TRUE;
        }
        elseif (self::outputDateFilter($user['undergraduate'], TRUE) === 1) {
          $under_c = TRUE;
        }
      }
      // Masters.
      $grad = FALSE;
      $grad_c = FALSE;
      if (!empty($user['masters'])) {
        if (self::outputDateFilter($user['masters'], FALSE) === 1) {
          $grad = TRUE;
          $grad_c = TRUE;
        }
        elseif (self::outputDateFilter($user['masters'], TRUE) === 1) {
          $grad_c = TRUE;
        }
      }
      // Doctoral - also graduate.
      if (!empty($user['doctoral'])) {
        if (self::outputDateFilter($user['doctoral'], FALSE) === 1) {
          $grad = TRUE;
          $grad_c = TRUE;
        }
        elseif (self::outputDateFilter($user['doctoral'], TRUE) === 1) {
          $grad_c = TRUE;
        }
      }
      // New hire.
      if (!empty($user['hired'])) {
        if (self::outputDateFilter($user['hired'], FALSE) === 1) {
          $hired = TRUE;
          $hired_c = TRUE;
        }
        elseif (self::outputDateFilter($user['hired'], TRUE) === 1) {
          $hired_c = TRUE;
        }
      }
      // Male.
      if ($user['gender'] === 'male') {
        if ($hired === TRUE) {
          $data['new-hires']['male']['current']++;
        }
        if ($hired_c === TRUE) {
          $data['new-hires']['male']['cumulative']++;
        }
        if ($under === TRUE) {
          $data['undergraduate']['male']['current']++;
        }
        if ($under_c === TRUE) {
          $data['undergraduate']['male']['cumulative']++;
        }
        if ($grad === TRUE) {
          $data['graduate']['male']['current']++;
        }
        if ($grad_c === TRUE) {
          $data['graduate']['male']['cumulative']++;
        }
        if ($postdoc === TRUE) {
          $data['post-doc']['male']['current']++;
        }
        if ($postdoc_c === TRUE) {
          $data['post-doc']['male']['cumulative']++;
        }
      }
      // Female.
      elseif ($user['gender'] === 'female') {
        if ($hired === TRUE) {
          $data['new-hires']['female']['current']++;
        }
        if ($hired_c === TRUE) {
          $data['new-hires']['female']['cumulative']++;
        }
        if ($under === TRUE) {
          $data['undergraduate']['female']['current']++;
        }
        if ($under_c === TRUE) {
          $data['undergraduate']['female']['cumulative']++;
        }
        if ($grad === TRUE) {
          $data['graduate']['female']['current']++;
        }
        if ($grad_c === TRUE) {
          $data['graduate']['female']['cumulative']++;
        }
        if ($postdoc === TRUE) {
          $data['post-doc']['female']['current']++;
        }
        if ($postdoc_c === TRUE) {
          $data['post-doc']['female']['cumulative']++;
        }
      }
      // Minority.
      if ($minority === TRUE) {
        if ($hired === TRUE) {
          $data['new-hires']['minority']['current']++;
        }
        if ($hired_c === TRUE) {
          $data['new-hires']['minority']['cumulative']++;
        }
        if ($under === TRUE) {
          $data['undergraduate']['minority']['current']++;
        }
        if ($under_c === TRUE) {
          $data['undergraduate']['minority']['cumulative']++;
        }
        if ($grad === TRUE) {
          $data['graduate']['minority']['current']++;
        }
        if ($grad_c === TRUE) {
          $data['graduate']['minority']['cumulative']++;
        }
        if ($postdoc === TRUE) {
          $data['post-doc']['minority']['current']++;
        }
        if ($postdoc_c === TRUE) {
          $data['post-doc']['minority']['cumulative']++;
        }
      }
      // Disabled.
      if (!empty($user['disabled']) && $user['disabled'] !== 'none') {
        if ($hired === TRUE) {
          $data['new-hires']['disabled']['current']++;
        }
        if ($hired_c === TRUE) {
          $data['new-hires']['disabled']['cumulative']++;
        }
        if ($under === TRUE) {
          $data['undergraduate']['disabled']['current']++;
        }
        if ($under_c === TRUE) {
          $data['undergraduate']['disabled']['cumulative']++;
        }
        if ($grad === TRUE) {
          $data['graduate']['disabled']['current']++;
        }
        if ($grad_c === TRUE) {
          $data['graduate']['disabled']['cumulative']++;
        }
        if ($postdoc === TRUE) {
          $data['post-doc']['disabled']['current']++;
        }
        if ($postdoc_c === TRUE) {
          $data['post-doc']['disabled']['cumulative']++;
        }
      }
    }
    return $data;
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
    $data = self::filterPatents($data);
    $data = self::filterProposals($data);
    $data = self::filterPublications($data);
    $data = self::filterUsers($data);
    return $data;
  }

}
