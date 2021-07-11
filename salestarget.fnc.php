<?php

function IsPublicHoliday($unixTimestamp) {
//    echo "in IsPublicHoliday <br>";
    $dateString = date("Y-m-d", $unixTimestamp);
//   echo "\$dateString = $dateString <br>";
    $year = substr($dateString, 0, 4);
    $month = substr($dateString, 5, 2);
    $day = substr($dateString, 8, 2);
// echo "\$year = $year , \$month = $month, \$day = $day <br>";
    $intMonth = intval($month);
    $intDay = intval($day);
    $calendar_table = "calendar_" . $year;
    $sql = "SELECT * FROM  $calendar_table "
            . "WHERE month = $month AND day = $day AND publicholiday = 'yes'";
//    echo "\$sql = $sql <br>";
    $obj = new SQL($sql);
    $result = $obj->getResultOneRowArray();
    if (!empty($result)) {
        $return_value = 'yes';
    } else {
        $return_value = 'no';
    }
//   echo "\$return_value = $return_value <br>";
    return $return_value;
}

function getMonthlyWorkingDays($y, $mon) {
//global $totalcountofPubHoliDays, $totalcountofPubHoliDays;
    $pe = substr($y, 2, 2);
    $period = $pe . $mon;
//     echo "Line 40 \$period = $period <br>";
    $intPeriod = intval($period);
    $calndr = new Calendar2($intPeriod);
//  echo "\$period = $period , \$intPeriod = $intPeriod  <br>";
    $lastDayOfmonth = $calndr->CaldaysInMonth($mon, $y);
// $totalcountOfDays = $totalcountOfDays + $lastDayOfmonth;
//  echo "\$lastDayOfmonth =  $lastDayOfmonth <br>";

    $totalcountofWorkingDays = 0;
    $totalcountofPubHoliDays = 0;
    $totalSatSunDays = 0;

    for ($i = 0; $i < $lastDayOfmonth; $i++) {
        $day = $i + 1;
//Create days in a month

        $dateString = $y . '-' . $mon . '-' . $day;
//Convert the date string into a unix timestamp.
        $unixTimestamp = strtotime($dateString);
// echo "\$unixTimestamp = $unixTimestamp <br>";
//Get the day of the week using PHP's date function.
        $dayOfWeek = date("l", $unixTimestamp);
//  echo "\$i = $i, \$day = $day , \$dateString = $dateString , \$dayOfWeek  = $dayOfWeek <br>";
        $checkIsPubHoliday = IsPublicHoliday($unixTimestamp);
//echo "\$checkIsPubHoliday = $checkIsPubHoliday <br>";
        if ($checkIsPubHoliday == 'no') {
            $totalcountofWorkingDays++;
//   echo "\$totalcountofWorkingDays = $totalcountofWorkingDays <br>";
        } elseif ($checkIsPubHoliday == 'yes') {
            $totalcountofPubHoliDays++;
            $GLOBALS['totalcountofPubHoliDays'] = $GLOBALS['totalcountofPubHoliDays'] + 1;
// echo "\$totalcountofPubHoliDays = $totalcountofPubHoliDays <br>";
        }
        if ($dayOfWeek == 'Saturday') {
// do nothing
            $totalSatSunDays++;
// echo "Saturday -> \$totalSatSunDays = $totalSatSunDays <br>";
//$GLOBALS['totalSatSunDays'] = $GLOBALS['totalSatSunDays'] + 1;
        } elseif ($dayOfWeek == 'Sunday') {
// do nothing
            $totalSatSunDays++;
//echo "Sunday -> \$totalSatSunDays = $totalSatSunDays <br>";
//$GLOBALS['totalSatSunDays'] = $GLOBALS['totalSatSunDays'] + 1;
        } else {

        }
// $globla_totalSatSunDays = $GLOBALS['totalSatSunDays'];
        $globla_totalSatSunDays = $totalSatSunDays;
//echo "line 87 \$globla_totalSatSunDays = $globla_totalSatSunDays <br>";
    }
// echo "Line 108 , \$totalcountofWorkingDays = $totalcountofWorkingDays , \$totalSatSunDays = $totalSatSunDays <br>";
// echo "Line 109, totalcountofWorkingDays +  totalSatSunDays = $totalcountofWorkingDays  " . "-" . "$totalSatSunDays <br>";
    $totalcountofWorkingDays = $totalcountofWorkingDays - $totalSatSunDays;
// echo "Line 110, totalcountofWorkingDays = $totalcountofWorkingDays <br> ";
//$GLOBALS['totalSatSunDays'] = $totalSatSunDays;
//$GLOBALS['totalcountofPubHoliDays'] = $totalcountofPubHoliDays;
    unset($calndr);
    echo "\$mon = $mon <br>";

    $_SESSION['month_' . $mon . '_target'] = $totalcountofWorkingDays;
    $_SESSION['totalHolidays'] = $_SESSION['totalHolidays'] + $totalcountofPubHoliDays;
    $_SESSION['totalSatSunDays'] = $_SESSION['totalSatSunDays'] + $totalSatSunDays;
    return $totalcountofWorkingDays;
}

