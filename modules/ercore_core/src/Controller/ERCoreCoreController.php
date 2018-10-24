<?php

namespace Drupal\ercore_core\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Controller routines for page example routes.
 */
class ERCoreCoreController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  protected function getModuleName() {
    return 'ercore_core';
  }

  /**
   * ERCore page.
   */
  public function ercore() {
    return ercore_core_submenu_tree_all_data('ercore_core.ercore');
  }

  /**
   * Administrative Actions page.
   */
  public function ercoreAdminActions() {
    $items = [
      '0' => [
        '#markup' => '<p>' . Link::fromTextAndUrl('Create New Institution', Url::fromUri('internal:/node/add/ercore_institution'))->toString() .
        ':<br />' . $this->t('This page allows administrators to add new institutions.') . '</p>',
      ],
      '1' => [
        '#markup' => '<p>' . Link::fromTextAndUrl('Create New User', Url::fromUri('internal:/admin/people/create'))->toString() .
        ':<br />' . $this->t('This page allows administrators to register new users.') . '</p>',
      ],
      '2' => [
        '#markup' => '<p>' . Link::fromTextAndUrl('ERCore Reporting Core Settings', Url::fromUri('internal:/admin/config/ercore/adminsettings'))->toString() .
        ':<br />' . $this->t('This area is specific to ERCore grant start dates as well as reporting period dates.') . '</p>',
      ],
    ];
    return ercore_core_format_general_list($items);
  }

  /**
   * ERCore Content page.
   */
  public function ercoreDataIntegrity() {
    return ercore_core_submenu_tree_all_data('ercore_core.data_integrity');
  }

  /**
   * ERCore Content page.
   */
  public function ercoreContent() {
    return ercore_core_submenu_tree_all_data('ercore_core.ercore_content');
  }

  /**
   * Participant Views.
   */
  public function ercoreViewsParticipant() {
    return ercore_core_submenu_tree_all_data('ercore_core.participant_views');
  }

  /**
   * Admin Views.
   */
  public function ercoreViewsAdmin() {
    return ercore_core_submenu_tree_all_data('ercore_core.admin_views');
  }

  /**
   * Admin Views.
   */
  public function ercoreUg() {
    return ercore_core_submenu_tree_all_data('ercore_core.ug1');
  }

  /**
   * User accounts page.
   */
  public function ercoreAccounts() {
    include_once drupal_get_path('module', 'ercore_core') . '/pages/ercore-user-guide.inc';
    return ercore_user_guide();
  }

  /**
   * User Entering Data page.
   */
  public function ercoreEntering() {
    include_once drupal_get_path('module', 'ercore_core') . '/pages/ercore-user-entering.inc';
    return ercore_user_entering();
  }

  /**
   * User Viewing Data page.
   */
  public function ercoreView() {
    include_once drupal_get_path('module', 'ercore_core') . '/pages/ercore-user-viewing.inc';
    return ercore_user_viewing();
  }

  /**
   * User Drupal page.
   */
  public function ercoreDrupal() {
    include_once drupal_get_path('module', 'ercore_core') . '/pages/ercore-user-drupal.inc';
    return ercore_user_drupal();
  }

  /**
   * User NSF page.
   */
  public function ercoreNsf() {
    include_once drupal_get_path('module', 'ercore_core') . '/pages/ercore-user-NSF.inc';
    return ercore_user_nsf();
  }

  /**
   * User Admin Guide page.
   */
  public function ercoreAdminGuide() {
    include_once drupal_get_path('module', 'ercore_core') . '/pages/ercore-admin-guide.inc';
    return ercore_core_admin_guide();
  }

}

/**
 * Get ERCore menu items for use on ERCore admin pages.
 *
 * @param int $min
 *   Receives min depth to use for menu.
 *
 * @return array
 *   Returns Menu Items.
 */
function ercore_core_get_menu_items($min) {
  $menu_data = ercore_core_get_menu($min);
  foreach ($menu_data['#items'] as $item) {
    if ($item['url']->getRouteName() == '') {
      $menu[] = [$item['title'] => $item['url']->getRouteName()];
    }
    else {
      $menu[] = [$item['title'] => $item['url']->getInternalPath()];
    }
  }
  return $menu;
}

/**
 * Get ERCore menu tree for use on ERCore admin pages.
 *
 * @param int $min
 *   Receives min depth to use for menu.
 *
 * @return array
 *   Return Menu array.
 */
