# Análisis Profundo del Workspace Monday - Mars Challenge CRM

## Resumen Ejecutivo

Este documento analiza cada tablero y columna del workspace de Monday en comparación con el blueprint oficial del Mars Challenge CRM (documento `vertopal.com_mars challenge bdm 2026.json`) para determinar qué elementos ya existen y cómo deben estructurarse según las 4 capas del sistema.

---

## 1. Comparación con las 4 Capas del Blueprint

### Capa 1 - Lead Intake Global (Entrada universal)
**Nombre del tablero según blueprint**: MC – Lead Master Intake
**Tablero existente más adecuado**: `Leads` (ID: 18392144864)

**Columnas requeridas por el blueprint vs. Columnas existentes**:

| Columna Requerida | Tipo | Función | Columna Actual | Coincide | Ajuste Necesario |
| --- | --- | --- | --- | --- | --- |
| Nombre del lead | Texto | Nombre de la persona o institución | Nombre | ✅ Sí | - |
| Tipo de lead | Dropdown | Universidad / Escuela / Ciudad / Empresa / Gobierno / Inversor / Otro | - | ❌ No | Crear |
| País | Dropdown | Lista de +25 países | - | ❌ No | Crear (ya creada: `text_mkyn95hk`) |
| Canal de origen | Dropdown | Website / WhatsApp / Redes / Mission Partner / Mission Pioneer / Evento / Email / Ads / Newsletter / Afiliado | - | ❌ No | Crear |
| Email | Email | Contacto | E-mail (`lead_email`) | ✅ Sí | - |
| Teléfono / WhatsApp | Phone | Contacto | Teléfono (`lead_phone`) | ✅ Sí | - |
| Prioridad | Status | Automático según Lead Score | - | ❌ No | Crear (ya creada: `color_mkyn199t`) |
| Lead Score | Número | 0–30 | - | ❌ No | Crear (ya creada: `numeric_mkyn2py0`) |
| Mission Partner asociado | Persona / Texto | Quién envió el lead | - | ❌ No | Crear |
| Responsable interno | Persona | BDM asignado | - | ❌ No | Añadir en automatización |
| Estado | Status | Etapas del pipeline global | Estado (`lead_status`) | ✅ Parcial | Ajustar valores |
| Fecha de entrada | Fecha | Automático | - | ❌ No | Crear o usar `creation_log` |
| Última interacción | Fecha | Automático | Última interacción (`date_mknjpaef`) | ✅ Sí | - |
| Próxima acción | Fecha | Automático | - | ❌ No | Crear |
| Notas | Long Text | Observaciones | - | ❌ No | Crear |

**Columnas ya creadas**: 
- Lead Score: `numeric_mkyn2py0` (numbers)
- Clasificación: `color_mkyn199t` (status) [Hot/Warm/Cold] 
- País: `text_mkyn95hk` (text)
- Rol Detectado: `color_mkyng649` (status) [Rector/Mission Partner]

---

### Capa 2 - Pipelines por segmento (4 tableros)
**Según blueprint**:
1. MC – Pipeline Universidades
2. MC – Pipeline Escuelas
3. MC – Pipeline Ciudades
4. MC – Pipeline Corporate Partners

**Tableros existentes relevantes**:
- `Acuerdos` (ID: 18392144863) → Puede ser adaptado como base para pipelines

**Etapas del Pipeline (Status Column)**:
1. Etapa 1 – Lead nuevo (transferido del intake)
2. Etapa 2 – Calificación inicial
3. Etapa 3 – Primer contacto enviado
4. Etapa 4 – Reunión agendada
5. Etapa 5 – Reunión realizada
6. Etapa 6 – Propuesta enviada
7. Etapa 7 – Negociación / Seguimiento
8. Etapa 8 – Cerrado – Ganado
9. Etapa 9 – Cerrado – Perdido
10. Etapa 10 – Dormant (3 meses)

**Columnas en `Acuerdos` que se pueden reutilizar**:
- Nombre (name)
- Tareas (subtasks)
- Etapa (status) → Coincide con las etapas requeridas
- Resp. (people) → Asignación de responsable
- Valor del acuerdo (numbers)
- Fecha estimada de cierre (date)
- Probabilidad de cierre (numbers)
- Valor previsto (formula)

---

### Capa 3 - Ventas & Cierre (Tablero único)
**Nombre según blueprint**: MC – Clientes Activos 2026

**Tablero existente más adecuado**: `Cuentas` (ID: 18392144865)

**Columnas requeridas vs. existentes**:

| Columna Requerida | Tipo | Columna Actual | Coincide |
| --- | --- | --- | --- |
| Institución | Texto | Nombre | ✅ Parcial |
| Tipo | - | Sector (dropdown) | ✅ Similar |
| Contrato | - | - | ❌ No |
| Valor | - | - | ❌ No |
| Fecha de cierre | - | - | ❌ No |
| Responsable | - | - | ❌ No |
| Fase de implementación | - | - | ❌ No |
| Estado de pago | - | - | ❌ No |
| Notas | - | Descripción (long_text) | ✅ Similar |

