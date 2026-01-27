<?php
// http://localhost/soap_test/soap_client.php

$client = new SoapClient(null, [
    'location' => 'http://localhost/soap_test/soap_server.php',
    'uri'      => 'http://localhost/soap_ex',
    'trace'    => 1
]);

// 1) Liste des individus
$individus = $client->getIndividus();

echo "<h2>Liste des individus :</h2><ul>";
foreach ($individus as $i) {
    echo "<li>{$i['nom']} {$i['prenom']} {$i['age']} ans - {$i['nom_service']} - Salaire : {$i['salaire']} €</li>";
}
echo "</ul>";

// 2) Détails d’un individu (ex: ID 1)
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 1;
$one = $client->getIndividuById($id);

echo "<h2>Détails de l'individu ID {$id} :</h2>";
echo "{$one['nom']} {$one['prenom']} {$one['age']} ans - {$one['nom_service']} - Salaire : {$one['salaire']} €";

// 3) XML brut
echo "<h2>Réponse XML brute :</h2>";
echo "<pre>" . htmlspecialchars($client->__getLastResponse()) . "</pre>";
