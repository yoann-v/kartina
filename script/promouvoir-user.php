<?php
ob_start();
require __DIR__.'/config/config.php';
require __DIR__.'/config/database.php';
require __DIR__.'/config/DB.php';
require __DIR__.'/config/functions.php';

$id=$_GET['id'] ?? 0;

global $db;

$query = DB::query("SELECT * FROM artiste WHERE id = :id",[
    ':id' => $id
]);

if($query){
    if($query[0]->isArtist == 0){
        DB::postQuery("UPDATE artiste SET isArtist = :isArtist WHERE id = :id",[
            ":isArtist" => 1,
            ":id" => $id
        ]);
    } else {
        DB::postQuery("UPDATE artiste SET isArtist = :isArtist WHERE id = :id",[
            ":isArtist" => 0,
            ":id" => $id
        ]);
    }
}

header('Location: admin.php');

?>