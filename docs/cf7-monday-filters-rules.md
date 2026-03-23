# Filtros y Reglas de Procesamiento para la Integración CF7-Monday

## 1. Introducción

Este documento describe los filtros y reglas de procesamiento que se deben aplicar para que los datos provenientes de los formularios Contact Form 7 se integren correctamente en Monday.com, asegurando calidad y coherencia en la información almacenada.

## 2. Filtros por Formulario

### 2.1 Filtros de Exclusión (Formularios a No Procesar)

#### 2.1.1 Formularios sin Perfil Definido
- **Formularios afectados**: "Contacto general", "Form pie de página"
- **Criterio de exclusión**: No tienen campo `perfil` definido
- **Acción**: No crear ítem en Monday si `perfil` está vacío o no existe
- **Razón**: No se puede determinar el tipo de lead ni aplicar scoring adecuado

#### 2.1.2 Formulario de Newsletter
- **Formulario afectado**: "Suscribirme a alertas"
- **Criterio de exclusión**: Campo `ea_source` = "popup" y `ea_tags` contiene "events,alerts"
- **Acción**: No crear ítem en Monday, solo procesar localmente para newsletter
- **Razón**: Es para suscripción, no para generación de leads

#### 2.1.3 Formulario Básico
- **Formulario afectado**: "Formulario de contacto 1"
- **Criterio de exclusión**: Tiene menos de 3 campos de información (`nombre`, `email` únicamente)
- **Acción**: No crear ítem en Monday si no hay información suficiente para scoring
- **Razón**: No proporciona suficiente información para calificar el lead

### 2.2 Filtros de Calidad de Datos

#### 2.2.1 Validación de Campos Obligatorios
- **Campos críticos**: `nombre`, `email`
- **Acción**: No crear ítem en Monday si alguno de estos campos está vacío
- **Regla**: Si `nombre` o `email` no existen o están vacíos, rechazar la entrada

#### 2.2.2 Validación de Email
- **Criterio**: Formato de email válido
- **Acción**: Verificar que el campo `email` tenga formato válido antes de crear ítem
- **Regla**: Usar validación de email estándar

#### 2.2.3 Limpieza de Datos
- **Criterio**: Eliminar caracteres no deseados o formatos especiales
- **Acción**: Limpiar los campos antes de enviarlos a Monday
- **Regla**: Eliminar caracteres especiales, URLs, o formatos que puedan afectar la visualización

## 3. Reglas de Procesamiento de Campos

### 3.1 Reglas de Mapeo Dinámico

#### 3.1.1 Mapeo de Nombre
- **Entradas posibles**: `nombre`, `contact_name`, `ea_firstname`, `ea_lastname`
- **Regla de prioridad**:
  1. Si `nombre` existe → usar directamente
  2. Si `contact_name` existe → usar directamente
  3. Si `ea_firstname` y `ea_lastname` existen → concatenar como "firstname lastname"
  4. Si solo `ea_firstname` existe → usar como nombre
- **Destino**: Monday column `name`

#### 3.1.2 Mapeo de Organización
- **Entradas posibles**: `org_name`, `company`, `entity`, `institucion`
- **Regla de prioridad**:
  1. Si `org_name` existe → usar directamente
  2. Si `company` existe → usar directamente
  3. Si `entity` existe → usar directamente
  4. Si `institucion` existe → usar directamente
- **Destino**: Monday column `lead_company`

#### 3.1.3 Mapeo de País
- **Entradas posibles**: `pais_cf7`, `pais_otro`, `ea_country`
- **Regla de prioridad**:
  1. Si `pais_cf7` existe → usar directamente
  2. Si `pais_otro` existe → usar directamente
  3. Si `ea_country` existe → usar directamente
- **Destino**: Monday column `text_mkyn95hk`

#### 3.1.4 Mapeo de Puesto/Ocupación
- **Entradas posibles**: `tipo_institucion`, `sector`, `interes`, `especialidad`, `ea_role`
- **Regla de prioridad**: Usar el primer campo disponible en orden de relevancia
- **Destino**: Monday column `text`

### 3.2 Reglas de Identificación de Rol

#### 3.2.1 Identificación de Perfil
- **Entrada**: Campo `perfil` (generalmente hidden)
- **Reglas de identificación**:
  - `pioneer` → "Mission Partner" (10 pts)
  - `institucion` → "Rector/Director" (10 pts)
  - `ciudad` → "Alcalde/Gobierno" (10 pts)
  - `empresa` → "Corporate" (5 pts)
  - `mentor` → "Maestro" (3 pts)
  - `pais` → "Interesado País" (5 pts)
  - `zer` → "Joven" (3 pts)
  - Si no existe o es vacío → "General" (0 pts)

#### 3.2.2 Asignación de Rol Detectado
- **Destino**: Monday column `color_mkyng649`
- **Acción**: Asignar el rol según la regla de identificación

## 4. Reglas de Calificación (Scoring)

### 4.1 Cálculo de Lead Score

#### 4.1.1 Puntuación por Rol (Base)
- Mission Partner / Rector / Alcalde → +10 puntos
- Corporate / Interesado País → +5 puntos
- Maestro / Joven → +3 puntos
- General → +0 puntos

#### 4.1.2 Puntuación por Características
- `tipo_institucion` = "Universidad" → +5 puntos
- `numero_estudiantes` > 1000 → +3 puntos
- `poblacion` > 100000 → +3 puntos
- País en lista prioritaria → +5 puntos

### 4.2 Clasificación Automática

