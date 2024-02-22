<?php
if  ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "mysql";
    $username = "root";
    $password = "password";
    $dbname = "F1";

    // Connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Traitement des votes
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'livery_') === 0) {
            $optionId = (int)$value;
            $sql = "UPDATE options SET votes = votes + 1 WHERE id = $optionId";
            $conn->query($sql);
        }
    }

    // Fermer la connexion à la base de données
    $conn->close();

    echo "Votes enregistrés avec succès!";
}
?>