function showCalculation($y) {
    $MonthlyWorkingDays = 0;
    $YearlyWorkingDays = 0;
    $totalcountOfDays = 0;
    $totalcountofPubHoliDays = 0;
    $totalSatSunDays = 0;
    for ($i = 0; $i < 12; $i++) {

// echo "\$i = $i <br>";
        $m = $i + 1;
//  echo "year = $y , month = $m <br>";
//            echo "<br>########### _dayinMonth #####################<br>";
//$daysInMonth = $this->_daysInMonth($m, $y);
//            echo "\$daysInMonth = $daysInMonth <br>";
//            echo "<br>#############################################<br>";
        $pe = substr($y, 2, 2);
        if ($m < 10) {

            $mon = '0' . strval($m);
        } elseif ($m >= 10) {
            $mon = strval($m);
        }

//Our YYYY-MM-DD date string.
## $date = "2002-12-02";$date = $year-$mon-$day
//Convert the date string into a unix timestamp.
#$unixTimestamp = strtotime($date);
        $MonthlyWorkingDays = getMonthlyWorkingDays($y, $mon);
//echo "Line 149 , Monthly working days at $mon, $y is $MonthlyWorkingDays<br>";
//echo "Line 151 , \$YearlyWorkingDaysat = $YearlyWorkingDays " . "+" . "$MonthlyWorkingDays<br>";
        $YearlyWorkingDays = $YearlyWorkingDays + $MonthlyWorkingDays;

//echo "Line 152 , Yearly Working Days at $mon, $y is $YearlyWorkingDays<br>";
        $period = $pe . $mon;
// echo "\$period = $period <br>";
        $intPeriod = intval($period);
        $calndr = new Calendar2($intPeriod);
// echo "\$period = $period , \$intPeriod = $intPeriod  <br>";
        $DayInmonth = $calndr->getDaysInMonth($m, $y);
// echo "\$DayInmonth =  $DayInmonth <br>";
        $totalcountOfDays = $totalcountOfDays + $DayInmonth;

        unset($calndr);
    }
    $totalcountofPubHoliDays = $_SESSION['totalHolidays'];
    $totalSatSunDays = $_SESSION['totalSatSunDays'];
    echo "\$totalcountofPubHoliDays = $totalcountofPubHoliDays <br>";
    echo "<br>\$totalcountOfDays = $totalcountOfDays <br>"
    . "\$YearlyWorkingDays = $YearlyWorkingDays <br>"
    . "\$totalSatSunDays = $totalSatSunDays <br>"
    . "\$totalcountofPubHoliDays = $totalcountofPubHoliDays<br>";
    unset($calndr);
    return $YearlyWorkingDays;
}

function createNavi($currentYear) {

    $naviHref = htmlentities($_SERVER['PHP_SELF']);

    $nextYear = intval($currentYear) + 1;



    $preYear = intval($currentYear) - 1;

    echo '<div class="header">' .
    '<a class="prev" href="' . $naviHref . '?year=' . $preYear . '">Prev</a>' .
    '<span class="title">' . $currentYear . '</span>' .
    '<a class="next" href="' . $naviHref . '?year=' . $nextYear . '">Next</a>' .
    '</div>';
}

function showAnnualTaget($annualTaget) {

    echo '<H1> The Fixed Annual sales target is ' . $annualTaget . '</H1>';
}

function getInputannualTarger() {
    $selfHref = htmlentities($_SERVER['PHP_SELF']);
    echo '<form action=" echo $_SERVER[\'PHP_SELF\']'
    . ' method = "post">';
    echo '<label for = \"annualtarget\">Annual Sales Targer</label>';
    echo '<input type = \"annualtarget\" id = \"annualtarget\" name = \"annualtarget\" >';
    echo '<input type = \"submit\" </form>';
}

function getdailySalesTarget($annualtarget, $YearlyWorkingDays) {

    $dailySalesTarget = $annualtarget / $YearlyWorkingDays;

    return $dailySalesTarget;
}

function calMonthlyTargetSession($month) {

    $monthly_target = $_SESSION['month_' . $month . '_target'];

    return $monthly_target;
}

function showMontlySalesTarget($dailySalesTarget) {
    for ($i = 0; $i < 12; $i++) {
        $mon = $i + 1;
        if ($mon < 10) {
            $strmon = "0" . strval($mon);
        } elseif ($mon >= 10) {
            $strmon = strval($mon);
        } else {
            $strmon = '0';
        }
        $MonWorkingDays = calMonthlyTargetSession($strmon);

        $MonTarget = $MonWorkingDays * $dailySalesTarget;
        $RM_MonTarget = number_format((float) $MonTarget, 2);
        echo "<br> (The sales target of month $strmon) = " . $RM_MonTarget . "  <br>";
    }
}
