<?php
$servername = "mysql";
$username = "root";
$password = "Sa23H7xv!Hkdl";
$dbname = "F1";


$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}

$nom = $_POST['nom'];
$email = $_POST['email'];
$reponse = $_POST['reponse'];

$insert_query = "INSERT INTO reponses (nom, email, reponse) VALUES ('$nom', '$email', '$reponse')";

if ($connexion->query($insert_query) === TRUE) {
    echo "Réponse soumise avec succès.";
} else {
    echo "Erreur lors de la soumission de la réponse : " . $connexion->error;
}

$connexion->close();
?>


// Créé un formulaire de ce que tu veu qui rempli une table d'une base de donnée.
// listing des enregistrement
// Ppossibilité du suppriméer un élément
// Possibilité de modifier un élément
// Pilote ou écurie F1


// COmment on se connexion à une base de donnée mysql en PHP
// Faire un formulaire de creation / modification des enregistrement
// les actions de modification et suppression des enregistrements 
// si tu utilises la F1 une photo serait la bienvenue

?>
