<?php
$servername = "mysql";
$username = "root";
$password = "Sa23H7xv!Hkdl";
$dbname = "F1";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les données des livrées
  $sql = "SELECT l.id as livery_id, l.livery_name, o.id as option_id, o.option_text
        FROM liveries l
        LEFT JOIN options o ON l.id = o.livery_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
 
//Vérification si des données ont été trouvées
    $liveries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($liveries) {
        echo '<form method="post" action="traiter_formulaire.php">';

//dehors de la boucle
echo '<legend>';
echo '<input type="text" name="pseudo" placeholder="merci d\'entrez un pseudo" required>';
echo ' Attention :Un pseudo ne peut avoir qu\'un vote (modifiable) par livrées.';
echo '</legend>';
        echo '||  Quel est votre avis sur les livrées ?';
        
         foreach ($liveries as $livery) {
            echo '<fieldset>';
            echo '<legend>'.'||' . htmlspecialchars($livery['livery_name']) . '||'.'</legend>';

            // Affichage de l'image de la livrée
            $imagePath = getLiveryImagePath($livery['livery_id']);

            if (!empty($imagePath)) {
                // Modification ici pour rendre l'image cliquable et s'ouvrir dans une nouvelle fenêtre/tab
                echo "<a href='" . htmlspecialchars($imagePath) . "' target='_blank'><img src='" . htmlspecialchars($imagePath) . "' alt='Livrée' style='width: 600px;'></a>";
            }

            // Affichage du menu déroulant pour le vote
            echo '<select name="vote_' . htmlspecialchars($livery['livery_id']) . '">';
            for ($i = 1; $i <= 11; $i++) {
                echo '<option value="' . $i . '">' . getVoteLabel($i) . '</option>';
            }
            echo '</select>';

            echo '</fieldset>';
        }

        echo '<input type="submit" value="Soumettre votre vote">';
        echo '</form>';
    } else {
        echo "Aucune livrée trouvée.";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

function getLiveryImagePath($liveryId) {
    switch ($liveryId) {
        // Vos chemins d'images ici, assurez-vous qu'ils sont corrects et accessibles
        // Exemple :
          case 1:     return 'W15.png';
        case 2:
            return 'RB20.png';
        case 3:
            return 'SF24.png';
        case 4:
            return 'MCL38.png';
        case 5:
            return 'a524.png';
        case 6:
            return 'C44.jpeg';
        case 7:
            return 'AMR24.png';
        case 8:
            return 'VF-24.png';
        case 9:
            return 'FW46.png';
        case 10:
            return 'Visa-Cash-App-RB-F1-2024.jpeg';
        default:
            return ''; // Chemin par d  faut ou vide si aucune imageé
    }
}

// Fonction pour obtenir le label du vote
function getVoteLabel($vote) {
    switch ($vote) {
        case 2: return 'Très moche';
        case 3: return 'Moche';
        case 4: return 'Assez moche';
        case 5: return 'Moyen nul';
        case 6: return 'OK';
        case 7: return 'Moyennement bien';
        case 8: return 'Assez jolie';
        case 9: return 'Jolie';
        case 10: return 'Belle';
        case 11: return 'Très belle';
        case 1: return 'Aucun avis';
        default: return 'Non défini';
    }
}
echo '<a href="http://vps-ea51236b.vps.ovh.net">Retour a l\'acceuil</a>'; 
$conn = null;

?>

