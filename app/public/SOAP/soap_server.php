<?php
// http://localhost/SOAP/soap_server.php

class IndividuService
{
    private function db()
    { 
      try {
        $conn = new PDO('mysql:dbname=entreprise_db;host=db', 'root', 'password');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
      } catch(PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
      }
    }

    // Retourne tous les individus
    public function getIndividus()
    {
        $conn = $this->db();
        $sql = "SELECT i.individu_id, i.nom, i.prenom, i.age, i.sexe, i.salaire, s.nom_service
                FROM individu i
                JOIN service s ON i.service_id = s.service_id
                ORDER BY i.individu_id";
        return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retourne un individu par ID
    public function getIndividuById($id)
    {
        $conn = $this->db();
        $stmt = $conn->prepare(
            "SELECT i.individu_id, i.nom, i.prenom, i.age, i.sexe, i.salaire, s.nom_service
             FROM individu i
             JOIN service s ON i.service_id = s.service_id
             WHERE i.individu_id = ?"
        );
        $stmt->execute([(int)$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Créer le serveur SOAP
try {
    $options = [
        'uri' => 'http://web/soap_ex'
    ];

    $server = new SoapServer(null, $options);
    $server->setClass(IndividuService::class);
    $server->handle();
} catch(Exception $e) {
    // Envoyer une réponse SOAP d'erreur
    header('Content-Type: text/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">';
    echo '<SOAP-ENV:Body><SOAP-ENV:Fault>';
    echo '<faultcode>SOAP-ENV:Server</faultcode>';
    echo '<faultstring>' . htmlspecialchars($e->getMessage()) . '</faultstring>';
    echo '</SOAP-ENV:Fault></SOAP-ENV:Body></SOAP-ENV:Envelope>';
}
?>
