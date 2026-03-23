# Plan para Completar las Fases Pendientes del Implementation Roadmap

## Estado Actual
- Fase 0: ✅ Completada
- Fase 1: ✅ Completada
- Fase 2: ✅ Completada (con excepción de configuración manual de etiquetas)
- Fase 3: ✅ Completada
- Fase 4: ✅ Completada
- Fase 5: ✅ Completada
- Fase 6: ⚠️ En progreso (50%) - Testing con los scripts creados
- Fase 7: ❌ Pendiente - Automatizaciones Monday
- Fase 8: ❌ Pendiente - Deployment a producción

## Fase 6: Testing Exhaustivo - Pendiente de Configuración Manual

### Configuración Manual Requerida en Monday.com (Paso Crítico)
Antes de ejecutar completamente el testing, se debe realizar este paso manual:

**Configurar las etiquetas de la columna "Clasificación" (`color_mkypv3rg`)**:
1. Ir al tablero "Leads" en Monday.com
2. Hacer clic en la columna "Clasificación" (status)
3. Hacer clic en "Column Settings"
4. Configurar las etiquetas como: "HOT", "WARM", "COLD"
5. Guardar la configuración

### Ejecución del Testing
Una vez completada la configuración manual:
```bash
php src/wordpress/test-all-forms.php
```

## Fase 7: Configurar Automatizaciones Monday - Pendiente

### Automatizaciones Requeridas

#### Automatización 1: Asignación Automática
- **CUANDO** se crea un ítem
- **Y** Clasificación = "HOT"
- **ENTONCES** asignar a "Adelino" (Director Comercial)
- **Y** enviar notificación

#### Automatización 2: Routing por Tipo
- **CUANDO** se crea un ítem
- **Y** Tipo de Lead = "Universidad"
- **ENTONCES** mover a grupo "🎓 Universidades"

#### Automatización 3: Follow-up Automático
- **CUANDO** se crea un ítem
- **ENTONCES** establecer "Próxima Acción" = Hoy + 2 días
- **Y** crear tarea "Contactar lead"

#### Automatización 4: Alertas HOT
- **CUANDO** se crea un ítem
- **Y** Lead Score > 20
- **ENTONCES** enviar email a "comercial@marschallenge.space"
- **Con asunto** "🔥 HOT Lead detectado"

## Fase 8: Deployment a Producción - Pendiente

### Paso 8.1: Subir Archivos al Servidor
```bash
# Vía FTP/SFTP
/wp-content/monday-integration/
├── webhook-handler.php
├── MondayAPI.php
├── LeadScoring.php
├── monday-webhook-trigger.php (plugin de WordPress)
└── logs/ (crear directorio con permisos adecuados)
```

### Paso 8.2: Verificar Permisos
```bash
chmod 755 webhook-handler.php
chmod 644 config.php
chmod 777 logs/
```

### Paso 8.3: Activar Webhook en CF7
- Instalar el plugin `monday-webhook-trigger.php` en WordPress
- Configurar el webhook para los 11 formularios (excluir newsletter)

### Paso 8.4: Monitoreo Inicial
```bash
# Revisar logs en tiempo real
tail -f /wp-content/monday-integration/logs/webhook_log.txt
```

## Prioridades para Avanzar

### Inmediata (Requiere acción humana)
1. **Configurar manualmente las etiquetas de clasificación en Monday.com**

### Alta (Después de configuración manual)
2. **Ejecutar testing completo con `test-all-forms.php`**
3. **Configurar automatizaciones en Monday.com (UI)**

### Media (Una vez completados los pasos anteriores)
4. **Preparar archivos para despliegue**
5. **Realizar deployment a producción**

## Checklist de Pre-Deployment (Actualizado)
- [x] Backup de Monday completado
- [x] Items existentes archivados
- [x] Todas las columnas creadas y verificadas (físicamente, con IDs actualizados en `webhook-handler.php`)
- [x] Webhook handler actualizado con mapeo completo
- [x] Funciones de detección implementadas
- [x] Grupos de clasificación creados
- [x] Reglas de validación implementadas
- [ ] **Configurar etiquetas de "Clasificación" (HOT, WARM, COLD) manualmente en Monday.com** ← **PENDIENTE**
- [ ] Testing de 12 formularios completado (pendiente de la configuración manual)
- [ ] Automatizaciones Monday configuradas ← **PENDIENTE**
- [ ] Archivos subidos al servidor ← **PENDIENTE**
- [ ] Permisos verificados ← **PENDIENTE**
- [ ] Webhook activado en CF7 ← **PENDIENTE**
- [ ] Monitoreo configurado ← **PENDIENTE**

## Recomendación de Siguiente Acción
El próximo paso crítico es configurar manualmente las etiquetas de la columna "Clasificación" en la interfaz de Monday.com, ya que este paso no puede realizarse mediante la API. Una vez completado este paso, se podrá ejecutar el testing completo y avanzar con las automatizaciones.