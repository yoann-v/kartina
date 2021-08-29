<?php

use Src\Photo;

$style = "./assets/style/nouveaute/nouveaute.css";
$title = "Nouveauté";

require './partials/header.php';

$photos = DB::query('SELECT nom, prenom, biographie, artiste.id AS artiste_id, pays, ville, photo.id AS photo_id, prix, theme_id, titre, url from artiste 
                    INNER JOIN photo ON artiste.id = photo.artiste_id 
                    INNER JOIN adresse_facturation ON artiste.id = adresse_facturation.artiste_id  
                    ORDER BY photo.date_publication DESC LIMIT 20
                    ');

?>

    <section class="nouveaute">
        <div class="title">
            <h1>
                NOUVEAUTÉS
            </h1>
        </div>

        <div class="galerie">
            <?php foreach($photos as $photo) { 
                $view = new Photo($photo);
                echo $view->view();
            } ?>
        </div>
    </section>




















<?php
require './partials/footer.php';
?>