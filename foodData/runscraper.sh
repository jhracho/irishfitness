#!/bin/bash

# Run Scraper
source ./venv/bin/activate;
python3 scraper.py;

# Scraper Cleanup
rm geckodriver.log;
deactivate;
killall -9 firefox;

# Update Database
chmod 664 todayNorth.csv todaySouth.csv;
php updateData.php;
