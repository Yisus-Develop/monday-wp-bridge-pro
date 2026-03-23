# Implementación del Filtrado por Idioma/País para la Integración CF7-Monday

## 1. Introducción

Basado en el proyecto mc-dynamic-mailer, este documento detalla cómo implementar un sistema de filtrado por idioma/país que permita enviar respuestas personalizadas según la ubicación geográfica del contacto. Esta funcionalidad puede integrarse con la integración existente de Contact Form 7 y Monday.com para:

1. Personalizar las respuestas automáticas según el idioma del contacto
2. Adaptar el contenido del mensaje según la región geográfica
3. Ajustar el scoring y clasificación basado en la ubicación

## 2. Estructura del Sistema de Idiomas/Países

### 2.1 Mapa de Idiomas basado en el proyecto mc-dynamic-mailer

```php
$countriesMap = [
    'ES' => [
        // Países hispanohablantes
        "España", "México", "Colombia", "Argentina", "Chile", "Perú", 
        "Venezuela", "Ecuador", "Guatemala", "Cuba", "Bolivia", 
        "República Dominicana", "Honduras", "El Salvador", "Nicaragua", 
        "Paraguay", "Costa Rica", "Uruguay", "Puerto Rico", "Panamá",
        // Códigos de país
        "ES", "CO", "MX", "AR", "CL", "PE", "VE", "EC", "GT", "CU", 
        "BO", "DO", "HN", "SV", "NI", "PY", "CR", "UY", "PR", "PA"
    ],
    'PT' => [
        // Países lusófonos
        "Portugal", "Brasil", "Angola", "Mozambique", 
        // Códigos de país
        "PT", "BR", "AO", "MZ"
    ],
    'EN' => [
        // Países angloparlantes
        "United States", "United Kingdom", "Canada", "Australia", 
        "Ireland", "New Zealand",
        // Códigos de país
        "US", "USA", "UK", "GB", "CA", "AU", "IE", "NZ"
    ]
];
```

### 2.2 Lógica de Detección de Idioma

```php
function detectLanguageByCountry($country) {
    $countryLower = strtolower($country);
    
    foreach ($countriesMap as $language => $countries) {
        foreach ($countries as $c) {
            if (strpos($countryLower, strtolower($c)) !== false) {
                return $language;
            }
        }
    }
    
    // Por defecto, español
    return 'ES';
}
```

## 3. Implementación en la Integración CF7-Monday

### 3.1 Extensión del Webhook Handler

Vamos a modificar el webhook handler para incluir la detección de idioma:

```php
// En webhook-handler.php o archivo similar

// 1. Detectar idioma basado en país
$country = $_POST['pais_cf7'] ?? $_POST['pais_otro'] ?? $_POST['ea_country'] ?? '';
$language = detectLanguageByCountry($country);

// 2. Personalizar mensaje según idioma
$template = getTemplateByLanguage($language);

// 3. Aplicar el template al mensaje
$message = $template['message'];
$subject = $template['subject'];

// 4. Reemplazar variables en el template
$message = replaceTemplateVariables($message, $_POST, $language);

// 5. Continuar con el proceso de scoring y creación en Monday
```

### 3.2 Templates de Mensajes por Idioma

```php
function getTemplatesByLanguage() {
    return [
        'ES' => [
            'subject' => 'Confirmación de contacto - Mars Challenge 2026',
            'message' => 'Hola [Nombre],\n\nGracias por contactarnos. Nos pondremos en contacto contigo pronto para continuar con el proceso.'
        ],
        'PT' => [
            'subject' => 'Confirmação de contacto - Mars Challenge 2026',
            'message' => 'Olá [Nome],\n\nObrigado por contactar-nos. Entraremos em contacto consigo em breve para continuar com o processo.'
        ],
        'EN' => [
            'subject' => 'Contact confirmation - Mars Challenge 2026',
            'message' => 'Hello [Name],\n\nThank you for contacting us. We will get in touch with you soon to continue the process.'
        ]
    ];
}
```

## 4. Integración con Monday.com

### 4.1 Columna de Idioma

Además de las columnas existentes, se puede añadir una columna en Monday para almacenar el idioma detectado:

- Columna: `Idioma` (ID: `language_code`)
- Tipo: Texto o Status (con valores ES/PT/EN)

### 4.2 Automatizaciones Basadas en Idioma

- **Cuando `Idioma` = "ES"**: Asignar a equipo español
- **Cuando `Idioma` = "PT"**: Asignar a equipo portugués
- **Cuando `Idioma` = "EN"**: Asignar a equipo internacional

## 5. Personalización de Campos y Scoring por Idioma

### 5.1 Reglas de Scoring por Idioma

Además de las reglas de scoring existentes, se podrían aplicar reglas específicas por idioma:

```php
function calculateLanguageScore($data) {
    $language = $data['language'] ?? 'ES';
    $score = 0;
    
    // Puntos especiales basados en idioma
    switch($language) {
        case 'ES':
            // Reglas específicas para países hispanohablantes
            if (in_array($data['pais_cf7'], ['México', 'Colombia', 'AR'])) {
                $score += 2; // Países prioritarios
            }
            break;
        case 'PT':
            // Reglas específicas para países lusófonos
            if (in_array($data['pais_cf7'], ['Brasil'])) {
                $score += 3; // País prioritario
            }
            break;
        case 'EN':
            // Reglas específicas para países angloparlantes
            if (in_array($data['pais_cf7'], ['US', 'CA'])) {
                $score += 2; // Mercados clave
            }
            break;
    }
    
    return $score;
}
```

