<?php 
//si get contient l'id alors on le lis
if(isset($_GET["id"])) {
    $id = $_GET["id"];

    //initialisation de la connexion
$serverName = 'localhost';
$username = 'root';
$password = '';
$dbname = 'myshop';

//création de la connexion
$connection = new mysqli($serverName, $username, $password, $dbname); 

//execution de la requete de suppression
$sql = "DELETE FROM clients WHERE id=$id";
$connection->query($sql);
}

header('location: /myshop/index.php');
exit;

?>