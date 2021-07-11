<html>
    <!-- <head>
    <link href="calendar.css" type="text/css" rel="stylesheet" />
    </head> -->
    <body>
        <?php
// original from https://www.startutorial.com/articles/view/how-to-build-a-web-calendar-in-php
        include 'calendar.inc.php';

        $calendar = new Calendar();

        echo $calendar->show();
        echo "<br>########################################################################<br>";
        $calendar2 = new Calendar();
        echo $calendar2->gendays();
        ?>
    </body>
</html>