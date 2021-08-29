<?php

require __DIR__.'/../config/DB.php';

DB::postQuery('SET FOREIGN_KEY_CHECKS = 0');
DB::postQuery('TRUNCATE TABLE orientation');
DB::postQuery('SET FOREIGN_KEY_CHECKS = 1');

$orientations = [['portrait','vert'],['paysage','horiz'],['carré','carre'],['panoramique','pano']];

foreach($orientations as $orientation){
    $query = DB::postQuery('INSERT into orientation (orientation, cover) VALUES (:orientation, :cover) ', [':orientation' => $orientation[0] , ':cover' => $orientation[1]]);
}

?>