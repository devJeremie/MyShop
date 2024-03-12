<?php 

//initialisation de la connexion
$serverName = 'localhost';
$username = 'root';
$password = '';
$dbname = 'myshop';

//création de la connexion
$connection = new mysqli($serverName, $username, $password, $dbname); 


$id = '';
$name = '';
$email = '';
$phone = '';
$adress = '';

$errorMessage = '';
$successMessage = '';

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    //methode get : recupere et affiche les données du client
    if(!isset($_GET["id"])) {//si il existe pas alors on redirige et on quitte(exit)
        header("location: /myshop/index.php");
        exit;
    }
    $id = $_GET["id"]; 

    //lis les lignes du client selectionné en base de données
    $sql = "SELECT * FROM clients  WHERE id = $id";
    $result = $connection->query($sql);//execute la requete
    $row = $result->fetch_assoc();//lis les données de la database 
    
    //sinon on le redirige vers index.php
    if(!$row) {
        header('location: /myshop/index.php');
        exit;
    }
    //stockage des données de la bdd
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $adress = $row['adress'];
   
    }
    else{
    //methode post : modifie les données du client
    $id = $_POST['id'];
    $name = $_POST['nom'];
    $email = $_POST['email'];
    $phone = $_POST['telephone'];
    $adress = $_POST['adresse'];
    //verifie si champ vide et si oui  m'essage d'erreur
    do {
        if (empty($id) || empty($name) || empty($email) || empty($phone) || empty($adress) ) {
            $errorMessage = 'Veuillez remplir tout les champs.';
            break;
        }//Requête d'update des données
        $sql = "UPDATE clients" .
                "SET name = '$name', email = '$email, phone = '$phone', adress = '$adress' ".
                "WHERE id= $id ";
        //execution de la requete
        $result = $connection->query($sql);
        //Si erreur envoie d'un message d'erreur
        if (!$result){
            $errorMessage = "Requête invalide" . $connection->error;
            break;
        }
        //si tout s'est bien passé on affiche un message puis on redirige
        $successMessage ="Modification réussie";

        header("location: /myshop/index.php");

    }while(false);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Ma boutique</title>
</head>
<body>
    <div class="container my-5">
        <h2>Nouveau client</h2>
        <!--Affichage message d'erreur-->
        <?php 
            if (!empty($errorMessage)) {
                echo"
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>{$errorMessage}</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                ";
            }
        ?>
        <form method="post">
            <input type="hidden" name="id"<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nom</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Téléphone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Adresse</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="adress" value="<?php echo $adress; ?>">
                </div>
            </div>

            <?php 
                if(!empty($successMessage)) {
                    echo "
                    <div class='row mb-3>
                        <div class='offset-sm-3 col-sm-6'>
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>$successMessage</strong>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        </div>
                    </div>
                    ";
                }
            
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary" >Soumettre</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/myshop/index.php" role="button">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>