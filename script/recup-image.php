<?php

require __DIR__.'/../config/DB.php';

set_time_limit(500);

$json = file_get_contents('../images-yk-copy.json');

$json = json_decode($json);

$photos = $json->ListBucketResult->Contents[2]->photos;

$arrayArtists = [];

DB::postQuery('SET FOREIGN_KEY_CHECKS = 0');
DB::postQuery('TRUNCATE TABLE artiste');
DB::postQuery('TRUNCATE TABLE photo');
DB::postQuery('TRUNCATE TABLE adresse_facturation');
DB::postQuery('TRUNCATE TABLE photo_has_format');
DB::postQuery('TRUNCATE TABLE photo_has_orientation');
DB::postQuery('SET FOREIGN_KEY_CHECKS = 1');

$mdp = 'azerty';
$mdp = password_hash($mdp, PASSWORD_DEFAULT);


foreach($photos as $photo){
    $string = $photo->Key;
    $url = 'https://storage.googleapis.com/yk-cdn/'.$string;
    // var_dump($url);



    $string = strstr($string, '.jpg', true);
    $string = substr($string, 14);
    $artistName = strstr($string, '/', true);
    $email = $artistName.'@domain.com';
    $title = substr(strstr($string, '/', false), 1);
    $title = str_replace('-', ' ', $title);

    $price = [49, 59, 89, 119, 149, 169, 219, 319];
    $prix = $price[array_rand($price, 1)];
    $quantity = rand(1, 1000);

    
    $firstname = strstr($artistName, '-', true);
    $name = substr(strstr($artistName, '-', false), 1);

    $phone = '06';
    for($i = 0; $i<8; $i++){
        $phone .= rand(0,9);
    }
    $isArtist = true;
    $theme = rand(1,8);
    $civil = rand(0,1);
    $date = date('Y-m-d', rand(1262055681,1598055681));
    $biography = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum ea pariatur consequatur adipisci doloremque? Sed at repellat, inventore veniam rem provident accusamus maxime necessitatibus vel magni voluptates, minus obcaecati cumque.';
    
    $pays = ['France', 'Italy', 'Germany', 'England', 'United States', 'Poland'];
    $ville = ['France'=>'Paris', 'Italy'=>'Roma', 'Germany'=>'Berlin', 'England' => 'London', 'United States'=>'Washington', 'Poland'=>'Varsovie'];

    $cp = '';

    for($i = 0; $i<5; $i++){
        $cp .= rand(0,9);
    }

    $paysName = $pays[array_rand($pays, 1)];
    $villeName = $ville[$paysName];


    $artistAdress = [
        'pays'=> $paysName,
        'ville'=> $villeName,
        'cp'=> $cp,
        'rue'=> 'Lorem Ipsum',
        'n_rue'=> rand(1,99),
    ];
    
    
    //var_dump($photo);
    //var_dump($email);
    // var_dump($date);
    //var_dump($artistName);
    //var_dump($phone);
    if(array_key_exists($artistName, $arrayArtists)){
        $arrayArtists[$artistName]['photos'][] = ['url' => $url, 'titre' => $title, 'theme_id' => $theme, 'date_publication' => $date, 'prix' => $prix];
        
    }else{
        $arrayArtists[$artistName]['artist'] = ['prenom'=> $firstname, 'nom' => $name, 'email'=> $email, 'telephone'=> $phone, 'isArtist'=> $isArtist, 'civilite' => $civil, 'mdp' => $mdp, 'biographie'=>$biography];
        $arrayArtists[$artistName]['adresse'] = $artistAdress;
        $arrayArtists[$artistName]['photos'][] = ['url' => $url, 'titre' => $title, 'theme_id' => $theme, 'date_publication' => $date, 'prix' => $prix];

    }
    //var_dump($arrayArtists);


}


foreach($arrayArtists as $artist){
    
    $query = DB::postQuery('INSERT into artiste (email, mdp, civilite, nom, prenom, telephone, isArtist, biographie) VALUES (:email, :mdp, :civilite, :nom, :prenom, :telephone, :isArtist, :biographie) ', $artist['artist']);
    $artist_id = DB::lastInsertId();
    $artist['adresse']['artiste_id'] = $artist_id;
    
    $query = DB::postQuery('INSERT into adresse_facturation (pays, ville, cp, rue, artiste_id, n_rue) VALUES (:pays, :ville, :cp, :rue, :artiste_id, :n_rue) ', $artist['adresse']);

    foreach($artist['photos'] as $photo){

        $photo['artiste_id'] = $artist_id;

        $query = DB::postQuery('INSERT into photo (titre, url, date_publication, theme_id, artiste_id, prix) VALUES (:titre, :url, :date_publication, :theme_id, :artiste_id, :prix)', $photo);

        $photo_id = DB::lastInsertId();

        $orientation_id = rand(1,4);

        $query = DB::postQuery('INSERT into photo_has_orientation (photo_id, orientation_id) VALUES (:photo_id, :orientation_id)', ['photo_id'=> $photo_id, 'orientation_id'=> $orientation_id]);

        for($i = 1; $i <= 4; $i++){
            
            if($i == 1){
                $quantite = rand(0,500);
            }else if($i ==2){
                $quantite = rand(0,50);
            }else if($i == 3){
                $quantite = rand(0,30);
            }else if($i == 4){
                $quantite = rand(0,10);
            }

            $query = DB::postQuery('INSERT into photo_has_format (photo_id, format_id, quantity) VALUES (:photo_id, :format_id, :quantity)', ['photo_id'=> $photo_id, 'format_id'=> $i, 'quantity'=> $quantite]);
        }
    }; 
    
}
