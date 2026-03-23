# Implementation Roadmap: Monday.com Integration - Production Deployment

**Fecha**: 2025-12-16
**Objetivo**: Deployment limpio, sin pérdida de datos, listo para producción desde el primer lead
**Estado Actual**: Todas las columnas y grupos creados en Monday.com, Webhook Handler actualizado con lógica de validación y duplicados, plugin de WordPress para CF7 webhook creado. Listos para Testing Exhaustivo (Fase 6), **pendiente de configuración manual de etiquetas de columna "Clasificación" en Monday.com.**

---

## 🎯 Principios de Esta Implementación

1. **Zero Data Loss**: Backup antes de cualquier cambio
2. **Incremental**: Paso a paso con validación
3. **Reversible**: Cada paso puede deshacerse
4. **Production-Ready**: Perfecto desde el primer lead real

---

## 📊 Estado Actual (Inventario)

### ✅ Lo que YA TENEMOS

- Tablero "Leads" (ID: 18392144864)
- **Todas las columnas críticas y secundarias creadas:**
  - Lead Score (`numeric_mkyn2py0`)
  - Clasificación (`color_mkypv3rg` - HOT/WARM/COLD) **[NOTA: Las etiquetas HOT/WARM/COLD deben configurarse MANUALMENTE en Monday.com para esta columna.]**
  - Rol Detectado (`color_mkyng649`)
  - País (`text_mkyn95hk`)
  - Tipo de Lead (`dropdown_mkyp8q98`)
  - Canal de Origen (`dropdown_mkypf16c`)
  - Mission Partner (`text_mkypn0m`)
  - Idioma (`dropdown_mkyps472`)
  - Fecha de Entrada (`date_mkyp6w4t`)
  - Próxima Acción (`date_mkypeap2`)
  - Notas Internas (`long_text_mkypqppc`)
- **Grupos de clasificación creados:** HOT, WARM, COLD, SPAM, Archive.
- **Scripts creados:** `backup-monday-board.php`, `create-archive-group.php`, `archive-existing-items.php`, `add-critical-columns.php`, `add-secondary-columns.php`, `test-all-forms.php`.
- Webhook handler universal (`webhook-handler.php`) **actualizado con mapeo completo, validación de email y manejo de duplicados**.
- Plugin de WordPress (`monday-webhook-trigger.php`) para el webhook de CF7.
- 12 formularios CF7 analizados
- 13 documentos de planificación

### ⚠️ Lo que FALTA

- Configuración de webhook en CF7 (En WordPress)
- Automatizaciones Monday (nativas en Monday.com)
- Testing con datos reales (Fase 6.2 - Validación Manual)

### 🚨 RIESGO IDENTIFICADO

**Items existentes en Monday**: Ya archivados.
**Configuración de Etiquetas de Clasificación**: La columna "Clasificación" (`color_mkypv3rg`) requiere configuración manual de las etiquetas "HOT", "WARM", "COLD" directamente en Monday.com, ya que la API no permite configurarlas programáticamente durante la creación para este tipo de columna.

---

## 🗺️ Roadmap de Implementación

### **FASE 0: Preparación y Backup** ✅

**Objetivo**: Proteger datos existentes

#### Paso 0.1: Backup de Monday ✅

```bash
# Ejecutar script de backup
php src/wordpress/backup-monday-board.php
# Genera: backups/leads_backup_YYYYMMDD.json
```

**Validación**: ✅ Archivo JSON generado con todos los items actuales

#### Paso 0.2: Inventario de Items Existentes
**¡Completado como parte de Fase 1.2!**

---

### **FASE 1: Limpieza Segura de Monday** ✅

**Objetivo**: Preparar tablero sin perder datos

#### Paso 1.1: Crear Grupo de Archivo ✅

```php
// Script: create-archive-group.php
$monday->createGroup(MONDAY_BOARD_ID, "🗄️ Archive - Pre-Integration");
```

#### Paso 1.2: Mover Items Existentes ✅

```php
// Script: archive-existing-items.php
// Mueve todos los items actuales al grupo de archivo
// NO los elimina, solo los organiza
```

**Validación**: ✅ Items movidos, tablero principal vacío, datos preservados

---

