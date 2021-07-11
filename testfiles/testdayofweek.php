
<?php

// Test date function
#refer https://thisinterestsme.com/php-get-day-of-the-week-from-date/
#
//Our YYYY-MM-DD date string.
$date = "2012-01-21";

//Get the day of the week using PHP's date function.
$dayOfWeek = date("l", strtotime($date));

//Print out the day that our date fell on.
echo $date . ' fell on a ' . $dayOfWeek;
echo "<br>#########################################################<br>";

//Our YYYY-MM-DD date string.
$date = "2002-12-02";

//Convert the date string into a unix timestamp.
$unixTimestamp = strtotime($date);

//Get the day of the week using PHP's date function.
$dayOfWeek = date("l", $unixTimestamp);

//Print out the day that our date fell on.

echo $date . ' fell on a ' . $dayOfWeek;
echo "<br>#########################################################<br>";
//Reverse of strtotime
$dateString = date("Y-m-d", $unixTimestamp);

echo 'The date  is  ' . $dateString;
