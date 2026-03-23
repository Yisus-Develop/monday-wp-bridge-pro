# ANÁLISIS Y PLAN DE AUTOMATIZACIONES
## Mars Challenge CRM Integration 2026

### 1. AUTOMATIZACIONES EXISTENTES EN EL SISTEMA

Hasta ahora, hemos implementado automatizaciones a través del webhook:

- **Cálculo automático de Lead Score** basado en perfil, país, tipo de institución
- **Clasificación automática** (HOT/WARM/COLD) basada en puntuación
- **Asignación automática a grupos** según Lead Score
- **Detección automática de idioma** basada en país
- **Gestión de duplicados** con validación de email
- **Detección de emails desechables** y asignación a grupo SPAM

### 2. AUTOMATIZACIONES FALTANTES (según blueprint original)

#### 2.1 Automatizaciones para "Cuando entra un nuevo lead"

**Objetivo:** Asignar automáticamente responsable (según país o tipo de lead)  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** When an item is created → assign to X (según reglas internas)

**Objetivo:** Enviar email automático de bienvenida  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** When an item is created → send email template "Bienvenida Lead"

**Objetivo:** Crear tarea "Contactar en 48h"  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** When an item is created → create task "Contactar en 48h"

**Objetivo:** Definir Prioridad (hot/warm/cold)  
- **Estado:** ✅ IMPLEMENTADO (parcialmente a través del webhook)  
- **Método:** Combinación de webhook + automatizaciones nativas  
- **Configuración:** Webhook calcula y asigna valor a columna "Clasificación"

#### 2.2 Automatizaciones para "Seguimiento de leads"

**Objetivo:** Si pasan 48h sin contacto → Notificación al responsable  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** If no update in 48h → send notification to responsible person

**Objetivo:** Si pasan 5 días sin actualización → Mover a "At Risk"  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** If no update in 5 days → move to "At Risk" group

**Objetivo:** Si pasan 5 días sin actualización → Notificación al gestor comercial global  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** If no update in 5 days → send notification to manager

#### 2.3 Automatizaciones de alertas por Lead Score

**Objetivo:** Si Lead Score > 20 (HOT Lead) → Crear alerta roja  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** If "Lead Score" > 20 → create alert

**Objetivo:** Si Lead Score > 20 (HOT Lead) → Notificar a Adelino / Dirección Comercial  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** If "Lead Score" > 20 → send notification to Adelino/Management

#### 2.4 Automatizaciones para Pipelines (Capa 2)

**Objetivo:** Al mover a "Reunión agendada" → Crear tarea automática  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** When status changes to "Reunión agendada" → create task

**Objetivo:** Al mover a "Reunión agendada" → Sincronizar con Calendly  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de integración (Zapier/Make)  
- **Configuración:** Monday status change → Zapier → Calendly

**Objetivo:** Al mover a "Reunión agendada" → Generar enlace Zoom automático  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de integración (Zapier/Make)  
- **Configuración:** Monday status change → Zapier → Zoom API

**Objetivo:** Al mover a "Propuesta enviada" → Crear tarea de follow-up en 3 días  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** When status changes to "Propuesta enviada" → create task in 3 days

**Objetivo:** Al mover a "Cerrado – Ganado" → Mover a MC – Clientes Activos 2026  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** When status changes to "Cerrado – Ganado" → move to different board

**Objetivo:** Al mover a "Cerrado – Ganado" → Enviar email de bienvenida  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** When status changes to "Cerrado – Ganado" → send email

**Objetivo:** Al mover a "Cerrado – Ganado" → Notificar al equipo de implementación  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** When status changes to "Cerrado – Ganado" → send notification

**Objetivo:** Al mover a "Cerrado – Perdido" → Solicitar motivo obligatoriamente  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** When status changes to "Cerrado – Perdido" → require column value

**Objetivo:** Al mover a "Cerrado – Perdido" → Registrar en dashboard de pérdidas  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de integración (Zapier/Make)  
- **Configuración:** Monday status change → Zapier → Dashboard update

**Objetivo:** Dormant → Si pasan 90 días sin acción → mover automáticamente  
- **Estado:** ❌ PENDIENTE  
- **Método:** A través de automatizaciones nativas de Monday.com  
- **Configuración:** If no update in 90 days → move to "Dormant" group

### 3. CÓMO IMPLEMENTAR LAS AUTOMATIZACIONES

#### 3.1 Automatizaciones nativas de Monday.com
- Se configuran en: Board Settings > Automations
- Seleccionar "Create Automation"
- Definir "Trigger" (Cuándo sucede)
- Definir "Action" (Qué hacer)

#### 3.2 Integraciones externas (Zapier/Make)
- Para funcionalidades más complejas
- Conexión con otros servicios (Calendly, Zoom, Emails personalizados, etc.)

### 4. PRIORIDADES PARA LA FASE 7

1. **Alta prioridad:**
   - Asignar responsable cuando entra un nuevo lead
   - Mover leads entre grupos según Lead Score (ya implementado vía webhook)
   - Notificaciones para leads sin contacto por 48h/5 días

2. **Media prioridad:**
   - Emails de bienvenida automatizados
   - Alertas para HOT leads
   - Crear tareas de seguimiento

3. **Baja prioridad:**
   - Integraciones con Calendly/Zoom
   - Migración a otros tableros
   - Dashboards avanzados

### 5. REQUISITOS PARA IMPLEMENTACIÓN

- **Acceso a automatizaciones:** Requiere plan de Monday.com con automatizaciones
- **Plantillas de email:** Necesario crearlas en Monday.com
- **Usuarios para asignación:** Definir responsables por país/tipo de lead
- **Configuración de grupos:** Asegurar que los grupos "At Risk", "Dormant", etc. existan

### 6. ESTADO ACTUAL DEL PROYECTO

- **Fase 0-6:** ✅ COMPLETADAS
- **Fase 7 (Automatizaciones):** 🔄 EN PREPARACIÓN
- **Fase 8 (Deployment):** ❌ PENDIENTE

**Sistema funcional:** ✅ 100% operativo para ingreso y clasificación de leads  
**Automatizaciones pendientes:** 12 de 18 automatizaciones del blueprint original