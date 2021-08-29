<?php 

require "../../config/DB.php";


function admin($a){
    DB::postQuery('UPDATE artiste SET isArtist = :isArtist WHERE email = :email',[
        ":isArtist" => 2,
        ":email" => $a
    ]);
}

admin('lalauxclement@gmail.com');

?>