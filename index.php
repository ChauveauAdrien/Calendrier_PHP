<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_ALL, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');

// liste pour les select 
$months = [1=>'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
$days = [1 =>'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

$currentDate = date('F Y');

$curMonth = date('n');
if (!empty($_GET['month'])) {
    $curMonth = $_GET['month'];
}
$curYear = date('Y');
if(!empty($_GET['year'])) {
    $curYear = $_GET['year'];
}


function nextMonth($curmonth, $curyear) {
    $next = $curmonth + 1 ;
if ($next > 12) {
    $next = 1;
    $curyear ++;
}
echo "http://td-calendrier.test/?month=$next&year=$curyear";
}

function prevMonth($curmonth, $curyear) {
    $prev = $curmonth - 1 ;
if ($prev < 1) {
    $prev = 12;
    $curyear --;
}
echo "http://td-calendrier.test/?month=$prev&year=$curyear";
}



$aDate = new DateTime($curYear.'-'.$curMonth.'-01');
$firstDay = $aDate->format('N');



$nbrDays = cal_days_in_month(CAL_GREGORIAN, $curMonth, $curYear);

$lastDays = new DateTime($curYear.'-'.$curMonth.'-'.$nbrDays);
$essai = $lastDays->format('N');




?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Td Calendrier</title>
    <link rel="stylesheet" href="./assets/css/style.css?version=<?= time() ?>">
</head>
<body>
    <h1>Calendrier</h1>
    <h2>Un calendrier élégant développé avec PHP</h2>
    <section id="calendar">
        <div class="calendar-wrapper">
            <div class="header-calendar">
                <div class="header-top">
                    <a href="<?php prevMonth($curMonth, $curYear) ?>"><ion-icon name="chevron-back-outline"></ion-icon></a>
                    <div class="current-month"><?= $months[$curMonth].' '.$curYear ?></div>
                    <a href="<?php nextMonth($curMonth, $curYear) ?>"><ion-icon name="chevron-forward-outline"></ion-icon></a>
                </div>
                <div class="header-mid">
                    <form action="" method="GET">
                        <select id="month" name="month"  class="months">
                            <!-- select month -->
                        <?php 
                            for($i = 1; $i <= sizeof($months); $i++) {
                                
                                if ($i == $_GET['month'] ) {
                                    echo "<option value=\"$i\" selected >$months[$i]</option>";
                                }else {
                                    echo "<option value=\"$i\">$months[$i]</option>";
                                }
                            }

                        ?>
                        
                        </select>
                        <select id="year" name="year" class="year">
                            <!-- select année -->
                            <?php 
                                for ($i=1970; $i <= 2030; $i++) { 
                                    if ($i == $_GET['year']) {
                                        echo "<option value=\"$i\" selected>$i</option>";
                                    }else {
                                        echo "<option value=\"$i\">$i</option>";
                                    }
                                }
                            ?>
                        </select>
                        <input type="submit" value="valider" class="valider">
                    </form>
                    
                </div>
                <div class="header-bot">
                    <!-- jour de la semaine -->
                    <?php  foreach ($days as $day => $key){
                        echo "<div class=\"days $day\">$key</div>";
                    }
                    ?>
                </div>
            </div>
            <div class="main-cal">
                <?php 
                    // jour du mois d'avant
                    $i = 1;
                    $a = $firstDay -1;
                    $arrayTest = [];

                    while ($a >= 1 ) {
                        date_add($aDate, date_interval_create_from_date_string('-1 days'));
                        $test = date_format($aDate,"d");
                        array_push($arrayTest, $test);
                        $a--;
                    }


                    $reverseArray = array_reverse($arrayTest);
                        for ($f=0; $f < sizeof($reverseArray); $f++) { 
                            echo "<div class=\"day-box-before\">$reverseArray[$f]</div>";
                        }
                        
                        
                    
                    // jour du mois actuel
                    while ($i <= $nbrDays) {
                        echo "<div class=\"day-box d$i\">$i</div>";
                        $i++;
                    }

                    // jour du mois d'après
                    while ($essai < 7 ) {
                        date_add($lastDays, date_interval_create_from_date_string('1 days'));
                        $ld = date_format($lastDays,"d");
                        echo "<div class=\"day-box-before\">$ld</div>";
                        $essai++;
                    }

                    
                ?>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>