#### 4.2.1 Rango de Clasificación
- **HOT**: Lead Score > 20 puntos
- **WARM**: Lead Score 10-20 puntos
- **COLD**: Lead Score < 10 puntos

#### 4.2.2 Asignación de Clasificación
- **Destino**: Monday column `color_mkyn199t`
- **Acción**: Asignar clasificación según rango

## 5. Filtros de Integración en el Webhook

### 5.1 Filtros en webhook-handler.php

```php
// Filtro de formulario no válido
if (!isset($_POST['perfil']) || $_POST['perfil'] === '') {
    // Verificar si es uno de los formularios permitidos sin perfil
    $form_title = $_POST['form_title'] ?? '';
    if (!in_array($form_title, ['formulario_con_perfil_permitido'])) {
        http_response_code(200); // No error, pero no procesar
        exit();
    }
}

// Filtro de email válido
if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit();
}

// Filtro de campos obligatorios
if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
    http_response_code(400);
    exit();
}

// Filtro de newsletter
if (isset($_POST['ea_source']) && $_POST['ea_source'] === 'popup') {
    // Registrar newsletter localmente, no crear ítem en Monday
    http_response_code(200);
    exit();
}
```

### 5.2 Procesamiento Condicional

#### 5.2.1 Procesamiento por Tipo de Formulario
```php
// Determinar si el formulario debe procesarse
$is_valid_for_crm = true;

// Excluir formularios de newsletter
if (isset($_POST['ea_tags']) && strpos($_POST['ea_tags'], 'newsletter') !== false) {
    $is_valid_for_crm = false;
}

// Excluir formularios sin información suficiente
if (count($_POST) < 5) { // Menos de 5 campos
    $is_valid_for_crm = false;
}

if (!$is_valid_for_crm) {
    // Procesar localmente pero no enviar a Monday
    http_response_code(200);
    exit();
}
```

## 6. Automatizaciones en Monday.com

### 6.1 Automatizaciones Basadas en Clasificación

#### 6.1.1 Para Leads HOT (>20 puntos)
- **Acción automática**: Asignar a responsable específico
- **Notificación**: Enviar alerta al equipo de ventas
- **Estados**: Cambiar estado a "A punto de cerrar" (si existe)

#### 6.1.2 Para Leads WARM (10-20 puntos)
- **Acción automática**: Agregar recordatorio de seguimiento
- **Notificación**: Enviar resumen semanal

#### 6.1.3 Para Leads COLD (<10 puntos)
- **Acción automática**: Etiquetar para seguimiento posterior
- **Notificación**: No enviar notificaciones automáticas

### 6.2 Automatizaciones Basadas en Rol Detectado

#### 6.2.1 Para Mission Partners y Gobiernos
- **Acción automática**: Agregar a carpeta "VIP Leads"
- **Notificación**: Alerta inmediata al responsable

#### 6.2.2 Para Instituciones Educativas
- **Acción automática**: Agregar etiqueta "Educación"
- **Notificación**: Enviar a equipo educativo

## 7. Validación y Pruebas de Filtros

### 7.1 Pruebas Unitarias de Filtros

1. **Prueba de formulario con perfil vacío** → No debe crear ítem en Monday
2. **Prueba de formulario con email inválido** → No debe crear ítem en Monday
3. **Prueba de formulario de newsletter** → No debe crear ítem en Monday
4. **Prueba de formulario VIP con perfil "pioneer"** → Debe crear ítem con score 10+ y clasificación "HOT"
5. **Prueba de formulario sin campos obligatorios** → No debe crear ítem en Monday

### 7.2 Pruebas de Integración

1. **Enviar datos desde cada formulario** → Verificar mapeo correcto
2. **Probar formularios con diferentes campos disponibles** → Verificar mapeo dinámico
3. **Verificar cálculo de scoring** → Confirmar puntuaje correcto
4. **Probar clasificación automática** → Confirmar categorización correcta

## 8. Monitoreo y Ajustes

### 8.1 Indicadores de Calidad

- Tasa de leads creados por formulario
- Porcentaje de leads con scoring > 10
- Cantidad de leads clasificados como HOT/WARM
- Errores de mapeo o datos faltantes

### 8.2 Ajustes Basados en Resultados

- Revisar filtros de exclusión si se identifican casos válidos
- Ajustar reglas de scoring basado en conversión real
- Modificar clasificaciones si se encuentran inconsistencias
- Actualizar listas de países prioritarios según estrategia

## 9. Resumen de Acciones por Formulario

| Formulario | Estado | Acción | Criterios |
|------------|--------|--------|-----------|
| Mission Partner | ✅ Procesar | Calcular 10+ pts score | perfil=pioneer |
| Registro Institución | ✅ Procesar | Calcular 10+ pts score | perfil=institucion |
| Registro Ciudad | ✅ Procesar | Calcular 10+ pts score | perfil=ciudad |
| Empresa | ✅ Procesar | Calcular 5+ pts score | perfil=empresa |
| Beneficios instituciones | ✅ Procesar | Calcular según datos | perfil=institucion |
| Registro Maestros | ✅ Procesar | Calcular 3+ pts score | perfil=mentor |
| Registro País | ✅ Procesar | Calcular 5+ pts score | perfil=pais |
| Registro Zer | ✅ Procesar | Calcular 3+ pts score | perfil=zer |
| Contacto general | ❌ Excluir | No procesar | perfil no definido |
| Form pie de página | ❌ Excluir | No procesar | perfil no definido |
| Suscribirme a alertas | ❌ Excluir | Solo newsletter | ea_source=popup |
| Formulario de contacto 1 | ❌ Excluir | No procesar | <3 campos |