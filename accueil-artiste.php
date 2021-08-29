<?php
$style = './assets/style/accueil-artiste/accueil-artiste.css';
$title = 'Accueil Artiste';

require './partials/header.php';
require './config/alphabetics.php';

$artistes = DB::query('SELECT nom, prenom, id FROM artiste WHERE isArtist = 1 LIMIT 6');

$lettre = $_GET['lettre'] ?? null;

?>

    <section class="accueil-artiste">

        <div class="bandeau-titre-artiste">
            <div class="title">
                <h1>ARTISTES GALERIE D'ART</h1>
                <p>Nous proposons des oeuvres de grands noms de la photographie</p>
                <p>Nous travaillons avec eux sur la qualité et la définition de nos tirages</p>
                <p>Nous nous attachons également à découvrir et promouvoir les talents de demain</p>
            </div>
            <div class="image">
                <img src="assets/image/accueil-artiste/img-banniere.jpg" alt="image-banniere">
            </div>
        </div>

        <div class="title2">
            <h2>ARTISTES MIS EN AVANT</h2>
        </div>

        <div class="artistes">
            <?php foreach($artistes as $artiste) { ?>
                <?php
                    $query = 'SELECT * FROM photo WHERE artiste_id ='.$artiste->id.' LIMIT 4';
                    $photos = DB::query($query);
                ?>
                <div class="artiste">
                    <div class="nom-photo">
                        <div class="nom">
                            <h3><?=$artiste->nom.' '.$artiste->prenom?></h3>
                            <div class="btn">
                                <a href="./page-artiste.php?id=<?= $artiste->id; ?>">Découvrir</a>
                            </div>
                        </div>
                        <?php if (is_array($photos) && count($photos) >= 1){ ?>
                            <div class="photo">
                                <a href=""><img src="<?=$photos[0]->url?>" alt="<?=$photos[0]->titre?>"></a>
                        </div>
                    </div>
                    <div class="photo-group">
                        <?php foreach($photos as $photo) { ?>
                            <div class="photo-multi">
                                <a href=""><img src="<?=$photo->url?>" alt="<?=$photo->titre?>"></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                       <?php }
             } ?>
        </div>

        <div class="full-artistes">
            <div class="title">
                <h3>TOUS LES ARTISTES</h3>
            </div>
            <div class="alphabetic">
                <?php 
                $artistesLetters = DB::query('SELECT * FROM artiste WHERE nom LIKE :lettre AND isArtist = 1',['lettre' => $lettre.'%'] );
                foreach($alphabetics as $alphabetic){ ?>
                    <div class="alphabetic-letter">
                        <a href="accueil-artiste?lettre=<?=$alphabetic?>">
                            <?= $alphabetic ?>
                        </a>
                    </div>
                <?php } ?>
            </div>      
        </div>
  
        <div class="artistes">
            <?php if($lettre == true) { ?>
                <div class="letter">
                    <h1><?= $lettre ?></h1> 
                </div>
                <?php }
            foreach($artistesLetters as $artistesLetter) {
                    $query = 'SELECT * FROM photo WHERE artiste_id ='.$artistesLetter->id.' LIMIT 4';
                    $photos = DB::query($query);
                ?>
            <div class="artiste">
                <div class="nom-photo">
                    <div class="nom">
                        <h3><?=$artistesLetter->nom.' '.$artistesLetter->prenom?></h3>
                        <div class="btn">
                            <a href="./page-artiste.php?id=<?= $artistesLetter->id; ?>">Découvrir</a>
                        </div>
                    </div>
                    <?php if (is_array($photos) && count($photos) >= 1){ ?>
                        <div class="photo">
                            <a href=""><img src="<?=$photos[0]->url?>" alt="<?=$photos[0]->titre?>"></a>
                    </div>
                </div>
                <div class="photo-group">
                    <?php foreach($photos as $photo) { ?>
                        <div class="photo-multi">
                            <a href=""><img src="<?=$photo->url?>" alt="<?=$photo->titre?>"></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
                    <?php }
            } ?>
        </div>
    </section>

<?php
require './partials/footer.php'
?>