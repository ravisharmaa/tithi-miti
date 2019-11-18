<?php
$dbh = new PDO('mysql:host=localhost;dbname=nepali_months;charset=utf8', 'root', '');

$sql = 'select * from monthly_data order by nepali_month_index asc';

$result = $dbh->query($sql);

$dataSets = $result->fetchAll(PDO::FETCH_ASSOC);

$results = [];


$months = [
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
$result = [];
foreach ($months as $month) {
    foreach ($dataSets as $data) {
        if (in_array($month, $data)) {
            $result[$month][] = $data;
        }
    }
}
$response['results'] = $result;
file_put_contents('dataset.json', json_encode($response, JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT));
