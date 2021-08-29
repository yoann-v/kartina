<?php

use Src\Photo;

$style = "./assets/style/derniers-exemp/derniers-exemp.css";
$title = "Derniers exemplaires";

require './partials/header.php';

$lasts = DB::query('SELECT titre, photo.id AS photo_id, nom, prenom, prix, format_id, quantity, theme_id, artiste_id, url FROM photo 
                    INNER JOIN photo_has_format ON photo_has_format.photo_id = photo.id 
                    INNER JOIN artiste ON artiste.id = photo.artiste_id 
                    WHERE quantity > 0 
                    ORDER BY quantity ASC 
                    LIMIT 12');

                    //var_dump($lasts);

?>

    <section class="last-exemp">
        <div class="title">
            <h1>
                Derniers exemplaires
            </h1>
        </div>

        <div class="galerie">
            <?php foreach($lasts as $last) { 
                $view = new Photo($last);
                echo $view->view();
            } ?>
        </div>
    </section>

<?php require './partials/footer.php'; ?>