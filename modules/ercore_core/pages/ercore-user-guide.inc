<?php

/**
 * @file
 * File for the ERCore Admin Guide Page.
 */

use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Constructs the epscor admin guide.
 *
 * Our menu maps this function to the path 'ercore/guide/accounts'.
 */
function ercore_user_guide() {
  $markup = "<h2>Introduction</h2>
<p>This guide has been developed for first time users of the EPSCoR Core
Reporting site (ERCore).  This site has been developed using Drupal 7, an
open-source content management system. Whether you are a developer, tester,
administrator or an end user, we all need to get familiar with Drupal first.
In addition, this guide also introduces important terms used by the NSF EPSCoR
program and how those terms are interpreted by the system.  This relationship
is important for system administrators to understand to be able to deliver
reporting data to NSF with confidence.</p><p>In general, most of the data
requested by this reporting system will be viewable by the public, but in order
to enter new, edit, or download the compiled tables you will need to have an
account and be logged in.</p>";
  $markup .= "<h2 id=\"request-account\">Request an Account</h2>
<ul>
<li>Select on the \"<em>Create new account</em>\" link located in the gray box at
the top left hand side of the home page. <strong>This varies by site.</strong>
</li>
<li>There are 4 fields that require information:
    <ol>
     <li>The name field is required. The title, generational, and credentials
     portions of this field are optional,</li>
		<li>Email: a unique email address for each individual</li>
		<li>Username: a unique value for each individual. This is not displayed.
		</li>
		<li>Participating Institution. If your institution is not on the list, talk
		to a site administrator.</li>
		<li>Department: The department field is optional, but can be helpful for
		grouping or differentiating people.</li>
		</ol>
</li>
<li>Click on Create New Account when you are done. This generates an email sent
to the Web Master who needs to approve the request. </li>
<li>An email will be sent when your account is approved</li>
</ul>";
  $markup .= "<h2 id=\"log-in\">Log In</h2>
<p>Once the Web Master has approved your account, an email will be sent to you.
In it will be directions to log in and include a link to visit the site.  In
this example we use the New Hampshire\'s development site.  In your web browser,
visit the URL to your jurisdiction\'s web site.  Your program administrator
needs to give this to you.</p>";
  $markup .= "<h2 id=\"user\">User Profile</h2>
<p>The system greatly depends on complete and accurate user data.  Please
complete all the fields presented to you in the user profile.  The final data
is only as good as the data you enter.</p>
<p>After you login you will be taken to your User Profile home page.  At any
point in time you need to get back to your user account, scroll to the top of
any page and look in the black menu bar for your user name.  It actually
says, \"<em>Hello (user)</em>\".  Click on your name and you will be taken to your
user account.</p>
<p>Near your user-name is a row of tabs. The most important of those are the View and
the Edit tabs.  Clicking either will give you that functionality (click Edit to
edit, and View to view your profile\'s content).</p>
<p>Below your photo (once you have uploaded one) is a block of horizontal tabs
of grouped information. The other tabs are Contact, Demographics, EPSCoR
Involvement,  Institution, and Data Collection.  Clicking on those tabs will
take you to that information.  Once in a View of our choice, clicking on Edit
will allow you to edit that content.</p>
<h3>Contact Information</h3>
<ol><li>Select on the \"<em>Hello (Your name)</em>\" link at the top right of any
page (after you are logged in)</li>
<li>Select on the Edit tab</li>
<li>Select on the Contact Information tab if you are not already there</li>
<li>The red asterisk after a field means that the data is required.  You will
not be able to save the form unless all required fields have been completed.</li>
<li>The name field may have been entered to create your account, but it can be
updated, and</li>
<li>Phone fields (mobile and work), Work Address and Professional Link are
optional fields.</li>
</ol>";
  $markup .= "<h3>Demographics</h3>
<p>NSF requires that we try to obtain demographic data for all our participants,
including those attending EPSCoR sponsored events.  Given such a requirement,
it is OPTIONAL to you if you want to submit it or not.  This data will be
encrypted and disassociated from your name.  Only the counts of the various
entries will be submitted to NSF.</p>
<ol>
<li>Select the appropriate radio buttons that best describes your demographics.
<br /><em>In the case where you have multiple disabilities, citizenships or
	races, select the one that best describes you.</em></li>
<li>Check the \"<em>I am a veteran</em>\" check box if you are a veteran</li></ol>
<h3>EPSCoR Involvement</h3>
<h4>Most Senior Project Role <em>(Required)</em></h4>
<ul><li>Select the one position type that best describes your involvement with
EPSCoR.  This list is defined by NSF Fast-lane. If a position type is not listed
that better defines your involvement, select the Other option.</li></ul>
<h4>EPSCoR Leadership Team <em>(Required)</em></h4>
<ul><li>Select the option that best fits your role.</li></ul>
<h4>Project Component(s) <em>(May be required or not present)</em></h4>
<p>Components are analogous to teams and are unique to each jurisdiction.
Components can easily be changed by an administrator or Drupal developer.</p>
<ul>
<li>Select the project component of which you are involved</li>
<li>Select multiple components if you are involved with more than one</li>
<li>If a component you are involved with is not listed, contact your
administrator</li></ul>";
  $markup .= "<h4>Program(s) <em>(May be required or not present)</em></h4>
<p>Programs can be projects, teams, or workign groups and will vary by
jurisdiction. Programs can easily be changed by an administrator or Drupal
developer.</p>
<ul>
<li>Select the program of which you are involved</li>
<li>Select multiple programs if you are involved with more than one</li>
<li>If a program you are involved with is not listed, contact your
administrator</li></ul>
<h4>Please select which boards or committees you will be a member of</h4>
<ul><li>Select one or multiple <em>(if applicable)</em></li></ul>
<h4>Participating Date</h4>
<ul><li>Enter the date you officially began participating with EPSCoR.</li></ul>
<h4>Hire Date</h4>
<ul><li>Enter the date that you were first hired by EPSCoR (if applicable). This
would be the date that you started getting paid.</li></ul>
<h3>Are you paid by the EPSCoR grant <em>(Required)</em></h3>
<ul><li>Select the option that best fits your role.</li>
<li>If yes, the option for Months of Direct Funding will appear. From the drop
down, select how many months of direct funding you receive. Round up or down to
the nearest month of funding you are expected to receive.</li></ul>";
  $markup .= "<h4>Do you participate in EPSCoR research more than 160 hours per year</h4>
<p>This ties into NSF Fast-lane and refers to whether or not you put in more
than 160 hours of effort in a year to this EPSCoR grant, whether you are paid
or not</p>
<ul>
<li>Select the appropriate radio button with respect to the number of hours you
participate in this EPSCoR grant in a year</li>
<li>If yes, please select the nearest person month of effort in EPSCoR</li>
<li>Select a number from the drop down box and round up or down to the nearest
month of funding you are expected to receive.</li></ul>
<h4>Please describe role and contribution to the project</h4>
<ul><li>Include information about what you are doing, in which projects, who you are
working with, location, dates and your contribution.</li></ul>
<h3>RCR - Responsible Conduct of Research</h3>
<ul><li>Select the \"<em>I have completed the RCR training</em>\" check box if you have taken
either in-person or on-line versions of the RCR training.</li></ul>
<ul>
<li>RCR In-Person: Enter the month, day and year of when you took the in-person
course</li>
<li>RCR In-Person Upload: Upload a txt, word or pdf of your certificate</li>
<li>RCR On-Line: Enter the date you took the RCR online training</li>
<li>RCR On-Line Upload: attach the txt, word or pdf of your online RCR
certificate</li></ul>
<h3>Institution</h3>
<ul><li>Select the radio button of the institution you are affiliated with.</li></ul>
<p>Department: Enter in the name of the department for which you are
affiliated</p>
<h3>Data Collection</h3>
<p>Check the \"<em>I plan to be collecting data through my research</em>\" check
box if you anticipate collecting data as a result of your research.</p>
<p>Has this user been put in touch with the Data Manager?: Check the
appropriate button for your situation.  This will send notices to the
EPSCoR administrator as well as the data repository manager.</p>";
  $markup .= "<h3>Account Information</h3>
<ol>
<li>Username: The system user name is determined by the website administrator
upon account creation. This is a required field </li>
<li>Current Password: This is your current (non-visible) password and can be
reset by clicking on the \"<em>Request new password</em>\" link near your Current
password field or by entering a new Password in the two fields below your E-mail
address. <strong>Some jurisdictions may block this setting.</strong></li>
<li>E-mail address: This will need to be A valid e-mail address. All e-mails
from the system will be sent to this address. The e-mail address is not made
public and will only be used if you wish to receive a new password or wish to
receive certain news or notifications by e-mail.  This is a required field.</li>
<li>Status:  This determines whether or not you or a user can login to the
system.  Leave it Active.</li>
<li>Roles:  These roles are the technical Drupal roles created to designate who
can see or access what.  Different from Involvement, which is the role or hat
one wears with respect to their participation within EPSCoR.  It is strongly
recommended that EPSCoR staff review the Roles and Permissions page to suit
your needs at your local area. Below is what is provided in the default EPSCoR
Reporting Core module. The standard roles are as follows:
	<ul>
  <li>Anonymous User:  This role is used for users that don\'t have a user
  account or that are not authenticated.</li>
	<li>Authenticated user:  This role is automatically granted to all logged
	in users(simply means that you have an account in Drupal). </li>
  <li>Guest: Very limited role with access to view ERCore module functionality
  only. </li>
  <li>Student:  Identical to Faculty out - of - the - box. An important
  designation technically, but left up to the jurisdiction to further restrict
  or grant access to specific areas.</li>
  <li>Faculty:  A subset of EPSCoR Administrator generally restricting the
  ability to edit other\'s content</li>
	<li>Administrator Staff: A subset of Site Administrator and EPSCoR
	Administrator, restricting access to the more technical aspects of Drupal and
	EPSCoR reporting</li>
 	<li>Administrator: Access to any and all Drupal capabilities</li></ul>
</li></ol>";
  $markup .= "<h3>Administrative Overlay</h3>
<p>Disregard this option if you see it.</p>
<h3>Upload a photo</h3>
<p>Click on the Choose file button to browse and upload a photo.</p>
<h3>Locale Settings</h3>
<p>Select your locale setting. This will configure Drupal to show date and time
to your location.</p>
<h3>Save</h3>
<p>Click the Save button when you are done. If any required fields are
incorrectly or not answered, an error message will be displayed at the top of
the page. Read it and address the issue.  If for some reason you cannot address
the issue, call your EPSCoR administrator or your Drupal web site manager for
help.</p>";
  return array(
    '#markup' => $markup,
  );
}
