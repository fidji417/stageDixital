<?php
// ... (connexion à la base de données et autres fonctionnalités)

// Initialisation d'un tableau pour conserver les votes
$updatedVotes = [];

// Récupérer le contenu actuel du fichier et le transformer en tableau
$votes = file("statistique.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Traiter chaque vote
// Traiter chaque vote
foreach ($_POST as $key => $value) {
    if ($key === 'pseudo') {
        $pseudo = htmlspecialchars($value);
        continue; // Ignore 'pseudo' key for voting
    }

    if (strpos($key, 'vote_') === 0) {
        $liveryId = substr($key, 5);
        $vote = (int)$value;
        $pseudoFound = false;

        // Vérifier et mettre à jour le vote si le pseudo existe déjà
        foreach ($votes as &$line) {
            list($existingLiveryId, $existingPseudo, $existingVoteValue) = explode(':', trim($line));

            if ($existingPseudo === $pseudo && $existingLiveryId === $liveryId) {
                // Mettre à jour le vote existant
                $line = "$liveryId:$pseudo:$vote";
                $pseudoFound = true;
                break; // Sortir de la boucle si le pseudo est trouvé et mis à jour
            }
        }

        // Ajouter le nouveau vote si le pseudo n'existe pas
        if (!$pseudoFound) {
            $votes[] = "$liveryId:$pseudo:$vote";
        }
    }
}
file_put_contents('statistique.txt', implode("\n", $votes));

header("Location: merci.php");
exit();
?>

