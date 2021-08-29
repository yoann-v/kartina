<?php

require __DIR__.'/../config/DB.php';

DB::postQuery('SET FOREIGN_KEY_CHECKS = 0');
DB::postQuery('TRUNCATE TABLE theme');
DB::postQuery('SET FOREIGN_KEY_CHECKS = 1');

$themes = ['mode','urban','noir et blanc','nature','voyage','rêve et création','sport et création','célébrités et histoire'];

foreach($themes as $theme){
    $query = DB::postQuery('INSERT into theme (theme) VALUES (:theme) ', [':theme' => $theme]);
}

?>