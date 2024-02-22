<?php
$servername = "mysql";
$username = "root";
$password = "password";
$dbname = "F1";

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Traitement des votes
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'vote_') === 0) {
                $livery_id = (int) str_replace('vote_', '', $key);
                $vote = (int) $value;

                // Ici, vous pouvez insérer ou mettre à jour le vote dans la base de données
                // Exemple : INSERT INTO votes (livery_id, vote) VALUES ($livery_id, $vote) ON DUPLICATE KEY UPDATE vote = $vote
            }
        }

        // Redirection ou gestion après soumission
        header('Location: merci.php'); // Assurez-vous que merci.php gère le message de remerciement.
        exit;
    }

    // Requête pour récupérer les données des livrées
    $sql = "SELECT l.id as livery_id, l.livery_name, o.id as option_id, o.option_text, o.votes, o.image_path FROM liveries l LEFT JOIN options o ON l.id = o.livery_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $liveries = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Votez pour vos livrées préférées</title>
</head>
<body>
    <h2>Votez pour vos livrées préférées</h2>
    <?php if (!empty($liveries)): ?>
        <form method="post" action="">
            <?php foreach ($liveries as $livery): ?>
                <fieldset>
                    <legend><?= htmlspecialchars($livery['livery_name']) ?></legend>
                    <?php if (!empty($livery['image_path'])): ?>
                        <img src="<?= htmlspecialchars($livery['image_path']) ?>" alt="Livrée">
                    <?php endif; ?>
                    <select name="vote_<?= htmlspecialchars($livery['livery_id']) ?>">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>"><?= getVoteLabel($i) ?></option>
                        <?php endfor; ?>
                    </select>
                </fieldset>
            <?php endforeach; ?>
            <input type="submit" value="Soumettre vos votes">
        </form>
    <?php else: ?>
        <p>Aucune livrée trouvée.</p>
    <?php endif; ?>
</body>
</html>

