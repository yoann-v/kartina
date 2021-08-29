<?php

require __DIR__.'/../config/DB.php';

DB::postQuery('SET FOREIGN_KEY_CHECKS = 0');
DB::postQuery('TRUNCATE TABLE cadre');
DB::postQuery('SET FOREIGN_KEY_CHECKS = 1');

$cadres = [['sans encadrement','0'],['encadrement noir satin','45'],['encadrement blanc satin','45'],['encadrement noyer','45'],['encadrement chene','45'],['encadrement aluminium noir','0'],['encadrement bois blanc','0'],['encadrement acajou mat','0'],['encadrement aluminium brosse','0']];

foreach($cadres as $cadre){
    $query = DB::postQuery('INSERT into cadre (cadre, pourcentage) VALUES (:cadre, :pourcentage) ', [':cadre'=> $cadre[0],':pourcentage'=>$cadre[1]]);
}

?>