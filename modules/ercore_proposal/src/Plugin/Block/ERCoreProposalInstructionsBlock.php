<?php

namespace Drupal\ercore_proposal\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'ERCoreProposalInstructionsBlock' block.
 *
 * @Block(
 *  id = "ercore_proposal_instructions_block",
 *  admin_label = @Translation("ERCore Proposal instructions block"),
 * )
 */
class ERCoreProposalInstructionsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['ercore_proposal_instructions_block']['#markup'] = '<h2>Instructions:</h2><p>Please report on all your Current, Pending, and Denied Support grant efforts in your pipeline starting from your initial participating start date. Do not list this EPSCoR grant, but include all proposals, regardless of funding source or success (include all proposals you have submitted, including denied proposals). Identify the PI and Co-PI, then list the other EPSCoR faculty or faculty equivalent. Do not list Post-Docs, Grad Students, Undergrads, Techs, etc.. Use this form once for each grant effort. ONE (grant) entry is needed per grant regardless of how many EPSCoR researchers are listed on the grant.</p>';

    return $build;
  }

}
