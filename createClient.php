<?php
//initialisation de la connexion
    $serverName = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'myshop';

//création de la connexion
$connection = new mysqli($serverName, $username, $password, $dbname); 


    $name = '';
    $email = '';
    $phone = '';
    $adress = '';

//si method POST ok alors initailisation des variable savec les données du form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $adress = $_POST['adress'];

    $errorMessage = ''; //message d'erreur si le formulaire n'est pas valide
    $successMessage = ''; //message de confirmation en cas de validation correct

    //Verification si les champs sont vide et si oui message erreur
    do {
        if (empty($name) || empty($email) || empty($phone) || empty($adress))  {
            $errorMessage = "Tout les champs sont obligatoires";
            break;
        } 

        //Ajoute le nouveau client en bdd
        $sql = "INSERT INTO clients (name, email, phone, adress)" .
               " VALUES ('$name', '$email', '$phone','$adress')";
        $result = $connection->query($sql);
        //si erreur dans la requète alors message
        if (!$result) {
            $errorMessage = "Requètes invalide :" .$connection->error;
            break;
        } 

        $name = '';
        $email = '';
        $phone = '';
        $adress = '';

        $successMessage = 'Profil ajouté avec succés';

        header("location: /myshop/index.php");
        exit;



    } while(false);
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