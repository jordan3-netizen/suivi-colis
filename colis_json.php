<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de Colis</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f0f4f8;
            font-family: Arial, sans-serif;
        }

        /* ── HEADER ── */
        .header {
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            color: white;
            text-align: center;
            padding: 30px 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .header h1 {
            font-size: 28px;
            letter-spacing: 1px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.85;
            margin-top: 5px;
        }

        /* ── CONTAINER ── */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px 20px;
            display: flex;
            gap: 25px;
            align-items: flex-start;
        }

        /* ── FORMULAIRE ── */
        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
            width: 340px;
            min-width: 300px;
            overflow: hidden;
        }

        .card-header {
            background: #1a73e8;
            color: white;
            padding: 14px 20px;
            font-size: 15px;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            color: #444;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 14px;
            outline: none;
            transition: border 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #1a73e8;
        }

        .form-group textarea {
            resize: vertical;
            height: 70px;
        }

        .btn-ajouter {
            width: 100%;
            padding: 10px;
            background: #1a73e8;
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 5px;
            transition: background 0.2s;
        }

        .btn-ajouter:hover {
            background: #0d47a1;
        }

        /* ── LISTE ── */
        .liste-card {
            flex: 1;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* ── RECHERCHE ── */
        .search-bar {
            display: flex;
            gap: 8px;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }

        .search-bar input {
            flex: 1;
            padding: 9px 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 14px;
            outline: none;
        }

        .search-bar input:focus {
            border-color: #1a73e8;
        }

        .btn-search {
            padding: 9px 18px;
            background: #1a73e8;
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-search:hover {
            background: #0d47a1;
        }

        /* ── TABLEAU ── */
        .table-wrapper {
            overflow-x: auto;
            padding: 0 0 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead tr {
            background: #f5f7ff;
            border-bottom: 2px solid #e0e0e0;
        }

        thead th {
            padding: 13px 15px;
            text-align: left;
            color: #555;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.15s;
        }

        tbody tr:hover {
            background: #f5f9ff;
        }

        tbody td {
            padding: 12px 15px;
            color: #333;
        }

        /* ── BADGES STATUT ── */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-attente {
            background: #fff3cd;
            color: #856404;
        }

        .badge-cours {
            background: #cce5ff;
            color: #004085;
        }

        .badge-livre {
            background: #d4edda;
            color: #155724;
        }

        /* ── VIDE ── */
        .empty-msg {
            text-align: center;
            padding: 40px;
            color: #aaa;
            font-size: 15px;
        }

        /* ── NUMERO ── */
        .num-suivi {
            font-weight: bold;
            color: #1a73e8;
        }
    </style>
</head>

<?php
// Nom du fichier JSON
$fichier = "colis.json";

// Si le fichier n'existe pas, on le crée avec un tableau vide
if (!file_exists($fichier)) {
    file_put_contents($fichier, json_encode([]));
}

// Lire le fichier JSON et mettre le contenu dans le tableau $tabColis
$tabColis = json_decode(file_get_contents($fichier), true);

// Ajout d'un colis
if (isset($_POST['btnAjouter'])) {
    $numero      = $_POST['numero_suivi'];
    $client      = $_POST['client'];
    $telephone   = $_POST['telephone'];
    $description = $_POST['description'];
    $statut      = $_POST['statut'];

    // Créer un tableau associatif pour le nouveau colis
    $nouveauColis = [
        "numero_suivi" => $numero,
        "client"       => $client,
        "telephone"    => $telephone,
        "description"  => $description,
        "statut"       => $statut
    ];

    // Ajouter le nouveau colis dans le tableau
    $tabColis[] = $nouveauColis;

    // Reconvertir le tableau en JSON et réécrire dans le fichier
    file_put_contents($fichier, json_encode($tabColis, JSON_PRETTY_PRINT));

    // Rafraîchir la page
    header("Location: colis.php");
    exit;
}

// Recherche par numéro de suivi ou téléphone
$recherche = $_GET['recherche'] ?? "";

if ($recherche != "") {
    $tabFiltres = [];
    foreach ($tabColis as $colis) {
        // Vérifier si le numéro de suivi ou le téléphone contient la recherche
        if (str_contains($colis['numero_suivi'], $recherche) || str_contains($colis['telephone'], $recherche)) {
            $tabFiltres[] = $colis;
        }
    }
} else {
    // Pas de recherche : afficher tous les colis
    $tabFiltres = $tabColis;
}
?>

<body>

    <!-- Header -->
    <div class="header">
        <h1> Suivi de Colis</h1>
        <p>Agence de Transport — Gestion des colis</p>
    </div>

    <div class="container">

        <!-- Formulaire d'ajout -->
        <div class="form-card">
            <div class="card-header"> Ajouter un Colis</div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label>Numéro de suivi</label>
                        <input type="text" name="numero_suivi" placeholder="Ex: COL-2024-001" required>
                    </div>
                    <div class="form-group">
                        <label>Nom du client</label>
                        <input type="text" name="client" placeholder="Ex: Jordan Caleb SAMEDI" required>
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="text" name="telephone" placeholder="Ex: 70 863 30 11" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" placeholder="Contenu du colis..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Statut</label>
                        <select name="statut">
                            <option value="En attente">En attente</option>
                            <option value="En cours">En cours</option>
                            <option value="Livré">Livré</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-ajouter" name="btnAjouter">Enregistrer</button>
                </form>
            </div>
        </div>

        <!-- Liste des colis -->
        <div class="liste-card">
            <div class="card-header"> Liste des Colis</div>

            <!-- Barre de recherche -->
            <form method="get">
                <div class="search-bar">
                    <input type="text" name="recherche"
                           placeholder=" Rechercher par numéro ou téléphone..."
                           value="<?= $recherche ?>">
                    <button type="submit" class="btn-search">Rechercher</button>
                </div>
            </form>

            <!-- Tableau -->
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Numéro de suivi</th>
                            <th>Client</th>
                            <th>Téléphone</th>
                            <th>Description</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($tabFiltres) == 0) { ?>
                            <tr>
                                <td colspan="6">
                                    <div class="empty-msg">Aucun colis trouvé.</div>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php foreach ($tabFiltres as $key => $colis) { ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td class="num-suivi"><?= $colis['numero_suivi'] ?></td>
                                <td><?= $colis['client'] ?></td>
                                <td><?= $colis['telephone'] ?></td>
                                <td><?= $colis['description'] ?></td>
                                <td>
                                    <?php if ($colis['statut'] == "En attente") { ?>
                                        <span class="badge badge-attente">En attente</span>
                                    <?php } elseif ($colis['statut'] == "En cours") { ?>
                                        <span class="badge badge-cours">En cours</span>
                                    <?php } else { ?>
                                        <span class="badge badge-livre">Livré</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</body>
</html>
