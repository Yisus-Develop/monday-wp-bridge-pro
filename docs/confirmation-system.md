# SISTEMA DE CONFIRMACIÓN Y MONITOREO DE FORMULARIOS
## Mars Challenge CRM Integration 2026

### DESCRIPCIÓN

El sistema de confirmación actúa como intermediario que verifica que cada formulario de Contact Form 7 se procese correctamente a través de todo el flujo:

**Formulario CF7** → **Webhook Handler** → **Procesamiento** → **Creación en Monday** → **Confirmación y Logging**

### COMPONENTES DEL SISTEMA

#### 1. **Clase WebhookConfirmation**
- **Archivo**: `src/wordpress/scripts/webhook-confirmation.php`
- **Función**: Procesa formularios con verificación paso a paso
- **Características**:
  - Validación de datos de entrada
  - Procesamiento de scoring
  - Preparación de datos para Monday
  - Creación/actualización de leads
  - Generación de logs detallados

#### 2. **Webhook Handler Mejorado**
- **Archivo**: `src/wordpress/scripts/enhanced-webhook-handler.php`
- **Función**: Reemplaza el webhook original con confirmación
- **Características**:
  - Uso del sistema de confirmación
  - Respuestas estructuradas
  - Manejo de errores robusto

#### 3. **Sistema de Logging**
- **Archivos**:
  - `logs/webhook_confirmation.log` - Logs de procesos exitosos
  - `logs/webhook_errors.log` - Logs de errores

### PASOS DE VERIFICACIÓN

El sistema verifica cada formulario en 4 pasos principales:

1. **Validación de Datos** (`validation`)
   - Verifica campos requeridos
   - Valida formato de email
   - Confirma datos mínimos necesarios

2. **Procesamiento de Scoring** (`scoring`)
   - Calcula Lead Score
   - Determina clasificación (HOT/WARM/COLD)
   - Detecta rol e idioma

3. **Preparación para Monday** (`monday_data_preparation`)
   - Formateo correcto de valores
   - Mapeo de columnas
   - Preparación de estructura de datos

4. **Creación en Monday** (`monday_creation`)
   - Creación o actualización de lead
   - Asignación de valores a columnas
   - Manejo de duplicados

### MONITOREO Y VERIFICACIÓN

#### Para Verificar que un Formulario se Procesó Correctamente:

1. **Consultar el log de confirmaciones**:
   ```bash
   php view-confirmation-logs.php
   ```

2. **Buscar por Process ID** (generado para cada formulario):
   ```php
   $confirm = new WebhookConfirmation();
   $status = $confirm->getProcessStatus('process_id_aqui');
   ```

3. **Verificar en Monday**:
   - Buscar el lead creado en el tablero MC – Lead Master Intake
   - Confirmar que todos los campos están correctamente llenados

#### Para Diagnóstico de Problemas:

1. **Verificar logs de errores**:
   - Archivo: `logs/webhook_errors.log`
   - Contiene errores de validación, procesamiento o API

2. **Verificar logs completos**:
   - Archivo: `logs/webhook_confirmation.log`
   - Contiene todos los pasos de cada proceso

### EJEMPLO DE RESPUESTA EXITOSA

```json
{
  "status": "success",
  "process_id": "proc_abc123...",
  "message": "Formulario procesado exitosamente",
  "lead_id": "1234567890",
  "score": 21,
  "classification": "HOT"
}
```

### IMPLEMENTACIÓN EN PRODUCCIÓN

Para usar el sistema de confirmación en producción:

1. **Colocar el webhook handler** en el endpoint que CF7 llama
2. **Asegurar que los directorios de logs** tengan permisos de escritura
3. **Monitorear regularmente** los logs para detectar problemas
4. **Usar los process_id** para rastrear formularios específicos

### BENEFICIOS DEL SISTEMA

- ✅ **Confirmación de procesamiento** - Saber que cada formulario se procesó
- ✅ **Rastreo completo** - Seguimiento de cada paso del proceso
- ✅ **Diagnóstico de errores** - Identificación precisa de problemas
- ✅ **Auditoría completa** - Registro de todos los procesos
- ✅ **Monitoreo en tiempo real** - Visibilidad del estado del sistema

### ARCHIVOS RELACIONADOS

- `webhook-confirmation.php` - Sistema de confirmación
- `enhanced-webhook-handler.php` - Webhook con confirmación
- `view-confirmation-logs.php` - Visualizador de logs
- `logs/webhook_confirmation.log` - Logs de procesos
- `logs/webhook_errors.log` - Logs de errores