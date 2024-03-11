<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>List of Clients</h2>
        <a href="/myshop/createClient.php" class="btn btn-primary" role="button">New Client</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Crée le : </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!--Début du code php connexion bdd-->
                <?php 
                    $serverName = 'localhost';
                    $userName = 'root';
                    $password = '';
                    $dbname = 'myshop';
                //création de la connexion
                    $connexion = new mysqli($serverName, $userName, $password, $dbname);
                //vérification si la connexion a réussi
                    if ($connexion->connect_error) {
                        die("Connexion echoué : " . $connexion->connect_error);
                    }
                //lire toutes les données de la table clients
                    $sql = "SELECT * FROM clients";
                    $result = $connexion->query($sql);
                //verifier si la requete est bien exécuté
                    if (!$result) {
                        die ("Requête invalide : ". $connexion->error);
                    }
                //lire les datas de chaque ligne
                    while($row = $result->fetch_assoc()) {
                        echo "
                            <tr>
                                <td>$row[id]</td>
                                <td>$row[name]</td>
                                <td>$row[email]</td>
                                <td>$row[phone]</td>
                                <td>$row[adress]</td>
                                <td>$row[created_at]</td>
                                <td>
                                    <a class='btn btn-primary btn-sm' href='/myshop/editClient.php?id=$row[id]'>Modifier</a>
                                    <a class='btn btn-danger btn-sm' href='/myshop/deleteClient.php?id=$row[id]'>Supprimer</a>
                                </td>
                            </tr>
                        ";
                    }
                ?>
                
            </tbody>
        </table>
    </div>
</body>
</html>