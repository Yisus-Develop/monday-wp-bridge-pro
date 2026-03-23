# Guía de Pruebas para la Integración CF7-Monday

## Descripción
Este documento explica cómo ejecutar las pruebas para validar la integración completa entre Contact Form 7 y Monday.com.

## Scripts Disponibles

### 1. Prueba Local de Scoring (`local-test-all-forms.php`)
Ejecuta la lógica de scoring localmente sin conexión a la API de Monday.com. Útil para validar la puntuación y clasificación sin depender de la configuración en Monday.com.

```bash
cd src/wordpress
php local-test-all-forms.php
```

### 2. Prueba de Integración Completa (`monday-integration-tester.php`)
Prueba la integración completa conectándose a la API de Monday.com y creando/actualizando ítems en el workspace.

```bash
cd src/wordpress
php monday-integration-tester.php
```

### 3. Prueba Original (`test-all-forms.php`)
Simula las llamadas al webhook handler, similar a como lo haría un formulario real.

```bash
cd src/wordpress
php test-all-forms.php
```

## Requisitos Previos

1. **Configuración de credenciales**: Antes de ejecutar pruebas que conectan a Monday.com, asegúrate de actualizar `config.php` con tus credenciales reales:
   ```php
   define('MONDAY_API_TOKEN', 'TU_TOKEN_REAL_AQUI');
   define('MONDAY_BOARD_ID', '18392144864');
   ```

2. **Configuración manual en Monday.com**:
   - Las etiquetas de la columna "Clasificación" deben configurarse manualmente como "HOT", "WARM", "COLD" en la interfaz de Monday.com
   - Asegúrate de que todas las columnas requeridas existan en tu tablero

## Casos de Prueba

Los scripts de prueba incluyen los siguientes perfiles:

1. **Mission Partner/Pioneer (VIP)**: Puntuación alta (10 pts base)
2. **Institución/Universidad**: Puntuación alta (10 pts base + extras por universidad/grandeza)
3. **Ciudad/Gobierno**: Puntuación alta (10 pts base + extras por población)
4. **Empresa**: Puntuación media (5 pts base + extras por modalidad)
5. **Contacto General**: Puntuación baja (0 pts base)
6. **Mentor/Zer**: Puntuación baja (3 pts base)

## Resultados Esperados

- **HOT**: Leads con puntuación > 20 (Mission Partners, Rectors, Alcaldes, con factores adicionales)
- **WARM**: Leads con puntuación 10-20 (Mission Partners, Rectors, Alcaldes, o Empresas con donación)
- **COLD**: Leads con puntuación < 10 (Contactos generales, Mentores, Jóvenes)

## Validación Crítica

Antes de desplegar a producción, asegúrate de:

1. [ ] Las etiquetas de clasificación (HOT/WARM/COLD) están configuradas en la columna "Clasificación" en Monday.com
2. [ ] Las pruebas locales de scoring pasan correctamente
3. [ ] Las pruebas de integración completas funcionan
4. [ ] Se ha validado el manejo de duplicados
5. [ ] Se han verificado las puntuaciones y clasificaciones correctas
6. [ ] Las automatizaciones están configuradas en Monday.com (cuando se alcance esa fase)

## Solución de Problemas

### La clasificación no se muestra correctamente en Monday.com
- **Causa**: Las etiquetas de la columna "Clasificación" no están configuradas en Monday.com
- **Solución**: Configurar manualmente las etiquetas como "HOT", "WARM", "COLD" en la interfaz de Monday.com

### Error de autenticación con Monday.com
- **Causa**: Token incorrecto o expirado
- **Solución**: Verificar y actualizar el token en `config.php`

### Columnas no encontradas
- **Causa**: IDs de columnas incorrectos
- **Solución**: Verificar los IDs actuales en `webhook-handler.php` y en el tablero de Monday.com

## Próximos Pasos

1. Completar las pruebas con credenciales reales
2. Configurar las automatizaciones en Monday.com
3. Validar con datos reales de formularios
4. Preparar el despliegue a producción