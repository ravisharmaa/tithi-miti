<?php

$dbh = new PDO('mysql:host=localhost;dbname=nepali_months', 'root', '');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$nepaliDateData = json_decode(file_get_contents('data.json'), 1);

$nepaliDays = [
  1 => 'आईतवार',
  2 => 'सोमवार',
  3 => 'मंगलवार',
  4 => 'बुधवार',
  5 => 'बिहीवार',
  6 => 'शुक्रवार',
  7 => 'शनिवार',
];

$romanMonthNames = [
  1=> 'Baisakh' ,
  2=> 'Jyestha' ,
  3=> 'Asadh' ,
  4=> 'Shrawan' ,
  5=> 'Bhadra' ,
  6=> 'Ashwin' ,
  7=> 'Kartik' ,
  8=> 'Mangsir' ,
  9=> 'Pausha' ,
  10=> 'Magha' ,
  11=> 'Falguna' ,
  12=> 'Chaitra' ,
];

$monthsInNepali = [
    1 => 'बैशाख',
    2 => 'जेष्ठ',
    3 => 'आषाढ',
    4 => 'श्रावण',
    5 => 'भदौ',
    6 => 'आश्विन',
    7 => 'कार्तिक',
    8 => 'मंसिर',
    9 => 'पौष',
    10 => 'माघ',
    11 => 'फाल्गुन',
    12 => 'चैत',
];

foreach ($nepaliDateData as $date) {
    $monthNumber = null;

    foreach ($date['days'] as $day) {
        switch ($date['month']) {
          case 1: case 2: case 3: case 4: case 5: case 6: case 7: case 8:case 9: case 10: case 11: case 12:
              $date['month'] = $months[$date['month']];
              break;
        }
        $monthNumber = empty($monthNumber)?array_search($date['month'], $months):$monthIndex;
        $sql = /**@lang sql **/
        "insert into `monthly_data` (
          nepali_month,
          nepali_month_index,
          nepali_date,
          english_date,
          miscellaneous,
          event, tithi)
          values (
          '{$date['month']}',
           {$monthIndex},
          '{$day['day']}',
          '{$day['en']}', 'Sangam Dai',
          '{$day['event']}',
          '{$day['tithi']}')";
        try {
            $dbh->prepare($sql);
            $dbh->exec($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
