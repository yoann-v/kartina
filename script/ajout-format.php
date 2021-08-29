<?php

require __DIR__.'/../config/DB.php';

DB::postQuery('SET FOREIGN_KEY_CHECKS = 0');
DB::postQuery('TRUNCATE TABLE format');
DB::postQuery('SET FOREIGN_KEY_CHECKS = 1');

$formats = [['classique', 30,'classic', 500],['grand', 160,'large', 50],['géant', 220,'giant', 30],['collector', 340,'collector', 10]];

foreach($formats as $format){
    $query = DB::postQuery('INSERT into format (format, pourcentage, cover, tirage) VALUES (:format, :pourcentage, :cover, :tirage) ', [':format' => $format[0] , ':pourcentage' => $format[1], ':cover' => $format[2], ':tirage'=> $format[3]]);
}
