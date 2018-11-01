# ERCore
CONTENTS OF THIS FILE
---------------------

* Introduction
* Requirements
* Recommended Modules
* Installation
* Configuration
* Maintainers


INTRODUCTION
------------

This ERCore module adds the appropriate entity types and fields to track EPSCoR grant data. This module is intended to
build the base requirements for an EPSCoR data tracking site. Additional customization is expected.

 * More data about ERCore and EPSCoR:
  http://www.epscorreporting.com/ercore

 * The development community and customization modules are on GitHub:
  https://github.com/EPSCoR/


REQUIREMENTS
------------

This module requires no modules outside of Drupal core.


RECOMMENDED MODULES
-------------------

The Apache mod_rewrite module is required to support the project
enable/disable checkboxes on the Project Listing page. Use the project form to
change the status if mod_rewrite is not available.


INSTALLATION
------------

Install the ERCore module as you would normally install a contributed Drupal
module. Visit https://www.drupal.org/node/1897420 for further information.

Due to the complexity of the module, I'd recommend installing after a clean, Minimal install of Drupal. This will
require more modules to be installed, but doesn't clutter site with additional modules before you start.


CONFIGURATION
--------------

 * If the environment has limited memory or is otherwise slow, I would suggest enabling some of ERCore's dependencies
   before the primary module.
 * Navigate to Administration > Extend and enable:
    * ERCore (All modules) module
    * ERCore Summary Views
    * Features UI (Optional) Enable and verify that all aspects of ERCore Features are in sync
 * Navigate to Administration > Configuration > ERCore > Administrative Settings for Jurisdiction specific settings
 * Add Taxonomy terms: Components, Programs, and Boards and Commissions. These are required by other entities.
 * Add Institutions, which are required by users.
 * Add additional content.


MAINTAINERS
-----------

The 8.x branches were created by:

 * Douglas Tschetter (Tschet) - https://www.drupal.org/u/tschet

