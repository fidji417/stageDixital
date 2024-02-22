<?php
// Connexion à la base de données
$servername = "mysql";
$username = "root";
$password = "Sa23H7xv!Hkdl";
$dbname = "F1";
$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "Merci, votre vote a bien été pris en compte.<br>";
echo "Recapitulatif de vos choix :<br>";

$votes = file("statistique.txt");

foreach ($votes as $vote) {
    list($liveryId, $pseudo, $voteValue) = explode(':', trim($vote));

    $stmtLivery = $conn->prepare("SELECT livery_name FROM liveries WHERE id = ?");
    $stmtLivery->execute([$liveryId]);
    $livery = $stmtLivery->fetch(PDO::FETCH_ASSOC);

    // Utilisez la fonction getImagePath pour obtenir le chemin de l'image
    $imagePath = getImagePath($liveryId);

    if ($livery) {
        echo '<div>';
echo '<fieldset>';        
// Affichez l'image en utilisant le chemin retourné par la fonction getImagePath
        echo "<a href='#' onclick='enlargeImage(\"" . htmlspecialchars($imagePath) . "\")'>";
        echo "<img src='" . htmlspecialchars($imagePath) . "' alt='Image' width='700px' class='clickableImage' style='cursor:pointer'></a><br>";
        echo '<legend>'. "|| Pseudo : " . htmlspecialchars($pseudo)."" . "  || Écurie (Livrée) : " . htmlspecialchars($livery['livery_name'])." ." . " || Vote : " . getVoteLabel($voteValue)." ." ."||" . '</legend>'."<br>";
        echo '</div>';
    }
}
echo '</fieldset>';
// Lien pour modifier le vote (à la fin)
echo "|";
echo "<a href='http://vps-ea51236b.vps.ovh.net/F1-formulaire.php'>modifier le vote</a>" ;
echo "| - |";
echo "<a href='http://vps-ea51236b.vps.ovh.net/supprimer_element.php?pseudo='>supprimer le vote</a>";
echo "| - |";
echo "<a href='http://vps-ea51236b.vps.ovh.net/'>retourner a l'accueil</a>";
echo "|";
// Fonction pour obtenir le chemin de l'image basé sur l'ID de la livrée
function getImagePath($liveryId) {
    switch ($liveryId) {
        case 1: return 'W15.png';
        case 2: return 'RB20.png';
        case 3: return 'SF24.png';
        case 4: return 'MCL38.png';
        case 5: return 'a524.png';
        case 6: return 'C44.jpeg';
        case 7: return 'AMR24.png';
        case 8: return 'VF-24.png';
        case 9: return 'FW46.png';
        case 10: return 'Visa-Cash-App-RB-F1-2024.jpeg';
        default: return 'image_defaut.png'; // Chemin d'une image par défaut si l'ID n'est pas trouvé
    }
}

//label du vote
function getVoteLabel($vote) {
    switch ($vote) {
        case 2: return ' Très moche ';
        case 3: return ' Moche ';
        case 4: return ' Assez moche ';
        case 5: return ' Moyennement moche ';
        case 6: return ' Ok ';
        case 7: return ' Moyennement bien ';
        case 8: return ' Assez jolie ';
        case 9: return ' Jolie';
        case 10: return ' Belle ';
        case 11: return ' Très belle ';
        case 1: return ' Aucuns avis ';
    }
}
?>

<!-- Script JavaScript pour agrandir les images -->
<script>
    function enlargeImage(imagePath) {
        window.open(imagePath, '_blank');
    }
</script>

