<?php

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$host = 'db';
$dbname = 'entreprise_db';
$username = 'root';
$password = 'password';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["message" => "Erreur de connexion à la base de données"]);
  exit();
}

// Récupérer la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Récupérer l'ID si présent dans l'URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

// Gérer les différentes méthodes
switch ($method) {
  case 'GET':
    // Lister tous les individus avec le nom du service
    $query = "SELECT i.individu_id, i.nom, i.prenom, i.age, i.sexe, i.salaire, s.nom_service
                  FROM individu i
                  LEFT JOIN service s ON i.service_id = s.service_id
                  ORDER BY i.individu_id";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $individus = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode($individus, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    break;

  case 'DELETE':
    // Supprimer un individu par ID
    if (!$id) {
      http_response_code(400);
      echo json_encode(["message" => "ID requis"]);
      break;
    }

    $query = "DELETE FROM individu WHERE individu_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
      if ($stmt->rowCount() > 0) {
        http_response_code(200);
        echo json_encode(["message" => "Individu supprimé"]);
      } else {
        http_response_code(404);
        echo json_encode(["message" => "Individu non trouvé"]);
      }
    } else {
      http_response_code(500);
      echo json_encode(["message" => "Erreur de suppression"]);
    }
    break;

  case 'POST':
    // Insérer un nouvel individu
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['nom'], $data['prenom'], $data['age'], $data['sexe'], $data['service_id'], $data['salaire'])) {
      http_response_code(400);
      echo json_encode(["message" => "Tous les champs sont requis"]);
      break;
    }

    $query = "INSERT INTO individu (nom, prenom, age, sexe, service_id, salaire) 
                  VALUES (:nom, :prenom, :age, :sexe, :service_id, :salaire)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nom', $data['nom']);
    $stmt->bindParam(':prenom', $data['prenom']);
    $stmt->bindParam(':age', $data['age']);
    $stmt->bindParam(':sexe', $data['sexe']);
    $stmt->bindParam(':service_id', $data['service_id']);
    $stmt->bindParam(':salaire', $data['salaire']);

    if ($stmt->execute()) {
      http_response_code(201);
      echo json_encode([
        "message" => "Individu créé",
        "id" => $pdo->lastInsertId()
      ]);
    } else {
      http_response_code(500);
      echo json_encode(["message" => "Erreur de création"]);
    }
    break;

  case 'PUT':
    // Mettre à jour le salaire d'un individu
    if (!$id) {
      http_response_code(400);
      echo json_encode(["message" => "ID requis"]);
      break;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['salaire'])) {
      http_response_code(400);
      echo json_encode(["message" => "Salaire requis"]);
      break;
    }

    $query = "UPDATE individu SET salaire = :salaire WHERE individu_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':salaire', $data['salaire']);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
      if ($stmt->rowCount() > 0) {
        http_response_code(200);
        echo json_encode(["message" => "Salaire mis à jour"]);
      } else {
        http_response_code(404);
        echo json_encode(["message" => "Individu non trouvé"]);
      }
    } else {
      http_response_code(500);
      echo json_encode(["message" => "Erreur de mise à jour"]);
    }
    break;

  default:
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée"]);
    break;
}
