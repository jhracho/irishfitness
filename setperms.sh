#!/bin/bash
# Script to give proper permissions to all of a users files
echo "Changing directory permissions..."
find /var/www/html/cse30246/irishfitness -type d  -exec chmod 775 2> /dev/null {} + 
echo "Changing file permissions..."
find /var/www/html/cse30246/irishfitness -type f ! -name "setperms.sh" ! -name "geckodriver" ! -name "scraper.py" ! -name "runscraper.sh" -exec chmod 664 2> /dev/null {} +
echo "Changed perms for all of YOUR files."