### 5.2 Adaptación de Contenido según Idioma

El sistema puede adaptar no solo las respuestas automáticas, sino también:

- **Etiquetas específicas**: `VIP_ES`, `VIP_PT`, `VIP_EN`
- **Campos personalizados**: Diferentes campos visibles según idioma
- **Flujo de trabajo**: Diferentes estados/automatizaciones según región

## 6. Actualización de las Reglas de Integración

### 6.1 Nueva Regla de Filtrado por Idioma

```json
{
  "language_based_rules": {
    "detection_method": "country_field_mapping",
    "language_templates": {
      "ES": {
        "subject_prefix": "[ES]",
        "templates": ["template_es_1", "template_es_2", "template_es_3"]
      },
      "PT": {
        "subject_prefix": "[PT]",
        "templates": ["template_pt_1", "template_pt_2", "template_pt_3"]
      },
      "EN": {
        "subject_prefix": "[EN]",
        "templates": ["template_en_1", "template_en_2", "template_en_3"]
      }
    }
  }
}
```

### 6.2 Adaptación del Procesamiento

Actualizar el webhook handler para:

1. Detectar el idioma basado en el país del formulario
2. Seleccionar el template adecuado
3. Aplicar scoring adicional según región
4. Etiquetar el lead con el idioma correspondiente

## 7. Implementación Técnica

### 7.1 Actualización del Webhook Handler

```php
// En webhook-handler.php

// Función para detectar idioma
function detectLanguageByCountry($country) {
    $countriesMap = [
        'ES' => ["españa", "méxico", "colombia", "argentina", "chile", "perú", 
                "venezuela", "ecuador", "guatemala", "cuba", "bolivia", 
                "república dominicana", "honduras", "el salvador", "nicaragua", 
                "paraguay", "costa rica", "uruguay", "puerto rico", "panamá",
                "es", "co", "mx", "ar", "cl", "pe", "ve", "ec", "gt", "cu", 
                "bo", "do", "hn", "sv", "ni", "py", "cr", "uy", "pr", "pa"],
        'PT' => ["portugal", "brasil", "angola", "mozambique", "pt", "br", "ao", "mz"],
        'EN' => ["united states", "united kingdom", "canada", "australia", 
                "ireland", "new zealand", "us", "usa", "uk", "gb", "ca", "au", "ie", "nz"]
    ];
    
    $countryLower = strtolower($country);
    
    foreach ($countriesMap as $language => $countries) {
        foreach ($countries as $c) {
            if (strpos($countryLower, $c) !== false) {
                return $language;
            }
        }
    }
    
    return 'ES'; // Valor por defecto
}

// En la función de manejo
$country = $_POST['pais_cf7'] ?? $_POST['pais_otro'] ?? $_POST['ea_country'] ?? '';
$language = detectLanguageByCountry($country);

// Enviar información de idioma a Monday
$mondayItemData['language'] = $language;

// Aplicar scoring adicional por idioma/región
$additionalScore = calculateLanguageScore([
    'language' => $language,
    'pais_cf7' => $country
]);
```

### 7.2 Actualización del Sistema de Scoring

```php
// En LeadScoring.php

function calculateLanguageScore($data) {
    $language = $data['language'] ?? 'ES';
    $country = $data['pais_cf7'] ?? '';
    $score = 0;
    
    // Puntos adicionales por región específica
    switch($language) {
        case 'ES':
            // Países hispanohablantes prioritarios
            $priorityCountries = ['México', 'Colombia', 'Argentina', 'España'];
            if (in_array($country, $priorityCountries)) {
                $score += 2;
            }
            break;
        case 'PT':
            // País lusófono prioritario
            if ($country === 'Brasil') {
                $score += 3;
            }
            break;
        case 'EN':
            // Países angloparlantes clave
            $keyMarkets = ['US', 'Canada', 'UK'];
            if (in_array($country, $keyMarkets)) {
                $score += 2;
            }
            break;
    }
    
    return $score;
}
```

## 8. Ventajas del Sistema

1. **Respuestas personalizadas**: Cada contacto recibe información en su idioma nativo
2. **Mejor experiencia**: Aumenta la tasa de respuesta y engagement
3. **Eficiencia operativa**: Automatiza la localización del contenido
4. **Segmentación precisa**: Permite estrategias diferenciadas por región
5. **Mejor scoring**: Considera factores regionales en la calificación de leads

## 9. Consideraciones de Implementación

1. **Retroalimentación**: Asegurar que el sistema puede aprender de las respuestas regionales
2. **Mantenimiento**: Las listas de países por idioma deben mantenerse actualizadas
3. **Pruebas**: Validar el sistema con muestras de diferentes regiones
4. **Escalabilidad**: Considerar cómo añadir nuevos idiomas en el futuro
5. **Privacidad**: Respetar las leyes de datos regionales específicas

## 10. Próximos Pasos

1. Implementar la detección de idioma en el webhook handler
2. Crear templates de mensajes por idioma
3. Actualizar la lógica de scoring para considerar región
4. Añadir columna de idioma en Monday.com
5. Probar con datos reales de diferentes regiones
6. Monitorear la efectividad de las respuestas personalizadas

Esta implementación permitirá una experiencia mucho más personalizada para los contactos según su región geográfica, aumentando la efectividad de la comunicación y la tasa de conversión de los leads.