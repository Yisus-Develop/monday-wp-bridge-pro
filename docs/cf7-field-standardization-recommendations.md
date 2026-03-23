# Recomendaciones para Estandarizar Campos en Contact Form 7

## Resumen del Análisis

Después de analizar los 12 formularios Contact Form 7, se identificaron patrones de consistencia y oportunidades de mejora para facilitar la integración con Monday.com y mejorar el Lead Scoring.

## Campos Comunes Identificados

### Campos Esenciales (Presentes en Todos o Casi Todos los Formularios)

- **nombre** - Nombre del contacto (varía entre "Nombre", "Nombre y Apellido", "Nombre completo", "Tus nombres")
- **email** - Correo electrónico del contacto
- **perfil** - Tipo de perfil del contacto (oculto o select, con valores como "empresa", "pioneer", "ciudad", "institucion", "mentor", "zer")
- **pais_cf7** - País del contacto (generalmente campo oculto)
- **ciudad_cf7** - Ciudad del contacto (generalmente campo oculto)
- **next_step** - Siguiente paso (generalmente campo oculto con valor "confirmacion")

### Campos Especializados por Tipo de Formulario

- **Organización/Institución**: org_name, institution, contact_name, tipo_institucion, numero_estudiantes
- **Contacto**: telefono, telefono, celular
- **Interés/Especialidad**: interes, especialidad, sector
- **Geografía**: pais_otro, ciudad (como campo de texto)
- **Otros**: mensaje, asunto, fecha_nacimiento, monto

## Recomendaciones de Estandarización

### 1. Campos Obligatorios Consistentes

Se recomienda que todos los formularios contengan al menos los siguientes campos con nombres estandarizados:

- `first_name` - Nombre (en lugar de "nombre")
- `last_name` - Apellido (muchos formularios no lo tienen, pero es importante para el scoring)
- `email` - Email (ya está estandarizado)
- `phone` - Teléfono (en lugar de "telefono", "celular", etc.)
- `profile_type` - Tipo de perfil (reemplazando "perfil", con valores consistentes)
- `country` - País (en lugar de "pais_cf7" y "pais_otro")
- `city` - Ciudad (en lugar de "ciudad_cf7" o "ciudad")
- `lead_source` - Fuente del lead (en lugar de "ea_source")

### 2. Nomenclatura de Campos

- Establecer una convención de nomenclatura consistente (por ejemplo, siempre en snake_case)
- Evitar campos duplicados con diferentes nombres que representan la misma información
- Establecer valores predefinidos para campos tipo select para mantener consistencia

### 3. Valores de Perfil

El campo de perfil actual tiene valores inconsistentes:

- Actual: `empresa`, `pioneer`, `ciudad`, `institucion`, `mentor`, `zer`, `pais`
- Propuesta: `company`, `mission_partner`, `local_government`, `educational_institution`, `mentor`, `youth`, `country`

### 4. Mapeo con Monday.com

Para facilitar el mapeo con columnas de Monday.com se recomienda:

- Crear un archivo de mapeo que relacione los campos CF7 con las columnas Monday
- Establecer correspondencias consistentes para facilitar el Lead Scoring
- Asegurar que todos los campos relevantes para el scoring estén presentes en todos los formularios

### 5. Implementación Gradual

1. Crear un formulario base con los campos estandarizados
2. Aplicar gradualmente los cambios a los 12 formularios existentes
3. Actualizar las funciones de procesamiento para manejar los nuevos nombres de campos
4. Asegurar la compatibilidad con la integración existente con Monday.com

## Beneficios de la Estandarización

1. **Facilita el Lead Scoring**: Con campos consistentes, será más fácil aplicar reglas de scoring uniformes
2. **Mejora la integración con Monday.com**: Mapeo más sencillo y menos errores
3. **Facilita el análisis de datos**: Comparación y análisis cruzado entre formularios
4. **Reduce errores de implementación**: Menos confusión sobre qué campos existen en cada formulario
5. **Simplifica el mantenimiento**: Actualizaciones más sencillo en una estructura estandarizada

## Próximos Pasos

1. Implementar una versión piloto en un formulario de prueba
2. Validar que la integración con Monday.com funcione correctamente
3. Planificar la migración gradual de los 12 formularios existentes
4. Actualizar la documentación relacionada con los formularios y la integración