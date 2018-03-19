<?php

/**
 * @file
 * Contains \Drupal\ercore_core\Plugin\Block\ERCoreFilterBlock.
 */

namespace Drupal\ercore_core\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides an ERCore Filter block.
 *
 * @Block(
 *   id = "ercore_filter_block",
 *   admin_label = @Translation("ERCore Filter Block"),
 *   category = @Translation("Used for filtering forms.")
 * )
 */
class ERCoreFilterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\ercore_core\Form\ERCoreDateFilter');
    return $form;
  }
}