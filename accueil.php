<?php

use Src\Photo;

$photos = DB::query('SELECT photo.id as photo_id, theme_id, titre,  prix, url, artiste_id, nom, prenom, artiste.id as id from photo 
                    INNER JOIN artiste ON photo.artiste_id = artiste.id 
                    ORDER BY RAND() 
                    LIMIT 6
                    ');

?>

<section class="accueil">
    <article class="carousel" id="carousel">
        <div class="slides" id="slides">
            <figure class="carousel-item" id="slide-1">
                <div>
                    <img src="./assets/image/accueil/1.jpg" alt="">
                </div>
                <figcaption>
                    <h3>Nouvelles Oeuvres</h3>
                    La légendaire collection Everest

                    <a href="">Explorer la nouvelle collection <span><i class="fa fa-chevron-right" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></span></a>
                </figcaption>
            </figure>
            <figure class="carousel-item" id="slide-2">
                <div>
                    <img src="./assets/image/accueil/2.jpg" alt="">
                </div>
                <figcaption>
                    <h3>Nature Sublimée</h3>
                    Nouveautés exclusives

                    <a href="">Voir la sélection <span><i class="fa fa-chevron-right" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></span></a>
                </figcaption>
            </figure>
            <figure class="carousel-item" id="slide-3">
                <div>
                    <img src="./assets/image/accueil/3.jpg" alt="">
                </div>
                <figcaption>
                    <h3>Noir et Blanc</h3>
                    Notre collection noir et blanc

                    <a href="">Découvrir les dernières sorties <span><i class="fa fa-chevron-right" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></span></a>
                </figcaption>
            </figure>
            <figure class="carousel-item" id="slide-4">
                <div>
                    <img src="./assets/image/accueil/4.jpg" alt="">
                </div>
                <figcaption>
                    <h3>Derniers exemplaires</h3>
                    Nos photographies en fin de sérialisation

                    <a href="">Explorer la fin de collection <span><i class="fa fa-chevron-right" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></span></a>
                </figcaption>
            </figure>
        </div>


        <div class="btn-carousel">
            <button class="btn" id="previous" name="previous"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
            <button class="btn" id="next" name="next"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
        </div>

        <div class="circles">
            <input type="radio" name="slides-select" id="item-carousel-1" value="1" checked autocomplete="false">
            <label for="item-carousel-1"><i class="fa fa-circle" aria-hidden="true"></i></label>

            <input type="radio" name="slides-select" id="item-carousel-2" value="2" autocomplete="false">
            <label for="item-carousel-2"><i class="fa fa-circle" aria-hidden="true"></i></label>

            <input type="radio" name="slides-select" id="item-carousel-3" value="3" autocomplete="false">
            <label for="item-carousel-3"><i class="fa fa-circle" aria-hidden="true"></i></label>

            <input type="radio" name="slides-select" id="item-carousel-4" value="4" autocomplete="false">
            <label for="item-carousel-4"><i class="fa fa-circle" aria-hidden="true"></i></label>
        </div>
    </article>

    <article class="meilleur">
        <h2>Photographies d'art</h2>
        <p>Oeuvres en edition limitée et numérotée avec certificat d'authenticité</p>
        <div class="image">

            <?php foreach ($photos as $photo) {
                $view = new Photo($photo);
                echo $view->view();
            } ?>


        </div>

    </article>

    <article class="quatro">
        <h2>Photographie d'art en édition limitée</h2>
        <div>
            <div>
                <div class="un">
                    <div>
                        <h3>Paris, New-York, Tokyo...</h3>
                        <p>Plus de 90 galeries dans le monde pour découvrir nos collections et bénéficier de l'expertise de nos galeristes.</p>
                        <p><a href="">Trouver une galerie <i class="fa fa-chevron-right" aria-hidden="true"></i></a></p>
                    </div>
                </div>

                <div class="deux">
                    <div>
                        <h3>Edition limitée et numérotée</h3>
                        <p>Toutes les photographies sont fournies avec leur certificat d'authenticité en édition limitée et numérotée.</p>
                        <p><a href="">Découvrir <i class="fa fa-chevron-right" aria-hidden="true"></i></a></p>
                    </div>
                </div>
            </div>

            <div>
                <div class="trois">
                    <div>
                        <h3>Tirage en qualité galerie</h3>
                        <p>Des tirages argentiques réalisés dans notre laboratoire professionnel YellowKorner sous la supervision des artistes.</p>
                        <p><a href="">Notre laboratoire <i class="fa fa-chevron-right" aria-hidden="true"></i></a></p>
                    </div>
                </div>

                <div class="quatre">
                    <div>
                        <img src="" alt="">
                        <h3>Retrait gratuit en galerie</h3>
                        <p>Emballage sécurisé, échanges et retours gratuits.</p>
                        <p><a href="">Nos garanties <i class="fa fa-chevron-right" aria-hidden="true"></i></a></p>
                    </div>
                </div>
            </div>
        </div>
    </article>

</section>
<script src="script/carousel.js"></script>