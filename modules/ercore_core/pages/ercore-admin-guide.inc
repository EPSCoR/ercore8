<?php

/**
 * @file
 * File for the ERCore Admin Guide Page.
 */

use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Constructs the epscor admin guide.
 */
function ercore_core_admin_guide() {
  $user_guide = link::createFromRoute(
    t('User Guide'),
    'ercore_core.ug1',
    array(),
    array())
    ->toString();
  $admin_config = link::createFromRoute(
    'administrative configuration page',
    'ercore_core.admin_settings_form',
    array(),
    array())
    ->toString();
  $phpexcel = Link::fromTextAndUrl(
    'PHPExcel',
    Url::fromUri('http://phpexcel.codeplex.com/releases/view/107442'))
    ->toString();
  $markup = [];
  $markup['copy1'] = "<p>" . t('This guide is aimed at site administrators and
  administrative staff. This document helps describe some of the internal
  features of ER Core, and how administrators may customize the Core to meet 
  jurisdictional needs. This document aims to describe the various tasks,
  views, operations, and procedures that an administrator may need to know about
  in order to properly administer the site.') . '</p><p>' . t('You may also be 
  interested in the more general') . ' ' . $user_guide . ' ' . t(' which talks 
  more about how researchers should enter data into the system.') . '</p>';
  $markup['heading1'] = '<h2>' . t('Post-Installation Guide/Jurisdictional Customizations')
    . '</h2>';
  $markup['copy2'] = '<p><strong>' . t('These are steps that should be taken
  immediately after installing the EPSCoR Reporting package. These 
  customizations will help make the system a better fit your jurisdiction.') .
    '</strong></p>';
  $markup['heading2'] = '<h3>' . t('Administrative settings') . '</h3>';
  $markup['copy2'] = '<p>' . t('Visit the') . ' ' . $admin_config . ' ' . t('for the
  ERCore module.') . '</p>';
  $markup['copy3'] = '<ol><li>' . t('Set the EPSCoR start date') . '</li><li>' .
  t('Set the Reporting period start month') . '</li><li>' .
  t('Input the EPSCoR Grant Number') . '</li><li>' .
  t('Select which data types to display on the Summary table') . '</li><li>' .
  t('Choose to use and/or require the Components field') . '</li><li>' .
  t('Choose to use and/or require the Programs field') . '</li></ol>';
  $markup['heading3'] = '<h3>' . t('Project Components') . '</h3>';
  $markup['copy4'] = '<p>' . t("If you're using the Components field, change the list of
  Project Components (Taxonomy) (which may also be known as \"teams\"). Use the
  \"Add term\" button to add a new component. This will present you with a form,
  which includes a checkbox labeled \"Core Component\", this checkbox denotes
  whether the component should show up on every component selection list, or
  just on the user profile's select list.") . '</p>';
  $markup['copy5'] = '<p>' . t('Ex. The "Administration" component is non-core, while
  "CYBER", "ENDER", "ECOGEM", and "DEW" are all core teams for Hawaii.') .
  '</p>';
  $markup['heading4'] = '<h3>' . t('Programs') . '</h3>';
  $markup['copy6'] = '<p>' . t("If you're using the Programs field, change the list of
  Programs (Taxonomy).  Use the \"Add term\" button to add a new component.") . '</p>';
  $markup['copy7'] = '<h3>' . t('Customize the list of ethnicities/races') . '</h3>';
  $markup['heading5'] = '<p>' . t('Modify the') . ' <strong>' . t('Ethnicity') . '</strong> '
  . t('Field that your jurisdiction will want to track and report on.') .
  '</p><p>' . t('Ex. In Hawaii we also provide options for: Filipino, Pacific
  Islander, and Native Hawaiian') . '</p>';
  $markup['heading6'] = '<h3>' . t('Committees/Advisory Boards') . '</h3>';
  $markup['copy7'] = '<p>' . t('Change the') . ' <strong>' . t('Boards and Committees 
  Field') . '</strong> ' . t('which oversee your EPSCoR grant.') . '</p><p>' .
  t('Ex. Hawaii has three advisory committees: Community Advisory Committee
  (CAC), Monitoring Assessment Panel (MAP), Statewide Committee (SWC)') .
  '</p>';
  $markup['heading7'] = '<h3>' . t('Institutions') . '</h3>';
  $markup['copy8'] = '<p>' . t('The reporting system needs to know certain information
  about the institutions being attached to users, or collaborations.  We need to
  know where the users come from, and what kind of institution it is in order to
  automatically fulfill certain NSF requirements.') . '</p><p>' . t('The system
  requires that you explicitly list the "Participating Institutions" (i.e. Those
  institutions which are participating in your EPSCoR grant), as well as any 
  institution which will be listed in a collaboration.') . '</p><p>' . t('This
  list will likely expand over time, but it is necessary to begin this process
  by setting up the most important institutions first.') . '</p><p>' . t('You
  can add a new institution to the system by going to the Add Content link, then
  selecting ERCore Institution.') . '</p><p>' . t('You may also see a list of
  institutions currently in the system through the Institutions page.') . '</p>';
  $markup['copy9'] = '<h3>' . t('Data Repository Managers') . '</h3>';
  $markup['copy10'] = '<p><strong>' . t('Notifications are not currently included in this
  version of ERCore.') . '</strong></p><p>' . t('After setting up user accounts
  for your administrators, you will be able to flag users whom should receive
  email notifications regarding researcher data collection events.') .
  '</p><p>' . t("We suggest that you create an account for your Data Repository
  Manager, then flag this person's account to receive the notifications. Other users
  may also be flagged to receive these notifications using the same procedure.")
  . '</p><p>' . t('In order to flag the user, you must first navigate to their
  user profile. You can find the user profile of someone in the system by
  navigating to the Participants page.') . '</p><p>' . t('Once viewing the
  user\'s profile, scroll to the bottom of the page, and locate the blue link
  labeled "Receive data collection notifications" and click on that link.') .
  '</p><p>' . t('The link should change it\'s label to say "Do not receive
  data collection
  notifications", which when clicked will remove the user from receiving these
  notifications.') . '</p>';
  $markup['heading8'] = '<h3>' . t('Setup Excel Sheet Output') . '</h3>';
  $markup['copy11'] = '<p>' . t('The system relies on an external library called') . ' '
  . $phpexcel . ' ' . t('to export various excel sheets. The Library must be
  downloaded, then uploaded to this server.') . '</p><p>' . t('The PHPExcel kit
  should first be downloaded and decompressed, and the contents should then be
  uploaded to the server directory') .
  '<code>/sites/all/libraries/PHPExcel/</code>, creating the
  <code>/libraries/PHPExcel/</code> directory if necessary.</p>';
  $markup['copy12'] = '<p>' . t('Once uploaded') . ' , <code>PHPExcel.php</code> ' .
  t('should be located at') .
  '<code>/sites/all/libraries/PHPExcel/Classes/PHPExcel.php</code>, the
   <code>IOFactory.php</code> should be located at
   <code>/sites/all/libraries/PHPExcel/Classes/PHPExcel/IOFactory.php</code>,
   and <code>changelog.txt</code> needs to be located at
   <code>/sites/all/libraries/PHPExcel/changelog.txt</code></p>';
  $markup['copy13'] = '<p>' . t('You can then navigate to the Drupal Status Report page
  to see if the library was detected.') . '</p>';
  $markup['heading9'] = '<h3>' . t('Customize the list of Event Types (Optional)') .
  '</h3>';
  $markup['copy14'] = '<p>' . t('Some states may wish to customize the') . ' <strong>' .
  t('Event Types Field') . '</strong> ' . t('which label calendar events.') .
  '</p>';
  $markup['heading10'] = '<h4>' . t('Notice: The available values should be of the form') .
  ':</h4>';
  $markup['copy15'] = '<p><code>#|Label</code>: ' . t('Where # is an integer value which
  is used as the internal representation (stored in the database), and Label is
  what is shown to the user.') . '</p>';
  $markup['heading11'] = '<h3>' . t('Public Profile settings (Optional)') . '</h3>';
  $markup['copy16'] = '<p>' . t('Some states may wish to hide the uer profiles from
  public view.') . '</p><p>' . t('This may be accomplished by changing the 
  "View user profiles" flag located on the User Permissions page.') . '</p>';
  return $markup;
}
