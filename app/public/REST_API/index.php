<?php
// Configuration
$api_url = 'http://web/REST_API/api.php';

// Fonction pour appeler l'API
function callAPI($method, $url, $data = null, $id = null)
{
  $curl = curl_init();

  // Construire l'URL avec l'ID si nécessaire
  if ($id && ($method === 'PUT' || $method === 'DELETE')) {
    $url .= '?id=' . $id;
  }

  $options = [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTPHEADER => [
      'Content-Type: application/json',
      'Accept: application/json'
    ],
    CURLOPT_CUSTOMREQUEST => $method
  ];

  if ($method === 'POST' || $method === 'PUT') {
    $options[CURLOPT_POSTFIELDS] = json_encode($data);
  }

  curl_setopt_array($curl, $options);

  $response = curl_exec($curl);
  $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $error = curl_error($curl);

  unset($curl);

  if ($error) {
    return ['error' => true, 'message' => 'Erreur cURL: ' . $error];
  }

  $result = json_decode($response, true) ?? $response;

  return [
    'error' => ($http_code < 200 || $http_code >= 300),
    'code' => $http_code,
    'data' => $result,
    'message' => is_array($result) && isset($result['message']) ? $result['message'] : ''
  ];
}

// Traitement des actions
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['action'])) {
    switch ($_POST['action']) {
      case 'create':
        $data = [
          'nom' => $_POST['nom'] ?? '',
          'prenom' => $_POST['prenom'] ?? '',
          'age' => (int) ($_POST['age'] ?? 0),
          'sexe' => $_POST['sexe'] ?? '',
          'service_id' => (int) ($_POST['service_id'] ?? 0),
          'salaire' => (float) ($_POST['salaire'] ?? 0)
        ];

        $result = callAPI('POST', $api_url, $data);

        if (!$result['error']) {
          $message = 'Individu créé avec succès!';
          $message_type = 'success';
        } else {
          $message = 'Erreur lors de la création: ' . $result['message'];
          $message_type = 'error';
        }
        break;

      case 'update':
        $id = $_POST['id'] ?? 0;
        $data = ['salaire' => (float) ($_POST['salaire'] ?? 0)];

        $result = callAPI('PUT', $api_url, $data, $id);

        if (!$result['error']) {
          $message = 'Salaire mis à jour avec succès!';
          $message_type = 'success';
        } else {
          $message = 'Erreur lors de la mise à jour: ' . $result['message'];
          $message_type = 'error';
        }
        break;

      case 'delete':
        $id = $_POST['id'] ?? 0;
        $result = callAPI('DELETE', $api_url, null, $id);

        if (!$result['error']) {
          $message = 'Individu supprimé avec succès!';
          $message_type = 'success';
        } else {
          $message = 'Erreur lors de la suppression: ' . $result['message'];
          $message_type = 'error';
        }
        break;
    }
  }
}

// Récupérer les données actuelles
$result = callAPI('GET', $api_url);
$individus = [];
$stats = [
  'total' => 0,
  'total_salaire' => 0,
  'hommes' => 0,
  'femmes' => 0,
  'moyenne_age' => 0,
  'moyenne_salaire' => 0
];

if (!$result['error'] && is_array($result['data'])) {
  $individus = $result['data'];
  $stats['total'] = count($individus);

  if ($stats['total'] > 0) {
    $total_age = 0;
    foreach ($individus as $individu) {
      $stats['total_salaire'] += $individu['salaire'] ?? 0;
      $total_age += $individu['age'] ?? 0;

      if (($individu['sexe'] ?? '') === 'M') {
        $stats['hommes']++;
      } elseif (($individu['sexe'] ?? '') === 'F') {
        $stats['femmes']++;
      }
    }

    $stats['moyenne_age'] = round($total_age / $stats['total'], 1);
    $stats['moyenne_salaire'] = round($stats['total_salaire'] / $stats['total'], 2);
  }
}

