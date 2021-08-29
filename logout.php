<?php
ob_start();
session_start();

// On déconnecte l'utilisateur
unset($_SESSION['user']);

header('Location: index.php');

?>