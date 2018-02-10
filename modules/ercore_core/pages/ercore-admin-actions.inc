<?php
/**
 * @file
 * File for the ERCore Admin Actions.
 */

/**
 * Constructs the epscor admin guide.
 *
 * Our menu maps this function to the path 'epscor/admin-guide'.
 */
function ercore_admin_guide_callback() {
  return array(
    '#markup' =>
    t('<p>Admin Actions</p>'),
  );
}