function ercore_core_get_menu($min) {
  $menu_name = 'ercore-admin-menu';
  $parents = ['ercore_core.admin_views'];
  $menu_tree = \Drupal::menuTree();
  // Build the typical default set of menu tree parameters.
  $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);
  // Remove links above the current page.
  $parameters->setMinDepth($min);
  // Load the tree based on this set of parameters.
  $tree = $menu_tree->load($menu_name, $parameters);
  // Transform the tree using the manipulators you want.
  $manipulators = array(
    // Only show links that are accessible for the current user.
    array('callable' => 'menu.default_tree_manipulators:checkAccess'),
    // Use the default sorting of menu links.
    array('callable' => 'menu.default_tree_manipulators:generateIndexAndSort'),
  );
  $tree = $menu_tree->transform($tree, $manipulators);
  // Finally, build a renderable array from the transformed tree.
  $menu = $menu_tree->build($tree);
  return $menu;
}

/**
 * Get ERCore menu tree for use on ERCore admin pages.
 *
 * @param string $parent
 *   Receives string of parents menu ID.
 *
 * @return array
 *   Returns menu array.
 */
function ercore_core_submenu_tree_all_data($parent) {
  $menu_tree = \Drupal::menuTree();
  $menu_parent_tree = \Drupal::menuTree();
  $menu_name = 'ercore-admin-menu';

  // Build the typical default set of menu tree parameters.
  $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);

  // Get the parent of current menu so we can use its
  // children as the links.
  $parameters->setRoot($parent);
  $tree = $menu_parent_tree->load($menu_name, $parameters);

  // Transform the tree using the manipulators you want.
  $manipulators = array(
    // Only show links that are accessible for the current user.
    array('callable' => 'menu.default_tree_manipulators:checkAccess'),
    // Use the default sorting of menu links.
    array('callable' => 'menu.default_tree_manipulators:generateIndexAndSort'),
  );
  $tree = $menu_parent_tree->transform($tree, $manipulators);

  foreach ($tree as $key => $menu_item) {
    // Check if the link is the current page?
    $current_internal_path = $menu_item->link->getUrlObject()->toString();
    foreach ($menu_item->subtree as $sub_key => $sub_link) {
      $sub_internal_path = $sub_link->link->getUrlObject()->toString();

      if ($current_internal_path == $sub_internal_path) {
        unset($tree[$key]->subtree[$sub_key]);
      }

      // Check if we have another sub tree (we are not the parent). This can
      // happen when a parent
      // link is attached to the same node as a child one.
      if ($sub_link->subtree && count($sub_link->subtree)) {
        $lower_level_links = $sub_link->subtree;

        foreach ($lower_level_links as $lower_link_key => $lower_level_link) {
          $lower_level_url = $lower_level_link->link->getUrlObject()->toString();
          if ($sub_internal_path == $lower_level_url) {
            // Set the active menu level as this.
            $tree = array($sub_link);
          }
        }
      }
    }
  }
  $menu = $menu_tree->build($tree);
  $items = $menu['#items'][$parent]['below'];
  $menu_items = [];
  foreach ($items as $item) {
    $menu_items[] = [
      'title' => $item['title'],
      'url' => $item['url']->getInternalPath(),
    ];
  }
  return ercore_core_format_nav_list($menu_items);
}

/**
 * Formats a list of menu items receives.
 *
 * @param array $items
 *   Receives an array of menu items.
 *
 * @return array
 *   Return render array of menu.
 */
function ercore_core_format_nav_list(array $items) {
  $links = [];
  foreach ($items as $item) {
    $links[] = Link::fromTextAndUrl($item['title'], Url::fromUri('internal:/' . $item['url']))
      ->toString();
  }
  return [
    '#theme' => 'item_list',
    '#list_type' => 'ul',
    '#items' => $links,
    '#attributes' => [],
    '#wrapper_attributes' => ['class' => 'ercore_menu'],
  ];
}

/**
 * Formats a list of menu items receives.
 *
 * @param array $items
 *   Receives an array of menu items.
 *
 * @return array
 *   Return render array of menu.
 */
function ercore_core_format_general_list(array $items) {
  return [
    '#theme' => 'item_list',
    '#list_type' => 'ul',
    '#items' => $items,
    '#attributes' => [],
    '#wrapper_attributes' => ['class' => 'ercore_menu'],
  ];
}
