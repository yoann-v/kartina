<?php 
ob_start();
$title = 'Login';
$style = './assets/style/login/login.css';
require './partials/header.php'; 
$email = $_POST['email'] ?? '';
$password = $_POST['mdp'] ?? '';

if (!empty($_POST)) {
    $query = DB::query("SELECT * FROM artiste WHERE email = :email",[
        'email' => $email
    ]);
    var_dump($_SESSION);
    if($query && password_verify($password,$query[0]->mdp)){
        $_SESSION['user'] = $query;
        header('Location: index.php');
    } else {
        echo 'Email ou mot de passe incorrect';
    }
}

var_dump($_POST);

?>
       
        <section class="login-page">
            <article class="login">
                   <h2>Déjà client</h2>
                   <div>
                       <form action="" method="post">
                           <div>
                               <div>
                                   <label for="">Adresse e-mail</label>
                                </div>
                                <div>
                                    <input type="text" name="email">
                                </div>
                            </div>
                            <div>
                                <div>
                                <label for="">Mot de passe</label>
                            </div>
                            <div>
                                <input type="password" name="mdp">
                            </div>
                        </div>
                        <div><a href="">Mot de passe oublié ?</a></div>
                        <div>
                            <button type="submit">Se connecter</button>
                        </div>
                    </form>
                </div>
            </article>
            
            <article class="new-account">
                <h2>Vous n'avez pas de compte Kartina</h2>
                <div>
                    <div>Vous pouvez commander sans créer de compte. Vous pouvez créer votre compte plus tard.</div>
                <div>
                    <a href="./form.php">Créer un compte</a>
                </div>
                </div>
            </article>

        </section>
        
        <?php require './partials/footer.php'; ?>
        