<?php

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

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

// Récupérer l'en-tête d'autorisation
$headers = getallheaders();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

// Récupérer la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Récupérer l'ID si présent dans l'URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

// Clé secrète pour JWT
define('JWT_SECRET', 'super_secret');
define('JWT_ALGORITHM', 'HS256');

// Fonction pour créer un token JWT
function createJWT($user_id, $username)
{
  $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
  $payload = json_encode([
    'user_id' => $user_id,
    'username' => $username,
    'iat' => time(),
    'exp' => time() + (60 * 60 * 24) // Expire dans 24 heures
  ]);

  $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
  $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

  $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
  $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

  return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
}

// Fonction pour vérifier un token JWT
function verifyJWT($token)
{
  $parts = explode('.', $token);
  if (count($parts) !== 3) {
    return false;
  }

  list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = $parts;

  $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
  $base64UrlSignatureToVerify = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

  if ($base64UrlSignatureToVerify !== $base64UrlSignature) {
    return false;
  }

  $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload)), true);

  // Vérifier l'expiration
  if (isset($payload['exp']) && $payload['exp'] < time()) {
    return false;
  }

  return $payload;
}


// Route pour l'authentification
if ($method === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['username']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(["message" => "Nom d'utilisateur et mot de passe requis"]);
    exit();
  }

  // Vérifier les identifiants
  // Pour cet exemple, on utilise des identifiants fixes
  $valid_users = [
    'admin' => password_hash('admin123', PASSWORD_DEFAULT)
  ];

  if (!isset($valid_users[$data['username']])) {
    http_response_code(401);
    echo json_encode(["message" => "Identifiants incorrects"]);
    exit();
  }

  if ($data['password'] === 'admin123' && $data['username'] === 'admin') {
    $token = createJWT(1, 'admin');
    http_response_code(200);
    echo json_encode([
      "message" => "Authentification réussie",
      "token" => $token,
      "user" => [
        "id" => 1,
        "username" => "admin",
        "role" => "admin"
      ]
    ]);
    exit();
  } else {
    http_response_code(401);
    echo json_encode(["message" => "Identifiants incorrects"]);
    exit();
  }
}

// Vérifier le token pour toutes les autres routes (sauf login)
if (strpos($authHeader, 'Bearer ') !== 0) {
  http_response_code(401);
  echo json_encode(["message" => "Token d'authentification manquant ou invalide"]);
  exit();
}

$token = str_replace('Bearer ', '', $authHeader);
$payload = verifyJWT($token);

if (!$payload) {
  http_response_code(401);
  echo json_encode(["message" => "Token invalide ou expiré"]);
  exit();
}

// L'utilisateur est authentifié, continuer avec les opérations CRUD
$user_id = $payload['user_id'];
$username = $payload['username'];

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
