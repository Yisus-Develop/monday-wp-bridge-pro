# Guía de Mapeo: Contact Form 7 → Monday CRM

**Fecha**: 2025-12-15 18:23
**Total Formularios Analizados**: 12
**Tablero Monday**: Leads (ID: 18392144864)

---

## 📊 Resumen de Formularios

| # | Formulario | Campos | Perfil | Uso |
|---|------------|--------|--------|-----|
| 1 | Registro Institución Educativa | 11 | institucion | Lead principal - Universidades/Escuelas |
| 2 | Registro Ciudad / Gobierno local | 11 | ciudad | Lead principal - Alcaldes/Gobiernos |
| 3 | Mission Partner / Pioneer | 9 | pioneer | **Lead VIP** - +10 pts |
| 4 | Empresa | 11 | empresa | Lead corporativo |
| 5 | Beneficios instituciones | 12 | institucion | Variante institucional |
| 6 | Registro Maestros o mentores | 9 | mentor | Lead educativo |
| 7 | Registro País | 8 | pais | Lead nacional |
| 8 | Registro Zer | 10 | zer | Lead joven |
| 9 | Contacto general | 9 | variable | Contacto genérico |
| 10 | Form pie de página | 9 | variable | Contacto footer |
| 11 | Suscribirme a alertas | 13 | - | Newsletter (NO CRM) |
| 12 | Formulario de contacto 1 | 2 | - | Básico legacy |

---

## 🎯 Mapeo Universal (Campos Comunes)

### Campos que TODOS los formularios tienen

| Campo CF7 | Tipo | → Monday Columna | ID Monday | Notas |
|-----------|------|------------------|-----------|-------|
| `nombre` / `contact_name` | text | **Nombre** | `name` | Nombre del lead |
| `email` / `ea_email` | email | **E-mail** | `lead_email` | Email principal |
| `telefono` | tel | **Teléfono** | `lead_phone` | Opcional en algunos |
| `perfil` | hidden | **Rol Detectado** | `color_mkyng649` | ⭐ Clave para scoring |
| `pais_cf7` / `pais_otro` / `ea_country` | hidden/text | **País** | `text_mkyn95hk` | Para scoring +5 |

### Campos de Organización

| Campo CF7 | → Monday | ID Monday |
|-----------|----------|-----------|
| `org_name` / `company` / `entity` / `institucion` | **Empresa** | `lead_company` |
| `tipo_institucion` / `sector` | **Puesto** | `text` |

---

## 🔥 Mapeo de Scoring (Campos Críticos)

### Perfil → Rol Detectado + Puntos

| Valor `perfil` | → Monday Label | Lead Score | Clasificación |
|----------------|----------------|------------|---------------|
| `pioneer` | **Mission Partner** | +10 pts | 🔥 HOT |
| `institucion` | Rector/Director | +10 pts (si cargo alto) | 🔥 HOT |
| `ciudad` | Alcalde/Gobierno | +10 pts | 🔥 HOT |
| `empresa` | Corporate | +5 pts | 🟡 WARM |
| `mentor` | Maestro | +3 pts | 🔵 COLD |
| `pais` | Interesado País | +5 pts | 🟡 WARM |
| `zer` | Joven | +3 pts | 🔵 COLD |

### Campos Adicionales para Scoring

| Campo CF7 | Condición | Puntos |
|-----------|-----------|--------|
| `tipo_institucion` | = "Universidad" | +5 pts |
| `numero_estudiantes` | > 1000 | +3 pts |
| `poblacion` | > 100000 | +3 pts |
| `pais_cf7` | En lista prioritaria | +5 pts |

---

## 📋 Mapeo Detallado por Formulario

### 1. Registro Institución Educativa (ID: 3070)

| Campo CF7 | → Monday | ID Monday |
|-----------|----------|-----------|
| `org_name` | Nombre | `name` |
| `contact_name` | (Ignorar - va en nombre) | - |
| `email` | E-mail | `lead_email` |
| `telefono` | Teléfono | `lead_phone` |
| `tipo_institucion` | Puesto | `text` |
| `numero_estudiantes` | (Scoring interno) | - |
| `pais_otro` | País | `text_mkyn95hk` |
| `perfil` = "institucion" | Rol Detectado | `color_mkyng649` |

**Lead Score Calculado**: Base 10 pts (Rector) + 5 pts (Universidad) = **15 pts → WARM**

---

### 2. Registro Ciudad / Gobierno local (ID: 3072)

