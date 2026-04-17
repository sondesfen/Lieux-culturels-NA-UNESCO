<?php
$mysqli = new mysqli("localhost", "admin", "admin", "corpus_ctm");

if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT * FROM sites_unesco");

$sites = [];
while ($row = $result->fetch_assoc()) {
    $sites[] = $row;
}
?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patrimoine Mondial de l'UNESCO - Maghreb</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; max-width: 900px; margin: auto; padding: 20px; background-color: #f4f7f6; }
        header { text-align: center; margin-bottom: 40px; border-bottom: 3px solid #3498db; padding-bottom: 20px; }
        article { background: white; border-radius: 12px; padding: 25px; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        img { max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 15px; display: block; }
        h2 { color: #2c3e50; margin-top: 0; }
        .badge { background: #3498db; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.85em; text-transform: uppercase; font-weight: bold; }
        .map-container { margin-top: 15px; border-radius: 8px; overflow: hidden; border: 1px solid #ddd; }
        footer { text-align: center; font-size: 0.9em; color: #7f8c8d; margin-top: 50px; padding: 20px; }
        a { color: #2980b9; text-decoration: none; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<header>
    <h1>Exploration du Patrimoine Mondial de l'UNESCO</h1>
    <p>Ce projet présente des sites classés en Afrique du Nord : Algérie, Tunisie, Maroc, Libye et Mauritanie.</p>
</header>

<main>
    <?php foreach ($sites as $site): ?>

    <article itemscope itemtype="https://schema.org/TouristAttraction">

        <?php if (!empty($site['image'])): ?>
            <img itemprop="image" src="<?= htmlspecialchars($site['image']) ?>" 
                 alt="Vue de <?= htmlspecialchars($site['nom']) ?>">
        <?php endif; ?>

        <h2 itemprop="name">
            <?= htmlspecialchars($site['nom']) ?>
        </h2>

        <p>
            <span class="badge"><?= htmlspecialchars($site['categorie']) ?></span>
        </p>

        <p itemprop="description">
            <?= htmlspecialchars($site['description']) ?>
        </p>

        <p>
            <strong>Localisation :</strong>
            <span itemprop="location" itemscope itemtype="https://schema.org/Place">
                <span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                    <span itemprop="addressCountry"><?= htmlspecialchars($site['pays']) ?></span>
                </span>
            </span>
        </p>

        <?php if (!empty($site['geo'])): ?>
            <?php 
                $coords = explode(',', $site['geo']); 
                $lat = trim($coords[0]);
                $lon = trim($coords[1]);
            ?>
            <div itemprop="geo" itemscope itemtype="https://schema.org/GeoCoordinates">
                <p>
                    <strong>Coordonnées GPS :</strong> 
                    Lat: <span itemprop="latitude"><?= htmlspecialchars($lat) ?></span> / 
                    Lon: <span itemprop="longitude"><?= htmlspecialchars($lon) ?></span>
                </p>
                
                <div class="map-container">
                    <iframe 
                        width="100%" 
                        height="250" 
                        style="border:0;" 
                        src="https://maps.google.com/maps?q=<?= htmlspecialchars($lat) ?>,<?= htmlspecialchars($lon) ?>&hl=fr&z=12&output=embed" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        <?php endif; ?>

        <p style="margin-top: 15px;">
            <strong>Inscrit en :</strong> 
            <span><?= htmlspecialchars($site['date_inscription']) ?></span>
        </p>

        <p>
            <a href="https://whc.unesco.org/fr/list/<?= htmlspecialchars($site['id']) ?>" target="_blank">
                🔗 Consulter la fiche officielle (UNESCO)
            </a>
        </p>

    </article>

    <?php endforeach; ?>
</main>

<footer>
    <p>Projet Master - Web Sémantique et Données Culturelles</p>
</footer>

</body>
</html>