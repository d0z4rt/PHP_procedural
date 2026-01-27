<?php
echo "<h2>Test complet Docker + SOAP</h2>";

echo "<h3>1. Test réseau Docker:</h3>";
$hosts_to_test = [
    'web' => 'http://web',
    'php' => 'http://php:9000',
    'db' => 'db:3306',
    'localhost' => 'http://localhost'
];

foreach ($hosts_to_test as $name => $host) {
    echo "Test $name ($host): ";
    $parts = parse_url($host);
    
    $fp = @fsockopen($parts['host'], $parts['port'] ?? 80, $errno, $errstr, 5);
    if ($fp) {
        echo "✓ Connecté<br>";
        fclose($fp);
    } else {
        echo "✗ Erreur $errno: $errstr<br>";
    }
}

echo "<h3>2. Test PHP SOAP extension:</h3>";
if (extension_loaded('soap')) {
    echo "✓ Extension SOAP chargée<br>";
    $ext_info = new ReflectionExtension('soap');
    echo "Version: " . $ext_info->getVersion() . "<br>";
} else {
    echo "✗ Extension SOAP non chargée<br>";
}

echo "<h3>3. Test connexion BDD:</h3>";
try {
    $pdo = new PDO('mysql:host=db;dbname=entreprise_db', 'root', 'password');
    echo "✓ Connexion BDD réussie<br>";
    
    // Vérifier les tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables trouvées: " . implode(', ', $tables) . "<br>";
    
    // Vérifier les données
    $count = $pdo->query("SELECT COUNT(*) FROM individu")->fetchColumn();
    echo "Nombre d'individus: $count<br>";
} catch (PDOException $e) {
    echo "✗ Erreur BDD: " . $e->getMessage() . "<br>";
}

echo "<h3>4. Test serveur SOAP:</h3>";
$soap_url = 'http://web/SOAP/soap_server.php';
echo "URL testée: $soap_url<br>";

// Test 1: Simple GET
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'timeout' => 5
    ]
]);

$response = @file_get_contents($soap_url, false, $context);
if ($response !== false) {
    echo "✓ GET réussi<br>";
    echo "Réponse: " . htmlspecialchars(substr($response, 0, 200)) . "...<br>";
} else {
    echo "✗ GET échoué<br>";
    print_r(error_get_last());
}

// Test 2: Test avec curl interne
echo "<h3>5. Test avec curl:</h3>";
if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $soap_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FAILONERROR => true,
        CURLOPT_HTTPHEADER => [
            'User-Agent: Test-SOAP'
        ]
    ]);
    
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    
    if ($response === false) {
        echo "✗ Curl erreur: " . curl_error($ch) . "<br>";
    } else {
        echo "✓ Curl réussi - HTTP " . $info['http_code'] . "<br>";
        echo "Taille: " . strlen($response) . " bytes<br>";
    }
    
    curl_close($ch);
} else {
    echo "Curl non disponible<br>";
}

echo "<h3>6. Variables serveur:</h3>";
echo "<pre>";
echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'non défini') . "\n";
echo "SCRIPT_FILENAME: " . ($_SERVER['SCRIPT_FILENAME'] ?? 'non défini') . "\n";
echo "PHP_SELF: " . ($_SERVER['PHP_SELF'] ?? 'non défini') . "\n";
echo "</pre>";

echo "<h3>7. Test direct PHP-FPM:</h3>";
// Tester si on peut exécuter du PHP
$test_file = '/tmp/test_php.php';
file_put_contents($test_file, '<?php echo "PHP fonctionne"; phpinfo(); ?>');
echo "Test fichier créé<br>";
?>