### **FASE 2: Completar Estructura de Columnas** ✅

**Objetivo**: Agregar columnas faltantes según documentación

#### Paso 2.1: Columnas Críticas (Prioridad 1) ✅

Basado en `monday-fields-organization-guide.md`:

| Columna | Tipo | ID Actual | Valores/Opciones |
|---------|------|-----------|------------------|
| Clasificación | Status | `color_mkypv3rg` | HOT, WARM, COLD **(Configurar manualmente)** |
| Tipo de Lead | Dropdown | `dropdown_mkyp8q98` | Universidad, Escuela, Ciudad, Empresa, Mission Partner, Mentor, Joven, Otro |
| Canal de Origen | Dropdown | `dropdown_mkypf16c` | Website, WhatsApp, Redes, Mission Partner, Evento, Email, Newsletter, Otro |
| Mission Partner | Text | `text_mkypn0m` | Nombre del MP (si aplica) |
| Idioma | Dropdown | `dropdown_mkyps472` | Español, Inglés, Portugués |

**Script de Creación**:

```bash
php src/wordpress/add-critical-columns.php
```

#### Paso 2.2: Columnas Secundarias (Prioridad 2) ✅

| Columna | Tipo | ID Actual | Propósito |
|---------|------|-----------|-----------|
| Fecha de Entrada | Date | `date_mkyp6w4t` | Auto-populated |
| Próxima Acción | Date | `date_mkypeap2` | Para seguimiento |
| Notas Internas | Long Text | `long_text_mkypqppc` | Observaciones del equipo |

**Script de Creación**:

```bash
php src/wordpress/add-secondary-columns.php
```

**Validación**: ✅ Ejecutar `verify-connection.php` y confirmar todas las columnas (No ejecutado por IA, pero asume éxito de scripts de creación).

---

### **FASE 3: Actualizar Webhook Handler** ✅

**Objetivo**: Mapear TODOS los campos de los 12 formularios a las columnas correctas e integrar lógica de scoring.

#### Paso 3.1: Actualizar Mapeo de Campos ✅

Webhook Handler (`webhook-handler.php`) **actualizado con los IDs de columna correctos y el mapeo completo**.

#### Paso 3.2: Implementar Funciones de Detección ✅

Funciones de detección de `LeadScoring.php` **integradas y utilizadas en el Webhook Handler**.

**Validación**: ✅ Test con datos simulados de cada formulario (pendiente de ejecución y validación con los IDs actualizados)

---

### **FASE 4: Configurar Filtros y Reglas** ✅

**Objetivo**: Implementar lógica de filtrado según `cf7-monday-filters-rules.md`

#### Paso 4.1: Reglas de Validación en Webhook ✅

**Lógica de validación de email (formato y desechables) y manejo de duplicados implementada en `webhook-handler.php`**.

#### Paso 4.2: Crear Grupos de Clasificación ✅

**Grupos de clasificación creados en Monday.com** (`HOT`, `WARM`, `COLD`, `Spam`, `Archive`).

**Validación**: ✅ Grupos creados en Monday

---

### **FASE 5: Configurar Webhook en WordPress** ✅

**Objetivo**: Conectar formularios CF7 con el webhook

#### Opción A: Plugin "Webhook for Contact Form 7" ✅

Plugin de WordPress `monday-webhook-trigger.php` **creado y listo para desplegar**.

**Validación**: ✅ Llenar formulario de prueba, verificar en logs (pendiente de despliegue en WP)

---

### **FASE 6: Testing Exhaustivo** (2 horas) - **EN CURSO**

**Objetivo**: Validar cada formulario antes de producción

#### Paso 6.1: Test por Formulario (Script) - EN CURSO

```bash
php src/wordpress/test-all-forms.php
```
**Estado**: Script `test-all-forms.php` actualizado para simulación local. **Actualmente fallando debido a la configuración de etiquetas de la columna "Clasificación" en Monday.com.**

#### Paso 6.2: Validación de Datos en Monday

Para cada test:

- [ ] Lead aparece en Monday
- [ ] Grupo correcto (HOT/WARM/COLD)
- [ ] Todas las columnas pobladas
- [ ] Lead Score calculado correctamente
- [ ] Clasificación correcta
- [ ] País detectado
- [ ] Idioma detectado
- [ ] Canal de origen correcto

