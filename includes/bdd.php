<?php
$dsn = 'localhost';
$user = 'root';
$password ='';

try {
    $bdd = new PDO("mysql:host=$dsn;dbname=webcms",$user,$password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //if ($dbb) {
    //    echo "Vous êtes connecté à la base de données";
    //}

} catch (PDOException $e) {
    echo "Echec lors de la connexion: ".$e->getMessage();
}
?>