# Guía de Integración: Filtrado por Idioma para CF7-Monday

## 1. Objetivo

Esta guía detalla cómo implementar el filtrado por idioma/país en la integración existente entre Contact Form 7 y Monday.com, basado en el sistema desarrollado en mc-dynamic-mailer.

## 2. Componentes Involucrados

- **webhook-handler.php**: Punto de entrada para datos de CF7
- **LeadScoring.php**: Cálculo de puntuación de leads
- **MondayAPI.php**: Interfaz con la API de Monday
- **Nuevos componentes**: Funciones de detección de idioma y templates multilingües

## 3. Modificaciones al Webhook Handler

### 3.1 Función de Detección de Idioma

Agregar esta función al archivo `webhook-handler.php`:

```php
function detectLanguageByCountry($country) {
    $countriesMap = [
        'ES' => [
            "españa", "méxico", "colombia", "argentina", "chile", "perú", 
            "venezuela", "ecuador", "guatemala", "cuba", "bolivia", 
            "república dominicana", "honduras", "el salvador", "nicaragua", 
            "paraguay", "costa rica", "uruguay", "puerto rico", "panamá",
            "es", "co", "mx", "ar", "cl", "pe", "ve", "ec", "gt", "cu", 
            "bo", "do", "hn", "sv", "ni", "py", "cr", "uy", "pr", "pa"
        ],
        'PT' => [
            "portugal", "brasil", "angola", "mozambique", "pt", "br", "ao", "mz"
        ],
        'EN' => [
            "united states", "united kingdom", "canada", "australia", 
            "ireland", "new zealand", "us", "usa", "uk", "gb", "ca", "au", "ie", "nz"
        ]
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
```

### 3.2 Actualización del Procesamiento Principal

Modificar el código principal de `webhook-handler.php` para incluir la detección de idioma:

```php
// Antes del cálculo de scoring
$country = $_POST['pais_cf7'] ?? $_POST['pais_otro'] ?? $_POST['ea_country'] ?? '';
$language = detectLanguageByCountry($country);

// Agregar el idioma a los datos para procesamiento posterior
$scoringData['language'] = $language;
$scoringData['country'] = $country;

// ... el resto del procesamiento existente ...
```

## 4. Modificaciones al Sistema de Scoring

Actualizar `LeadScoring.php` para considerar el idioma/país en el cálculo:

```php
function calculateLanguageScore($data) {
    $language = $data['language'] ?? 'ES';
    $country = $data['country'] ?? '';
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

// En la función principal de cálculo de scoring
function calculateScore($data) {
    // ... cálculo existente de scoring ...
    
    // Cálculo adicional basado en idioma
    $languageScore = calculateLanguageScore($data);
    $totalScore += $languageScore;
    
    return $totalScore;
}
```

## 5. Actualización de la API de Monday

Modificar `MondayAPI.php` para manejar la columna de idioma:

```php
// En la función createItem() o similar
function createItem($boardId, $itemName, $columns = []) {
    // ... código existente ...
    
    // Agregar código de idioma a las columnas si está disponible
    if (isset($scoringData['language'])) {
        $columns['language_mkyn_code'] = $scoringData['language'];
    }
    
    // ... resto del código ...
}
```

## 6. Implementación de Templates Multilingües

Crear un sistema de templates para respuestas automáticas personalizadas:

```php
function getTemplateByLanguage($language, $templateType = 'confirmation') {
    $templates = [
        'ES' => [
            'confirmation' => [
                'subject' => '[Institucion] — Activación Mars Challenge 2026 como Institución Líder',
                'message' => 'Estimada/o [Nombre],\n\nGracias por registrar a [Institucion] en Mars Challenge 2026 – Tierra...'
            ]
        ],
        'PT' => [
            'confirmation' => [
                'subject' => '[Institucion] — Ativação Mars Challenge 2026 como Instituição Líder', 
                'message' => 'Prezado(a) [Nombre],\n\nObrigado por registar a [Institucion] no Mars Challenge 2026 – Terra...'
            ]
        ],
        'EN' => [
            'confirmation' => [
                'subject' => '[Institucion] — Mars Challenge 2026 Activation as Leading Institution',
                'message' => 'Dear [Nombre],\n\nThank you for registering [Institucion] in Mars Challenge 2026 – Earth...'
            ]
        ]
    ];
    
    // Si no existe el idioma, usar el template en español por defecto
    return $templates[$language][$templateType] ?? $templates['ES'][$templateType];
}
```

## 7. Validación y Pruebas

### 7.1 Pruebas Unitarias

1. **Detección de idioma**: Verificar que países específicos retornen el idioma correcto
2. **Aplicación de scoring**: Confirmar que se agregan puntos adicionales por región
3. **Asignación de templates**: Validar que se selecciona el template correcto según idioma
4. **Mapeo a Monday**: Asegurar que el código de idioma se almacena correctamente

### 7.2 Pruebas de Integración

1. Enviar formularios desde diferentes países y verificar el idioma detectado
2. Confirmar que el scoring refleja los ajustes regionales
3. Validar que los mensajes se personalizan según el idioma
4. Verificar que los leads se clasifican correctamente en Monday

## 8. Consideraciones de Seguridad

1. **Validación de entradas**: Asegurar que los valores de país no contienen código malicioso
2. **Sanitización**: Limpiar los datos antes de usarlos en queries SQL o templates
3. **Control de acceso**: Verificar que solo los usuarios autorizados puedan modificar templates

## 9. Monitoreo y Mantenimiento

1. **Registro de idiomas**: Monitorear qué idiomas se detectan con más frecuencia
2. **Efectividad de templates**: Medir tasas de respuesta para diferentes idiomas
3. **Actualización de listas**: Mantener actualizadas las listas de países por idioma
4. **Feedback de usuarios**: Recopilar información sobre la calidad de las respuestas

## 10. Documentación para Desarrolladores

Incluir en la documentación del proyecto:

1. **Parámetros esperados**: Cómo se espera que los formularios envíen información de país
2. **Códigos de idioma**: Qué códigos se utilizan y cómo se asignan
3. **Sistema de templates**: Cómo se pueden agregar nuevos idiomas o modificar existentes
4. **Procedimientos de actualización**: Cómo mantener actualizadas las listas de países

Esta implementación permitirá una experiencia más personalizada para los usuarios según su ubicación geográfica, mejorando la efectividad de la comunicación automatizada y la calificación de leads.