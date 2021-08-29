<?php
$style = './assets/style/produit/produit.css';

require './partials/header.php';
$id = $_GET['id'];
$title = $_GET['photo'];

$photo = DB::query('SELECT titre, photo.id AS id_photo, nom, prenom, prix, format_id, quantity, url FROM photo 
                    INNER JOIN artiste ON artiste.id = photo.artiste_id 
                    INNER JOIN photo_has_format ON photo_id = photo.id 
                    where photo.id = :id OR titre = :titre AND isArtist = 1 
                    GROUP BY format_id', ['id' => $id, 'titre' => $title]);

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

// Gestion du formulaire ajout panier

$format = $_POST['filters']['format'] ?? null;
$finition = $_POST['filters']['finition'] ?? null;
$cadre = $_POST['filters']['cadre'] ?? null;
$errors = [];
$prix = $photo[0]->prix;

function calculPrice($types, $truc, $prixInit) {

    foreach($types as $type){
        $check = get_object_vars ( $type);
        if(in_array($truc, $check)){
            $prixInit = floatval($prixInit);
            $mod = floatval($type->pourcentage);
            $mod = 1 + $mod / 100;
          
            $prixInit = $prixInit * $mod;

            return $prixInit;
        } 
    }

  
}

function checkPerso($types,$truc){
    foreach($types as $type){
        $check = get_object_vars ( $type);
        if(in_array($truc, $check)){
            return true;
        } 
    }
}




if (!empty($_POST) && isset($_POST['filters'])) {

    if(!checkPerso($formats, $format, $prix)){
        $errors['format'] = 'Le format est invalide.';
    }
    if(!checkPerso($finitions, $finition, $prix)){
        $errors['finition'] = 'Le finition est invalide.';
    }
    if(!checkPerso($cadres, $cadre, $prix)){
        $errors['cadre'] = 'Le cadre est invalide.';
    }

    if(empty($errors)){
        if(checkCart($id, $format, $finition, $cadre)){
            updateCart($id, $format, $finition, $cadre, $prix);
        }else{
            addToCart($id, $format, $finition, $cadre, $prix);
        }
        // header('Location: page-panier.php');
    }else{
        foreach($errors as $error){
            echo $error.'</br>';
        }
    }
}


?>


<section class="produit">
    <article class="display">
        <h1><?= mb_ucfirst($photo[0]->titre) . ', ' . mb_ucfirst($photo[0]->prenom) . ' ' . mb_ucfirst($photo[0]->nom) ?></h1>

        <div class="view">
            <div class="carousel">
                <div class="miniatures">
                    <input type="radio" name="slide" id="slide-1" checked><label for="slide-1"><img src="<?= $photo[0]->url ?>" alt="" class="miniature-slide-1"></label>
                    <input type="radio" name="slide" id="slide-2"><label for="slide-2"><img src="./assets/image/page-produit/salon.jpg" alt="" class="miniature-slide-2"></label>
                </div>
                <div class="display-carousel" id="display-carousel">
                    <div class="slide" id="display-1">
                        <img src="<?= $photo[0]->url ?>" alt="">
                    </div>
                    <div class="slide" id="display-2">
                        <img src="./assets/image/page-produit/salon.jpg" alt="">
                    </div>

                </div>

            </div>
            <div class="personnalisation">
                <h2>Créez votre photographie d'art sur mesure</h2>
                <div class="selection">

                    <div class="titre" id="titre">
                        <div id='titre-format' data-type="format">
                            <img src="./assets/image/page-produit/cercle1.svg" alt="1">
                            <h3>Format</h3>
                        </div>

                        <div id='titre-finition' data-type="finition">
                            <img src="./assets/image/page-produit/cercle2.svg" alt="2">
                            <h3>Finition</h3>
                        </div>

                        <div id='titre-cadre' data-type="cadre">
                            <img src="./assets/image/page-produit/cercle3.svg" alt="3">
                            <h3>Cadre</h3>
                        </div>

                    </div>

                    <form action="" method="POST">
                        <div class="select" id="select">

                            <div class="format" id="format">
                                <ul>
                                    <?php foreach ($formats as $format) { ?>
                                        <li><input type="radio" name="filters[format]" id="size-<?= $format->cover ?>" value="<?= $format->format ?>" data-prix="<?= $format->pourcentage ?>">
                                            <img src="./assets/image/format/size-<?= $format->cover ?>.jpg" alt="">
                                            <label for="size-<?= $format->cover ?>"><?php echo mb_ucfirst($format->format); ?></label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>

                            <div class="finition" id="finition">
                                <ul>
                                    <?php foreach ($finitions as $finition) { ?>
                                        <li><input type="radio" name="filters[finition]" id="<?= $finition->finition ?>" value="<?= $finition->id ?>">
                                            <img src="./assets/image/finition/<?= changeChar($finition->finition) ?>.jpg" alt=""> <label for="<?= $finition->finition ?>"><?php echo mb_ucfirst($finition->finition); ?></label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>

                            <div class="cadre" id="cadre">
                                <ul>
                                    <?php foreach ($cadres as $cadre) { ?>
                                        <li><input type="radio" name="filters[cadre]" id="<?= $cadre->cadre ?>" value="<?= $cadre->id ?>">
                                            <img src="./assets/image/cadre/<?= changeChar($cadre->cadre) ?>.jpg" alt="">
                                            <label for="<?= $cadre->cadre ?>"><?php echo mb_ucfirst($cadre->cadre); ?></label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>

                        </div>

                        <div class="step">

                            <div class="previous" id="previous">
                                <div id="previous-finition">
                                    ◄ Etape précédente
                                </div>
                                <div id="previous-cadre">
                                    ◄ Etape précédente
                                </div>
                            </div>

                            <div class="total">
                                <div class="prix">
                                    <div>
                                        TOTAL :
                                    </div>
                                    <div id="price" data-prix="<?= $photo[0]->prix ?>">
                                        <?= number_format($photo[0]->prix, 2) . ' €'; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="check" id="check">

                                <div class="lien_format" id="check-format">
                                    Choisir ce format ►
                                </div>
                                <div class="lien_finition" id="check-finition">
                                    Choisir cette finition ►
                                </div>
                                <div class="lien_panier" id="check-cadre">
                                    Choisir ce cadre ►
                                </div>

                                <div id="check-checkout" class="check-checkout">
                                    <button type="submit">Ajouter au panier</button>
                                </div>

                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>

    </article>


    <article class="description">

        <h2>Détails de l'oeuvre</h2>

        <div class="info-stock">

            <h3>Éditions Limitées</h3>
            <div>

                <div class="infos">

                    <?php
                    $i = 0;
                    foreach ($formats as $format) {
                    ?>
                        <div class="format-stock">
                            <div>
                                <h4><?= $format->format ?></h4>
                                <?= $format->tirage . ' Tirages'; ?>
                            </div>

                            <div class="stock">
                                <?php
                                $quantity = $photo[$i]->quantity;
                                $ratio = $quantity / $format->tirage * 100;
                                if ($ratio == 0) {
                                    $color = "dark-red";
                                    $reste = "Epuisé";
                                } else if ($ratio <= 20) {
                                    $color = "red";
                                    $reste = "Il reste moins de " . (($format->tirage * 20) / 100) . " exemplaires disponibles";
                                } else if ($ratio <= 40) {
                                    $color = "orange";
                                    $reste = "Il reste moins de " . (($format->tirage * 40) / 100) . " exemplaires disponibles";
                                } else {
                                    $color = "green";
                                    $reste = "Encore disponible";
                                }
                                ?>
                                <div class="bar">
                                    <div class="bar <?= $color ?>" style="width: <?= 100 - $ratio ?>%;"></div>
                                </div>
                                <div><?= $reste ?></div>
                            </div>

                        </div>
                    <?php
                        $i++;
                    } ?>
                </div>
                <div class="image">
                    <img src="https://www.yellowkorner.com/on/demandware.static/-/Library-Sites-YK_Library/default/dw3cf17d62/images/homepage/263.jpg" alt="">
                </div>
            </div>


        </div>

    </article>



</section>

<script src="./script/personnalisation.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<?php require './partials/footer.php' ?>