<?php
/**
 * @file
 * File for the ERCore Admin Guide Page.
 */

/**
 * Constructs the epscor admin guide.
 *
 * Our menu maps this function to the path 'ercore/guides/reporting'.
 */
function ercore_user_reporting_callback() {
  return array(
    '#markup' =>
    t('<p>This guide is written with the assumption that you are working with a
default ERCore installation. Logged in users will see a black menu across the
top of the browser, just under the tabs of the browser. This is a Drupal user
menu.  The default ERCore installation will show this administrative menu and
this guide is written assuming it is visible. Each jurisdiction will have the
option to change the layout of the site and how menus look and are placed.</p>
<p>Placement of the ERCore specific menu will vary by site, but it will likely
be prominently placed. This guide is written assuming that this menu is also
visible</p>
<p>The content link will be one of the first listed in the Drupal admin menu.
If yo view tis page, there will be a priminent link near the top titled "Add
content". following that link will take you to a page where you will see a list
 of various types of content you can add grouped into the headings of ERCore,
 Ercore Jurisdictional, and Drupal.</p>
<dl>
<dt>ERCore</dt><dd>The content types that come with the ERCore
module and represent the minimal reporting requirements to populate the
reporting tables.</dd>
<dt>ERCore Jurisdictional</dt><dd>Includes items that are optional or custom to
that jurisdiction.</dd>
<dt>Drupal Content</dt><dd>The type of content that Drupal comes with during a
standard installation such as article, page, blog, image, etc. Your jurisdiction
can add or remove items from this group.</dd></dl>
<p><em>Specific fields and configuration in each content type may vary by
jurisdiction.</em></p>
<h2 id = "ercore-event">Calendar Events</h2>
<p>The general process is to enter a calendar event and denote
whether or not the event will be attended or not by the public. If it is, then
the external engagement form will be made available after the event has passed
in time. To get to the external engagement form you visit the calendar event and
look for the external engagement link down near the bottom(specific steps
outlined below).</p>
<p>A Calendar Event(node) is the typical data that represents an event.
The External Engagement data is linked to a specific Calendar Event when
the event will be attended by non - EPSCoR participants and includes the counts
by demographic breakout of the public that attended the event.</p>
<h3>To create a Calendar Event:</h3>
<ul>
<li>Find the "<em>ERCore Calendar Event</em>" link from the Create Content page.
</li>
<li>Title: Enter the title of the event</li>
<li>Date:  Enter the date of the event
	<ul>
	<li>Show End Date:  Click the Show End Date box if you want to designate
	this event with an ending period or time.
	<li>Click the Repeat box if this event recurs on a regular schedule</li></ul>
</li>
<li>EPSCoR Organizers:  Select the point of contact or organizer for this event.
This person must be an EPSCoR participant (registered in the system).</li>
<li>Event Type:  Select from the drop down list the type of event this will be.
</li>
<li>Program:  Select from the drop down list the program associated with this
event.</li>
<li>URL:  enter the link to the event if it is represented by another web site
</li>
<li>Will this event be attended by non-EPSCoR participants:  Select
the appropriate radio button. Selecting "Yes" will allow for External Engagement
data to be added to this event. <em>External Engagement data will be discussed
in detail later in this document</em></li>
<li>Abstract or Short Description:  write a short description or abstract of the
event.
<li>Attach Document(s): select "Choose File" to attach a flier or additional
file for the event.</li>
<li>Location/Address:  Enter the address of the event if there is one</li>
<li>Building (Room Number):  Enter the building and room number if there is one
</li>
<li>Save:  Click Save when you are done.</li></ul>
<h2 id = "ercore-collaboration">Collaborations</h2>
<p>There are three steps needed to accurately report on a collaboration. The
first step is to describe the collaboration.</p>
<ol><li>Describe the Collaboration: give the collaboration a title, assign the
relevant dates, and provide a description of the effort.</li>
<li>Select Internal Collaborators from the autocomplete field</li>
<li>Select External Collaborators with associated Institution information as
needed.</li></ol>
<h3>Creating a Collaboration</h3>
<ul>
<li>Select <em>ERCore Collaboration</em> from the Add Content page.</li>
<li>Title: Some of the activities under the collaboration definition we
provided above may not have a clearly defined "<em>title</em>". Nevertheless,
we ask that you provide some kind of semi-descriptive title that will be
used in reference to the collaborative effort, e. g. "<em>Visualization and
Scientific Computation</em>", "<em>Survey of Statewide K-12 STEM Programs
</em>", "<em>Wentworth Core Genetic Facility</em>", and so on.</li>
<li>Components: are meant to describe a certain branch, component, team, or
department within your EPSCoR jurisdiction. This list is populated by the
administrator running your site, and will therefore be specific to your
EPSCoR jurisdiction(or "<em>Project</em>"). Select the components that this
collaborative activity falls under.</li>
<li>Dates: Please provide the dates during which the collaboration took place.
If the collaboration is still active, simply do not provide the "<em>end</em>"
date.</li>
<li>Description: Please provide a brief summary of the collaborative effort,
the general roles of the people involved, and any other relevant contextual
information. Address why you are engaged with the individuals at the other
institutions and how their expertise enhances or benefits your EPSCoR
efforts.</li>
<li>EPSCoR Collaorator(s) is a field that allows you to select people that are
within your EPSCoR system. These are internal collaborators. Multiple
collaborators can be added by using the "<em>Add another item</em> button that
follows the field.</li>
<li>External Collaborators is a compound field that will ask for three values
for each external collaborator. Multiple collaborators can be added by using the
"<em>Add another item</em> button that follow the field.
	<ol>
	<li>Name: Provide the full name of the individual. This should be the name of
	a person, and not a location, place, establishment, etc.</li>
	<li>Institution: Please select the institution that the person was working
	from during the collaboration. A person may belong to several institutions,
	and may collaborate from one of many. Select the institution that is
	appropriate for this collaboration. <em>If you are looking for an institution
	but not finding it on the list, select the "<em>New Content</em>" link
	following the Institution field.</em> This will allow you to add a new
	institution and then return you to your collaboration page to complete
	the form.</li>
	<li>Institution Department/Unit: We provide you with the option of including
	the Department that the person is collaborating from. Please note that the
	system counts two different departments from the same University to be two
	distinct "<em>institutions</em>" (as defined by NSF). This plays a part in
	how we count up the collaboration information in our reports to NSF.</li></ol>
</li>
<li>Program:  Select from the drop down list the program associated with this
event.</li></ul>

<h2 id="ercore-engagement">External Engagements</h2>
<p>If you selected the "<em>This event will be attended by non-EPSCoR
attendees</em>" radio button, this event is elligable to accept External
Engagement data. After the event date has passed, an "<em>Add External
Engagement</em>" link will be available on the bottom of the event page.</p>
<h3>There are two options to add external engagement attendee data</h3>
<ol>
<li>Upload a completed Excel sheet: Perhaps the easiest method to attach External
Engagement data to an event is to use the Upload a completed Excel Sheet method.
	<ul>
	<li>Select "<em>Upload Completed Excel Sheet</em>" and that area of the page
	will expand. Download the External Engagement Reporting Sheet and fill out
	the data at your event. Once the sheet is completed you may then upload the
	Excel sheet below, and the system will do the rest.</li>
	<li>After you have uploaded your completed excel sheet you may skip the
	"<em>Enter Attendee Figures Manually</em>" section.</li>
	</ul>
</li>
<li>Select "<em>Enter Attendee Figures Manually</em>" and that area of the page
	will expand.
	<ul>
	<li>Open the various sections and enter data for the appropriate
	categories</li>
	<li>Values are estimated:  Select this value to indicate that
	the counts being entered are estimated by the POC.</li></ul>
</li></ol>
<h2 id="ercore-proposal">Proposals and Grants</h2>
<ul>
<li>Choose the "<em>ERCore Grants and Proposals</em>" from the Add Content
page.:
	<ul>
	<li>Note 1:  Do not enter data to represent the EPSCoR grant, but all other
	grants are required regardless of funding agency or amounts</li>
	<li>Note 2:  NSF also requires that you enter data on grants that have been
	declined while you are an EPSCoR participant.</li></ul>
</li>
<li>Title:  Enter the official title of the grant</li>
<li>EPSCoR Participants listed on the Grant:  Enter the names of all the
EPSCoR participants listed on the grant.  This is a look-up field.  Start
typing in the first or last name of the participant and give the little
blue wheel a chance to search the database.  If the name does not appear in
the drop down choices, try again using the other name.  If it still does not
appear, that person is NOT has not registered with the EPSCoR web site and
needs to do so.  In the meanwhile, you can enter that participant\'s name in
the Non - EPSCoR Participants section directly below.</li>
<li>Non - EPSCoR Participants listed on the Grant:  List all the other
non-EPSCoR participants on the grant in this section. Please note that this
representation of the grant is for internal reporting purposes. We do not
need to know who is the PI on record, hence we don\'t ask for that
designation.</li>
<li>Salary Support:  If ANY EPSCoR members listed on the grant receive
salary support from this grant, check the appropriate radio button</li>
<li>Source of Support:  Enter the name of the funding agency</li>
<li>Please Categorize the nature of the Source of Support:  Select one of
the 3 choices
	<ol>
	<li>Other NSF:  key word "other".  Do not list this NSF EPSCoR grant.
	List all other NSF grants you may have.</li>
	<li>Other Gov:  List all other federally funded grants you may have</li>
	<li>Other:  List all other grants not federally funded (state, local,
	university, private, etc.)</li></ol>
</li>
<li>Amount Requested:  Enter the original amount requested.</li>
<li>Status:  Select the appropriate status of the grant.
	<ul>
	<li>Pending:  If you select Pending, please enter the Date of Pending
	Notification</li></ul>
</li>
<li>Date Submitted:  Enter the date you submitted the grant</li>
<li>Location:  Enter the primary location of where the research will be
conducted.</li>
<li>Brief Description of Proposed Work:  Enter the summary or the abstract
of the Proposed work to be done for that grant.</li>
<li>Save:  Click the Save button to save your work.  This form will not be
able to be partially completed.  All required fields are necessary to be
completed in order form to be saved.</li>
<li>If you are the only researcher listed on the grant, and you do not
receive salary support from this grant, you are done and do not need to
proceed to step 2.</li>
<li>Program:  Select from the drop down list the program associated with this
event.</li></ul>

<h2 id="other-cts">Highlights, Institutions, Other
Research Products, Patents, Presentations, Publications</h2>
<p>These content types share signficant functionality and the instructions have
been combined below.</p>
<ol>
<li>Select the appropriate content type from the "<em>Add Content</em>" page.
</li>
<li>Title: Enter the title</li>
<li>EPSCoR Participants:  use the auto look-up to attach EPSCoR Participants</li>
<li>Date:  Enter the year, month and date as appropriate</li>
<li>Description:  enter a short description of the data content at hand</li>
<li>Other, data category-specific fields:  the fields will vary for the
different data categories.  Fill them out as appropriate.  Some will be
required. Other fields will not be required but please remember that more
information is better and that the data will only be as good as the data
you enter.</li>
<li>Save:  Select save when data entry is complete.</li>
</ol>'),
  );
}
