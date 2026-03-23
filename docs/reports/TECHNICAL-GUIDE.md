# Monday-Automation: Guía Técnica Rápida

## 🎯 ¿Qué Hace el Proyecto?

Captura leads de Contact Form 7 (WordPress) → Calcula score automático → Envía a Monday.com con clasificación inteligente.

---

## 📊 Flujo de Datos

```
Formulario CF7 → webhook-handler.php → LeadScoring.php → MondayAPI.php → Monday.com
                      ↓
                 Validación + Score
                      ↓
                 Clasificación (HOT/WARM/COLD)
                      ↓
                 Grupo automático en Monday
```

---

## 🗂️ Archivos de Producción (deployment/)

### **webhook-handler.php** - El Cerebro

- **Qué hace**: Recibe datos del formulario, orquesta todo el proceso
- **Cómo**:
  1. Valida email
  2. Llama a LeadScoring para calcular puntos
  3. Crea item en Monday con datos básicos
  4. Actualiza teléfono y dropdowns por separado (más robusto)
- **Por qué**: Monday API es exigente; dos pasos = más confiable

### **LeadScoring.php** - El Calculador

- **Qué hace**: Asigna puntos según perfil, país, tamaño institución
- **Cómo**:
  - `calculate()`: Función principal, retorna score + metadata
  - `sanitizePhone()`: Limpia teléfonos (+52 55.1234-5678 → +525512345678)
  - `mapPerfilToTipoLead()`: Convierte perfil interno a etiqueta Monday
  - `detectLanguage()`: Detecta idioma por país usando `language-config.json`
- **Por qué**: Centraliza toda la lógica de negocio

### **MondayAPI.php** - El Comunicador

- **Qué hace**: Cliente GraphQL para Monday.com
- **Cómo**:
  - `createItem()`: Crea lead con datos básicos (auto-stringify JSON)
  - `changeSimpleColumnValue()`: Actualiza dropdowns y teléfono
  - `query()`: Ejecuta GraphQL, maneja errores
- **Por qué**: Abstrae la complejidad de la API de Monday

### **NewColumnIds.php** - El Mapa

- **Qué hace**: Constantes con IDs de columnas de Monday
- **Cómo**: `const LEAD_EMAIL = 'lead_email';`
- **Por qué**: Un solo lugar para cambiar IDs si Monday los modifica

### **StatusConstants.php** - El Clasificador

- **Qué hace**: Define rangos de score y grupos de Monday
- **Cómo**:
  - `getScoreClassification()`: Score → HOT/WARM/COLD
  - `getGroupById()`: Clasificación → ID de grupo Monday
- **Por qué**: Separar lógica de clasificación del código principal

### **language-config.json** - La Configuración

- **Qué hace**: Mapea países a idiomas y códigos ISO
- **Cómo**: JSON con arrays de países por idioma
- **Por qué**: Dinámico, no hardcoded; fácil agregar idiomas

### **config.php** - Las Credenciales

- **Qué hace**: Token API y Board ID de Monday
- **Cómo**: `define('MONDAY_API_TOKEN', '...');`
- **Por qué**: Seguridad; no hardcodear en código

---

## 🧪 Carpetas de Soporte

### **tests/** - Scripts de Verificación

- `comprehensive-test.php`: Prueba los 8 perfiles
- `verify-*.php`: Auditorías de datos
- `test-*.php`: Pruebas de API

### **utils/** - Herramientas de Mantenimiento

- `cleanup-*.php`: Limpieza de columnas/items
- `stabilize-board.php`: Configuración de tablero
- `update-dropdown-labels.php`: Actualiza etiquetas

---

## 🔄 Proceso Completo (Ejemplo Real)

**Usuario llena formulario:**

```
Nombre: Ana López
Email: ana@universidad.mx
Teléfono: +52 55 1234 5678
País: México
Perfil: institucion
```

**1. webhook-handler.php recibe:**

```php
$data = [
  'nombre' => 'Ana López',
  'email' => 'ana@universidad.mx',
  'telefono' => '+52 55 1234 5678',
  'pais_cf7' => 'México',
  'perfil' => 'institucion'
];
```

**2. LeadScoring.php calcula:**

```php
$score = 10 (perfil institucion) + 5 (país prioritario) + 3 (teléfono completo) = 18
$classification = 'HOT' (score > 10)
$tipo_lead = 'Institución'
$clean_phone = '+525512345678'
$idioma = 'Español' (México → ES)
```

**3. MondayAPI.php envía:**

```php
// Paso 1: Crear item
createItem(boardId, 'Ana López', [
  'lead_email' => ['email' => 'ana@...', 'text' => 'ana@...'],
  'numeric_mkyn2py0' => '18',
  'classification_status' => ['label' => 'HOT'],
  'text_mkyn95hk' => 'México',
  'date_mkyp6w4t' => ['date' => '2025-12-23'],
  'long_text_mkyxhent' => '{"nombre":"Ana López",...}' // Backup
], groupId: 'HOT_GROUP')

// Paso 2: Actualizar teléfono y dropdowns
changeSimpleColumnValue(boardId, itemId, 'lead_phone', '+525512345678')
changeSimpleColumnValue(boardId, itemId, 'dropdown_mkywgchz', 'Institución', true)
changeSimpleColumnValue(boardId, itemId, 'source_channel', 'Website', true)
changeSimpleColumnValue(boardId, itemId, 'language', 'Español', true)
```

**4. Resultado en Monday.com:**

- ✅ Lead "Ana López" en grupo HOT
- ✅ Score: 18
- ✅ Teléfono: +525512345678 (con bandera 🇲🇽)
- ✅ Tipo: Institución
- ✅ Idioma: Español
- ✅ Backup JSON completo

---

## 🚨 Puntos Críticos

### **¿Por qué dos pasos (create + update)?**

Monday API rechaza teléfonos en `createItem()` pero acepta en `changeSimpleColumnValue()`. Paradoja de su API.

### **¿Por qué `create_labels_if_missing: true`?**

Auto-crea etiquetas en dropdowns si no existen. Evita errores si agregas nuevo perfil.

### **¿Por qué RAW_DATA_JSON?**

Seguro de vida. Si Monday pierde datos o cambia estructura, tienes el JSON original.

### **¿Por qué `sanitizePhone()`?**

Monday necesita solo dígitos + código país. Espacios/guiones rompen la detección de bandera.

---

## 📈 Estado Actual

- ✅ **8 perfiles** mapeados (Zer, Pioneer, Institución, Ciudad, Empresa, Mentor, País, General)
- ✅ **Teléfonos** llegando sin errores
- ✅ **Clasificación automática** HOT/WARM/COLD
- ✅ **Backup JSON** funcionando
- ✅ **Idiomas** detectados por país
- ⏳ **Fase 3 pendiente**: Emails automáticos según perfil/score

---

## 🎓 Para Entender Mejor

**Lee en orden:**

1. `webhook-handler.php` (líneas 19-73) - El flujo principal
2. `LeadScoring.php` (líneas 27-91) - La lógica de scoring
3. `MondayAPI.php` (líneas 47-62) - Cómo se crea un item
4. `comprehensive-test.php` - Ejemplo completo de uso
