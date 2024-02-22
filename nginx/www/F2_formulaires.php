<?php
// Connexion à la base de données
function getDatabaseConnection() {
    $servername = "mysql";
    $username = "root";
    $password = "password";
    $dbname = "F1";
    try {
        return new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}

// Récupération des livrées
function fetchLiveries($conn) {
    $sql = "SELECT l.id as livery_id, l.livery_name, o.id as option_id, o.option_text, o.votes, o.image_path FROM liveries l LEFT JOIN options o ON l.id = o.livery_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getLiveryImagePath($imagePath) {
    $basePath = '.'; // Chemin de base où les images sont stockées
    $fullPath = $basePath . DIRECTORY_SEPARATOR . $imagePath;

    // Vérifier si le fichier existe (en prenant en compte la sensibilité à la casse du système de fichiers)
    if (file_exists($fullPath)) {
        return $imagePath;
    }

    return ''; // Retourner un chemin vide si le fichier n'existe pas
}

// Obtention du label du vote
function getVoteLabel($vote) {
    // Exemple de logique pour le label de vote
    $labels = [
        1 => 'Très moche', 2 => 'Moche', 3 => 'Assez moche', 4 => 'Moyen nul',
        5 => 'OK', 6 => 'Moyennement bien', 7 => 'Assez jolie', 8 => 'Jolie',
        9 => 'Belle', 10 => 'Très belle', 11 => 'Aucun avis'
    ];
    return $labels[$vote] ?? 'Non défini';
}

$conn = getDatabaseConnection();
$liveries = fetchLiveries($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire F1</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        img { cursor: pointer; }
	    .liveries-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Espacement entre les éléments */
    }

    .liveries-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Espacement entre les éléments */
        justify-content: flex-start; /* Aligner les éléments au début de la ligne */
    }
    .livery {
        flex: 1 1 calc(25% - 20px); /* Calcule pour 4 éléments par ligne en soustrayant l'espacement */
        max-width: calc(25% - 20px); /* Largeur maximale pour 4 éléments par ligne, en tenant compte du gap */
    }
.livery img {
    width: 100%; /* Garde la largeur de l'image à 100% du conteneur */
    height: auto; /* Ajuste la hauteur automatiquement pour maintenir le ratio */
    max-height: 150px; /* Fixe une hauteur maximale pour toutes les images */
    object-fit: cover; /* Assure que l'image couvre la zone dédiée, peut-être utile si tu fixes explicitement la hauteur */
}
#imageModal .modal-dialog {
    max-width: 80%; /* Définis la largeur maximale de la modal à 80% de la largeur de l'écran */
}

#imageModal .modal-content {
    height: auto; /* Hauteur automatique basée sur le contenu */
    max-height: 70hv; /* Hauteur minimale pour s'assurer que la modal n'est pas trop petite */
}

#imageModal .modal-body img {
    max-width: 100%; /* Assure que l'image ne dépasse pas la largeur de la modal */
    height: 70hv; /* Permet à l'image de maintenir son ratio d'aspect */
}

</style>

</style>    
</style>
</head>
<body>

<?php if (!empty($liveries)): ?>
<form method="post" action="traiter_formulaire.php">
    <input type="text" name="pseudo" placeholder="Entrez votre pseudo" required>
    <div class="liveries-container">
    <?php foreach ($liveries as $livery): ?>
        <div class="livery">
            <fieldset>
                <legend><?= htmlspecialchars($livery['livery_name']) ?></legend>
                <img src="<?= htmlspecialchars(getLiveryImagePath($livery['image_path'])) ?>" alt="Livrée" data-toggle="modal" data-target="#imageModal" data-img-src="<?= htmlspecialchars(getLiveryImagePath($livery['image_path'])) ?>">
                <select name="vote_<?= htmlspecialchars($livery['livery_id']) ?>">
                    <?php for ($i = 1; $i <= 11; $i++): ?>
                    <option value="<?= $i ?>"><?= getVoteLabel($i) ?></option>
                    <?php endfor; ?>
                </select>
            </fieldset>
        </div>
    <?php endforeach; ?>
    </div>
    <input type="submit" value="Soumettre">
</form>
<?php else: ?>
    Aucune livrée trouvée.
<?php endif; ?>

<!-- Modal pour afficher l'image en grand -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Aperçu de l'image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" style="width: 100%;">
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var imgSrc = button.data('img-src');
        var modal = $(this);
        modal.find('.modal-body #modalImage').attr('src', imgSrc);
    });
});
</script>

</body>
</html>
