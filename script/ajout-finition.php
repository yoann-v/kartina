<?php

require __DIR__.'/../config/DB.php';

DB::postQuery('SET FOREIGN_KEY_CHECKS = 0');
DB::postQuery('TRUNCATE TABLE finition');
DB::postQuery('SET FOREIGN_KEY_CHECKS = 1');

$finitions = [['passe-partout noir','0'],['passe-partout blanc','40'],['support aluminium','160'],['support aluminium avec verre acrylique','235'],['tirage sur papier photo','0']];

foreach($finitions as $finition){
    $query = DB::postQuery('INSERT into finition (finition, pourcentage) VALUES (:finition, :pourcentage) ', [':finition'=> $finition[0],':pourcentage'=>$finition[1]]);
}

?>