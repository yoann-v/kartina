<?php

// Pour mettre le premier char en majuscule 
function mb_ucfirst($string, $encoding = 'UTF-8'){
    $strlen = mb_strlen($string, $encoding);
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}

/**
 * Ajouter une photo dans le panier
 */
function addToCart($id, $format, $finition, $cadre, $prix) {
    $item = [
        'id' => $id,
        'format' => $format,
        'finition' => $finition,
        'cadre' => $cadre,
        'prix' => $prix,
        'quantity' => 1,
    ];

    $_SESSION['cart'][] = $item;
}

/**
 * Modifier une photo dans le panier
 */
function updateCart($id, $format, $finition, $cadre, $prix) {
    $indexToUpdate = null;

    foreach (panier() as $index => $cart) {
        if ($id === $cart['id'] && 
            $format === $cart['format'] && 
            $finition === $cart['finition'] && 
            $cadre === $cart['cadre']) {
                $indexToUpdate = $index;
            }
    }

    $_SESSION['cart'][$indexToUpdate]['quantity']++;
    $cart['prix'] = $prix * $_SESSION['cart'][$indexToUpdate]['quantity'];
}


/**
 * Vérifier si une photo est présent dans le panier
 */
function checkCart($id, $format, $finition, $cadre) {
    foreach (panier() as $cart) {
        if ($id === $cart['id'] && 
            $format === $cart['format'] && 
            $finition === $cart['finition'] && 
            $cadre === $cart['cadre']) {
            return true;
        }
    }

    return false;
}

/**
 * Récupérer le panier
 */
function panier() {
    return $_SESSION['cart'] ?? [];
}
