<?php
require __DIR__.'/config/config.php';
require __DIR__.'/config/database.php';
require __DIR__.'/config/DB.php';
require __DIR__.'/config/functions.php';
    
global $db;
$query = DB::query("SELECT * FROM artiste");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Admin</title>
</head>
<body class="front">
    <div class="container">
    <div class="row align-items-around">
        <div class="col-9">
            <h1>Pannel administrateur</h1>
        </div>
        <div class="col-3 mt-2">
            <a class="btn btn-success" href="./user.php">Retour</a>
        </div>
    </div>
        <?php foreach($query as $q){?>
            <div>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h2 class="card-title">
                            <?= $q->email; ?>
                        </h2>
                        <div class="d-flex justify-content-evenly">
                                <?php if($q->isArtist == "0"){ ?>
                                    <a class="btn btn-success" href="promouvoir-user.php?id=<?= $q->id;?>">Promouvoir en artiste</a>
                                <?php }else if($q->isArtist == "1"){ ?>
                                    <a class="btn btn-danger" href="promouvoir-user.php?id=<?= $q->id;?>">Remettre en utilisateur</a>
                                <?php } ?>                  
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
    </div>
</body>
</html>