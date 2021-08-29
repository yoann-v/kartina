<?php
ob_start();
$title = 'Création de compte';
$style = './assets/style/form/form.css';
require './partials/header.php';

$civil = $_POST['civil'] ?? 0;
$lastname = $_POST['lastname'] ?? '';
$firstname = $_POST['firstname'] ?? '';
$password = $_POST['password'] ?? '';
$mdp = $_POST['mdp'] ?? '';
$phone = $_POST['phone'] ?? 0;
$email = $_POST['email'] ?? '';
$country = $_POST['country'] ?? '';



//adresse split pour la bdd

$housenumber= $_POST['housenumber'] ?? '';
$street= $_POST['street'] ?? '';
$city= $_POST['city'] ?? '';
$postcode= $_POST['postcode'] ?? '';

$lastname = htmlspecialchars($lastname);
$firstname =htmlspecialchars($firstname);
$phone = htmlspecialchars($phone);
$email = htmlspecialchars($email);
$country = htmlspecialchars($country);
$housenumber= htmlspecialchars($housenumber);
$street= htmlspecialchars($street);
$city= htmlspecialchars($city);
$postcode= htmlspecialchars($postcode);

$hash = password_hash($password , PASSWORD_DEFAULT);

$errors = [];


if (!empty($_POST)){
    if(DB::query('SELECT * from artiste WHERE email = :email', ['email'=>$email])){
        $errors['verifEmail'] = "L'email est déjà utilisé";
    }
    if(strlen($lastname)<=2){
        $errors['lastname'] = "Le nom de famille n'est pas correct";
    }
    if(strlen($firstname)<=2){
        $errors['firstname'] = "Le prenom n'est pas correct";
    }

    if($password !== $mdp){
        $errors['password'] = "Les mots de passes ne correspondent pas";
    }
    if(strlen($phone)<7 && !ctype_digit($phone)){
        $errors['phone'] = "le numero de téléphone n'est pas correct";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide";
    }
    if(strlen($housenumber)<1){
        $errors['housenumber'] = "Le numéro de l'habitation n'est pas bon";
    }
    if(strlen($country)<2){
        $errors['country'] = "Le pays n'est pas valide";
    }
    if(strlen($city)<2){
        $errors['city'] = "La ville n'est pas valide";
    }
    if(strlen($street)<2){
        $errors['street'] = "La rue n'est pas valide";
    }
    if(!ctype_digit($postcode) && strlen($postcode)!=5){
        $errors['postcode'] ="Le code postal n'est pas valide";
    }

    if (empty($errors)) {
        global $db;
        DB::postQuery(
            'INSERT INTO artiste (email, mdp, civilite, nom, prenom, telephone, isArtist, biographie) VALUES (:email, :password, :civilite, :nom, :prenom, :telephone, :isArtist, :biographie)',[
                'email' => $email,
                'password' => $hash,
                'civilite' => $civil,
                'nom' => $lastname,
                'prenom' => $firstname,
                'telephone' => $phone,
                'isArtist' => 0,
                'biographie' => ''
            ]
        );

        $artist_id = DB::lastInsertId();


        DB::postQuery(
            'INSERT INTO adresse_facturation (pays, ville, cp, rue, artiste_id, n_rue) VALUES (:pays,:ville,:cp,:rue,:artiste_id, :n_rue)',[
                'pays' => $country,
                'ville' => $city,
                'cp' => $postcode,
                'rue' => $street,
                'artiste_id' => $artist_id,
                'n_rue' => $housenumber
            ]
        );

        DB::postQuery(
            'INSERT INTO adresse_livraison (pays, ville, cp, rue, nom, prenom, artiste_id, n_rue) VALUES (:pays,:ville,:cp,:rue, :nom, :prenom, :artiste_id, :n_rue)',[
                'pays' => $country,
                'ville' => $city,
                'cp' => $postcode,
                'rue' => $street,
                'nom' => $lastname,
                'prenom' => $firstname,
                'artiste_id' => $artist_id,
                'n_rue' => $housenumber
            ]
        );

        $query = DB::query("SELECT * FROM artiste WHERE email = :email",[
            'email' => $email
        ]);

        $adresse = DB::query("SELECT * FROM adresse_facturation WHERE id = :id",[
            'id' => $artist_id
        ]);

        $_SESSION['artiste'] = $adresse;
        
        $_SESSION['user'] = $query[0];

        header('Location: index.php');
    }
    else {
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>'.$error.'</li>'; // Affiche chaque message d'erreur
        }
        echo '</ul>';
    }
}

?>

    <section class="inscription">
        <h2>Formulaire d'inscription</h2>

        <div class="form">
            <form action="" method="post" id="inscription" class="inscription" name="form" >

                <fieldset class="civil">
                    <legend>Civilité</legend>
                    <label for="">Monsieur</label><input type="radio" name="civil" id="mr" value = "0" checked>
                    <label for="">Madame</label><input type="radio" name="civil" id="mrs" value = "1">
                </fieldset>

                <fieldset>
                    <legend>Nom</legend>
                    <input type="text" placeholder="Nom" id="lastname" name="lastname">
                    <input type="text" placeholder="Prénom" id="firstname" name="firstname">
                </fieldset>

                <fieldset>
                    <legend>Mot de passe</legend>
                    <input type="password" placeholder="Entrez votre mot de passe" id="pswd" title="Votre mot de passe doit contenir un minimum de 6 caractères dont  au moins une majuscule, une minuscule et un chiffre" name="password">
                    <input type="password" placeholder="Confirmez votre mot de passe" id="mdp" name="mdp">
                </fieldset>

                <fieldset>
                    <legend>Contact</legend>
                    <input type="tel" name="phone" id="phone" placeholder="Numéro de téléphone" >
                    <input type="email" name="email" id="mail" placeholder="xyz@xyz.com" >
                </fieldset>

                <fieldset class="adress">
                    <legend>Adresse</legend>                    
                    <div class="adress">
                        <input list="adresse" placeholder="Adresse rue" id="address" name="address">
                        <ul id="adresseComplete">
                        </ul>
                        <input type="text" hidden="hidden" name="housenumber" id="housenumber">
                        <input type="text" hidden="hidden" name="street" id="street">
                        <input type="text" hidden="hidden" name="city" id="city">
                        <input type="text" hidden="hidden" name="postcode" id="postcode">
                    </div>
                    <div class="country">
                        <select name="region" id="region" >
                            <option value="">Choisissez votre continent...</option>
                            <option value="africa">Afrique</option>
                            <option value="europe">Europe</option>
                            <option value="asia">Asie</option>
                            <option value="americas">Amérique</option>
                            <option value="oceania">Océanie</option>
                        </select>
                        <input list="country" name="country">
                        <datalist id="country">
                            <option value="">Choisissez votre pays...</option>
                        </datalist>
                    </div>
                </fieldset>

                <button id="envoi">S'inscrire</button>
            </form>
        </div>
    </section>

    <script src="./script/form.js"></script>

<?php
require './partials/footer.php'
?>

