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
  $user_guide_url = url::createFromRoute('ercore_core.ug1', array(), array());
  return array(
    '#markup' =>
    t('<p>This guide is aimed at site administrators and administrative staff.
This document helps describe some of the internal features of ER Core, and how
administrators may customize the Core to meet jurisdictional needs. This
document aims to describe the various tasks, views, operations, and procedures
that an administrator may need to know about in order to properly administer the
site.</p><p>You may also be interested in the more general
<a href="@user_guide">ESCoR User Guide</a> which talks more about how
researchers should enter data into the system.</p>
  <h2>Post-Installation Guide/Jurisdictional Customizations</h2>
    <p><strong>These are steps that should be taken immediately after installing
    the EPSCoR Reporting package. These customizations will help make the system
    a better fit your jurisdiction.</strong></p>
    <h3>Administrative settings</h3>
    <p>Visit the <a href = "/admin/config/ercore/admin">administrative
    configuration page</a> for the ERCore module.</p>
    <ol><li>Set the EPSCoR start date</li>
    <li>Set the Reporting period start month</li>
    <li>Input the EPSCoR Grant Number</li>
    <li>Select which data types to display on the Summary table</li>
    <li>Choose to use and/or require the Components field</li>
    <li>Choose to use and/or require the Programs field</li></ol>
    <h3>Project Components</h3>
     <p>If you\'re using the Components field, change the list of Project
     Components (Taxonomy) (which may also be known as "teams").  Use the
     "Add term" button to add a new component. This will present you with a
     form, which includes a checkbox labeled "Core Component", this checkbox
     denotes whether the component should show up on every component selection
     list, or just on the user profile\'s select list.</p>
     <p>Ex. The "Administration" component is non-core, while "CYBER", "ENDER",
     "ECOGEM", and "DEW" are all core teams for Hawaii.</p>
     <h3>Programs</h3>
     <p>If you\'re using the Programs field, change the list of Programs
     (Taxonomy).  Use the "Add term" button to add a new component.</p>
      <h3>Customize the list of ethnicities/races</h3>
        <p>Modify the <strong>Ethnicity</strong> Field that your jurisdiction
        will want to track and report on.</p>
        <p>Ex. In Hawaii we also provide options for: Filipino, Pacific
        Islander, and Native Hawaiian</p>
  <h3>Committees/Advisory Boards</h3>
  <p>Change the <strong>Boards and Committees Field</strong> which oversee your
  EPSCoR grant.</p>
  <p>Ex. Hawaii has three advisory committees: Community Advisory Committee
  (CAC), Monitoring Assessment Panel (MAP), Statewide Committee (SWC)</p>
  <h3>Institutions</h3>
  <p>The reporting system needs to know certain information about the
  institutions being attached to users, or collaborations.  We need to know
  where the users come from, and what kind of institution it is in order to
  automatically fulfill certain NSF requirements.</p>
  <p>The system requires that you explicitly list the "Participating
  Institutions" (i.e. Those institutions which are participating in your EPSCoR
  grant), as well as any institution which will be listed in a collaboration.
  </p>
  <p>This list will likely expand over time, but it is necessary to begin this
  process by setting up the most important institutions first.</p>
  <p>You can add a new institution to the system by going to the Add Content
  link, then selecting ERCore Institution.</p>
  <p>You may also see a list of institutions currently in the system through
  the Institutions page.</p>
  <h3>Data Repository Managers</h3>
  <p><strong>Notifications are not currently included in this version of
  ERCore.</strong></p>
  <p>After setting up user accounts for your administrators, you will be able
  to flag users whom should receive email notifications regarding researcher
  data collection events.</p>
  <p>We suggest that you create an account for your Data Repository Manager,
  then flag this person\'s account to receive the notifications. Other users
  may also be flagged to receive these notifications using the same procedure.
  </p>
   <p>In order to flag the user, you must first navigate to their user profile.
   You can find the user profile of someone in the system by navigating to the
   Participants page.</p>
   <p>Once viewing the user\'s profile, scroll to the bottom of the page, and
   locate the blue link labeled "Receive data collection notifications" and
   click on that link.</p>
   <p>The link should change it\'s label to say "Do not receive data collection
   notifications", which when clicked will remove the user from recieving these
   notifications.</p>

  <h3>Setup Excel Sheet Output</h3>
  <p>The system relies on an external library called
  <a href="http://phpexcel.codeplex.com/releases/view/107442">PHPExcel</a> to
  export various excel sheets. The Library must be downloaded, then uploaded to
  this server.</p>
  <p>The PHPExcel kit should first be downloaded and decompressed, and the
  contents should then be uploaded to the server directory
  <code>/sites/all/libraries/PHPExcel/</code>, creating the
  <code>/libraries/PHPExcel/</code> directory if necessary.</p>
   <p>Once uploaded, <code>PHPExcel.php</code> should be located at
   <code>/sites/all/libraries/PHPExcel/Classes/PHPExcel.php</code>, the
   <code>IOFactory.php</code> should be located at
   <code>/sites/all/libraries/PHPExcel/Classes/PHPExcel/IOFactory.php</code>,
   and <code>changelog.txt</code> needs to be located at
   <code>/sites/all/libraries/PHPExcel/changelog.txt</code></p>
    <p>You can then navigate to the Drupal Status Report page to see if the
    library was detected.</p>
  <h3>Customize the list of Event Types (Optional)</h3>
  <p>Some states may wish to customize the <strong>Event Types Field</strong>
  which label calendar events.</p>
  <h4>Notice: The available values should be of the form:</h4>
   <p><code>#|Label</code>: Where # is an integer value
   which is used as the internal representation (stored in the database), and
   Label is what is shown to the user.
  </p>
 <h3>Public Profile settings (Optional)</h3>
  <p>Some states may wish to hide the uer profiles from public view.</p>
   <p>This may be accomplished by changing the "View user profiles" flag located
   on the User Permissions page.</p>', ['@user_guide' => $user_guide_url]),
  );
}
