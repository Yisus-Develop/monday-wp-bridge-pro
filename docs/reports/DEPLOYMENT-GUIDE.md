# Archivos para Actualizar en WordPress

## 📦 Archivos de Producción (8 archivos)

Sube **SOLO estos archivos** a tu servidor WordPress:

### Ubicación en el servidor

```
wp-content/plugins/monday-automation/
```

### Lista de archivos

1. **`monday-webhook-trigger.php`** ⭐ NUEVO
   - Se engancha automáticamente a Contact Form 7
   - No necesitas configurar nada en CF7

2. **`webhook-handler.php`** ✏️ ACTUALIZADO
   - Procesador principal con dos pasos (create + update)
   - Maneja teléfonos de forma robusta

3. **`LeadScoring.php`** ✏️ ACTUALIZADO
   - Agregado `sanitizePhone()` para limpiar teléfonos
   - Terminología directa (Zer, Pioneer, etc.)

4. **`MondayAPI.php`** ✏️ ACTUALIZADO
   - Manejo correcto de JSON para Monday API
   - Auto-stringify en createItem/updateItem

5. **`NewColumnIds.php`** ✏️ ACTUALIZADO
   - ID actualizado para RAW_DATA_JSON: `long_text_mkyxhent`

6. **`StatusConstants.php`** (sin cambios)
   - Clasificación HOT/WARM/COLD

7. **`language-config.json`** (sin cambios)
   - Configuración de idiomas por país

8. **`config.php`** ⚠️ IMPORTANTE
   - **ACTUALIZA tu token de Monday.com aquí**
   - Verifica el Board ID

---

## ❌ NO Subas Estas Carpetas

- `tests/` - Solo para desarrollo
- `utils/` - Solo para mantenimiento

---

## 🚀 Pasos de Instalación

### 1. Respalda la versión actual

```bash
# En tu servidor
cd wp-content/plugins/
cp -r monday-automation monday-automation-backup-$(date +%Y%m%d)
```

### 2. Sube los 8 archivos

- Vía FTP/SFTP
- O desde el panel de WordPress (File Manager)

### 3. Verifica `config.php`

```php
define('MONDAY_API_TOKEN', 'TU_TOKEN_AQUI'); // ← Actualiza
define('MONDAY_BOARD_ID', '18392144864');    // ← Verifica
```

### 4. Prueba con 1 lead

- Llena el formulario de contacto
- Verifica que llegue a Monday.com
- Confirma que todos los campos estén llenos

---

## ✅ Checklist de Verificación

Después de subir, verifica:

- [ ] El formulario sigue funcionando
- [ ] Los leads llegan a Monday.com
- [ ] El teléfono aparece con bandera correcta
- [ ] El "Tipo de Lead" muestra el perfil correcto (Zer, Pioneer, etc.)
- [ ] El campo "Respaldo RAW (JSON)" tiene datos
- [ ] La clasificación es HOT/WARM/COLD según el score

---

## 🆘 Si Algo Falla

1. Revisa los logs de WordPress: `wp-content/debug.log`
2. Verifica el token en `config.php`
3. Confirma que el Board ID sea correcto
4. Restaura el backup si es necesario

---

## 📊 Diferencias vs Versión Anterior

| Característica | Antes | Ahora |
|----------------|-------|-------|
| Teléfonos | ❌ Fallaban | ✅ Llegan limpios con bandera |
| Perfiles | Solo algunos | ✅ Los 8 perfiles completos |
| Backup JSON | ❌ No existía | ✅ Columna dedicada |
| Terminología | Genérica | ✅ Directa (Zer, Pioneer) |
| Confiabilidad | 1 paso (frágil) | ✅ 2 pasos (robusto) |
