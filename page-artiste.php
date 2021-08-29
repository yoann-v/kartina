<?php

use Src\Photo;

$style = './assets/style/artiste/artiste.css';
$title = 'Page Artiste';

require './partials/header.php';

$id = $_GET['id'] ?? 0;

$photos = DB::query('SELECT nom, prenom, biographie, artiste.id AS artiste_id, pays, ville, photo.id AS photo_id, prix, theme_id, titre, url from artiste 
                    INNER JOIN photo ON artiste.id = photo.artiste_id 
                    INNER JOIN adresse_facturation ON artiste.id = adresse_facturation.artiste_id  
                    WHERE artiste.id = :id_artiste', ['id_artiste'=> $id]
                    );

?>
    <section class="page-artiste"> 

        <div class="description">
            <h1><?=$photos[0]->nom.' '.$photos[0]->prenom?></h1>
            <h3><?= $photos[0]->pays?></h3>
            <p><?=$photos[0]->biographie?></p>
        </div>

        <div class="reseau_sociaux">
            <div class="twitter">
                <a href="#">
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
            </div>
            <div class="facebook">
                <a href="#">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
            </div>
            <div class="googlePlus">
                <a href="#">
                    <i class="fa fa-google-plus" aria-hidden="true"></i>
                </a>
            </div>
            <div class="pinterest">
                <a href="#">
                    <i class="fa fa-pinterest" aria-hidden="true"></i>    
                </a>
            </div>
        </div>

        <div class="galerie">
            <?php foreach($photos as $photo) { 
                $view = new Photo($photo);
                echo $view->view();
            } ?>
        </div>

    </section>
    
<?php
require './partials/footer.php'
?>