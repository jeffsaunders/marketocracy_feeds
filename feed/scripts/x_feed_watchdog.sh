#!/bin/bash
##
#   Watchdog script to make sure the Xignite feed is running
##

# Check to see if the daemon is running
processCheck=`/bin/ps -ef | grep x_d[a]ily_loop.php`

#echo $processCheck
# If we have a blank response then it's not running
if test "$processCheck" == "" ; then
       # Start it
       /usr/bin/php /var/www/html/feed_dev/x_daily_loop.php
fi
