<?php
require 'src/wordpress/config.php';
require 'src/wordpress/MondayAPI.php';
require 'src/wordpress/LeadScoring.php';
require 'src/wordpress/NewColumnIds.php';
require 'src/wordpress/StatusConstants.php';

echo "🧪 Test de Enrutamiento PERSISTENTE: Lead Zers\n";
echo "=============================================\n\n";

$monday = new MondayAPI(MONDAY_API_TOKEN);
$scoring = new LeadScoring();

// 1. Simular datos de un "Zer"
$data = [
    'nombre' => 'Kevin',
    'last-name' => 'Prueba Lead Zers',
    'email' => 'kevin.zer.verificacion@example.com',
    'perfil' => 'zer',
    'telefono' => '123456789',
    'pais_cf7' => 'México'
];

try {
    // 2. Calcular Scoring y Detección
    $scoreResult = $scoring->calculate($data);
    $detectedRole = $scoreResult['detected_role'];
    
    // 3. Lógica del Status
    $statusFinal = 'Lead Zers';
    
    // 4. Creación REAL en Monday
    echo "📤 Enviando a Monday.com...\n";
    $fullName = "[TEST] " . $data['nombre'] . ' ' . $data['last-name'];
    
    $columnValues = [
        NewColumnIds::EMAIL => ['email' => $data['email'], 'text' => $data['email']],
        NewColumnIds::STATUS => ['label' => $statusFinal],
        NewColumnIds::ENTITY_TYPE => ['label' => 'Corporativo'],
        NewColumnIds::ROLE_DETECTED => ['label' => 'Joven']
    ];

    $resp = $monday->createItem(MONDAY_BOARD_ID, $fullName, $columnValues);
    $itemId = $resp['create_item']['id'] ?? null;

    if ($itemId) {
        echo "✅ Lead creado exitosamente!\n";
        echo "   - ID en Monday: $itemId\n";
        echo "   - Nombre: $fullName\n";
        echo "   - Status asignado: $statusFinal\n";
        echo "\n⚠️ NO lo he borrado para que puedas verlo en tu tablero ahora mismo.\n";
    } else {
        echo "❌ Error al crear el item.\n";
        print_r($resp);
    }

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}


if (is_admin()) { require_once plugin_dir_path(__FILE__) . "includes/class-eweb-github-updater.php"; new EWEB_GitHub_Updater(__FILE__, "Yisus-Develop", "monday-wp-bridge-pro"); }