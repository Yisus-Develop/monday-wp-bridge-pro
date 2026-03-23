# Implementación de Filtrado por Idioma en Monday.com usando Plantillas

## 1. Introducción

Este documento explica cómo utilizar las herramientas de plantillas de Monday.com para implementar filtros por idioma/país, permitiendo una personalización efectiva de los leads basados en su ubicación geográfica y el idioma correspondiente.

## 2. Configuración de Columnas en Monday.com

### 2.1 Columnas Requeridas

Para implementar correctamente el filtrado por idioma, se deben crear o asegurar las siguientes columnas en el tablero "Leads":

#### 2.1.1 Columna de País
- **Nombre**: País
- **Tipo**: Texto
- **ID**: `text_mkyn95hk` (o el ID asignado al crearla)
- **Descripción**: Almacena el país del contacto extraído del formulario

#### 2.1.2 Columna de Idioma
- **Nombre**: Idioma
- **Tipo**: Estado
- **ID**: `language_mkyn_code`
- **Opciones**: ES (Español), PT (Portugués), EN (Inglés)
- **Descripción**: Idioma detectado basado en el país

#### 2.1.3 Columna de Plantilla
- **Nombre**: Plantilla de Mensaje
- **Tipo**: Texto
- **ID**: `template_message_text`
- **Descripción**: Contiene el mensaje personalizado según el idioma

## 3. Creación de Plantillas por Idioma

### 3.1 Plantilla para Idioma Español

1. **Crear un board o grupo para la plantilla**:
   - Nombre: "Plantilla ES - Hablantes de Español"
   - Configurar los valores predeterminados para esta plantilla

2. **Configurar valores predeterminados**:
   - Columna "Idioma": ES
   - Columna "Clasificación": WARM (puede ajustarse según reglas de negocio)
   - Columna "Rol Detectado": Personalizar según perfil hispanohablante

### 3.2 Plantilla para Idioma Portugués

1. **Crear un board o grupo para la plantilla**:
   - Nombre: "Plantilla PT - Hablantes de Portugués"
   - Configurar los valores predeterminados para esta plantilla

2. **Configurar valores predeterminados**:
   - Columna "Idioma": PT
   - Columna "Clasificación": WARM
   - Columna "Rol Detectado": Personalizar según perfil lusófono

### 3.3 Plantilla para Idioma Inglés

1. **Crear un board o grupo para la plantilla**:
   - Nombre: "Plantilla EN - Hablantes de Inglés"
   - Configurar los valores predeterminados para esta plantilla

2. **Configurar valores predeterminados**:
   - Columna "Idioma": EN
   - Columna "Clasificación": WARM
   - Columna "Rol Detectado": Personalizar según perfil angloparlante

## 4. Configuración de Automatizaciones en Monday.com

### 4.1 Automatización basada en columna de país

1. **Ir a Automatizaciones en el tablero "Leads"**
2. **Crear nueva automatización**:
   - **Nombre**: "Detectar idioma por país"
   - **Cuando**: Una actualización cambia la columna "País"
   - **Entonces**: Actualizar la columna "Idioma" con el valor correspondiente

3. **Configurar la lógica**:
   ```
   Si columna "País" contiene "México" o "Colombia" o "Argentina" o "España" → Establecer "Idioma" = ES
   Si columna "País" contiene "Brasil" o "Portugal" → Establecer "Idioma" = PT
   Si columna "País" contiene "Estados Unidos" o "Canadá" o "Reino Unido" → Establecer "Idioma" = EN
   ```

### 4.2 Automatización basada en idioma

1. **Crear nueva automatización**:
   - **Nombre**: "Personalizar mensaje por idioma"
   - **Cuando**: Una actualización cambia la columna "Idioma"
   - **Entonces**: Actualizar columna "Plantilla de Mensaje" y posiblemente otros campos

2. **Configurar las acciones**:
   - Si "Idioma" = "ES" → Actualizar "Plantilla de Mensaje" con mensaje en español
   - Si "Idioma" = "PT" → Actualizar "Plantilla de Mensaje" con mensaje en portugués
   - Si "Idioma" = "EN" → Actualizar "Plantilla de Mensaje" con mensaje en inglés

### 4.3 Automatización de clasificación por idioma

