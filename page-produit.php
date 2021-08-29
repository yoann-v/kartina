<?php

$style = './assets/style/page-produit/page-produit.css';

require './partials/header.php';
$id = $_GET['id'];
$title = $_GET['photo'];

$photo = DB::query('SELECT * FROM photo 
                    INNER JOIN artiste ON artiste.id = photo.artiste_id 
                    where photo.id = :id OR titre = :titre AND isArtist = 1', ['id' => $id, 'titre' => $title]);

$formats = DB::query('SELECT * FROM format');
$finitions = DB::query('SELECT * FROM finition');
$cadres = DB::query('SELECT * FROM cadre');


function changeChar($string)
{
    $re = '/\s/m';
    $subst = '-';

    $result = preg_replace($re, $subst, $string);

    echo $result;
}


?>

<section class="page-produit">
    <h1><?= mb_ucfirst($photo->titre) . ', ' . mb_ucfirst($photo->prenom) . ' ' . mb_ucfirst($photo->nom) ?></h1>
    <div class="bloc1">

        <div class="carousel">
            <div class="slide">
                <ul class="carousel__thumbnails">
                    <li>
                        <label for="slide-1"><img src="<?= $photo->url ?>" alt=""></label>
                    </li>
                    <li>
                        <label for="slide-2"><img src="./assets/image/page-produit/salon.jpg" alt=""></label>
                    </li>
                </ul>

            </div>
            <div class="miniature">
                <input type="radio" name="slides" checked="checked" id="slide-1">
                <input type="radio" name="slides" id="slide-2">
                <ul class="carousel__slides">
                    <li class="carousel__slide">
                        <figure>
                            <div>
                                <img src="<?= $photo->url ?>" alt="">
                            </div>
                        </figure>
                    </li>
                    <li class="carousel__slide">
                        <figure>
                            <div>
                                <img src="./assets/image/page-produit/salon.jpg" alt="">
                            </div>
                        </figure>
                        <div class="display-picture">
                            <img src="<?= $photo->url ?>" alt="">
                        </div>
                    </li>
                </ul>
            </div>

        </div>

        <div class="personnalisation">
            <div class="title">
                Créez votre photographie d'art sur mesure
            </div>
            <hr>
            <div class="selection_titre">
                <div onclick="openPerso(event)" class="format" id='titre-format' data-type="format">
                    <img src="./assets/image/page-produit/cercle1.svg" alt="1">
                    <p>Format</p>
                </div>

                <div onclick="openPerso(event)" class="finition" id='titre-finition' data-type="finition">
                    <img src="./assets/image/page-produit/cercle2.svg" alt="2">
                    <p>Finition</p>
                </div>
                <div onclick="openPerso(event)" class="cadre" id='titre-cadre' data-type="cadre">
                    <img src="./assets/image/page-produit/cercle3.svg" alt="3">
                    <p>Cadre</p>
                </div>
            </div>
            <div class="selection">
                <div onclick="selection(e)" id="format" class="format">
                    <ul>
                        <?php foreach ($formats as $format) { ?>
                            <li><input type="radio" onclick="perso(e)" name="size-format" id="size-<?= $format->cover ?>" value="<?= $format->cover ?>" data-type="<?= $format->cover ?>">
                                <img src="./assets/image/format/size-<?= $format->cover ?>.jpg" alt="">
                                <label for="size-<?= $format->cover ?>"><?php echo mb_ucfirst($format->format); ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div onclick="selection(e)" id="finition" class="finition">
                    <ul>
                        <?php foreach ($finitions as $finition) { ?>
                            <li><input type="radio" name="finition" id="<?= $finition->finition ?>" value="<?= $finition->finition ?>">
                                <img src="./assets/image/finition/<?= changeChar($finition->finition) ?>.jpg" alt=""> <label for="<?= $finition->finition ?>"><?php echo mb_ucfirst($finition->finition); ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div onclick="selection(e)" id="cadre" class="cadre">
                    <ul>
                        <?php foreach ($cadres as $cadre) { ?>
                            <li><input type="radio" name="cadre" id="<?= $cadre->cadre ?>" value="<?= $cadre->cadre ?>">
                                <img src="./assets/image/cadre/<?= changeChar($cadre->cadre) ?>.jpg" alt="">
                                <label for="<?= $cadre->cadre ?>"><?php echo mb_ucfirst($cadre->cadre); ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

            </div>
            <div onclick="openPerso(event)" class="lien_etape" id="btn_return" data-btn="btn_return1">
                <a href="#">◄ Etape précédente</a>
            </div>
            <div onclick="openPerso(event)" class="lien_etape" id="btn_return2" data-btn="btn_return2">
                <a href="#">◄ Etape précédente</a>
            </div>
            <div class="total_prix">
                <div class="total">
                    TOTAL :
                </div>
                <div class="prix">
                    <?= number_format($photo->prix, 2) . ' €'; ?>
                </div>
            </div>
            <div class="lien_validation">
                <div onclick="openPerso(event)" class="lien_format" id="btn_format" data-btn="btn_format">
                    <a href="#">Choisir ce format ►</a>
                </div>
                <div onclick="openPerso(event)" class="lien_finition" id="btn_finition" data-btn="btn_finition">
                    <a href="#">Choisir cette finition ►</a>
                </div>
                <div onclick="openPerso(event)" class="lien_panier" id="btn_panier" data-btn="btn_panier">
                    <a href="/page_panier.php">Ajouter au panier</a>
                </div>
            </div>
        </div>
    </div>

    <div class="descriptif">
        <div class="artistName">
            Nom de l'artiste
        </div>
        <div class="title">
            Titre
        </div>
        <div class="bio">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus explicabo molestias eos reiciendis sit, veritatis earum? Nam temporibus quis eaque blanditiis autem architecto ab iure, aliquam debitis totam assumenda placeat.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus explicabo molestias eos reiciendis sit, veritatis earum? Nam temporibus quis eaque blanditiis autem architecto ab iure, aliquam debitis totam assumenda placeat.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus explicabo molestias eos reiciendis sit, veritatis earum? Nam temporibus quis eaque blanditiis autem architecto ab iure, aliquam debitis totam assumenda placeat.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus explicabo molestias eos reiciendis sit, veritatis earum? Nam temporibus quis eaque blanditiis autem architecto ab iure, aliquam debitis totam assumenda placeat.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus explicabo molestias eos reiciendis sit, veritatis earum? Nam temporibus quis eaque blanditiis autem architecto ab iure, aliquam debitis totam assumenda placeat.
        </div>
    </div>

</section>

<script src="./script/personnalisation.js"></script>
<?php require './partials/footer.php' ?>