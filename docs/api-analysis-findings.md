# Análisis Completo de la API de Monday.com y Estado Real del Sistema

## Resumen Ejecutivo

Después de una auditoría completa del workspace y un análisis profundo de la documentación de la API de Monday.com, se ha identificado la causa raíz de los problemas detectados en el sistema de integración.

## Hallazgos Clave de la API

### 1. No Existe la Mutación `update_item`
- **Error encontrado**: Nuestro script anterior intentaba usar una mutación `update_item` que **no existe** en la API de Monday.com
- **Solución correcta**: Usar `change_column_value` para actualizar valores de columnas individuales
- **Para múltiples actualizaciones**: Agrupar múltiples operaciones `change_column_value` en una sola solicitud GraphQL

### 2. Gestión de Columnas de Estado (Status)
- **Creación**: Se pueden crear columnas de tipo status con etiquetas específicas usando `create_status_column`
- **Actualización de etiquetas**: Se puede modificar el conjunto completo de etiquetas usando `update_status_column`
- **Importante**: Las etiquetas se gestionan como un conjunto completo, no individualmente
- **Asignación a ítems**: Usar `change_column_value` con el índice o texto de la etiqueta

### 3. Operaciones CRUD Completas
- **Tableros**: CRUD completo (create_board, boards query, update_board, delete_board)
- **Ítems**: CRUD completo (create_item, items query, change_column_value/move_item_to_group/etc., delete_item)
- **Columnas**: CRUD completo (create_column, columns query, update_column, delete_column)
- **Grupos**: CRUD completo (create_group, groups query, update_group, delete_group)

## Estado Real del Sistema vs. Expectativa

### Lo que Encontramos en el Tablero Leads (ID: 18392144864)

| Columna | ID Real | Estado Actual | Debería Ser | Acción Requerida |
|---------|---------|---------------|--------------|------------------|
| Clasificación | `color_mkypv3rg` | "En curso", "Listo", "Detenido" | "HOT", "WARM", "COLD" | ✅ Actualizar etiquetas con `update_status_column` |
| Rol Detectado | `color_mkyng649` | "En curso", "Listo", "Detenido" | "Mission Partner", "Rector/Director", etc. | ✅ Actualizar etiquetas con `update_status_column` |
| Tipo de Lead | `dropdown_mkyp8q98` y `dropdown_mkypgz6f` | Duplicado | "Universidad", "Empresa", etc. | ✅ Definir y actualizar una columna principal |
| Canal de Origen | `dropdown_mkypf16c` y `dropdown_mkypbsmj` | Duplicado | "Website", "Mission Partner", etc. | ✅ Definir y actualizar una columna principal |
| Idioma | `dropdown_mkyps472` y `dropdown_mkypzbbh` | Duplicado | "Español", "Portugués", "Inglés" | ✅ Definir y actualizar una columna principal |

## Recomendaciones de Acción Inmediata

### 1. Actualizar Etiquetas de Clasificación
```graphql
mutation {
  update_status_column(
    board_id: 18392144864
    id: "color_mkypv3rg"
    settings: {
      labels: [
        { label: "HOT", color: "red", index: 1 },
        { label: "WARM", color: "yellow", index: 2 },
        { label: "COLD", color: "blue", index: 3 }
      ]
    }
  ) {
    id
  }
}
```

### 2. Actualizar Etiquetas de Rol Detectado
```graphql
mutation {
  update_status_column(
    board_id: 18392144864
    id: "color_mkyng649"
    settings: {
      labels: [
        { label: "Mission Partner", color: "purple", index: 1 },
        { label: "Rector/Director", color: "green", index: 2 },
        { label: "Alcalde/Gobierno", color: "orange", index: 3 },
        { label: "Corporate", color: "sky", index: 4 },
        { label: "Maestro/Mentor", color: "pink", index: 5 },
        { label: "Joven", color: "grass_green", index: 6 }
      ]
    }
  ) {
    id
  }
}
```

### 3. Arreglar el Webhook Handler
- **Reemplazar** cualquier intento de usar `update_item` con operaciones `change_column_value`
- **Verificar** que los IDs de columnas en el webhook coincidan con los reales del sistema
- **Actualizar** la lógica para manejar correctamente las nuevas etiquetas

## Conclusión

El sistema puede crear ítems en Monday.com pero tiene los siguientes problemas estructurales:

1. **Etiquetas incorrectas** en las columnas de clasificación
2. **IDs de columnas posiblemente desactualizados** en el webhook
3. **Fallas de actualización** debido al uso de una mutación inexistente (`update_item`)
4. **Duplicación de columnas** para Tipo de Lead, Canal de Origen e Idioma

Con las acciones correctivas recomendadas, el sistema podrá funcionar completamente según lo planeado originalmente.