<?php

/**
 * @file
 * File for the ERCore Data Integrity.
 */

/**
 * Display ERCore data data integrity Views.
 *
 * @return array
 *   Returns form array for page display.
 */
function ercore_data_integrity_callback() {
  $form = array();
  $theme_variable = 'ercore_integrity';

  $form['table'] = array(
    '#theme' => "$theme_variable",
    '#prefix' => "<div id=\"$theme_variable\">",
    '#suffix' => '</div>',
  );
  return $form;
}

/**
 * This theme function (see theme.inc) generates the summary table.
 *
 * @return array
 *   Returns render array of results.
 */
function ercore_integrity() {
  $summary['event1'] = array(
    '#tag' => 'div',
    '#attributes' => array(
      'class' => 'data-wrapper',
      'id' => 'ercore_integrity_events1',
    ),
    '#value' => views_embed_view('ercore_integrity_events', 'panel_pane_1'),
    '#theme' => 'html_tag',
  );
  $summary['event2'] = array(
    '#tag' => 'div',
    '#attributes' => array(
      'class' => 'data-wrapper',
      'id' => 'ercore_integrity_events2',
    ),
    '#value' => views_embed_view('ercore_integrity_events', 'panel_pane_2'),
    '#theme' => 'html_tag',
  );
  $summary['proposal'] = array(
    '#tag' => 'div',
    '#attributes' => array(
      'class' => 'data-wrapper',
      'id' => 'ercore_integrity_proposals',
    ),
    '#value' => views_embed_view('ercore_integrity_proposals', 'panel_pane_1'),
    '#theme' => 'html_tag',
  );
  $summary['publications'] = array(
    '#tag' => 'div',
    '#attributes' => array(
      'class' => 'data-wrapper',
      'id' => 'ercore_integrity_publications',
    ),
    '#value' => views_embed_view('ercore_integrity_publications', 'panel_pane_1'),
    '#theme' => 'html_tag',
  );
  $duplicates = ercore_duplicates();
  if ($duplicates === '') {
    $duplicates = '<p>There appears to be no duplicate content.</p>';
  }
  $duplicates = '<div class="view-header"><h2>Possible Duplicate Content</h2></div>' . $duplicates;
  $summary['duplicates'] = array(
    '#tag' => 'div',
    '#attributes' => array(
      'class' => 'data-wrapper',
      'id' => 'ercore_integrity_duplicates',
    ),
    '#value' => $duplicates,
    '#theme' => 'html_tag',
  );

  return render($summary);
}

/**
 * Find duplicates based on title.
 */
function ercore_duplicates() {
  $duplicates = views_get_view_result('ercore_integrity_duplicate', 'panel_pane_1');
  $nids = array();
  foreach ($duplicates as $duplicate) {
    $type = $duplicate->node_type;
    $title = $duplicate->node_title;
    $query = new EntityFieldQuery();
    $entities = $query->entityCondition('entity_type', 'node')
      ->propertyCondition('type', $type)
      ->propertyCondition('title', $title)
      ->propertyCondition('status', 1)
      ->execute();

    if (!empty($entities['node'])) {
      foreach ($entities['node'] as $e_nodes) {
        $nids[] = $e_nodes->nid;
      }
    }
  }
  $nodes = node_load_multiple($nids);

  $type = 'ol';
  // The following attributes apply to the list tag (e.g.,  or ).
  $attributes = array(
    'id' => 'integrity_duplicates',
    // A string or indexed (string) array with the classes for the list tag.
    'class' => 'integrity',
  );

  $items = array();
  foreach ($nodes as $node) {
    $items[] = array(
      'data' => l($node->title, 'node/' . $node->nid),
    );
  }
  return theme('item_list', array(
    'items' => $items,
    'title' => NULL,
    'type' => $type,
    'attributes' => $attributes,
  )
  );

}
