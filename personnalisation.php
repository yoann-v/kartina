<?php

require './config/DB.php';

$_GET;

$json = file_get_contents('perso.json');

$json = json_decode($json);
$perso = null;
$query = '';
$finitions = [];
$cadres = [];
$params = [];

if (isset($_GET["filters"])) {

    foreach ($_GET["filters"] as $key => $filter) {
        $i = 1;

        if ($key == "format") {
            $perso = $json->$key->$filter->finition;

            foreach ($perso as $index => $finition) {
                $finitions['finition' . $i] = $index;
                $finitionValues[] = ':finition' . $i;
                $i++;
            }

            $query = 'SELECT * from finition WHERE id IN (' . implode(',', $finitionValues) . ')';
            $params = $finitions;
            // var_dump($finitions);
            // var_dump($result);
        } else if ($key == "finition") {

            if (isset($perso->$filter)) {

                if ($filter == 5) {
                    $query = null;

                } else {
                    $perso = $perso->$filter->cadre;

                    foreach ($perso as $index => $cadre) {
                        $cadres['cadre' . $i] = $index;
                        $cadreValues[] = ':cadre' . $i;
                        $i++;
                    }

                    $query = 'SELECT * from cadre WHERE id IN (' . implode(',', $cadreValues) . ')';
                    $params = $cadres;
                }

            }
        }

    }
    if(isset($query)){
        $result = DB::query($query, $params);
    }else{
        $result = ["cadre"=>false];
    }
}
// var_dump($query);
// var_dump($params);


header('Content-Type: application/json');
// J'autorise n'importe qui à se connecter à l'API
header('Access-Control-Allow-Origin: *');

// echo json_encode($query);
// echo json_encode($params);
//  echo json_encode($json);
echo json_encode($result);
// echo json_encode($finitions);

 //echo json_encode($_GET);
 //echo json_encode($format);
//  echo json_encode($filtre);