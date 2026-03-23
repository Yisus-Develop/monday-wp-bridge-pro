# INSTALACIÓN EN WORDPRESS - MARS CHALLENGE CRM INTEGRATION 2026

## REQUISITOS PREVIOS

- **WordPress instalado** y funcionando
- **Contact Form 7** instalado y activo
- **Acceso FTP o al sistema de archivos** del servidor WordPress
- **Token de API de Monday.com**
- **Servidor con soporte para PHP** (versión 7.4 o superior recomendada)

## PASOS DE INSTALACIÓN

### 1. CONFIGURACIÓN DEL SERVIDOR

#### A. Crear directorio para scripts de integración
```
wp-content/
└── plugins/
    └── mars-challenge-integration/
        ├── webhook-handler.php
        ├── monday-api.php
        ├── lead-scoring.php
        ├── new-column-ids.php
        └── webhook-confirmation.php
```

#### B. Copiar los archivos esenciales
Necesitas copiar los siguientes archivos al directorio del plugin:

- `webhook-handler.php` (o `enhanced-webhook-handler.php`)
- `MondayAPI.php` 
- `LeadScoring.php`
- `NewColumnIds.php`
- `webhook-confirmation.php`

### 2. ARCHIVO DE CONFIGURACIÓN

Crea un archivo de configuración específico para WordPress:

```php
<?php
// wp-content/plugins/mars-challenge-integration/config.php

// Configuración de Monday.com
define('MONDAY_API_TOKEN', 'TU_TOKEN_DE_API_AQUI');
define('MONDAY_BOARD_ID', 18392144864); // ID del tablero MC – Lead Master Intake

// Opciones de integración
define('ENABLE_LOGGING', true);
define('LOG_FILE_PATH', __DIR__ . '/logs/webhook.log');
define('ERROR_FILE_PATH', __DIR__ . '/logs/webhook_errors.log');

// Directorio de logs
$logDir = __DIR__ . '/logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0755, true);
}
?>
```

### 3. INSTALAR EL WEBHOOK HANDLER

Crea el archivo principal del webhook:

```php
<?php
// wp-content/plugins/mars-challenge-integration/webhook-handler.php

require_once 'config.php';
require_once 'monday-api.php';
require_once 'lead-scoring.php';
require_once 'new-column-ids.php';
require_once 'webhook-confirmation.php';

// Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    die('Solo POST permitido');
}

// Obtener datos (JSON o Form-Data)
$input = file_get_contents('php://input');
$data = json_decode($input, true) ?: $_POST;

// Logging
if (defined('ENABLE_LOGGING') && ENABLE_LOGGING) {
    file_put_contents(LOG_FILE_PATH, date('Y-m-d H:i:s') . " - Datos: " . print_r($data, true) . "\n", FILE_APPEND);
}

try {
    // Usar el sistema de confirmación
    $confirmation = new WebhookConfirmation();
    $result = $confirmation->processForm($data);
    
    if ($result['status'] === 'success') {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => $result['message'],
            'process_id' => $result['process_id'],
            'lead_id' => $result['lead_id'],
            'score' => $result['score'],
            'classification' => $result['classification']
        ]);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json');
        
        echo json_encode([
            'status' => 'error',
            'message' => $result['message'],
            'process_id' => $result['process_id']
        ]);
    }
    
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json');
    
    $errorMsg = $e->getMessage();
    if (defined('ENABLE_LOGGING') && ENABLE_LOGGING) {
        file_put_contents(ERROR_FILE_PATH, date('Y-m-d H:i:s') . " - ERROR: $errorMsg\n", FILE_APPEND);
    }
    
    echo json_encode([
        'status' => 'error',
        'message' => 'Error interno del servidor'
    ]);
}
?>
```

### 4. CONFIGURAR CONTACT FORM 7

#### A. Configurar webhook en CF7
1. Ve al panel de administración de WordPress
2. Ve a **Contact → Contact Forms**
3. Selecciona el formulario que quieres conectar
4. Ve a la pestaña **"Additional Settings"**
5. Agrega esta configuración:

```
webhook: {
    url: "https://tuweb.com/wp-content/plugins/mars-challenge-integration/webhook-handler.php",
    method: "POST",
    fields: "all"
}
```

#### B. Opción alternativa: Hooks personalizados
Si la opción de webhook no está disponible en tu versión de CF7, usa el hook `wpcf7_mail_sent`:

