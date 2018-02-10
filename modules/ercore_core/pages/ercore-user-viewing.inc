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
function ercore_user_viewing_callback() {
  return array(
    '#markup' =>
    t('<ul>
<li>After logging in, the default ERCore installation will show an ERCore
administrative menu. This guide is written assuming it is visible. Each
jurisdiction will have the option to change the layout of the site and how menus
look and are placed.  This guide is written with the assumption that you are
working with a default installation.</li>
<li>One link on that ERCore menu should be to
<a href="/ercore/content">ERCore Content</a>. This page will display a list of
available ERCore content types.</li>
<li>Once you have selected the type of content you wish to view, you will be
directed to a page displaying a list of all content
of the appropriate type well as giving you filtering options.</li>
<li>If you wish to download the reporting data in Excel format, <em>and have
the appropriate permissions</em>, you will find a link on the bottom of the page
that reads "Download <em>Type of content</em>". Selecting the download link
will begin the download.</li>
</ul>
<h2 id="editing-data">Editing Reporting Data</h2>
<p>Make sure you are logged into the website and have the appropriate
permissions to edit data. Use the ERCore menu to find the appropriate content
to edit.</p>
<p>Once the content to edit has been located, select the title to view the
specific page.  Then select the "<em>Edit</em>" tab. (<em>This is often
underneath the title.</em>) This will open the node edit form and allow you to
make changes. When you are done with your changes, save them by selecting the
save button at the bottom of the page.</p>'),
  );
}