1. **Crear nueva automatización**:
   - **Nombre**: "Ajustar scoring por idioma"
   - **Cuando**: Una actualización cambia la columna "Idioma"
   - **Entonces**: Ajustar el campo "Lead Score" y "Clasificación" según sea necesario

## 5. Implementación de Reglas de Negocio por Idioma

### 5.1 Reglas de Puntuación Específicas

Utilizando las automatizaciones de Monday, se pueden implementar reglas específicas:

- **Países hispanohablantes prioritarios** (MX, CO, AR): +2 puntos al Lead Score
- **País lusófono prioritario** (BR): +3 puntos al Lead Score  
- **Países angloparlantes clave** (US, CA, UK): +2 puntos al Lead Score

### 5.2 Asignación Automática

- **Leads con idioma ES**: Asignar a representante de habla hispana
- **Leads con idioma PT**: Asignar a representante de habla portuguesa
- **Leads con idioma EN**: Asignar a representante internacional

## 6. Configuración de Grupos de Trabajo por Idioma

### 6.1 Crear Grupos por Idioma

En el tablero "Leads", crear grupos para organizar visualmente los leads por idioma:

1. **Grupo "Hablantes de Español"**
   - Filtro: Columna "Idioma" = "ES"
   - Color: Verde

2. **Grupo "Hablantes de Portugués"**
   - Filtro: Columna "Idioma" = "PT"
   - Color: Azul

3. **Grupo "Hablantes de Inglés"**
   - Filtro: Columna "Idioma" = "EN"
   - Color: Rojo

### 6.2 Filtros Personalizados

Crear vistas filtradas para cada equipo:

- **Vista "Equipo Español"**: Mostrar solo leads con idioma ES
- **Vista "Equipo Portugués"**: Mostrar solo leads con idioma PT
- **Vista "Equipo Internacional"**: Mostrar solo leads con idioma EN

## 7. Monitoreo y Reportes por Idioma

### 7.1 Crear Reportes Específicos

1. **Reporte de Conversión por Idioma**:
   - Comparar tasas de conversión entre diferentes idiomas
   - Evaluar la efectividad de los mensajes personalizados

2. **Reporte de Tiempo de Respuesta por Idioma**:
   - Medir tiempos de respuesta para diferentes idiomas
   - Asegurar atención equitativa

### 7.2 KPIs por Idioma

- Tasa de respuesta por idioma
- Tiempo promedio de conversión por idioma
- Lead Score promedio por idioma
- Conversion rate por idioma

## 8. Consideraciones Técnicas

### 8.1 Mapeo desde Contact Form 7

Asegurar que el webhook desde Contact Form 7 esté enviado correctamente el país del contacto para que Monday pueda aplicar las automatizaciones:

```
Dato enviado desde CF7: "country" o "pais_cf7" o "pais_otro"
Mapeado a: Columna "País" en Monday
```

### 8.2 Validación de Datos

- Implementar validación para asegurar que el país enviado es reconocido
- Establecer un valor por defecto (ES) para países no reconocidos
- Controlar mayúsculas/minúsculas y acentos en los nombres de países

## 9. Mejores Prácticas

1. **Prueba exhaustiva**: Probar con muestras de diferentes países antes de producción
2. **Mantenimiento de listas**: Actualizar regularmente las listas de países por idioma
3. **Feedback de equipos**: Recopilar comentarios de los equipos de ventas sobre la efectividad
4. **Escalabilidad**: Diseñar el sistema para fácil incorporación de nuevos idiomas

## 10. Implementación Gradual

### 10.1 Fase 1: Configuración Básica
- Crear columnas requeridas
- Establecer automatizaciones básicas de detección de idioma
- Probar con un subconjunto de datos

### 10.2 Fase 2: Automatizaciones Avanzadas
- Implementar reglas de scoring por idioma
- Añadir asignación automática de equipos
- Configurar grupos por idioma

### 10.3 Fase 3: Monitoreo y Ajustes
- Implementar reportes por idioma
- Recopilar feedback y hacer ajustes
- Expandir a otros tableros si aplica

Esta implementación permite una personalización efectiva de la experiencia del lead basada en su idioma y ubicación geográfica, directamente dentro de la plataforma Monday.com, sin necesidad de sistemas externos complejos.