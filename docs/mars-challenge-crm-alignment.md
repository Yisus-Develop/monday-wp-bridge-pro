# Mars Challenge CRM Integration - Documento de Alineamiento

## 1. Visión del Proyecto

Crear una aplicación personalizada que integre los formularios web (Contact Form 7) de un sitio WordPress con el CRM de Monday.com para el Mars Challenge 2026, permitiendo una gestión centralizada y automatizada de leads con seguimiento completo desde la captación inicial hasta el cierre de oportunidades.

## 2. Objetivos Principales

- Conectar formularios web con Monday para registro automático de leads
- Implementar el Lead Scoring definido en el blueprint oficial
- Automatizar tareas y notificaciones según reglas de negocio
- Permitir respuesta y seguimiento directo desde Monday
- Crear un sistema centralizado con visibilidad total del pipeline

## 3. Alcance del Proyecto

### 3.1. Componentes Principales
- **Servidor Backend**: API para manejar webhooks y lógica de negocio
- **Integración WordPress**: Conexión con formularios Contact Form 7
- **Integración Monday.com**: Gestionar tableros, columnas y automatizaciones
- **Sistema de Automatizaciones**: Reglas personalizadas de negocio

### 3.2. Funcionalidades Clave
- Recepción de datos de formularios vía webhooks
- Procesamiento y validación de datos
- Cálculo automático de Lead Score (0-30 puntos)
- Asignación automática de responsables
- Creación automática de tareas de seguimiento
- Monitoreo de leads según tiempos de respuesta
- Sistema de notificaciones inteligentes

## 4. Arquitectura del Sistema

### 4.1. Capas del Sistema
1. **CAPA 1** - Lead Intake Global (entrada universal)
2. **CAPA 2** - Pipelines por segmento (4 tableros)
3. **CAPA 3** - Ventas & Cierre (tablero único)
4. **CAPA 4** - Dashboards & Reportes (paneles automáticos)

### 4.2. Tableros Monday
- **MC – Lead Master Intake**: Captación universal de leads
- **MC – Pipeline Universidades**: Gestión de oportunidades universitarias
- **MC – Pipeline Escuelas**: Gestión de oportunidades escolares
- **MC – Pipeline Ciudades**: Gestión de oportunidades municipales
- **MC – Pipeline Corporate Partners**: Gestión de oportunidades corporativas
- **MC – Clientes Activos 2026**: Seguimiento post-cierre

## 5. Lead Scoring - Fórmula Oficial

### 5.1. Criterios y Puntos
- Recomendación / Mission Partner: 10 puntos
- Rector / Alcalde / CEO: 10 puntos
- País prioritario: 5 puntos
- Contacto en evento: 5 puntos
- Formulario completo: 3 puntos
- Website orgánico: 5 puntos
- Lead Ads: 3 puntos

### 5.2. Clasificación
- Hot Lead (>20 puntos)
- Warm Lead (10-20 puntos)
- Cold Lead (<10 puntos)

## 6. Automatizaciones Obligatorias

### 6.1. Lead Intake
- Asignación automática de responsable
- Email automático de bienvenida
- Creación de tarea "Contactar en 48h"
- Cálculo automático de Lead Score
- Definición de Prioridad automática

### 6.2. Seguimiento
- Notificación si pasan 48h sin contacto
- Movimiento a "At Risk" si pasan 5 días sin actualización
- Alerta roja si Lead Score > 20 (HOT Lead)
- Seguimiento específico según etapa del pipeline

## 7. Integración con Canales Externos

- Formularios del sitio web (Contact Form 7)
- Redes sociales
- WhatsApp API
- Sistema de email
- Mission Partners

## 8. Fases de Desarrollo

### 8.1. Fase 1: Backend
- Configuración del servidor Node.js/Express
- Implementación de endpoints para webhooks
- Conexión con API de Monday
- Implementación de lógica de Lead Scoring

### 8.2. Fase 2: Conexión WordPress
- Análisis de formularios existentes
- Configuración de webhooks desde WordPress
- Validación de datos recibidos

### 8.3. Fase 3: Integración Monday
- Creación de la estructura de tableros y columnas
- Implementación de lógica para crear leads
- Configuración de automatizaciones personalizadas

## 9. Requerimientos Técnicos

- Node.js v16+
- TypeScript
- Express.js
- graphql-request (API de Monday)
- Sistema de autenticación y logging
- Mecanismos de validación de datos

## 10. Consideraciones de Seguridad

- Validación de todos los datos entrantes
- Autenticación en endpoints críticos
- Protección contra inyección de consultas GraphQL
- Monitoreo de actividad

## 11. Indicadores de Éxito

- Ningún lead se pierde en el proceso
- Acompañamiento centralizado de todas las oportunidades
- Conversión 3× más rápida
- Visibilidad total del pipeline
- Reporte semanal global
- Escalabilidad en 25+ países

## 12. Próximos Pasos

1. Configurar el entorno de desarrollo
2. Implementar el servidor backend básico
3. Crear conexión con la API de Monday
4. Desarrollar la lógica de Lead Scoring
5. Integrar con formularios WordPress
6. Probar y validar el sistema
7. Desplegar a producción