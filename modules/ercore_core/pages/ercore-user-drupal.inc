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
 * Our menu maps this function to the path 'ercore/guides/reporting'.
 */
function ercore_user_drupal() {
  $drupal = Link::fromTextAndUrl(
    'Drupal',
    Url::fromUri('http://drupal.org'))
    ->toString();
  $markup = "<dl>
<dt>Auto Complete</dt>
<dd>A field on a form that searches for data already in the database such as
a User's name.  If you were to start typing \"dav\" of David Kimball, matching
user names would be displayed in a list directly below the autocomplete field.
You may use your mouse or cursor to select one of the results.</dd>
<dd>Note: even though you can type in any string of text, unless there
is a match and you select it from the list, the form cannot be saved.
If you are searching for a name of someone who is a project member for example,
and the name does not appear, you may be misspelling the name, or that person
may not have an account.</dd>
<dt> Content</dt>
 <dd>Content refers to the information or data that Users input into Drupal
 through Forms.</dd>
 <dt> Content Type </dt>
 <dd>A content type is used to specify the different groups of content Drupal
 can collect. Examples of Content Types are ERCore Calendar Event,
 Collaboration, page, etc.</dd>
 <dt>Drupal</dt>";
  $markup .= "<dd>" . $drupal . ' ' . "is a free and open - source content
 management framework(CMF) written in PHP and distributed under the GNU General
 Public License.</dd>
 <dt>Module</dt>
 <dd>A module is a collection of files containing some functionality. They are
 written in PHP. They can be used to add functionality and access variables and
 structures of Drupal core or other modules.</dd>
 <dt>Custom Module </dt>
 <dd>A custom module is a Drupal Module that has not been adopted by the Drupal
 Association for general release. Typically custom modules are written for
 unique needs. At this time the ERCore module is a custom module, but it is
 being developed to be promoted to an approved Drupal module.</dd>
 <dt>Field</dt>
<dd>A Field is an element of a Form where data is entered. Fields can include
such items as Dates, Titles, text boxes, etc.</dd>
<dt>Form</dt>
<dd>A form is the web interface that allows Users to input information or data.
Each Content Type will have a form associated with it. The term form is
generic.</dd>
<dt>Node</dt>
<dd>A Node refers to the group of information or data that comes into the
database through a form. You might consider this another name for \"page\". If
you wanted to create an Event, the Event Node would be all the information that
the user can input through the Event form about that specific event. Each time
a new event is created it is assigned a unique Node ID, which is used to
differentiate Events or nodes. In the case of events, the database can collect
unlimited events, or event nodes, each one being unique, and just as Events
have nodes, so do each of the other Content Types.</dd>
<dt> Roles (Drupal)</dt>
<dd>Drupal Roles are groups of Users with respect to the web site and Drupal,
<strong>not EPSCoR</strong>. A Drupal role is defined by the site administrator
and represents a set of privileges given to users assigned that role. Typical
ERCore roles are Adminsitrator, EPSCoR Administrator, Faculty, Student,
Committee Member and Public.  This approach allows new Users to be assigned
appropriate access to the site quickly and confidently.
<em>NSF defined (EPSCoR) roles are different and often confused</em>.</dd>
<dt>User Profile </dt>
<dd>The User Profile is the data or information that is associated with a User.
It is in the User Profile where the User\'s real name, user name, password,
photo, roles, involvement, contact information, demographics, etc., is kept.</dd>
<dt>User Permissions</dt>
<dd>User permissions are the set of access or restrictions to the various
functions of the site.  For each content type one can define who can see,
edit, delete or create new and whether or not you need to be logged in or not
to do so.  User pernissions are grouped by roles to allow the site administrator
to quickly assign or restrict access to common types of users.</dd>
<dt>View</dt><dd>A display or grouping of data formatted and controlled by the
Drupal module \"Views\". A View may be a small portion of a page, an entire page,
or a group of pages. Exported data may be aggregated and prepared by a View.
</dd>
<dt>Widget</dt>
<dd>A widget is a generic term that describes items on a form that do a
specific function.  A common widget is the calendar widget.  The calendar widget
has	the fields for day, month and year, where you can enter that data manually
or you can click a day on a mini-calendar.</dd>
</dl>";
  return array(
    '#markup' => $markup,
  );
}