```php
<?php
// wp-content/plugins/mars-challenge-integration/integration.php

class MarsChallengeIntegration {
    
    public function __construct() {
        add_action('wpcf7_mail_sent', array($this, 'handle_form_submission'));
    }
    
    public function handle_form_submission($contact_form) {
        // Obtener datos del formulario
        $submission = WPCF7_Submission::get_instance();
        $data = $submission->get_posted_data();
        
        // Enviar datos al webhook
        $webhook_url = 'https://tuweb.com/wp-content/plugins/mars-challenge-integration/webhook-handler.php';
        
        $response = wp_remote_post($webhook_url, array(
            'body' => $data,
            'timeout' => 30,
            'sslverify' => false
        ));
        
        // Registrar resultado si es necesario
        if (is_wp_error($response)) {
            error_log('Error CF7-Monday integration: ' . $response->get_error_message());
        }
    }
}

// Inicializar la integración
new MarsChallengeIntegration();
?>
```

### 5. PERMISOS Y SEGURIDAD

#### A. Permisos de archivos
Asegúrate de que los archivos tengan los permisos correctos:
- Archivos PHP: 644
- Directorio de logs: 755 (con permiso de escritura)
- Archivos de logs: 664

#### B. Protección del webhook
Para proteger el webhook de accesos no autorizados, puedes agregar autenticación:

```php
<?php
// Al inicio del webhook-handler.php

// Verificar cabecera de autenticación
$auth_token = $_SERVER['HTTP_X_AUTH_TOKEN'] ?? '';
$expected_token = 'TOKEN_SECRETO_PARA_PROTEGER_WEBHOOK';

if ($auth_token !== $expected_token) {
    header('HTTP/1.1 401 Unauthorized');
    die('No autorizado');
}
?>
```

### 6. CONFIGURACIÓN FINAL

#### A. Activar el plugin (si lo creas como plugin)
Puedes empaquetar toda la integración como un plugin de WordPress:

```php
<?php
/**
 * Plugin Name: Mars Challenge CRM Integration
 * Description: Integración completa de CF7 con Monday.com para Mars Challenge
 * Version: 1.0
 * Author: Tu Nombre
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Cargar la integración
require_once plugin_dir_path(__FILE__) . 'integration.php';
?>
```

#### B. Definir la URL del webhook
La URL final del webhook será:
```
https://tuweb.com/wp-content/plugins/mars-challenge-integration/webhook-handler.php
```

O si lo haces como plugin:
```
https://tuweb.com/wp-content/plugins/mars-challenge-integration/webhook-handler.php
```

### 7. PRUEBA DE IMPLEMENTACIÓN

#### A. Probar el webhook directamente
Usa curl o una herramienta como Postman para probar:
```bash
curl -X POST https://tuweb.com/wp-content/plugins/mars-challenge-integration/webhook-handler.php \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Test Integration",
    "email": "test@example.com",
    "pais_cf7": "España",
    "perfil": "institucion",
    "tipo_institucion": "Universidad"
  }'
```

#### B. Probar desde CF7
1. Enviar un formulario de prueba desde tu sitio
2. Verificar en Monday que se creó el lead
3. Revisar los logs de confirmación
4. Verificar que todos los campos están correctos

### 8. MONITOREO POST-INSTALACIÓN

#### A. Verificar logs regularmente
```bash
tail -f wp-content/plugins/mars-challenge-integration/logs/webhook_confirmation.log
```

#### B. Sistema de alertas
Puedes configurar alertas para errores:
- Revisar `webhook_errors.log` regularmente
- Configurar notificaciones por email para errores críticos
- Monitorear el estado del servicio

## RESUMEN DE INSTALACIÓN

1. **Copiar archivos** al directorio de plugins
2. **Configurar API token** en config.php
3. **Configurar webhook** en Contact Form 7
4. **Ajustar permisos** de archivos y directorios
5. **Probar el sistema** con formularios reales
6. **Monitorear logs** para asegurar funcionamiento

## URL DEL WEBHOOK FINAL

```
https://tuweb.com/wp-content/plugins/mars-challenge-integration/webhook-handler.php
```

## ARCHIVOS NECESARIOS

- `webhook-handler.php` - Endpoint principal
- `monday-api.php` - Clase API Monday
- `lead-scoring.php` - Lógica de scoring
- `new-column-ids.php` - Definición de columnas
- `webhook-confirmation.php` - Sistema de confirmación
- `config.php` - Configuración
- `integration.php` (opcional) - Integración CF7

**¡LISTO! Tu sistema Mars Challenge CRM Integration 2026 está listo para funcionar en WordPress con Contact Form 7.**