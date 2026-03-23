# Estrategia de Reutilización: Infraestructura Existente vs Blueprint

**Estado Workspace**: Contiene 16 tableros (Plantilla CRM Estándar de Monday + Lead Validation).
**Objetivo**: Mapear lo existente al diseño "Mars Challenge Ecosystem" para NO crear desde cero innecesariamente.

## 1. Mapeo de Tableros (Blueprint Alignment)

| Rol en Blueprint (Mars Challenge) | Tablero Existente (Candidato) | Acción Recomendada |
| :--- | :--- | :--- |
| **Capa 1: Lead Intake** (Entrada) | `Leads` (ID: 18392144864) | **MODIFICAR**. Usar este como "Master Intake". Agregar columnas de Scoring y Routing. |
| **Capa 2: Pipelines** (Segmentos) | `Acuerdos` (ID: 18392144863) | **CLONAR/DIVIDIR**. "Acuerdos" es un pipeline genérico. Necesitamos dividirlo en 4 Vistas o Tableros: Universidades, Escuelas, Ciudades, Corporates. |
| **Capa 3: Clientes/Cierre** | `Cuentas` (ID: 18392144865) | **REUTILIZAR**. Para "Corporate Partners" y "Clientes Activos". |
| **Base de Datos Contactos** | `Contactos` (ID: 18392144862) | **MANTENER**. Como repositorio central de personas (vinculado a Cuentas/Acuerdos). |
| **Validación Técnica** | `Lead Validation` (ID: 18392205833) | **MANTENER**. Como paso previo invisible o "Cuarentena" para emails dudosos. |

---

## 2. Análisis Detallado

### A. El Tablero `Leads` (Candidato a Master Intake)

Es probable que este tablero ya tenga columnas para "Estado", "Responsable", etc.

* **Ventaja**: Ya está conectado con "Contactos" y "Cuentas" en la lógica nativa del CRM de Monday.
* **Faltante**: Seguramente le falta nuestro "Lead Score (0-30)" y la "Clasificación Mars" (Rector, Mission Partner, etc.).
* **Plan**:
    1. Inspeccionar `Leads` para ver sus columnas.
    2. Agregarle SOLO lo que falta (Score, Clasificación).
    3. Apuntar el Webhook de WordPress AQUÍ en lugar de "Lead Validation".

### B. El Tablero `Acuerdos` (Deals)

En el Blueprint del Mars Challenge, tenemos pipelines separados por *Tipo de Institución*. El CRM estándar usa un solo "Pipeline de Negocios" (`Acuerdos`).

* **Opción 1 (Simple)**: Usar `Acuerdos` para todo y filtrar por una columna "Tipo de Institución" (Escuela, Uni, Ciudad).
* **Opción 2 (Fiel al Blueprint)**: Duplicar `Acuerdos` en 4 tableros separados.

### C. `Lead Validation` (El que ya conectamos)

No lo borremos. Funciona perfecto como "Pre-Filtro".

* *Flujo Propuesto*: WordPress -> Lead Validation (PHP Script) -> Si Score > 0 -> Crear Item en `Leads` (Master Intake).
* *Beneficio*: No ensucias tu CRM principal con basura. Solo pasan los leads con score.

---

## 3. Recomendación Final

**"Evolución, no Revolución"**

1. **NO borrar nada.** La estructura CRM de Monday es sólida.
2. **Usar `Leads` como destino final** de nuestra integración PHP.
3. **Mantener `Lead Validation`** como "Zona de Aterrizaje Técnica" (Landing Zone). El script PHP escribe ahí, y una **Automatización de Monday** (o el mismo PHP) mueve los buenos a `Leads`.

¿Te hace sentido este flujo híbrido?
**WP -> PHP -> Lead Validation (Técnico) -> (Si es bueno) -> Tablero `Leads` (CRM Comercial)**
