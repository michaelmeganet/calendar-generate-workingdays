<html>
    <!-- <head>
    <link href="calendar.css" type="text/css" rel="stylesheet" />
    </head> -->
    <body>
        <?php
        //test functions that refer to original files main.php
        include 'calendar2.inc.php';
        include 'phhdate.inc.php';

        $calendar = new Calendar2(2201);

        echo $calendar->show();
        echo "<br>########################################################################<br>";
        $calendar2 = new Calendar2(2201);
        echo $calendar2->gendays();
        unset($calendar2);
        echo "<br>########################################################################<br>";
# get each month last day in order to know the count of total days in each month
        echo "get each month last day in order to know the count of total days in each month <br>";
        $totalcountOfDays = 0;
        $y = '2022';
        echo "Do iteration of months in year str($y) <br>";
        for ($i = 0; $i < 12; $i++) {

            echo "\$i = $i <br>";
            $m = $i + 1;
            echo "year = $y , month = $m <br>";
            $pe = substr($y, 2, 2);
            if ($m < 10) {

                $mon = '0' . strval($m);
            } elseif ($m >= 10) {
                $mon = strval($m);
            }
            $period = $pe . $mon;
            echo "\$period = $period <br>";
            $intPeriod = intval($period);
            $calndr = new Calendar2($intPeriod);
            echo "\$period = $period , \$intPeriod = $intPeriod  <br>";
            $lastDayOfmonth = $calndr->checklastday();
            $totalcountOfDays = $totalcountOfDays + $lastDayOfmonth;
            echo "\$lastDayOfmonth =  $lastDayOfmonth <br>";
            unset($calndr);
        }
        echo "<br>\$totalcountOfDays = $totalcountOfDays <br>";
        ?>
    </body>
</html>