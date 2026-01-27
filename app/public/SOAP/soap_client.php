
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API SOAP - Gestion des Employés</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        header {
            background: linear-gradient(135deg, #4f46e5 0%, #7e22ce 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .content {
            padding: 30px;
        }

        .controls {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 300px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e0e7ff;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .btn {
            padding: 15px 30px;
            background: linear-gradient(135deg, #4f46e5 0%, #7e22ce 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        }

        .employees-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .employee-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            border: 1px solid #e0e7ff;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .employee-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .employee-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4f46e5 0%, #7e22ce 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .employee-info h3 {
            color: #1e293b;
            font-size: 1.4rem;
            margin-bottom: 5px;
        }

        .employee-info .department {
            color: #64748b;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .stat-item {
            text-align: center;
            padding: 15px;
            background: #f8fafc;
            border-radius: 10px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #4f46e5;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.9rem;
        }

        .detail-view {
            background: #f8fafc;
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
            border: 2px solid #e0e7ff;
        }

        .detail-view h3 {
            color: #4f46e5;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .detail-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        }

        .detail-item .label {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .detail-item .value {
            color: #1e293b;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .xml-view {
            background: #1e293b;
            color: #e2e8f0;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            max-height: 400px;
            overflow: auto;
        }

        .xml-view h4 {
            color: #94a3b8;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .xml-content {
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .gender-male {
            color: #3b82f6;
        }

        .gender-female {
            color: #ec4899;
        }

        .salary {
            color: #10b981;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .employees-grid {
                grid-template-columns: 1fr;
            }
            
            .controls {
                flex-direction: column;
            }
            
            .search-box {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-users-cog"></i> API SOAP - Gestion des Employés</h1>
            <p>Interface moderne pour tester votre API SOAP</p>
        </header>

        <div class="content">
            <?php
// soap_client.php - AJOUTEZ CETTE PARTIE AU DÉBUT

// URL correcte pour Docker
$server_url = 'http://web/SOAP/soap_server.php';

try {
    // Essayer d'abord avec curl pour vérifier si le serveur répond
    $ch = curl_init($server_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    unset($ch);
    
    if ($http_code != 200) {
        throw new Exception("Le serveur SOAP ne répond pas (HTTP $http_code)");
    }
    
    // Créer le client SOAP avec plus d'options
    $client = new SoapClient(null, [
        'location' => $server_url,
        'uri'      => 'http://web/soap_ex',
        'trace'    => 1,
        'exceptions' => true,
        'connection_timeout' => 10,
        'cache_wsdl' => WSDL_CACHE_NONE,
        'stream_context' => stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
            'http' => [
                'timeout' => 10,
                'header' => "Content-Type: text/xml; charset=utf-8\r\n"
            ]
        ])
    ]);

    // Récupération de tous les individus
    $individus = $client->getIndividus();
    $id = isset($_GET["id"]) ? (int)$_GET["id"] : 1;
    $one = $client->getIndividuById($id);
    

?>
                
                <!-- Contrôles -->
                <div class="controls">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="number" id="searchId" placeholder="Rechercher un employé par ID..." 
                               value="<?php echo $id; ?>">
                    </div>
                    <button class="btn" onclick="searchEmployee()">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                    <button class="btn btn-secondary" onclick="showAll()">
                        <i class="fas fa-list"></i> Voir tous
                    </button>
                </div>

                <!-- Liste des employés -->
                <h2 style="color: #4f46e5; margin-bottom: 20px;">
                    <i class="fas fa-users"></i> Liste des Employés (<?php echo count($individus); ?>)
                </h2>
                
                <div class="employees-grid">
                    <?php foreach ($individus as $i): 
                        $initiales = substr($i['prenom'], 0, 1) . substr($i['nom'], 0, 1);
                        $genderIcon = $i['sexe'] == 'M' ? 'mars' : 'venus';
                        $genderClass = $i['sexe'] == 'M' ? 'gender-male' : 'gender-female';
                    ?>
                    <div class="employee-card" onclick="viewEmployee(<?php echo $i['individu_id']; ?>)">
                        <div class="employee-header">
                            <div class="avatar"><?php echo strtoupper($initiales); ?></div>
                            <div class="employee-info">
                                <h3><?php echo $i['prenom'] . ' ' . $i['nom']; ?></h3>
                                <div class="department">
                                    <i class="fas fa-building"></i>
                                    <?php echo $i['nom_service']; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stats">
                            <div class="stat-item">
                                <div class="stat-value"><?php echo $i['age']; ?></div>
                                <div class="stat-label">Âge</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value <?php echo $genderClass; ?>">
                                    <i class="fas fa-<?php echo $genderIcon; ?>"></i>
                                    <?php echo $i['sexe']; ?>
                                </div>
                                <div class="stat-label">Genre</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value salary">
                                    <?php echo number_format($i['salaire'], 0, ',', ' '); ?> €
                                </div>
                                <div class="stat-label">Salaire</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">#<?php echo $i['individu_id']; ?></div>
                                <div class="stat-label">ID</div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Vue détaillée -->
                <div class="detail-view">
                    <h3><i class="fas fa-user-circle"></i> Détails de l'employé sélectionné</h3>
                    
                    <?php if ($one): 
                        $genderIcon = $one['sexe'] == 'M' ? 'mars' : 'venus';
                        $genderClass = $one['sexe'] == 'M' ? 'gender-male' : 'gender-female';
                    ?>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="label">Nom complet</div>
                            <div class="value"><?php echo $one['prenom'] . ' ' . $one['nom']; ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Âge</div>
                            <div class="value"><?php echo $one['age']; ?> ans</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Genre</div>
                            <div class="value <?php echo $genderClass; ?>">
                                <i class="fas fa-<?php echo $genderIcon; ?>"></i>
                                <?php echo $one['sexe'] == 'M' ? 'Masculin' : 'Féminin'; ?>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Service</div>
                            <div class="value"><?php echo $one['nom_service']; ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Salaire</div>
                            <div class="value salary">
                                <?php echo number_format($one['salaire'], 2, ',', ' '); ?> €
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="label">ID Employé</div>
                            <div class="value">#<?php echo $one['individu_id']; ?></div>
                        </div>
                    </div>
                    <?php else: ?>
                        <p style="color: #ef4444; text-align: center; padding: 20px;">
                            <i class="fas fa-exclamation-circle"></i> Aucun employé trouvé avec cet ID
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Vue XML -->
                <div class="xml-view">
                    <h4><i class="fas fa-code"></i> Réponse XML brute de l'API SOAP</h4>
                    <div class="xml-content"><?php echo htmlspecialchars($client->__getLastResponse()); ?></div>
                </div>

            <?php } catch (SoapFault $e) { ?>
                <div style="background: #fee2e2; color: #dc2626; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3><i class="fas fa-exclamation-triangle"></i> Erreur SOAP</h3>
                    <p><?php echo $e->getMessage(); ?></p>
                </div>
            <?php } catch (Exception $e) { ?>
                <div style="background: #fee2e2; color: #dc2626; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <h3><i class="fas fa-exclamation-triangle"></i> Erreur</h3>
                    <p><?php echo $e->getMessage(); ?></p>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
        function searchEmployee() {
            const id = document.getElementById('searchId').value;
            if (id) {
                window.location.href = '?id=' + id;
            }
        }

        function showAll() {
            window.location.href = window.location.pathname;
        }

        function viewEmployee(id) {
            window.location.href = '?id=' + id;
        }

        // Touche Enter pour la recherche
        document.getElementById('searchId').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchEmployee();
            }
        });
    </script>
</body>
</html>