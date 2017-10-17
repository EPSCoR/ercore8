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
  public function defaultConfiguration() {
    return [
      'ercore_grant_number' => $this->t(''),
    ] + parent::defaultConfiguration();

  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['ercore_grant_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ERCore Grant Number'),
      '#description' => $this->t(''),
      '#default_value' => $this->configuration['ercore_grant_number'],
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['ercore_grant_number'] = $form_state->getValue('ercore_grant_number');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['ercore_grant_block_ercore_grant_number']['#markup'] = '<p class="grant">This material is based upon work supported by the National Science Foundation under Grant Number <em class="grant-number">' . $this->configuration['ercore_grant_number'] . '</em>.<br />
Any opinions, findings, and conclusions or recommendations expressed in this material are those of the author(s) and do not necessarily reflect the views of the National Science Foundation.</p>';

    return $build;
  }

}
