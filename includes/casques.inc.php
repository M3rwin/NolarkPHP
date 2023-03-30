<?php

$cnx = new PDO('mysql:host=127.0.0.1;dbname=nolark', 'nolarkuser', 'nolarkpwd');

$req = 'SELECT casque.id, nom, modele, marque, type, libelle, prix, classement, image, stock';
$req .= ' FROM casque INNER JOIN type ON casque.type=type.id';
$req .= ' INNER JOIN marque ON casque.marque=marque.id';

$res = $cnx->query($req);

/*$stock = $res->fetch(PDO::FETCH_OBJ);
if($stock->stock<=0){
    $etat='stockko';
} else {
    $etat="stockok";
}
*/

$etat='stockok';

// Récupération nom de la page courante dans $pageActuelle
$scriptName = filter_input(INPUT_SERVER, 'SCRIPT_NAME');
$pageActuelle = substr($scriptName, strrpos($scriptName, '/') + 1);

if($pageActuelle=='cross.php'){
    $type = 1;
}elseif($pageActuelle=="enfants.php"){
    $type = 2;
}elseif($pageActuelle=="piste.php"){
    $type = 3;
}elseif($pageActuelle=='route.php'){
    $type = 4;
}


echo '<section id="casques">';
while ($ligne = $res->fetch(PDO::FETCH_OBJ)) {
    if($ligne->type==$type){
        echo '<article>';
        echo '<img src="../images/casques/', $ligne->libelle, '/', $ligne->image,
            '" alt="', $ligne->modele, '">';
        echo '<p class="', $etat, '"><abbr data-tip="', $ligne->stock, 'casques en stock">stock</abbr></p>';
        echo '<p class="prix">', $ligne->prix, '€</p>';
        echo '<p class="marque">', $ligne->nom, '</p>';
        echo '<p class="modele">', $ligne->modele, '</p>';
        echo '<img class="classement classement', $ligne->classement, '" src="../images/casques/etoiles.gif" alt="Classement 0,5 sur 5">';
        echo '</article>';
    }
}
echo '</section>';