// Services disponibles
$services = [
  1 => 'Informatique',
  2 => 'Ressources Humaines',
  3 => 'Comptabilité',
  4 => 'Marketing',
  5 => 'Production'
];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Gestion des Individus</title>
  <style>
    /* Theme sombre */
    :root {
      --bg-dark: #0f172a;
      --bg-card: #1e293b;
      --bg-hover: #334155;
      --text-primary: #f1f5f9;
      --text-secondary: #94a3b8;
      --accent: #3b82f6;
      --accent-hover: #2563eb;
      --success: #10b981;
      --error: #ef4444;
      --warning: #f59e0b;
      --border: #475569;
      --shadow: rgba(0, 0, 0, 0.4);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: var(--bg-dark);
      color: var(--text-primary);
      min-height: 100vh;
      padding: 20px;
      line-height: 1.6;
    }

    .container {
      max-width: 1400px;
      margin: 0 auto;
    }

    .header {
      background: var(--bg-card);
      padding: 10px;
      border-radius: 12px;
      margin-bottom: 20px;
      border: 1px solid var(--border);
      box-shadow: 0 8px 25px var(--shadow);
      text-align: center;
    }

    .header h1 {
      color: var(--accent);
      font-size: 2em;
      margin: 0;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .header p {
      color: var(--text-secondary);
      font-size: 1.2em;
    }

    .main-content {
      display: grid;
      grid-template-columns: 1fr;
      gap: 25px;
    }

    @media (min-width: 992px) {
      .main-content {
        grid-template-columns: 1fr 1fr;
      }
    }

    .card {
      background: var(--bg-card);
      border-radius: 12px;
      padding: 25px;
      border: 1px solid var(--border);
      box-shadow: 0 8px 25px var(--shadow);
    }

    .card-title {
      font-size: 1.6em;
      color: var(--accent);
      margin-bottom: 25px;
      padding-bottom: 12px;
      border-bottom: 2px solid var(--accent);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .card-title::before {
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
    }


    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: var(--text-secondary);
      font-weight: 500;
    }

    .form-control {
      width: 100%;
      padding: 14px 16px;
      background: #2d3748;
      border: 2px solid var(--border);
      border-radius: 8px;
      color: var(--text-primary);
      font-size: 16px;
      transition: all 0.3s;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--accent);
      background: #374151;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr;
      gap: 15px;
    }

    @media (min-width: 768px) {
      .form-row {
        grid-template-columns: 1fr 1fr;
      }
    }

    .btn {
      background: linear-gradient(135deg, var(--accent), var(--accent-hover));
      color: white;
      border: none;
      padding: 0.4rem 1rem;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      text-decoration: none;
    }

    .btn:hover {
      background: linear-gradient(135deg, var(--accent-hover), #1d4ed8);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
    }

    .btn-danger {
      background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    .btn-danger:hover {
      background: linear-gradient(135deg, #b91c1c, #991b1b);
      box-shadow: 0 5px 15px rgba(220, 38, 38, 0.4);
    }

    .btn-success {
      background: linear-gradient(135deg, #059669, #047857);
    }

    .btn-success:hover {
      background: linear-gradient(135deg, #047857, #065f46);
      box-shadow: 0 5px 15px rgba(5, 150, 105, 0.4);
    }

    .btn-block {
      width: 100%;
    }

    .table-responsive {
      overflow-x: auto;
      margin-top: 10px;
    }

    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    .data-table th {
      background: #2d3748;
      color: var(--accent);
      font-weight: 600;
      padding: 16px;
      text-align: left;
      border-bottom: 2px solid var(--border);
      position: sticky;
      top: 0;
    }

    .data-table td {
      padding: 16px;
      border-bottom: 1px solid var(--border);
      color: var(--text-primary);
    }

    .data-table tr:hover {
      background: var(--bg-hover);
    }

    .badge {
      display: inline-block;
      padding: 6px 16px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .badge-male {
      background: linear-gradient(135deg, #1d4ed8, #1e40af);
      color: white;
    }

    .badge-female {
      background: linear-gradient(135deg, #be185d, #9d174d);
      color: white;
    }

    .alert {
      padding: 18px 20px;
      border-radius: 8px;
      margin-bottom: 25px;
      display: flex;
      align-items: center;
      gap: 15px;
      border-left: 5px solid transparent;
      animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert-success {
      background: rgba(16, 185, 129, 0.1);
      border-left-color: var(--success);
      color: #86efac;
    }

    .alert-error {
      background: rgba(239, 68, 68, 0.1);
      border-left-color: var(--error);
      color: #fca5a5;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 20px;
      margin-bottom: 20px;
    }

    .stat-card {
      background: #2d3748;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      border: 1px solid var(--border);
      transition: transform 0.3s;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      background: #374151;
    }

    .stat-value {
      font-size: 2.2em;
      font-weight: bold;
      color: var(--accent);
      margin-bottom: 8px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .stat-label {
      font-size: 13px;
      color: var(--text-secondary);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .no-data {
      text-align: center;
      padding: 60px 20px;
      color: var(--text-secondary);
    }

    .no-data::before {
      content: '\f5b3';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      font-size: 4em;
      display: block;
      margin-bottom: 20px;
      color: var(--border);
    }

    .no-data h3 {
      font-size: 1.5em;
      margin-bottom: 10px;
      color: var(--text-secondary);
    }

    .actions-cell {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .action-form {
      display: inline;
    }

    .modal-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(15, 23, 42, 0.9);
      z-index: 1000;
      align-items: center;
      justify-content: center;
    }

    .modal-content {
      background: var(--bg-card);
      padding: 35px;
      border-radius: 12px;
      max-width: 500px;
      width: 90%;
      border: 1px solid var(--border);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    .modal-title {
      font-size: 1.8em;
      color: var(--accent);
    }

    .modal-actions {
      display: flex;
      gap: 12px;
      justify-content: flex-end;
      margin-top: 25px;
    }

    .salaire-display {
      font-size: 1.2em;
      color: var(--success);
      font-weight: bold;
      background: rgba(16, 185, 129, 0.1);
      padding: 12px 20px;
      border-radius: 8px;
      border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .text-success {
      color: var(--success);
    }

    .text-warning {
      color: var(--warning);
    }

    .text-error {
      color: var(--error);
    }

    /* Styles pour les formulaires inline */
    .inline-form {
      display: inline-block;
      margin: 0;
    }

    /* Style pour le bouton d'édition */
    .btn-edit {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      padding: 8px 16px;
      font-size: 14px;
    }

    .btn-edit:hover {
      background: linear-gradient(135deg, #d97706, #b45309);
      box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
    }

    /* Message de confirmation */
    .confirm-message {
      text-align: center;
      padding: 20px;
      background: rgba(59, 130, 246, 0.1);
      border-radius: 8px;
      margin: 20px 0;
      border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .confirm-message p {
      margin-bottom: 15px;
    }

    /* Animation pour le chargement */
    @keyframes pulse {
      0% {
        opacity: 0.6;
      }

      50% {
        opacity: 1;
      }

      100% {
        opacity: 0.6;
      }
    }

    .loading {
      animation: pulse 1.5s infinite;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Header -->
    <div class="header">
      <h1>📊 Dashboard Gestion des Individus</h1>
    </div>

    <!-- Messages d'alerte -->
    <?php if ($message): ?>
      <div class="alert alert-<?= $message_type === 'success' ? 'success' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <!-- Modal pour l'édition -->
    <?php if (isset($_GET['edit'])):
      $edit_id = (int) $_GET['edit'];
      $edit_individu = null;

      // Trouver l'individu à éditer
      foreach ($individus as $individu) {
        if ($individu['individu_id'] == $edit_id) {
          $edit_individu = $individu;
          break;
        }
      }

      if ($edit_individu): ?>
        <div class="modal-overlay" style="display: flex;">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title">✏️ Modifier le salaire</h2>
              <a href="?" class="btn btn-danger">✕</a>
            </div>

            <form method="POST" action="">
              <input type="hidden" name="action" value="update">
              <input type="hidden" name="id" value="<?= $edit_individu['individu_id'] ?>">

              <div class="form-group">
                <label>Individu</label>
                <div class="salaire-display">
                  <?= htmlspecialchars($edit_individu['prenom'] . ' ' . $edit_individu['nom']) ?>
                  <br>
                  <small>Salaire actuel: <?= number_format($edit_individu['salaire'], 0, ',', ' ') ?> €</small>
                </div>
              </div>

              <div class="form-group">
                <label for="edit_salaire">Nouveau salaire (€)</label>
                <input type="number" id="edit_salaire" name="salaire" class="form-control" min="0" step="100"
                  value="<?= $edit_individu['salaire'] ?>" required>
              </div>

              <div class="modal-actions">
                <a href="?" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-success">
                  <span class="loading">💾</span> Mettre à jour
                </button>
              </div>
            </form>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Modal pour la suppression -->
    <?php if (isset($_GET['delete'])):
      $delete_id = (int) $_GET['delete'];
      $delete_individu = null;

      // Trouver l'individu à supprimer
      foreach ($individus as $individu) {
        if ($individu['individu_id'] == $delete_id) {
          $delete_individu = $individu;
          break;
        }
      }

      if ($delete_individu): ?>
        <div class="modal-overlay" style="display: flex;">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title">🗑️ Confirmer la suppression</h2>
              <a href="?" class="btn btn-danger">✕</a>
            </div>

            <div class="confirm-message">
              <p>Êtes-vous sûr de vouloir supprimer cet individu ?</p>
              <p><strong><?= htmlspecialchars($delete_individu['prenom'] . ' ' . $delete_individu['nom']) ?></strong></p>
              <p>Cette action est irréversible.</p>
            </div>

            <form method="POST" action="">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= $delete_individu['individu_id'] ?>">

              <div class="modal-actions">
                <a href="?" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-danger">
                  <span class="loading">🗑️</span> Supprimer définitivement
                </button>
              </div>
            </form>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <div class="main-content">
      <!-- Section des statistiques -->
      <div class="card">
        <h2 class="card-title stats-title">Statistiques</h2>
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-value"><?= $stats['total'] ?></div>
            <div class="stat-label">Individus</div>
          </div>
          <div class="stat-card">
            <div class="stat-value"><?= $stats['hommes'] ?></div>
            <div class="stat-label">Hommes</div>
          </div>
          <div class="stat-card">
            <div class="stat-value"><?= $stats['femmes'] ?></div>
            <div class="stat-label">Femmes</div>
          </div>
          <div class="stat-card">
            <div class="stat-value"><?= $stats['moyenne_age'] ?></div>
            <div class="stat-label">Âge moyen</div>
          </div>
          <div class="stat-card">
            <div class="stat-value"><?= number_format($stats['moyenne_salaire'], 0, ',', ' ') ?>€</div>
            <div class="stat-label">Salaire moyen</div>
          </div>
          <div class="stat-card">
            <div class="stat-value"><?= number_format($stats['total_salaire'], 0, ',', ' ') ?>€</div>
            <div class="stat-label">Masse salariale</div>
          </div>
        </div>
      </div>

      <!-- Formulaire d'ajout -->
      <div class="card">
        <h2 class="card-title add-title">Ajouter un individu</h2>
        <form method="POST" action="">
          <input type="hidden" name="action" value="create">

          <div class="form-row">
            <div class="form-group">
              <label for="nom">Nom</label>
              <input type="text" id="nom" name="nom" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="prenom">Prénom</label>
              <input type="text" id="prenom" name="prenom" class="form-control" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="age">Âge</label>
              <input type="number" id="age" name="age" class="form-control" min="18" max="70" required>
            </div>

            <div class="form-group">
              <label for="sexe">Sexe</label>
              <select id="sexe" name="sexe" class="form-control" required>
                <option value="">Sélectionner...</option>
                <option value="M">Masculin</option>
                <option value="F">Féminin</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="service_id">Service</label>
              <select id="service_id" name="service_id" class="form-control" required>
                <option value="">Sélectionner un service...</option>
                <?php foreach ($services as $id => $nom): ?>
                  <option value="<?= $id ?>"><?= $nom ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="salaire">Salaire (€)</label>
              <input type="number" id="salaire" name="salaire" class="form-control" min="0" step="100" required>
            </div>
          </div>

          <button type="submit" class="btn btn-success btn-block">
            <span class="loading">➕</span> Ajouter l'individu
          </button>
        </form>
      </div>

      <!-- Liste des individus -->
      <div class="card" style="grid-column: span 2">
        <h2 class="card-title list-title">Liste des individus</h2>

        <?php if (empty($individus)): ?>
          <div class="no-data">
            <h3>Aucun individu trouvé</h3>
            <p>Commencez par ajouter un individu en utilisant le formulaire ci-dessus</p>
          </div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>Âge</th>
                  <th>Sexe</th>
                  <th>Service</th>
                  <th>Salaire</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($individus as $individu): ?>
                  <tr>
                    <td>#<?= $individu['individu_id'] ?></td>
                    <td><strong><?= htmlspecialchars($individu['nom']) ?></strong></td>
                    <td><?= htmlspecialchars($individu['prenom']) ?></td>
                    <td><?= $individu['age'] ?> ans</td>
                    <td>
                      <span class="badge <?= $individu['sexe'] === 'M' ? 'badge-male' : 'badge-female' ?>">
                        <?= $individu['sexe'] === 'M' ? 'Homme' : 'Femme' ?>
                      </span>
                    </td>
                    <td><?= htmlspecialchars($individu['nom_service'] ?? 'Non affecté') ?></td>
                    <td class="text-success"><?= number_format($individu['salaire'], 0, ',', ' ') ?> €</td>
                    <td class="actions-cell">
                      <a href="?edit=<?= $individu['individu_id'] ?>" class="btn btn-edit">
                        <span class="loading">✏️</span> Éditer
                      </a>
                      <a href="?delete=<?= $individu['individu_id'] ?>" class="btn btn-danger">
                        <span class="loading">🗑️</span> Supprimer
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>

</html>