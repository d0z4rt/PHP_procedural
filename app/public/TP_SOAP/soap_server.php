<?php
// http://localhost/soap_test/soap_server.php

class IndividuService
{
    private function db()
    {
        $conn = new PDO("mysql:host=localhost;dbname=api_database;charset=utf8mb4", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
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

$options = [
    'uri' => 'http://localhost/soap_ex'
];

$server = new SoapServer(null, $options);
$server->setClass(IndividuService::class);
$server->handle();