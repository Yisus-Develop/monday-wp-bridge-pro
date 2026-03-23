# CONFIGURACIÓN DE PLANTILLAS DE EMAIL MULTILINGÜES EN MONDAY.COM
## Mars Challenge CRM Integration 2026

### INTRODUCCIÓN

Monday.com ofrece funcionalidades para gestionar emails y actividades dentro de la plataforma. Según la documentación, puedes:

1. **Añadir emails como actividades** directamente desde la página de un item
2. **Usar email templates** configurados en la sección de Configuración
3. **Configurar automatizaciones** que envíen emails automáticos

### IMPLEMENTACIÓN ACTUAL

Nuestro sistema actual (Mars Challenge CRM Integration 2026) implementa plantillas multilingües a través del webhook handler, que:

- Detecta el idioma del lead basado en la columna "language" o país
- Clasifica el lead como HOT/WARM/COLD
- Selecciona la plantilla correspondiente del sistema PHP
- Envía el email en el idioma apropiado

### CREACIÓN DE PLANTILLAS DIRECTAMENTE EN MONDAY.COM

#### 1. **Configurar Integración de Email**

Primero, configura la integración de email en tu cuenta de Monday.com:
- Ir a Admin Center > Integrations
- Conectar tu cuenta de Gmail o Outlook
- Configurar permisos para enviar emails

#### 2. **Configurar Email Templates en Monday.com**

Para crear plantillas que puedan usarse directamente en Monday:

1. Ve a la página de un item en tu tablero MC – Lead Master Intake
2. Haz clic en la sección de "Email and Activities"
3. Puedes crear emails directamente allí, o bien:
4. Crear automatizaciones que envíen emails basados en condiciones

#### 3. **Opción Recomendada: Automatizaciones por Clasificación e Idioma**

Monday.com permite crear automatizaciones que envían emails cuando se cumplen ciertas condiciones. Estas serían las configuraciones recomendadas:

##### Automatización para HOT Leads en Español:
```
CUANDO:
- El valor de la columna "Clasificación" cambia a "HOT"
Y "Idioma" es "Español"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - CC: (opcional)
  - Asunto: "¡Gracias por tu interés en el Mars Challenge!"
  - Cuerpo:
    "Hola {{Name}},

    ¡Gracias por tu interés en el Mars Challenge! Tu perfil ha sido clasificado como prioritario (HOT Lead).

    Estamos emocionados de saber que estás interesado en ser parte de esta revolución educativa. Pronto nos pondremos en contacto contigo.

    Mientras tanto, te invitamos a:
    - Visitar nuestro sitio web: https://mars-challenge.org
    - Conocer más sobre el proyecto: https://mars-challenge.org/info

    Saludos cordiales,
    El equipo del Mars Challenge"
```

##### Automatización para HOT Leads en Portugués:
```
CUANDO:
- El valor de la columna "Clasificación" cambia a "HOT"
Y "Idioma" es "Portugués"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Obrigado pelo seu interesse no Mars Challenge!"
  - Cuerpo:
    "Olá {{Name}},

    Obrigado pelo seu interesse no Mars Challenge! Seu perfil foi classificado como prioritário (HOT Lead).

    Estamos animados em saber que você está interessado em fazer parte desta revolução educacional. Em breve entraremos em contato.

    Enquanto isso, convidamos você a:
    - Visitar nosso site: https://mars-challenge.org
    - Conhecer mais sobre o projeto: https://mars-challenge.org/info

    Atenciosamente,
    Equipe do Mars Challenge"
```

##### Automatización para WARM Leads en Inglés:
```
CUANDO:
- El valor de la columna "Clasificación" cambia a "WARM"
Y "Idioma" es "Inglés"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Welcome to the Mars Challenge"
  - Cuerpo:
    "Hi {{Name}},

    Thank you for your interest in the Mars Challenge. We've registered your information and you're classified as an interest lead (WARM Lead).

    Stay tuned to our communications where we'll inform you about project updates.

    If you have any questions, please don't hesitate to contact us.

    Best regards,
    The Mars Challenge Team"
```

##### Automatización para COLD Leads en Francés:
```
CUANDO:
- El valor de la columna "Clasificación" cambia a "COLD"
Y "Idioma" es "Francés"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Mars Challenge - Confirmation d'inscription"
  - Cuerpo:
    "Bonjour {{Name}},

    Nous avons reçu vos informations et vous remercions pour votre intérêt dans le Mars Challenge.

    Nous conserverons vos données enregistrées et vous contacterons en cas d'opportunités liées.

    Nous vous invitons à suivre nos réseaux sociaux pour rester informé.

    Cordialement,
    L'équipe du Mars Challenge"
```

### PASOS PARA CREAR LAS AUTOMATIZACIONES EN MONDAY

1. Ve a tu tablero **MC – Lead Master Intake**
2. Clic en el menú de configuración del tablero (engranaje)
3. Selecciona "Automatization"
4. Crea una nueva automatización
5. Configura la condición: "When column value changes" → "Clasificación"
6. Configura la subcondición: "Changes to" → "HOT/WARM/COLD"
7. Añade otra condición: "When column value changes" → "Idioma"
8. Configura la subcondición: "Changes to" → "Español/Portugués/Inglés/Francés"
9. Añade la acción: "Send email"
10. Completa los campos: destinatario, asunto y cuerpo con los templates anteriores

### VENTAJAS DEL SISTEMA ACTUAL (WEBHOOK) VS AUTOMATIZACIONES MONDAY

**Sistema Actual (Webhook):**
- ✅ Más flexible y personalizable
- ✅ Procesamiento más complejo si se necesita
- ✅ Mayor control sobre el contenido y timing
- ❌ Requiere infraestructura externa

**Automatizaciones Monday:**
- ✅ Funciona completamente dentro de Monday
- ✅ No requiere infraestructura externa
- ✅ Fácil de configurar para usuarios no técnicos
- ❌ Menos flexibilidad en contenido complejo
- ❌ Requiere crear múltiples automatizaciones (12 en total para todas combinaciones)

### RECOMENDACIÓN

Para la implementación del Mars Challenge CRM Integration 2026, tienes dos opciones:

#### Opción 1: Sistema Actual (Recomendado)
- Mantener el webhook handler actual con las plantillas PHP multilingües
- Este sistema ya está funcionando y probado
- Más eficiente que crear 12 automatizaciones separadas

#### Opción 2: Automatizaciones Monday
- Si prefieres un sistema completamente dentro de Monday
- Requiere crear 12 automatizaciones diferentes (una para cada combinación)
- Más adecuado si no quieres depender de infraestructura externa

### CONCLUSIÓN

El sistema actual ya implementa completamente la funcionalidad de plantillas de email multilingües. La diferencia es que las plantillas se gestionan en el webhook handler externo en lugar de dentro de las automatizaciones nativas de Monday.com.

Tu sistema actual ya:
- ✅ Detecta idioma y clasificación
- ✅ Selecciona plantilla correspondiente
- ✅ Personaliza y envía email
- ✅ Lo hace en el idioma apropiado
- ✅ Mantiene todo integrado con Monday.com

Para ver las plantillas exactas que se usan, consulta el archivo `multilingual-email-templates.php` en este proyecto.