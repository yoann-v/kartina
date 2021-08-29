<?php
$title = 'shop';
$style = './assets/style/catalogue/catalogue.css';
require './partials/header.php';

use Src\Photo;


$limit = $_GET['nbr'] ?? 12;
$tri = $_GET['tri'] ?? '';
$offset = $_GET['offest'] ?? 0;
$th = $_GET['theme'] ?? null;
$form = $_GET['format'] ?? null;
$orient = $_GET['orientation'] ?? null;

if(isset($th)){
    $filtres['theme_id'] = $th;
}
if(isset($form)){
    $filtres['format_id'] = $form;
}
if(isset($orient)){
    $filtres['orientation_id'] = $orient;
}

$params = ['limit'=> intval($limit), 'offset' => $offset];

$themes = DB::query('SELECT * FROM theme');
$formats = DB::query('SELECT * from format');
$orientations = DB::query('SELECT * from orientation');

$query = 'SELECT photo.id as photo_id, theme_id, titre,  prix, url, artiste_id, nom, prenom, artiste.id as id from photo INNER JOIN artiste ON photo.artiste_id = artiste.id';

$orderBy = '';

if (empty($_GET)) {

    $products = DB::query($query. ' LIMIT :limit OFFSET :offset', $params);

} else {
    
    if (!empty($tri)) {
        switch ($tri) {

            case 'asc':
                $orderBy = ' ORDER BY prix asc';
                break;
            case 'desc':
                $orderBy = ' ORDER BY prix desc';
                break;
            case 'AtoZ':
                $orderBy = ' ORDER BY titre asc';
                break;
            case 'ZtoA':
                $orderBy = ' ORDER BY titre desc';
                break;
        }
    }

    if(!empty($filtres)){
        
    $i = 1;
    $j = $i;

    $where = '';
    

    foreach($filtres as $key => $filtre){

        if($i !== $j){
            $ajout = ' AND';
        }else{
            $ajout = ' WHERE';
        }

        $params[$key] = intval($filtre);

        if($key == 'theme_id'){
            $where .= ' WHERE theme_id = :theme_id';
            $i++;

        }else if($key == 'format_id'){            

            $query .= ' INNER JOIN photo_has_format ON photo.id = photo_has_format.photo_id'; 
        
            $where.= $ajout.' format_id = :format_id';
            $i++;

        }else if($key == 'orientation_id'){
            $query .= ' INNER JOIN photo_has_orientation ON photo.id = photo_has_orientation.photo_id';
            $where .=  $ajout .' orientation_id = :orientation_id';
            $i++;
        }else if($key == 'prix'){
            if($filtre == 50){
                
                $where .= $ajout. ' prix < :prix';
                
            }else if($filtre == 100){
                
                $where .= $ajout. ' prix BETWEEN 50 AND :prix';
                
            }else if($filtre == 200){
                
                $where .= $ajout. ' prix BETWEEN 100 AND :prix';
                
            }else if($filtre == 500){
                
                $where .= $ajout. ' prix BETWEEN 200 AND :prix';
                
            }else if ($filtre == 1000){
                
                $where .= $ajout. ' prix > :prix';

            }
        }
    }

    $query .= $where. ' AND isArtist = 1';
    $query .= $orderBy;
    $query .= ' LIMIT :limit OFFSET :offset';

    }

    $products = DB::query($query, $params);
}

?>

