<?php 

    require "../../config/DB.php";

    DB::postQuery('SET FOREIGN_KEY_CHECKS = 0');
    DB::postQuery('TRUNCATE TABLE artiste');
    DB::postQuery('TRUNCATE TABLE adresse_facturation');
    DB::postQuery('TRUNCATE TABLE adresse_livraison');
    DB::postQuery('SET FOREIGN_KEY_CHECKS = 1');

?>