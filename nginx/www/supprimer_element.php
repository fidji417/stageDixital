<?php
if (isset($_GET['pseudo'])) {
    $pseudo = $_GET['pseudo'];
    $allVotes = file('statistique.txt');
    $newVotes = array_filter($allVotes, function($line) use ($pseudo) {
        list($liveryId, $linePseudo, $vote) = explode(':', trim($line));
        return $linePseudo !== $pseudo; // Conserve seulement les lignes où le pseudo est différent
    });

    // Réécrire le fichier sans les votes du pseudo
    file_put_contents('statistique.txt', implode("\n", $newVotes));

    // Redirection vers F1-formulaire.php
    header("Location: confirmation-suppression.php");
    exit;
}

?>