<section class="shop">

    <div id="navbar" class="navbar">
        <h2>Affiner votre recherche</h2>

        <form action="photographies.php" id="filtrage" class="filtrage">

            <div>
                <label for="nbr">Afficher</label>
                <select name="nbr" id="nbr">
                    <option value="12">12</option>
                    <option value="24">24</option>
                    <option value="48">48</option>
                </select>
                <span>par page</span>
            </div>
            <div>
                <label for="tri">Trier par</label>
                <select name="tri" id="tri">
                    <option value="" selected>--</option>
                    <option value="asc">Prix croissant</option>
                    <option value="desc">Prix décroissant</option>
                    <option value="AtoZ">De A à Z</option>
                    <option value="ZtoA">De Z à A</option>
                    <option value="stock">En stock</option>
                </select>
                <span>par page</span>
            </div>
            <input type="number" name="offset" id="offset" value=0 min=0 hidden>


            <div class="divTheme">
                <div class="menu">
                    <h3 onclick="openMenu(event)">Thème</h3>
                </div>
                <div id="filtreThème">
                    <ul>
                        <?php foreach ($themes as $theme) { ?>
                            <li class="theme"><input type="radio" name="filters[theme_id]" value="<?= $theme->id ?>" id="theme-<?= $theme->id ?>"
                            <?php 
                            if(isset($th)){
                                if($th == $theme->id){
                                echo 'checked';
                                }
                            }
                            ?>
                            ><label for="theme-<?= $theme->id?>"><?= mb_ucfirst($theme->theme) ?></label></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="divFormat">
                <h3 onclick="openMenu(event)">Format</h3>
                <div id="filtreFormat">
                    <ul>
                        <?php foreach ($formats as $format) { ?>
                            <li class="format"><input type="radio" name="filters[format_id]" id="size-<?= $format->id ?>" value="<?= $format->id ?>"
                            <?php 
                            if(isset($form)){
                                if($form == $format->id){
                                echo 'checked';
                                }
                            }
                            ?>
                            ><img src="./assets/image/format/size-<?= $format->cover ?>.jpg" alt=""><label for="size-<?= $format->id ?>"><?= mb_ucfirst($format->format); ?></label></li>
                        <?php
                        } ?>
                    </ul>

                </div>
            </div>

            <div class="divOrientation">
                <h3 onclick="openMenu(event)">Orientation</h3>
                <div id="filtreOrientation">
                    <div class="orient" id="orientation">
                        <ul>
                            <?php foreach ($orientations as $orientation) { ?>
                                <li class="orientation"><input type="radio" name="filters[orientation_id]" id="orientation-<?= $orientation->id ?>" value="<?= $orientation->id ?>"
                                <?php 
                                if(isset($orient)){
                                    if($orient == $orientation->id){
                                    echo 'checked';
                                    }
                                }
                            ?>
                                ><img src="./assets/image/orientation/orient-<?= $orientation->cover ?>.jpg" alt=""><label for="orientation-<?= $orientation->id ?>"><?= mb_ucfirst($orientation->orientation); ?></label></li>
                            <?php
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="divPrix">
                <h3 onclick="openMenu(event)">Prix</h3>
                <div id="filtrePrix">
                    <ul>
                        <li class="prix"><input type="radio" name="filters[prix]" id="50" value="50"><label for="50"> Moins de 50€ </label></li>
                        <li class="prix"><input type="radio" name="filters[prix]" id="100" value="100"><label for="100">De 50€ à 100€ </label></li>
                        <li class="prix"><input type="radio" name="filters[prix]" id="200" value="200"><label for="200">De 100€ à 200€ </label></li>
                        <li class="prix"><input type="radio" name="filters[prix]" id="500" value="500"><label for="500">De 200€ à 500€ </label></li>
                        <li class="prix"><input type="radio" name="filters[prix]" id="1000" value="1000"><label for="1000">Plus de 500€ </label></li>

                    </ul>
                </div>
            </div>

        </form>

    </div>

    <div id="catalogue" class="catalogue">

        <div class="filtre" id="filtre">
            <h3>Filtre : </h3>

        </div>

        <div id="post-loading" class="loader" hidden>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>

        <div id="photographies" class="photographies">

            <?php foreach ($products as $product) {
                $photo = new Photo($product);
                echo $photo->view();
            } ?>

        </div>

        <div class="loader" id="loadPages" hidden>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
</section>

<script src="./script/shop.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


<?php require './partials/footer.php'; ?>