# Análisis Completo de Campos en Formularios Contact Form 7

## Resumen General

- Total de formularios: 12
- Total de campos únicos: 35
- Campos esenciales estandarizados: 8 (recomendados)
- Formularios con mayor cantidad de campos: "Beneficios instituciones", "Registro Ciudad/Gobierno local", "Empresa" (11-13 campos cada uno)
- Formularios con menor cantidad de campos: "Formulario de contacto 1" (2 campos)

## Desglose por Formulario

### 1. form pie de pagina (ID: 6811)
- Campos (9): next_step, pais_cf7, ciudad_cf7, perfil, nombre, email, institucion, asunto, mensaje
- Perfil: No definido específicamente
- Comentarios: Similar al formulario "contacto general"

### 2. contacto general (ID: 6807)
- Campos (9): next_step, pais_cf7, ciudad_cf7, perfil, nombre, email, institucion, asunto, mensaje
- Perfil: No definido específicamente
- Comentarios: Duplicado del formulario "form pie de pagina"?

### 3. Beneficios instituciones (ID: 6468)
- Campos (12): perfil, next_step, pais_cf7, ciudad_cf7, org_name, contact_name, email, telefono, tipo_institucion, numero_estudiantes, pais_otro, timestamp-field
- Perfil: definido como "institucion"
- Comentarios: Formulario completo para instituciones educativas

### 4. Suscribirme a alertas (ID: 5410)
- Campos (13): ea_firstname, ea_lastname, ea_role, ea_institution, ea_email, ea_city, ea_country, ea_lang, ea_source, ea_referrer, ea_tags, ea_timestamp, ea_nonce
- Perfil: No definido, pero campos indican propósito de suscripción
- Comentarios: Formulario especializado para suscripciones con campos extendidos

### 5. Registro País (ID: 3074)
- Campos (8): perfil, next_step, pais_cf7, ciudad_cf7, nombre, email, pais_otro, mensaje
- Perfil: definido como "pais"
- Comentarios: Formulario para registro de país

### 6. Mission Partner / Pioneer (ID: 3073)
- Campos (9): perfil, next_step, pais_cf7, ciudad_cf7, nombre, email, interes, telefono, pais_otro
- Perfil: definido como "pioneer"
- Comentarios: Formulario para partners o pioneros

### 7. Registro Ciudad / Gobierno local (ID: 3072)
- Campos (11): perfil, next_step, pais_cf7, ciudad_cf7, entity, nombre, email, telefono, poblacion, aliados_potenciales, pais_otro
- Perfil: definido como "ciudad"
- Comentarios: Formulario detallado para gobiernos locales

### 8. Empresa (ID: 3071)
- Campos (11): perfil, next_step, pais_cf7, ciudad_cf7, company, nombre, email, modality, sector, telefono, pais_otro
- Perfil: definido como "empresa"
- Comentarios: Formulario para empresas con información sobre modalidad y sector

### 9. Registro Institución Educativa (ID: 3070)
- Campos (11): perfil, next_step, pais_cf7, ciudad_cf7, org_name, contact_name, email, telefono, tipo_institucion, numero_estudiantes, pais_otro
- Perfil: definido como "institucion"
- Comentarios: Similar a "Beneficios instituciones" pero sin algunos campos

### 10. Registro Maestros o mentores (ID: 3069)
- Campos (9): perfil, next_step, pais_cf7, ciudad_cf7, nombre, email, institucion, especialidad, pais_otro
- Perfil: definido como "mentor"
- Comentarios: Formulario para educadores y mentores

### 11. Registro Zer (ID: 2759)
- Campos (10): perfil, next_step, monto, pais_cf7, ciudad_cf7, nombre, fecha_nacimiento, institucion, email, pais_otro
- Perfil: definido como "zer"
- Comentarios: Formulario para jóvenes con campo de fecha de nacimiento

### 12. Formulario de contacto 1 (ID: 2758)
- Campos (2): nombre, email
- Perfil: No definido
- Comentarios: Formulario mínimo de contacto

## Campos de Perfil Identificados

1. **institucion** - Formularios ID: 6468, 3070
2. **pais** - Formulario ID: 3074
3. **pioneer** - Formulario ID: 3073
4. **ciudad** - Formulario ID: 3072
5. **empresa** - Formulario ID: 3071
6. **mentor** - Formulario ID: 3069
7. **zer** - Formulario ID: 2759
8. **No definido** - Formularios ID: 6811, 6807, 2758

## Campos con Mayor Uso

1. **email** - Presente en 11 de 12 formularios
2. **nombre** - Presente en 9 de 12 formularios
3. **pais_cf7** - Presente en 9 de 12 formularios
4. **ciudad_cf7** - Presente en 9 de 12 formularios
5. **perfil** - Presente en 8 de 12 formularios
6. **next_step** - Presente en 8 de 12 formularios
7. **telefono** - Presente en 6 de 12 formularios
8. **pais_otro** - Presente en 6 de 12 formularios

## Inconsistencias Identificadas

1. **Duplicados**: "form pie de pagina" y "contacto general" son prácticamente idénticos
2. **Nomenclatura**: Se usan diferentes nombres para campos con la misma finalidad:
   - Nombres: "nombre", "ea_firstname", "ea_lastname", "contact_name", "org_name"
   - Campos institucionales: "institucion", "org_name", "company", "entity"
3. **Perfil**: No está definido en todos los formularios
4. **Campos ocultos**: Muchos formularios usan campos ocultos con diferentes propósitos

## Recomendaciones de Acción Prioritarias

1. **Unificar formularios duplicados**: "form pie de pagina" y "contacto general"
2. **Estandarizar campos de nombre**: Implementar first_name y last_name en todos los formularios
3. **Agregar perfil a formularios que no lo tengan**: Especialmente los dos formularios de contacto general
4. **Crear mapeo con columnas de Monday.com**: Para facilitar la integración y el Lead Scoring
5. **Implementar campos para Lead Scoring**: Asegurar que todos los formularios capturen suficiente información para el scoring