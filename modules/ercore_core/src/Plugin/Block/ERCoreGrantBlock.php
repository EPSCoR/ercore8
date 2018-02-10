<?php

namespace Drupal\ercore_core\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'ERCoreGrantBlock' block.
 *
 * @Block(
 *  id = "ercore_grant_block",
 *  admin_label = @Translation("ERCore Grant Block"),
 * )
 */
class ERCoreGrantBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $grant = \Drupal::config('ercore_core.adminsettings')->get('ercore_epscor_number');
    $build['ercore_grant_block_ercore_grant_number']['#markup'] = '<p class="grant">This material is based upon work supported by the National Science Foundation under Grant Number <em class="grant-number">' . $grant . '</em>.<br />
Any opinions, findings, and conclusions or recommendations expressed in this material are those of the author(s) and do not necessarily reflect the views of the National Science Foundation.</p>';

    return $build;
  }

}
