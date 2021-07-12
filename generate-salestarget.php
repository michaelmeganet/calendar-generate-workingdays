<html>
    <body>
        <?php
        session_start();
        include 'dbh.inc.php';
        include 'variables.inc.php';
        include 'generate_calendar.inc.php';
        include 'phhdate.inc.php';
        include 'salestarget.fnc.php';
        $annualtarget = null;
        if (null == $annualtarget && isset($_GET['annualtarget'])) {
            $annualtarget = $_GET['annualtarget'];
        } elseif (null == $annualtarget) {
            $annualtarget = 24000000;
        }

        $year = null;
        //$year =  $this->year;
        if (null == $year && isset($_GET['year'])) {

            $year = $_GET['year'];
        } else if (null == $year) {

            $year = date("Y", time());
        } else {
            $year = $_GET['year'];
        }
        $totalcountofPubHoliDays = 0;
        $totalSatSunDays = 0;

        # get each month last day in order to know the count of total days in each month
        //echo "get each month last day in order to know the count of total days in each month <br>";
        $_SESSION['totalHolidays'] = 0;
        $_SESSION['totalSatSunDays'] = 0;
        $y = $year;
        echo "The year is $y <br>";
        $naviContent = createNavi($year);
        //$annualTarger = getInputannualTarger();
        showAnnualTaget($annualtarget);
//        getInputannualTarger();
        $TotalMonthlyTarget = 0;
        for ($i = 0; $i < 12; $i++) {
            $mon = $i + 1;
            if ($mon < 10) {
                $strmon = "0" . strval($mon);
            } elseif ($mon >= 10) {
                $strmon = strval($mon);
            } else {
                $strmon = '0';
            }
            $MonTarget = calMonthlyTargetSession($strmon);
            //echo "Line 52, \$strmon = $strmon ,\$MonTarget = $MonTarget <br>";
            echo "month : $strmon -> Monthly sales target = $MonTarget days <br>";
//            echo "Line 53, before addition,\$TotalMonthlyTarget = $TotalMonthlyTarget <br> ";
            $TotalMonthlyTarget = $TotalMonthlyTarget + $MonTarget;
//            echo "Line 55, \$TotalMonthlyTarget = \$TotalMonthlyTarget + \$MonTarget<br> ";
//            echo "Line 56, \$TotalMonthlyTarget = $TotalMonthlyTarget <br> ";
        }
        echo '<form action="generate-salestarget.php"'
        . ' method = "get">';
        echo '<label for = "annualtarget">Annual Sales Target</label>';
        echo '<input type = "text" id = "annualtarget" name = "annualtarget" value = ' . $annualtarget . ' >';
        echo '<input type = "hidden" id = "year" name = "year" value = ' . $year . ' >';
        echo '<input type="submit" name="submit" value="Submit Form">'
        . '</form><br>';

        if (!isset($_GET['submit'])) {

        } elseif ($_GET['submit'] == 'Submit Form') {

            $YearlyWorkingDays = showCalculation($y);

            $dailySalesTarget = getdailySalesTarget($annualtarget, $YearlyWorkingDays);
            echo "\$dailySalesTarget = $dailySalesTarget <br>";

            echo "Daily Sales Target is " . number_format((float) $dailySalesTarget, 2);

            echo "<br>################################################<br>";
            //print_r($_SESSION);

            showMontlySalesTarget($dailySalesTarget);
        }
        ?>
    </body>
</html>

