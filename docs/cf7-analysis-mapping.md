# Análisis Detallado de Formularios CF7 vs Columnas Monday

## Resumen General
- **Total de formularios**: 12
- **Rango de IDs**: 2758 a 6811
- **Campos más comunes**: nombre, email, pais_cf7, pais_otro, perfil

## Mapeo de Campos a Columnas Monday

### Campos Básicos (Comunes a la mayoría de formularios)

| Campo CF7 | Tipo | Columna Monday | Puntaje Lead Scoring |
|-----------|------|----------------|---------------------|
| `nombre` | text | Nombre (`name`) | - |
| `email` | email | E-mail (`lead_email`) | - |
| `telefono` | tel | Teléfono (`lead_phone`) | +3 (formulario completo) |
| `institucion`/`org_name` | text | Empresa (`lead_company`) | - |

### Campos para Lead Scoring

| Campo CF7 | Tipo | Uso para Lead Scoring | Puntos |
|-----------|------|----------------------|--------|
| `perfil` | hidden/select | Tipo de contacto | - |
| `pais_cf7`/`pais_otro` | hidden/text | Deteción de país prioritario | +5 |
| `telefono` | tel | Formulario completo | +3 |
| `next_step` | hidden | - | - |

### Formularios Específicos y sus Campos Únicos

#### Formularios para Instituciones Educativas:
- **Beneficios instituciones** (ID: 6468) y **Registro Institución Educativa** (ID: 3070)
  - Campos especiales: `tipo_institucion`, `numero_estudiantes`, `contact_name`
  - Posible rol VIP: Si `tipo_institucion` incluye "Universidad" → +10 puntos si es Rector

#### Formulario para Empresa (ID: 3071):
- Campos: `company`, `modality`, `sector`
- Posible rol VIP: Si cargo es de directorial → +10 puntos

#### Formulario Mission Partner/Pioneer (ID: 3073):
- Campo: `interes`
- Posible puntaje: +10 puntos por ser Mission Partner

#### Formulario Maestros o mentores (ID: 3069):
- Campos: `especialidad`
- Puntaje potencial bajo en Lead Scoring

#### Formulario Zer (ID: 2759):
- Campo: `fecha_nacimiento` (date)
- Puntaje potencial bajo en Lead Scoring

#### Formulario de Suscripción (ID: 5410):
- Campos específicos: `ea_firstname`, `ea_lastname`, `ea_role`, `ea_institution`
- Usado para alertas, no para leads comerciales

## Recomendaciones para Webhook Handler

### 1. Campos Prioritarios para Lead Scoring:
```php
// Campos clave para cálculo de Lead Score
$scoringData = [
    'name' => $data['nombre'] ?? $data['ea_firstname'] . ' ' . $data['ea_lastname'] ?? 'Sin Nombre',
    'email' => $data['email'] ?? $data['ea_email'] ?? '',
    'role' => $data['ea_role'] ?? $data['perfil'] ?? '',
    'country' => $data['pais_cf7'] ?? $data['pais_otro'] ?? '',
    'mission_partner' => ($data['perfil'] === 'pioneer') ? 'Mission Partner' : '',
    'phone' => $data['telefono'] ?? '',
    'company' => $data['institucion'] ?? $data['org_name'] ?? $data['company'] ?? $data['ea_institution'] ?? ''
];
```

### 2. Detección de Perfiles VIP:
- `perfil` = "institucion" con cargo de rector/director: +10 puntos
- `perfil` = "pioneer" (Mission Partner): +10 puntos
- Formulario "Empresa" con cargo ejecutivo: +10 puntos

### 3. Formularios para diferentes Pipelines Monday:

| Formulario | Tipo Lead | Pipeline Destino |
|------------|-----------|------------------|
| Empresa | Empresa | Pipeline Corporate Partners |
| Mission Partner/Pioneer | Mission Partner | Pipeline Corporate Partners |
| Registro Ciudad | Ciudad | Pipeline Ciudades |
| Registro Institución Educativa | Universidad/Escuela | Pipeline Universidades |
| Beneficios instituciones | Universidad/Escuela | Pipeline Universidades |
| Registro Maestros | Escuela | Pipeline Escuelas |
| Registro Zer | Jóvenes | Pipeline Escuelas |
| Suscribirme a alertas | Suscriptor | Lead general |

### 4. Campos Adicionales para Columnas Monday:

- **Rol Detectado (`color_mkyng649`)**: Valor de `perfil` o `ea_role`
- **País (`text_mkyn95hk`)**: Valor de `pais_cf7` o `pais_otro`
- **Estado (`lead_status`)**: "Nuevo Lead" por defecto
- **Clasificación (`color_mkyn199t`)**: Calculado por Lead Scoring

## Observaciones Importantes

1. **Campos ocultos**: Muchos formularios tienen campos `hidden` como `perfil`, `next_step`, `pais_cf7` que contienen información clave para clasificación

2. **Consistencia en nomenclatura**: 
   - Nombre: `nombre` (más común)
   - Email: `email` (más común)
   - País: `pais_cf7` (hidden), `pais_otro` (text)
   - Perfil: `perfil` (hidden o select)

3. **Formularios sin campos útiles**: El formulario ID 2758 solo tiene `nombre` y `email`, muy básico.

4. **Campos con placeholders**: La mayoría tiene placeholders que indican el tipo de valor esperado ("Nombre de la institución", "Email", etc.)

## Recomendación para webhook-handler.php

Actualizar para manejar los siguientes campos comunes:
- `nombre` → Nombre
- `email` → Email
- `telefono` → Teléfono
- `institucion`/`org_name`/`company` → Empresa
- `pais_otro` o `pais_cf7` → País
- `perfil` → Rol detectado
- `mensaje` → Para análisis de scoring