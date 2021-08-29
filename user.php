<?php
ob_start();
$title = 'Données personelles';
$style = './assets/style/user/style.css';
require './partials/header.php';

$lastname = $_POST['lastname'] ?? '';
$firstname = $_POST['firstname'] ?? '';
$password = $_POST['password'] ?? '';
$mdp = $_POST['mdp'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';

$housenumber = $_POST['housenumber'] ?? '';
$street = $_POST['street'] ?? '';
$city = $_POST['city'] ?? '';
$postcode = $_POST['postcode'] ?? '';

$housenumber2 = $_POST['housenumber2'] ?? '';
$street2 = $_POST['street2'] ?? '';
$city2 = $_POST['city2'] ?? '';
$postcode2 = $_POST['postcode2'] ?? '';

$bio = $_POST['biographie'] ?? '';

if ($lastname === '') {
    $lastname = $_SESSION['user'][0]->nom;
}
if ($firstname === '') {
    $firstname = $_SESSION['user'][0]->prenom;
}
if ($phone === '') {
    $phone = $_SESSION['user'][0]->telephone;
}

if ($password !== '') {
    $hash = password_hash($password, PASSWORD_DEFAULT);
}

if ($password === '') {
    $hash = $_SESSION['user'][0]->mdp;
}


$lastname = htmlspecialchars($lastname);
$firstname = htmlspecialchars($firstname);
$phone = htmlspecialchars($phone);
$housenumber = htmlspecialchars($housenumber);
$street = htmlspecialchars($street);
$city = htmlspecialchars($city);
$postcode = htmlspecialchars($postcode);
$housenumber2 = htmlspecialchars($housenumber2);
$street2 = htmlspecialchars($street2);
$city2 = htmlspecialchars($city2);
$postcode2 = htmlspecialchars($postcode2);


$id = intval($_SESSION['user'][0]->id);
$errors = [];
$thisArtiste = DB::query('SELECT * FROM adresse_facturation WHERE artiste_id = :id', ['id' => $_SESSION['user'][0]->id]);
$thisArtiste2 = DB::query('SELECT * FROM adresse_livraison WHERE artiste_id = :id', ['id' => $_SESSION['user'][0]->id]);

if (!empty($_POST) && isset($_POST['form'])) {
    if (password_verify($password, $_SESSION['user'][0]->mdp)) {
        $errors['mdpIdentique'] = "Le mot de passe est identique à votre précédent mot de passe";
    }
    if (count(DB::query('SELECT * FROM artiste WHERE email = :email', ['email' => $email])) != 0) {
        $errors['verifEmail'] = "L'email est déjà utilisé";
    }
    if ($email === '') {
        $email = $_SESSION['user'][0]->email;
    }
    if (strlen($lastname) <= 2) {
        $errors['lastname'] = "Le nom de famille n'est pas correct";
    }
    if (strlen($firstname) <= 2) {
        $errors['firstname'] = "Le prenom n'est pas correct";
    }

    if ($password !== $mdp) {
        $errors['password'] = "Les mots de passes ne correspondent pas";
    }

    if (strlen($password) < 6 && strlen($password) > 0) {
        $errors['pswd'] = "Le mot de passe est trop court";
    }
    if (strlen($phone) < 8 && !ctype_digit($phone)) {
        $errors['phone'] = "le numero de téléphone n'est pas correct";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide";
    }
    if (empty($errors)) {
        global $db;
        DB::postQuery(
            "UPDATE artiste SET email = :email, mdp = :password, nom = :lastname , prenom = :firstname, telephone = :phone WHERE id = :id",
            [
                'email' => $email,
                'password' => $hash,
                'lastname' => $lastname,
                'firstname' => $firstname,
                'phone' => $phone,
                'id' => $id
            ]
        );

        $query = DB::query("SELECT * FROM artiste WHERE email = :email", [
            'email' => $email
        ]);

        $_SESSION['user'][0] = $query[0];

        header('Location: user.php#dataUser');
    } else {
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
    }
}



if (!empty($_POST) && isset($_POST['form2'])) {
    if (strlen($housenumber) < 1) {
        $errors['housenumber'] = "Le numéro entré n'est pas correct";
    }
    if (strlen($street) < 2) {
        $errors['street'] = "La rue n'est pas valide";
    }
    if (strlen($city) < 2) {
        $errors['city'] = "La ville n'est pas valide";
    }
    if (!ctype_digit($postcode) && strlen($postcode) != 5) {
        $errors['postcode'] = "Le code postal n'est pas valide";
    }
    if (empty($errors)) {
        global $db;
        var_dump($city);
        DB::postQuery(
            "UPDATE adresse_facturation SET ville = :ville, cp = :cp , rue = :rue, n_rue = :n_rue WHERE artiste_id = :artiste_id",
            [
                'ville' => $city,
                'cp' => $postcode,
                'rue' => $street,
                'n_rue' => $housenumber,
                'artiste_id' => $id
            ]
        );

        header('Location: user.php#dataUser');
    } else {
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
    }
}

if (!empty($_POST) && isset($_POST['form3'])) {

    if (strlen($housenumber2) < 1) {
        $errors['housenumber2'] = "Le numéro2 entré n'est pas correct";
    }
    if (strlen($street2) < 2) {
        $errors['street2'] = "La rue2 n'est pas valide";
    }
    if (strlen($city2) < 2) {
        $errors['city2'] = "La ville2 n'est pas valide";
    }
    if (!ctype_digit($postcode2) && strlen($postcode2) != 5) {
        $errors['postcode2'] = "Le code2 postal n'est pas valide";
    }
    if (empty($errors)) {
        global $db;
        DB::postQuery(
            "UPDATE adresse_livraison SET ville = :ville, cp = :cp , rue = :rue, n_rue = :n_rue WHERE artiste_id = :artiste_id",
            [
                'ville' => $city2,
                'cp' => $postcode2,
                'rue' => $street2,
                'n_rue' => $housenumber2,
                'artiste_id' => $id
            ]
        );

        header('Location: user.php#dataUser');
    } else {
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
    }
}

if (!empty($_POST) && isset($bio)) {
    if (strlen($bio) < 5) {
        $errors['bio'] = 'le texte est trop court';
    }
    if (empty($errors)) {
        global $db;
        DB::postQuery(
            "UPDATE artiste SET biographie = :bio WHERE id = :id",
            [
                ':bio' => $bio,
                ':id' => $id
            ]
        );
    }
}

?>

<nav id="tab">
    <div id="myAccount">
        <h3>Mon compte</h3>
            <p><a onclick="change('user','myAccount','infoShop');">Afficher les données personnelles</a></p>
            <p onclick="change('changeData','myAccount','infoShop');">Modifier les données personnelles</p>
        <?php if ($_SESSION['user'][0]->isArtist == 1) { ?>
                <p><a onclick="change('changeBio','myAccount','infoShop');">Modifier la biographie</a></p>
        <?php } ?>
        <?php if ($_SESSION['user'][0]->isArtist == 2) { ?>
            <p><a href="admin.php" style="text-decoration:none;color:black;">Modifier les droits utilisateur</a></p>
        <?php } ?>
    </div>

    <div id="infoShop">

        <h3>Informations d'achat</h3>
        <p><a onclick="change('history','infoShop','myAccount');">Historique d'achat</a></p>
        <p><a onclick="change('delivery','infoShop','myAccount');">Suivi de commande</a></p>
        <p><a onclick="change('dataCard','infoShop','myAccount');">Informations bancaires</a></p>
        <div>
            <p><a onclick="change('changePayment','infoShop','myAccount');">Modifier mes informations bancaires</a></p>
        </div>
        
    </div>

</nav>

<section style="display:none;" id="section">

    <article id="user" class="user" name="user" >

        <h2>Mon compte</h2>

        <div id="dataUser">

            <h3>Données</h3>
            <p>Prénom : <?= $_SESSION['user'][0]->prenom ?> , Nom : <?= $_SESSION['user'][0]->nom ?></p>
            <p>Numéro de téléphone : <?= $_SESSION['user'][0]->telephone ?> , Mail : <?= $_SESSION['user'][0]->email ?></p>
        </div>

        <div id="dataAdress">

            <h3><img src="./assets/image/user/location.png" alt="adresse" style="width:16px;"> Adresses</h3>
            <p>Adresse de facturation : <?= $thisArtiste[0]->n_rue ?> <?= $thisArtiste[0]->rue ?>, <?= $thisArtiste[0]->cp ?> <?= $thisArtiste[0]->ville ?> <?= $thisArtiste[0]->pays ?></p>
            <p>Adresse de livraison : <?= $thisArtiste2[0]->n_rue ?> <?= $thisArtiste2[0]->rue ?>, <?= $thisArtiste2[0]->cp ?> <?= $thisArtiste2[0]->ville ?> <?= $thisArtiste2[0]->pays ?></p>

        </div>
    </article>
    <?php if ($_SESSION['user'][0]->isArtist == 1) { ?>
        <article id="changeBio" name="changeBio" class="changeBio">
                <form name="bio" id="bio" action="" method="post">
                    <textarea name="biographie" id="biographie" class="biographie" placeholder="Entrez votre biographie"></textarea>
                    <button>Valider</button>
                </form>
        </article>
    <?php } ?>

    <article id="changeData" class="changeData" name="changeData">

        <h2>Modifier mes informations personnelles</h2>

        <div class="formUser">
            <form action="" method="post" id="inscription" class="inscription">


                <fieldset>
                    <legend>Nom</legend>
                    <input type="text" placeholder="Nom" id="lastname" name="lastname">
                    <input type="text" placeholder="Prénom" id="firstname" name="firstname">
                </fieldset>

                <fieldset>
                    <legend>Mot de passe</legend>
                    <input type="password" placeholder="Entrez votre mot de passe" id="pswd" name="password" title="Votre mot de passe doit contenir un minimum de 6 caractères dont  au moins une majuscule, une minuscule et un chiffre">
                    <input type="password" placeholder="Confirmez votre mot de passe" id="mdp" name="mdp">
                </fieldset>

                <fieldset>
                    <legend>Contact</legend>
                    <input type="tel" name="phone" id="phone" placeholder="Numéro de téléphone">
                    <input type="email" name="email" id="mail" placeholder="xyz@xyz.com">
                </fieldset>


                <button id="envoi" name="form">Changer les informations perso</button>
            </form>
        </div>



        <div class="formAdress">
            <form action="" method="post" id="AdresseFacture">

                <fieldset class="adress">
                    <legend>Adresse de facturation</legend>
                    <div class="adress">
                        <input list="adresse" placeholder="Adresse rue" id="address" name="address">
                        <ul id="adresseComplete">
                        </ul>
                        <input type="text" hidden="hidden" name="housenumber" id="housenumber">
                        <input type="text" hidden="hidden" name="street" id="street">
                        <input type="text" hidden="hidden" name="city" id="city">
                        <input type="text" hidden="hidden" name="postcode" id="postcode">
                    </div>
                </fieldset>
                <button id="envoi1" name='form2' hidden='true'>Changement addresse facturation</button>
            </form>

            <form action="" method="POST" id="AdresseDelivery">

                <fieldset class="adress2">
                    <legend>Adresse de livraison</legend>
                    <div class="adress2">
                        <input list="adresse2" placeholder="Adresse rue" id="address2" name="address2">
                        <ul id="adresseComplete2">
                        </ul>
                        <input type="text" hidden="hidden" name="housenumber2" id="housenumber2">
                        <input type="text" hidden="hidden" name="street2" id="street2">
                        <input type="text" hidden="hidden" name="city2" id="city2">
                        <input type="text" hidden="hidden" name="postcode2" id="postcode2">
                    </div>
                </fieldset>

                <button id="envoi2" name='form3' hidden='true'>Changement adresse livraison</button>
            </form>
        </div>
    </article>




        <article id="history" class="history" name='history'>
            <div>
                <h3> Historique d'achat</h3>
                <p>Vérifier les derniers achats réalisés</p>
            </div>
        </article>

        <article id="delivery" class="delivery" name='delivery'>

            <h3><img src="./assets/image/user/location.png" alt="commande" style="width:16px;"> Suivi de commandes</h3>
            <p>Vérifier le statut de vos commandes</p>

        </article>

        <article id="dataCard" class="dataCard" name='dataCard'>

            <h3>Informations bancaires</h3>
            <p>Cartes enregistrée</p>

        </article>


    <article id="changePayment" class="changePayment" name="changePayment">
        <p>Modifier les moyens de paiement</^p>

    </article>


</section>


<script src="./script/script.js"></script>
<script src="./script/adresse.js"></script>
<?php
require './partials/footer.php'
?>