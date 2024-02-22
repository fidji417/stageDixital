<?php
// Vérifie si le formulaire a été soumis
if (isset($_POST['formulaire_envoye']) && $_POST['formulaire_envoye'] == 1) {

   // Vos opérations de traitement du formulaire ici

   // Enregistrement des statistiques dans un fichier
   $statistiques = "Date: " . date("Y-m-d H:i:s") . "\n";
   $statistiques .= "IP de l'utilisateur: " . $_SERVER['REMOTE_ADDR'] . "\n";
   // Ajoutez d'autres statistiques pertinentes
   $statistiques .= "------------------------------\n";

   file_put_contents('statistiques.txt', $statistiques, FILE_APPEND);

   // Redirection vers une page de confirmation ou autre
   header("Location: confirmation.php");
   exit();
}
?>
