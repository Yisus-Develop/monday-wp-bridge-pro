# Opciones para Conectarse a Formularios Contact Form 7

## Resumen

Este documento detalla todas las opciones disponibles para conectarse y leer los formularios de Contact Form 7 en el sitio de Mars Challenge.

## Opción 1: API REST Oficial de Contact Form 7

**Endpoint**: `https://marschallenge.space/wp-json/contact-form-7/v1/contact-forms`

**Método**: GET con autenticación básica

**Credenciales**:
- Usuario: `wmaster_cs4or9qs`
- Contraseña de aplicación: `THuf tLn6 MQXG bCsS usyN yBca`

**Ventajas**:
- API oficial del plugin
- Devuelve datos estructurados de formularios
- Puede acceder a la propiedad `properties.form` que contiene el template del formulario

**Desventajas**:
- Requiere activar la extensión REST API de CF7
- Puede tener limitaciones de seguridad
- Algunos campos pueden no estar completamente expuestos

**Script existente**: `inspect-wp.php`

## Opción 2: Custom Post Type de WordPress

**Endpoint**: `https://marschallenge.space/wp-json/wp/v2/wpcf7_contact_form`

**Método**: GET con autenticación básica

**Credenciales**:
- Usuario: `wmaster_cs4or9qs`
- Contraseña de aplicación: `THuf tLn6 MQXG bCsS usyN yBca`

**Ventajas**:
- Accede a los formularios como contenido de WordPress
- Puede proporcionar información adicional
- Método más estándar de WordPress

**Desventajas**:
- Puede que no exponga todos los detalles del formulario
- Requiere permisos adecuados

**Script existente**: `analyze-cf7-forms-v2.php`

## Opción 3: Acceso Directo a la Base de Datos (si es posible)

**Requiere**: Acceso directo a la base de datos del sitio WordPress

**Método**: Consulta a la tabla `wp_posts` donde `post_type = 'wpcf7_contact_form'`

**Ventajas**:
- Acceso completo a todos los datos del formulario
- Incluye el contenido completo del formulario en `post_content`
- No depende de APIs ni permisos REST

**Desventajas**:
- Requiere acceso directo a la base de datos
- Mayor complejidad de implementación
- Mayor riesgo de seguridad

## Opción 4: Scraping del Panel de Administración (no recomendado)

**Método**: Acceder al panel de administración de WordPress y extraer la información de los formularios

**Ventajas**:
- Acceso a todo el contenido como lo ve el administrador

**Desventajas**:
- Muy inestable
- Requiere manejo de sesiones y autenticación
- No es una solución técnica recomendable
- Puede violar políticas de uso

## Opción 5: Plugin de Exportación/Importación

**Método**: Usar plugins específicos que exporten configuraciones de CF7

**Ventajas**:
- Puede proporcionar formatos estructurados
- A veces más accesible que las APIs

**Desventajas**:
- Requiere que el plugin esté instalado y activo
- Puede no estar disponible en producción

## Opción 6: Webhooks Personalizados o Hooks de WordPress

**Método**: Si tienes control del código del sitio, puedes implementar endpoints personalizados

**Ventajas**:
- Control total sobre la información expuesta
- Puedes estructurar la salida como necesites

**Desventajas**:
- Requiere acceso al código del sitio
- Cambios en el sitio de producción pueden ser riesgosos

## Recomendación Actual

De las opciones ya implementadas en el proyecto:

1. **Primero intentar**: `analyze-cf7-forms-v2.php` (método CPT)
2. **Segunda opción**: `inspect-wp.php` (API REST CF7)
3. **Última opción**: `analyze-cf7-forms.php` (API REST CF7 método 1)

## Estado Actual

Según el archivo `cf7_forms_analysis.json`, ambos métodos han devuelto un array vacío, lo que sugiere:

1. Las credenciales podrían ser incorrectas
2. El plugin REST API de CF7 no está activo
3. No hay permisos suficientes para acceder a los detalles de los formularios
4. Los endpoints no están disponibles o están restringidos

## Próximos Pasos

1. Verificar que las credenciales sean correctas
2. Verificar que el plugin REST API de CF7 esté activo
3. Probar manualmente los endpoints con las credenciales
4. Considerar el acceso directo a la base de datos si las opciones API no funcionan