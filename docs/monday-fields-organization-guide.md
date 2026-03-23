# Guía de Organización de Campos en Monday.com para Integración con Contact Form 7

## 1. Visión General

La integración entre los formularios Contact Form 7 y Monday.com requiere una organización clara de los campos en Monday.com para que puedan recibir correctamente la información de los formularios sin necesidad de modificar estos últimos.

## 2. Estructura Actual del Tablero "Leads"

### 2.1 Columnas Existentes (Post-Optimización)

| Columna | Tipo | ID Monday | Finalidad |
|---------|------|-----------|-----------|
| `name` | Text | `name` | Nombre del lead (obligatorio en Monday) |
| `lead_email` | Email | `lead_email` | Email principal del contacto |
| `lead_phone` | Phone | `lead_phone` | Teléfono del contacto |
| `lead_company` | Text | `lead_company` | Empresa o institución del lead |
| `text` | Text | `text` | Puesto u ocupación del contacto |
| `numeric_mkyn2py0` | Numbers | `numeric_mkyn2py0` | Lead Score (0-30) |
| `color_mkyn199t` | Status | `color_mkyn199t` | Clasificación (Hot/Warm/Cold) |
| `color_mkyng649` | Status | `color_mkyng649` | Rol Detectado (Mission Partner, Rector, etc.) |
| `text_mkyn95hk` | Text | `text_mkyn95hk` | País del contacto |

## 3. Organización por Categorías de Información

### 3.1 Información Básica de Contacto
- `name` (Nombre) - Campo obligatorio, siempre presente
- `lead_email` (Email) - Campo importante para seguimiento
- `lead_phone` (Teléfono) - Campo opcional, no siempre presente

### 3.2 Información de Organización
- `lead_company` (Empresa) - Nombre de la institución/empresa
- `text` (Puesto) - Cargo o rol del contacto

### 3.3 Información de Calificación
- `numeric_mkyn2py0` (Lead Score) - Puntuación calculada (0-30)
- `color_mkyn199t` (Clasificación) - Categoría basada en puntuación
- `color_mkyng649` (Rol Detectado) - Tipo de perfil del lead
- `text_mkyn95hk` (País) - Para scoring adicional

## 4. Reglas de Mapeo para Datos de Contact Form 7

### 4.1 Mapeo Dinámico de Campos

| Campo Monday | Fuente CF7 | Prioridad | Regla |
|--------------|-------------|-----------|--------|
| `name` | `nombre`, `contact_name`, `ea_firstname` + `ea_lastname` | Alta | 1. `nombre` → `name` 2. `contact_name` → `name` 3. Concatenar `ea_firstname` + `ea_lastname` |
| `lead_email` | `email`, `ea_email` | Alta | 1. `email` → `lead_email` 2. `ea_email` → `lead_email` |
| `lead_phone` | `telefono`, `celular` | Media | Si existe, mapear directamente |
| `lead_company` | `org_name`, `company`, `entity`, `institucion` | Media | 1. `org_name` → `lead_company` 2. `company` → `lead_company` 3. `entity` → `lead_company` 4. `institucion` → `lead_company` |
| `text` (Puesto) | `tipo_institucion`, `sector`, `interes`, `especialidad` | Baja | Mapear el primer campo disponible |
| `text_mkyn95hk` (País) | `pais_cf7`, `pais_otro`, `ea_country` | Media | 1. `pais_cf7` → `text_mkyn95hk` 2. `pais_otro` → `text_mkyn95hk` 3. `ea_country` → `text_mkyn95hk` |

### 4.2 Identificación de Rol y Cálculo de Score

#### Campo de Rol (`color_mkyng649`)
- Si `perfil` = "pioneer" → "Mission Partner"
- Si `perfil` = "institucion" → "Rector/Director" 
- Si `perfil` = "ciudad" → "Alcalde/Gobierno"
- Si `perfil` = "empresa" → "Corporate"
- Si `perfil` = "mentor" → "Maestro"
- Si `perfil` = "pais" → "Interesado País"
- Si `perfil` = "zer" → "Joven"
- Si no hay `perfil` → "General"

#### Cálculo del Lead Score
1. **Rol Base**: 
   - Mission Partner/Ciudad/Institución = +10 pts
   - Empresa/País = +5 pts
   - Mentor/Zer = +3 pts
2. **Características Especiales**:
   - Universidad = +5 pts
   - Número de estudiantes > 1000 = +3 pts
   - Población > 100000 = +3 pts
   - País prioritario = +5 pts

## 5. Filtros y Validaciones por Formulario

### 5.1 Formularios con Perfil Definido (Alto Valor)

| Formulario | Perfil | Score Base | Campos Prioritarios |
|------------|--------|------------|-------------------|
| Mission Partner/Pioneer | pioneer | 10 pts | nombre, email, telefono, interes |
| Registro Ciudad | ciudad | 10 pts | entity, nombre, email, poblacion |
| Registro Institución | institucion | 10 pts | org_name, contact_name, email, tipo_institucion |

### 5.2 Formularios sin Perfil (Necesitan Identificación)

| Formulario | Estrategia | Acción |
|------------|------------|--------|
| Contacto general | No enviar | Filtrar si no tiene perfil definido |
| Form pie de página | No enviar | Filtrar si no tiene perfil definido |
| Formulario de contacto 1 | No enviar | Filtrar si no tiene información suficiente |

### 5.3 Filtro para Formulario de Suscripción

| Formulario | Acción |
|------------|--------|
| Suscribirme a alertas | No enviar a CRM | Solo newsletter - excluir de integración |

## 6. Estrategia de Filtros en Monday.com

### 6.1 Filtros por Calidad de Lead

1. **Filtro de Leads Completos**:
   - Mostrar solo leads con nombre y email completos
   - Excluir leads con score < 3

2. **Filtro por Clasificación**:
   - Agrupar por clasificación (Hot/Warm/Cold)
   - Enfocar seguimiento en leads Hot

### 6.2 Automaciones Sugeridas en Monday.com

1. **Cuando se crea un ítem con Clasificación = "Hot"**:
   - Asignar a vendedor específico
   - Enviar notificación por Slack/Email

2. **Cuando Lead Score > 20**:
   - Mover a tablero de "Hot Leads"
   - Crear follow-up automático

## 7. Consideraciones de Seguridad y Privacidad

- **No mapear campos sensibles** como `fecha_nacimiento` por GDPR
- **Evitar campos demasiado largos** como `mensaje` o `aliados_potenciales`
- **Mantener confidencialidad** de información sensible

## 8. Validación de la Integración

### 8.1 Checklist de Pruebas

- [ ] Formulario "Mission Partner" crea ítem en Monday con Score 10+ y Clasificación "Hot"
- [ ] Nombre, email y teléfono se mapean correctamente
- [ ] El rol detectado se muestra como "Mission Partner"
- [ ] El país se registra correctamente
- [ ] Formularios sin perfil no crean leads (o se filtran)
- [ ] Campos dinámicos se detectan sin importar su nombre específico

### 8.2 Validación de Escenarios Límite

- [ ] Formulario con campos inexistentes no rompe la integración
- [ ] Formulario con campos vacíos se maneja adecuadamente
- [ ] Formulario con caracteres especiales no causa errores

## 9. Monitoreo y Mantenimiento

- **Revisar periódicamente** los logs para identificar mapeos erróneos
- **Actualizar las reglas de mapeo** si se añaden nuevos formularios
- **Revisar la calidad de los leads** y ajustar las reglas de scoring según sea necesario