---

### Capa 4 - Dashboards & Reportes (paneles automáticos)
**Dashboard existentes**:
- `Productos y servicios` (ID: 18392144860) → Tiene una vista de Dashboard
- `Proyectos de clientes` (ID: 18392144859) → Tiene una vista de Gantt

**Requerimientos del blueprint**:
1. Dashboard 1 – Crecimiento Global
2. Dashboard 2 – Performance Comercial
3. Dashboard 3 – Funil vivo
4. Dashboard 4 – Rendimiento de Mission Partners

---

## 2. Análisis Detallado de Cada Tablero

### Tablero: Leads (ID: 18392144864) - PRINCIPAL
**Categoría**: Capa 1 (Lead Intake) / Adaptar para MC – Lead Master Intake

**Grupos existentes**:
- Leads nuevos

**Columnas existentes y su análisis**:
1. Nombre (`name`) - ✅ Requerido
2. Estado (`lead_status`) - ✅ Requerido (etapas)
3. Crear un contacto (`button`) - ❌ Extra
4. Empresa (`lead_company`) - ✅ Requerido
5. Puesto (`text`) - ✅ Requerido
6. E-mail (`lead_email`) - ✅ Requerido
7. Teléfono (`lead_phone`) - ✅ Requerido
8. Última interacción (`date_mknjpaef`) - ✅ Requerido
9. Secuencias activas (`enrolled_sequences_mkn36hnq`) - ❌ Extra
10. Cronograma de actividades (`custom_mkt2ktmt`) - ❌ Extra
11. Lead Score (`numeric_mkyn2py0`) - ✅ Añadida (requerida)
12. Clasificación (`color_mkyn199t`) - ✅ Añadida (requerida)
13. Rol Detectado (`color_mkyng649`) - ✅ Añadida (requerida)
14. País (`text_mkyn95hk`) - ✅ Añadida (requerida)

**Faltantes por añadir**:
- Tipo de lead (Dropdown)
- Canal de origen (Dropdown)
- Mission Partner asociado (Persona/Texto)
- Prioridad (Status) - Ya añadida como Clasificación
- Fecha de entrada (Date)
- Próxima acción (Date)
- Notas (Long Text)

### Tablero: Acuerdos (ID: 18392144863) - SECUNDARIO
**Categoría**: Capa 2 (Pipelines) / Adaptar para pipelines segmentados

**Grupos existentes**:
- Acuerdos activos
- Cerrados: ganados

**Columnas existentes y su análisis**:
1. Nombre (name) - ✅
2. Tareas (subtasks) - ✅
3. Cronograma de actividades (unsupported) - ❌ Extra
4. Etapa (status) - ✅ Requerido (mismas etapas del blueprint)
5. Resp. (people) - ✅ Requerido
6. Valor del acuerdo (numbers) - ✅
7. Contactos (board_relation) - ✅
8. Fecha estimada de cierre (date) - ✅
9. Probabilidad de cierre (numbers) - ✅
10. Valor previsto (formula) - ✅
11. Enlace a proyectos de clientes (board_relation) - ❌ Extra
12. Presupuestos y facturas (unsupported) - ❌ Extra

**Vistas existentes**:
- Pronóstico
- Pipeline

### Tablero: Contactos (ID: 18392144862) - SOPORTE
**Categoría**: Infraestructura de base - Reutilizable

**Columnas existentes**:
1. Nombre (name) - ✅
2. Subelementos (subtasks) - ✅
3. E-mail (email) - ✅
4. Cronograma de actividades (unsupported) - ❌ Extra
5. Cuentas (board_relation) - ✅
6. Acuerdos (board_relation) - ✅
7. Valor del acuerdo (mirror) - ✅
8. Teléfono (phone) - ✅
9. Puesto (text) - ✅
10. Tipo (status) - ✅
11. Prioridad (status) - ✅
12. Comentarios (long_text) - ✅

### Tablero: Cuentas (ID: 18392144865) - CIERRE
**Categoría**: Capa 3 (Clientes Activos) / Adaptar para MC – Clientes Activos 2026

**Columnas existentes**:
1. Nombre (name) - ✅
2. Dominio (link) - ❌ Extra
3. Contactos (board_relation) - ✅
4. Acuerdos (mirror) - ✅
5. Sector (dropdown) - ✅ Similar a "Tipo"
6. Descripción (long_text) - ✅ Similar a Notas
7. Cant. de empleados (text) - ❌ Extra
8. Ubicación de la sede central (text) - ❌ Extra
9. Cronograma de actividades (unsupported) - ❌ Extra

---

## 3. Propuesta de Flujo Completo (Según Blueprint)

