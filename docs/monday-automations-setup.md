# Instrucciones para Configurar Automatizaciones en Monday.com

## Resumen de Automatizaciones Requeridas

Este documento proporciona instrucciones detalladas para configurar las automatizaciones en la interfaz de Monday.com, parte crítica de la Fase 7 del Implementation Roadmap.

## Requisitos Previos

Antes de configurar las automatizaciones, asegúrate de haber completado:

- [x] Todas las columnas críticas creadas
- [x] Etiquetas de clasificación (HOT, WARM, COLD) configuradas manualmente en la columna "Clasificación"
- [x] Grupos de clasificación creados (HOT, WARM, COLD, SPAM, Archive)
- [x] Testing básico completado

## Automatización 1: Asignación Automática de Leads HOT

### Objetivo
Asignar automáticamente a un responsable específico los leads clasificados como "HOT" y enviar notificación.

### Instrucciones de Configuración

1. **Navegar a tu tablero "Leads"**
2. **Clic en "Automatization"** (en el menú lateral derecho)
3. **Clic en "Create New Automation"**
4. **Seleccionar "Rule-based automation"**
5. **Configurar la regla como sigue:**

#### Trigger:
- "When an update changes the column"
- Seleccionar columna: "Clasificación" (`color_mkypv3rg`)
- "When its value changes to": HOT

#### Action:
- "Change assignee"
- Seleccionar el responsable (ej: "Adelino" o Director Comercial)
- "Send notification to assignee"

6. **Guardar la automatización**
7. **Nombrarla**: "Auto-assign HOT leads"

## Automatización 2: Routing por Tipo de Lead

### Objetivo
Mover automáticamente los leads universitarios al grupo correspondiente.

### Instrucciones de Configuración

1. **En la misma sección de "Automatization"**
2. **Clic en "Create New Automation"**
3. **Seleccionar "Rule-based automation"**
4. **Configurar la regla como sigue:**

#### Trigger:
- "When an update changes the column"
- Seleccionar columna: "Tipo de Lead" (`dropdown_mkyp8q98`)
- "When its value changes to": Universidad

#### Action:
- "Move item to group"
- Seleccionar grupo: "🎓 Universidades"

5. **Guardar la automatización**
6. **Nombrarla**: "Move university leads to group"

## Automatización 3: Follow-up Automático

### Objetivo
Establecer una fecha de próxima acción y crear una tarea de seguimiento para cada nuevo lead.

### Instrucciones de Configuración

**NOTA**: Esta automatización puede requerir el plan de Monday.com Business o superior, ya que involucra la creación de tareas.

1. **En la sección de "Automatization"**
2. **Clic en "Create New Automation"**
3. **Seleccionar "Rule-based automation"**
4. **Configurar la regla como sigue:**

#### Trigger:
- "When an item is created"

#### Action:
- "Add date": Establecer columna "Próxima Acción" (`date_mkypeap2`) a "Today + 2 days"
- "Create a task": Crear tarea con título "Contactar lead" asignada al responsable correspondiente

5. **Guardar la automatización**
6. **Nombrarla**: "Auto follow-up setup"

## Automatización 4: Alertas para Leads HOT

### Objetivo
Enviar una notificación por email cuando se crea un lead clasificado como HOT.

### Instrucciones de Configuración

1. **En la sección de "Automatization"**
2. **Clic en "Create New Automation"**
3. **Seleccionar "Rule-based automation"**
4. **Configurar la regla como sigue:**

#### Trigger:
- "When an update changes the column"
- Seleccionar columna: "Clasificación" (`color_mkypv3rg`)
- "When its value changes to": HOT

#### Action:
- "Send email"
- Destinatario: "comercial@marschallenge.space"
- Asunto: "🔥 HOT Lead detectado"
- Cuerpo: "Se ha creado un nuevo lead clasificado como HOT. Revisar en el tablero: [enlace al tablero]"

5. **Guardar la automatización**
6. **Nombrarla**: "HOT lead email alert"

## Automatizaciones Adicionales (Opcionales)

### Automatización 5: Clasificación por Lead Score
- **Trigger**: When an update changes the column "Lead Score" (`numeric_mkyn2py0`)
- **Action**: When value is greater than 20, update "Clasificación" to "HOT"

### Automatización 6: Canal por Origen
- **Trigger**: When an item is created with specific form identifier
- **Action**: Update "Canal de Origen" based on form source

## Validación de Automatizaciones

Después de configurar cada automatización:

1. **Crear un ítem de prueba** en el tablero
2. **Cambiar su clasificación a HOT** para probar la automatización de asignación
3. **Verificar que se haya asignado al responsable correcto**
4. **Repetir con cada tipo de lead** para validar el routing
5. **Comprobar que las fechas de seguimiento** se hayan establecido
6. **Confirmar que las alertas por email** se hayan enviado

## Troubleshooting

### Problemas Comunes:
- **La automatización no se ejecuta**: Verificar que las condiciones se hayan cumplido correctamente
- **Etiquetas no reconocidas**: Asegurarse de que las etiquetas en las columnas coincidan exactamente
- **Permisos insuficientes**: Algunas acciones requieren permisos de admin o plan Business+

### Validación de IDs de Columnas:
Asegúrate de usar los IDs correctos:
- Clasificación: `color_mkypv3rg`
- Tipo de Lead: `dropdown_mkyp8q98`
- Canal de Origen: `dropdown_mkypf16c`
- Fecha de Entrada: `date_mkyp6w4t`
- Próxima Acción: `date_mkypeap2`

## Próximos Pasos

Una vez configuradas todas las automatizaciones:

1. **Realizar testing completo** con datos reales simulados
2. **Revisar logs y comportamiento** de las automatizaciones
3. **Preparar para deployment a producción**
4. **Capacitar al equipo comercial** en el nuevo flujo