<?php
require __DIR__.'/../config/config.php';
require __DIR__.'/../config/database.php';
require __DIR__.'/../config/DB.php';
require __DIR__.'/../config/functions.php';

session_start();

spl_autoload_register(function ($class) {

    $class = str_replace('\\', '/', $class);

    require $class.'.php';
    
});

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style/style.css">
    <?php
    if(isset($style)){
        echo '<link rel="stylesheet" href="'.$style.'">';
    } 
    ?>
    <title><?=$title?></title>
</head>

<body>

    <div class="container">

        <header>

            <!-- Logo site -->
            <div class="logo">
                <a href="index.php">
                    <figure>
                        <img src="./assets/image/header/kartina_logo.svg" alt="">
                        <figcaption>
                            <p>Photographie d'art en édition limitée</p>
                        </figcaption>
                    </figure>
                </a>
            </div>

            <!-- Search bar + menu clients+panier+langue+aide -->
            <div class="main-header">

                <!-- Barre de recherche -->
                <div class="searchbar">
                    <form action="" method="get">
                        <input type="text" name="" id="" placeholder="Rechercher sur Kartina">
                        <button type="submit"><img src="./assets/image/header/Magnifying_glass_icon.svg" alt=""></button>
                    </form>
                </div>

                <!-- Barre de navigation utilisateur -->
                <div class="nav-user">

                    <!-- Accès compte utilisateur -->
                    <?php if (isset($_SESSION['user'])) { ?>
                        <div>
                            <a href="./user.php">Bonjour <?= mb_ucfirst($_SESSION['user'][0]->prenom) ; ?></a>

                        </div>
                        <div>
                        <a href="./logout.php">
                            Deconnexion</a>
                    </div>
                    <?php } else { ?>
                        <div>
                            <a href="./login.php"><object data="./assets/image/header/user.svg" type="image/svg+xml">user</object>Username</a>
                        </div>
                    <?php } ?>
                    <!-- Menu d'aide -->
                    <div>
                        <a href="#"><object data="./assets/image/header/question-mark-button-svgrepo-com.svg" type=""></object>
                            Aide</a>
                    </div>
                    
                    <!-- Panier -->
                    <div>
                        <a href="./page-panier.php"><object data="./assets/image/header/shopping-cart.svg" type="">cart</object> Panier (<?= count(panier()) ?>)</a>
                    </div>

                    <!-- Menu selection langue -->
                    <div class="lang" id="lang">
                        <div class="langue" id="langue"><img src="./assets/image/header/Flag_of_France.svg" alt="">
                        </div>
                        <div id="selec-lang" class="selec-lang">
                            <ul class="" id="ln">
                                <li>
                                    <a href="#"><img src="./assets/image/header/Flag_of_France.svg" alt=""> FR</a>
                                </li>
                                <li>
                                    <a href="#"><img src="./assets/image/header/Flag_of_the_United_Kingdom.svg" alt=""> EN</a>
                                </li>
                                <li>
                                    <a href="#"><img src="./assets/image/header/Flag_of_Spain.svg" alt=""> ES</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        
            <!-- Navigation catalogue -->
            <nav>
                <ul>
                    <a href="./catalogue.php">
                        <li>Photographies</li>
                    </a>
                    <a href="./nouveaute.php">
                        <li>Nouveautés</li>
                    </a>
                    <a href="./accueil-artiste.php">
                        <li>Artistes</li>
                    </a>
                    <a href="./derniers-exemp.php">
                        <li>Derniers exemplaires</li>
                    </a>
                </ul>
            </nav>

        </header>
        