| Campo CF7 | → Monday | ID Monday |
|-----------|----------|-----------|
| `entity` | Empresa | `lead_company` |
| `nombre` | Nombre | `name` |
| `email` | E-mail | `lead_email` |
| `telefono` | Teléfono | `lead_phone` |
| `poblacion` | (Scoring interno) | - |
| `aliados_potenciales` | (Ignorar - muy largo) | - |
| `perfil` = "ciudad" | Rol Detectado | `color_mkyng649` |

**Lead Score Calculado**: Base 10 pts (Alcalde) + 5 pts (País prioritario) = **15-20 pts → WARM/HOT**

---

### 3. Mission Partner / Pioneer (ID: 3073) ⭐ VIP

| Campo CF7 | → Monday | ID Monday |
|-----------|----------|-----------|
| `nombre` | Nombre | `name` |
| `email` | E-mail | `lead_email` |
| `telefono` | Teléfono | `lead_phone` |
| `interes` | Puesto | `text` |
| `perfil` = "pioneer" | **Mission Partner** | `color_mkyng649` |

**Lead Score Calculado**: **10 pts (Mission Partner) = HOT** 🔥

---

### 4. Empresa (ID: 3071)

| Campo CF7 | → Monday | ID Monday |
|-----------|----------|-----------|
| `company` | Empresa | `lead_company` |
| `nombre` | Nombre | `name` |
| `email` | E-mail | `lead_email` |
| `telefono` | Teléfono | `lead_phone` |
| `sector` | Puesto | `text` |
| `modality` | (Scoring: Donación +3) | - |

**Lead Score Calculado**: 5 pts (Corporate) + 3 pts (Donación) = **8 pts → COLD/WARM**

---

## 🚀 Implementación en webhook-handler.php

### Estrategia de Mapeo Dinámico

```php
// Detectar campos dinámicamente
$scoringData = [
    'name' => $_POST['nombre'] ?? $_POST['contact_name'] ?? '',
    'email' => $_POST['email'] ?? $_POST['ea_email'] ?? '',
    'phone' => $_POST['telefono'] ?? '',
    'company' => $_POST['org_name'] ?? $_POST['company'] ?? $_POST['entity'] ?? $_POST['institucion'] ?? '',
    'role' => $_POST['tipo_institucion'] ?? $_POST['sector'] ?? $_POST['interes'] ?? '',
    'country' => $_POST['pais_cf7'] ?? $_POST['pais_otro'] ?? $_POST['ea_country'] ?? '',
    'perfil' => $_POST['perfil'] ?? 'general',
    
    // Campos para scoring
    'tipo_institucion' => $_POST['tipo_institucion'] ?? '',
    'numero_estudiantes' => (int)($_POST['numero_estudiantes'] ?? 0),
    'poblacion' => (int)($_POST['poblacion'] ?? 0),
];
```

### Lógica de Scoring Mejorada

```php
// En LeadScoring.php - Actualizar calculateScore()

if ($data['perfil'] === 'pioneer') {
    $score += 10; // Mission Partner
    $detectedRole = 'Mission Partner';
}

if ($data['perfil'] === 'institucion' || $data['perfil'] === 'ciudad') {
    $score += 10; // Rector/Alcalde
    $detectedRole = ($data['perfil'] === 'ciudad') ? 'Alcalde' : 'Rector';
}

if ($data['tipo_institucion'] === 'Universidad') {
    $score += 5;
}

if ($data['numero_estudiantes'] > 1000) {
    $score += 3;
}
```

---

## ⚠️ Campos a IGNORAR (No mapear a Monday)

| Campo | Razón |
|-------|-------|
| `mensaje` / `aliados_potenciales` | Demasiado largo para columna |
| `next_step` / `timestamp-field` | Campos técnicos |
| `ea_nonce` / `ea_referrer` | Metadatos de tracking |
| `fecha_nacimiento` | Dato sensible (GDPR) |

---

## 📝 Próximos Pasos

1. ✅ **Actualizar `webhook-handler.php`** con mapeo dinámico
2. ✅ **Actualizar `LeadScoring.php`** con lógica mejorada
3. ⏳ **Probar** con formulario real
4. ⏳ **Configurar webhook** en cada formulario CF7

---

## 🆘 Notas Importantes

- **Formulario "Suscribirme a alertas"**: NO debe ir a Monday CRM (es newsletter)
- **Formulario "Contacto 1"**: Muy básico, probablemente legacy
- **Campo `perfil`**: Es CRÍTICO para el scoring - asegúrate que todos los forms lo tengan
- **País**: Algunos usan `pais_cf7` (hidden), otros `pais_otro` (text) - mapear ambos
