ERCore

Installation:
1. Currently must be installed with Drupal 8.4.2
2. Drupal site must be set up with Composer. This is necessary to successfully
   install csv_serialization required library (league/csv). I've included a
   composer.json file for use with the installation. Not required, but may be
   helpful. Copy the composer.json file from ercore/development to one level 
   above the Drupal folder. Run `composer update` from there. 
3. Once the site is running, ERCore can be installed by installing the ERCore
   module. Other sub-modules will be installed by this process.