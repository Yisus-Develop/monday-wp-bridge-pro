# Instrucciones para Actualizar Etiquetas de Status Manualmente

## Introducción

Después de nuestro análisis, hemos descubierto que la API de Monday.com requiere un argumento `revision` para actualizar las columnas de status, y este valor no es fácilmente accesible a través de la API pública estándar. Por lo tanto, debemos actualizar manualmente las etiquetas en la interfaz de Monday.com.

## Pasos para Actualizar las Etiquetas

### 1. Actualizar Columna "Clasificación" (color_mkypv3rg)

1. Ve al tablero de **Leads**
2. Haz clic en la columna **"Clasificación"**
3. Selecciona **"Editar Columna"**
4. Haz clic en **"Opciones de Status"**
5. Cambia las etiquetas actuales:
   - "En curso" → **"HOT"**
   - "Listo" → **"WARM"** 
   - "Detenido" → **"COLD"**
6. Puedes asignar colores si lo deseas:
   - HOT → Color rojo
   - WARM → Color amarillo
   - COLD → Color azul

### 2. Actualizar Columna "Rol Detectado" (color_mkyng649)

1. Ve al tablero de **Leads**
2. Haz clic en la columna **"Rol Detectado"**
3. Selecciona **"Editar Columna"**
4. Haz clic en **"Opciones de Status"**
5. Cambia las etiquetas actuales:
   - "En curso" → **"Mission Partner"**
   - "Listo" → **"Rector/Director"**
   - "Detenido" → **"Alcalde/Gobierno"**
6. Agrega las siguientes opciones adicionales:
   - **"Corporate"**
   - **"Maestro/Mentor"**
   - **"Joven"**

## Actualización del Webhook Handler

Mientras tanto, el webhook handler continuará funcionando con las etiquetas actuales ("En curso", "Listo", "Detenido") hasta que se completen las actualizaciones manuales.

### Valores de Clasificación Actuales
- "En curso" = Clasificación alta (HOT)
- "Listo" = Clasificación media (WARM)
- "Detenido" = Clasificación baja (COLD)

### Valores de Rol Detectado Actuales
- "En curso" = Mission Partner
- "Listo" = Rector/Director
- "Detenido" = Alcalde/Gobierno

## Validación Post-Actualización

Después de completar las actualizaciones manuales:

1. **Verificar en la API** que los nuevos valores estén disponibles
2. **Actualizar el webhook handler** para usar las nuevas etiquetas
3. **Ejecutar pruebas** para confirmar que la clasificación funciona correctamente

## Script para Actualizar Webhook Handler

Un script ha sido preparado para adaptar el webhook handler a las nuevas etiquetas una vez que se completen las actualizaciones manuales.