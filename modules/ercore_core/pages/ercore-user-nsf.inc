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
function ercore_user_nsf_callback() {
  return array(
    '#markup' =>
    t('<p>The following are a few key terms used in EPSCoR reporting, which may
or may not be defined by NSF, yet must be and have been defined by the ERCore
collaborative group in order for the Drupal ERCore to properly handle this data.
EPSCoR administrators must understand the ERCore criterion in order to have
confidence in the data and manage it properly.</p>
<dl>
<dt>Participant (NSF)</dt>
<dd>Participants are members of the project who contribute in an ongoing and
regular basis. They can be paid or unpaid and are involved in activities funded
by the project.</dd>
<dd>Note: in the absence of a formal NSF definition of a Participant
of EPSCoR, the ERCore Drupal Committee defines a Participant as:
	<ul><li>Needs to be housed at one of the partnering institutions as defined by
	the RII, and,</li>
	<li>Contribute equal to or greater than 160 hours (one person month) in a year
	(reporting period).</li>
	</ul>
</dd>
<dt>Participant (ERCore)</dt>
<dd>Once the user\'s account meets the following criteria, the system adds 1 to
the appropriate category in Table A - Participants. The criteria is:
	<ul>
  <li>User must be marked as Active </li>
  <li>User must have the "Authenticated EPSCoR" user role </li>
  <li>User must belong to a Participating Institution </li>
  <li>User must contribute at least 160 hours per year(1 person - month of
  effort)</li>
  </ul>
</dd>
<dt>Participating Institution (NSF) </dt>
<dd>Participating institutions are those institutions that receive direct
support from the RII award including sub - awards.</dd>
<dt>Participating Institution (ERCore)</dt>
<dd>Institution node must be marked as participating (checkbox, an
administrative function).  For each institution that has its "
<em>participating</em>" field checked, the system is then able to properly
place participants in Table A, by institution.</dd>
<dt>Collaboration (NSF)</dt>
<dd>NSF does not formally define what a collaboration is for EPSCoR.</dd>
<dd>Note: in the absence of a formal NSF definition of a collaboration
for EPSCoR, the ERCore Drupal Committee defines a collaboration as a set of
activities between a participating institution(s) and non-participating
institutions, organizations or agencies that lead to a definable outcome. In a
collaboration, each party contributes intellectually and brings complementary
capabilities and resources. Examples can include activities such as research
projects, outreach events, database development or web dissemination of
research data and results.</dd>
<dt>Collaboration (ERCore)</dt>
<dd>A collaboration is the composition of different internal and external
elements. Each of these elements have criteria that must be met. Once all the
required elements meet the criteria, a collaboration is established and a count
of 1 is added to Table C - Collaborations, regardless of how many EPSCoR
researchers participate in the collaboration. The following is a list of the
required elements for a collaboration:
	<ol>
	<li>Non-participating Institution (see above criteria to be counted as
	participating)</li>
  <li>Text fields that describe:
  	<ul>
  	<li>Title</li>
    <li>Description of work and contribution to the RII </li>
    <li>Start Date </li>
    <li>Name of at least one EPSCoR participant </li>
    <li>Name of at least one EPSCoR research component or project </li>
    <li>Names of collaborators (see definition of collaborator below)</li>
    <li>Department for each named collaborator </li></ul>
  </li></ol>
</li></dd>
<dt>Collaborator (Drupal Committee)</dt>
<dd>NSF does not formally define who a collaborator is for EPSCoR.</dd>
<dd>Note: in the absence of a formal NSF definition of who a collaborator is for
EPSCoR, the ERCore Drupal Committee defines a collaborator as a researcher,
faculty level or equivalent, who significantly contributes (intellectually,
labor) to the project less than 160 hrs/yr. A collaborator may or may not be
housed in a participating institution.</dd>
<dt> Collaborator (ERCore)</dt>
<dd>A collaborator contributes less than 160 hrs of effort during the (reporting
period) year. This value is set in the user profile within the Involvement tab.
A collaborator may or may not be housed at a participating institution.</dd>
<dd>Collaborator names are simply text fields and part of the Collaboration
Content Type, not formal roles assigned within a default installation of the
ERCore.  For each name that is listed as a collaborator in a completed
collaboration, the system counts 1 and adds that to Table C - Collaborations.</dd>
<dd>The default ERCore role options do not include a Collaborator Role. This is
left up to the jurisdiction. We suggest using the Guest Role to allow
collaborators access to the system.</dd>
<dt> New Investigator (NSF)</dt>
<dd>New investigators are those at the faculty, junior faculty, and post doc
level who are new to the RII project during the reporting period.</dd>
<dt> New Investigator (ERCore)</dt>
<dd>New Investigators are Participants assigned with Post Doc or Faculty roles
who\'s start date is less then 365 days from the most recent reporting period.
For each user who\'s profile meets the below criteria, the system counts 1
and adds it to Table B - Participants.</dd>
<dd>In order for the system to count a user as a new investigator, the
following criteria must be met:
	<ol>
  <li>Be an active system - defined participant </li>
  <li>Have the faculty or Post Doc role assigned </li>
  <li>Have the difference between the most recent reporting period and the
  user\'s start date be less than 365 days</li>
  </ol>
</dd>
<dt>Project Start Date (ERCore)</dt>
<dd>The start date is set by administration after the installation of the
ERCore in the <a href="/admin/config/ercore/admin">ERCore Reporting Module
Settings</a> page. This is also listed on the Drupal Configuration page.  It is
arbitrarily set and can be changed at any point.</dd>
<dt>Reporting Period (ERCore)</dt>
<dd>The Reporting Period uses the Year of the Start Date, plus a month
(arbitrarily set by site administration), and the first day of that month. The
Reporting Period starting month is set in the
<a href="/admin/config/ercore/admin">ERCore Reporting Module
Settings</a> page. The Reporting Period starting day is 1 and cannot be changed.
</dd></dl>'),
  );
}