### Flujo Propuesto: Desde el formulario hasta el cierre

1. **Formulario Web (Contact Form 7)**:
   - Nombre
   - Email
   - Teléfono
   - Tipo de institución (Universidad, Escuela, Ciudad, Empresa)
   - País
   - Mensaje/Notas
   - Canal de origen
   - Mission Partner (si aplica)

2. **Conector PHP (webhook-handler.php)**:
   - Recibe datos del formulario
   - Calcula Lead Score (0-30 puntos)
   - Clasifica como HOT/WARM/COLD
   - Envía a Monday (tablero Leads)

3. **Lead Intake Global (Tablero: Leads)**:
   - Recibe el lead con:
     - Datos básicos (nombre, email, teléfono, empresa)
     - Tipo de lead (Universidad, Escuela, etc.)
     - País
     - Canal de origen
     - Mission Partner
     - Lead Score (0-30)
     - Clasificación (HOT/WARM/COLD)
     - Estado: "Nuevo Lead"
   - Automatización 1: Asigna responsable según país/tipo
   - Automatización 2: Envía email de bienvenida
   - Automatización 3: Crea tarea "Contactar en 48h"
   - Automatización 4: Define prioridad según Lead Score

4. **Pipeline Automático (Según tipo de lead)**:
   - Automatización: Mueve a Pipeline apropiado según tipo de lead
   - Opciones:
     - MC – Pipeline Universidades (si tipo = Universidad)
     - MC – Pipeline Escuelas (si tipo = Escuela)
     - MC – Pipeline Ciudades (si tipo = Ciudad)
     - MC – Pipeline Corporate Partners (si tipo = Empresa)

5. **Pipelines Segmentados (Tablero: Acuerdos o copias)**:
   - Seguimiento por etapas:
     - Etapa 1 – Lead nuevo
     - Etapa 2 – Calificación inicial
     - Etapa 3 – Primer contacto enviado
     - Etapa 4 – Reunión agendada
     - Etapa 5 – Reunión realizada
     - Etapa 6 – Propuesta enviada
     - Etapa 7 – Negociación / Seguimiento
     - Etapa 8 – Cerrado – Ganado
     - Etapa 9 – Cerrado – Perdido
     - Etapa 10 – Dormant (3 meses)

6. **Cierre (Tablero: Cuentas)**:
   - Al mover a "Cerrado – Ganado":
     - Se mueve al tablero de Clientes Activos
     - Se envía email de bienvenida
     - Se notifica al equipo de implementación
     - Se actualizan campos de contrato, valor, fecha de cierre, etc.

---

## 4. Acciones Recomendadas

### Inmediatas:
1. Añadir columnas faltantes en tablero "Leads":
   - Tipo de lead (Dropdown)
   - Canal de origen (Dropdown)
   - Mission Partner asociado (Persona/Texto)
   - Fecha de entrada (Date)
   - Próxima acción (Date)
   - Notas (Long Text)

2. Configurar automatizaciones en tablero "Leads":
   - Asignar responsable por país/tipo
   - Enviar email de bienvenida
   - Crear tarea "Contactar en 48h"
   - Definir prioridad por Lead Score

3. Crear vistas o tableros separados para cada tipo de pipeline:
   - Clonar tablero "Acuerdos" o usar vistas del tablero existente

### Mediano Plazo:
1. Configurar automatizaciones avanzadas:
   - Seguimiento si pasan 48h sin contacto
   - Mover a "At Risk" si pasan 5 días sin actualización
   - Crear alerta roja si Lead Score > 20 (HOT Lead)
   - Notificar a Adelino/Dirección Comercial para HOT Leads

2. Configurar dashboards:
   - Crecimiento Global
   - Performance Comercial
   - Funil vivo
   - Rendimiento de Mission Partners

### Configuración de Valores de Dropdowns:
- Tipo de lead: Universidad, Escuela, Ciudad, Empresa, Gobierno, Inversor, Otro
- Canal de origen: Website, WhatsApp, Redes, Mission Partner, Mission Pioneer, Evento, Email, Ads, Newsletter, Afiliado
- Etapas pipeline: Las 10 etapas según blueprint
- Clasificación: HOT, WARM, COLD
- Prioridad: (mismo que clasificación o similar)

---

## 5. Consideraciones Finales

1. **Reutilización de infraestructura existente**: Se está aprovechando eficientemente el CRM base de Monday
2. **Lead Scoring ya implementado**: La integración PHP ya calcula los 30 puntos según el blueprint
3. **Automatizaciones nativas**: Se usarán las automatizaciones nativas de Monday para mayor estabilidad
4. **Columnas clave ya añadidas**: Lead Score y Clasificación ya están en el tablero principal
5. **Necesidad de ajuste fino**: Faltan algunas columnas importantes que deben agregarse para alinear completamente con el blueprint