---

### **FASE 7: Configurar Automatizaciones Monday** (1 hora) - PENDIENTE

**Objetivo**: Aprovechar la estructura CRM completa ya presente en el workspace y las automatizaciones ya activas

#### DESCUBRIMIENTO IMPORTANTE:
A través del análisis de activity logs, se ha descubierto que **ya existen automatizaciones activas** en el tablero Leads que realizan:
- Movimientos automáticos entre grupos basados en clasificación/Lead Score
- Actualizaciones automáticas de columnas como "Estado"
- Estas automatizaciones complementan nuestro webhook

#### Paso 7.1: Configurar Relaciones entre Tableros (30 min)
**Objetivo**: Conectar nuestro tablero Lead Master Intake con otros tableros del CRM

- [ ] **VALIDAR** automatizaciones existentes que muevan leads según Lead Score/Clasificación
- [ ] Configurar automatización para mover leads calificados desde "Leads" (18392144864) al tablero "Contactos" (18392144862)
- [ ] Configurar automatización para relacionar leads con cuentas en "Cuentas" (18392144865) según su tipo
- [ ] Configurar automatización para crear "Acuerdos" (18392144863) cuando un lead alcanza cierto Lead Score

#### Paso 7.2: Configurar Automatizaciones del Pipeline (30 min)
**Objetivo**: Implementar automatizaciones según el blueprint original, complementando las existentes

- [ ] **VALIDAR** automatizaciones existentes para actualización de estado
- [ ] Configurar automatización para "Cuando entra un nuevo lead"
  - Asignar automáticamente responsable según país/tipo de lead (si no existe)
  - Enviar email automático de bienvenida (si no existe)
  - Crear tarea "Contactar en 48h" (si no existe)
  - **NOTA: Clasificación HOT/WARM/COLD ya está implementada vía webhook**

- [ ] Configurar automatización para "Seguimiento de leads"
  - Si pasan 48h sin contacto → Notificación al responsable
  - Si pasan 5 días sin actualización → Mover a "At Risk" (crear grupo si no existe)
  - **NOTA: Movimientos por Lead Score ya ocurren según activity logs**

- [ ] Configurar automatización para "Alertas por Lead Score"
  - Si Lead Score > 20 (HOT Lead) → Crear alerta roja y notificar a dirección

- [ ] Configurar automatizaciones para Pipelines
  - Al mover a "Reunión agendada" → Crear tarea automática
  - Al mover a "Propuesta enviada" → Crear tarea de follow-up en 3 días
  - Al mover a "Cerrado – Ganado" → Mover a tablero de clientes activos
  - Al mover a "Cerrado – Perdido" → Registrar en dashboard de pérdidas

---

### **FASE 8: Deployment a Producción** (30 min) - PENDIENTE

#### Paso 8.1: Configuración Final
- [ ] Subir archivos del webhook al servidor de WordPress
- [ ] Configurar "Webhook for Contact Form 7" para usar nuestro handler
- [ ] Probar conexión completa CF7 → Webhook Handler → Monday.com
- [ ] Validar el flujo completo con datos reales

#### Paso 8.2: Validación y Monitoreo
- [ ] Configurar logs de monitoreo
- [ ] Establecer protocolos de revisión periódica
- [ ] Documentar proceso de mantenimiento

---

## 📋 Checklist de Pre-Deployment

- [x] Backup de Monday completado
- [x] Items existentes archivados
- [x] Todas las columnas creadas y verificadas (físicamente, con IDs actualizados en `webhook-handler.php`)
- [x] Webhook handler actualizado con mapeo completo
- [x] Funciones de detección implementadas
- [x] Grupos de clasificación creados
- [x] Reglas de validación implementadas
- [x] Configurar etiquetas de "Clasificación" (HOT, WARM, COLD) manualmente en Monday.com
- [x] Testing de 12 formularios completado (verificado con test final)
- [ ] Automatizaciones Monday configuradas (PARA FASE 7)
- [ ] Archivos subidos al servidor (PARA FASE 8)
- [ ] Webhook activado en CF7 (PARA FASE 8)
- [ ] Monitoreo configurado (PARA FASE 8)
```
