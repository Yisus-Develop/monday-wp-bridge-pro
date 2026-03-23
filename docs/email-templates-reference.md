# PLANTILLAS DE EMAIL MULTILINGÜES - MARS CHALLENGE CRM INTEGRATION 2026

## RESUMEN GENERAL

**Sistema de Plantillas**: Completo  
**Idiomas Disponibles**: 4 (es, pt, en, fr)  
**Tipos de Leads**: 3 (HOT, WARM, COLD)  
**Total de Plantillas**: 12 (4 idiomas × 3 tipos de leads)

---

## DETALLE DE PLANTILLAS

### 1. PLANTILLAS PARA HOT LEADS

#### Español
- **Asunto**: ¡Gracias por tu interés en el Mars Challenge!
- **Cuerpo**:
```
Hola {name},

¡Gracias por tu interés en el Mars Challenge! Tu perfil ha sido clasificado como prioritario (HOT Lead).

Estamos emocionados de saber que estás interesado en ser parte de esta revolución educativa. Pronto nos pondremos en contacto contigo.

Mientras tanto, te invitamos a:
- Visitar nuestro sitio web: {website_url}
- Conocer más sobre el proyecto: {project_url}

Saludos cordiales,
El equipo del Mars Challenge
```

#### Portugués
- **Asunto**: Obrigado pelo seu interesse no Mars Challenge!
- **Cuerpo**:
```
Olá {name},

Obrigado pelo seu interesse no Mars Challenge! Seu perfil foi classificado como prioritário (HOT Lead).

Estamos animados em saber que você está interessado em fazer parte desta revolução educacional. Em breve entraremos em contato.

Enquanto isso, convidamos você a:
- Visitar nosso site: {website_url}
- Conhecer mais sobre o projeto: {project_url}

Atenciosamente,
Equipe do Mars Challenge
```

#### Inglés
- **Asunto**: Thank you for your interest in the Mars Challenge!
- **Cuerpo**:
```
Hi {name},

Thank you for your interest in the Mars Challenge! Your profile has been classified as priority (HOT Lead).

We're excited to know you're interested in being part of this educational revolution. We'll be in touch soon.

In the meantime, we invite you to:
- Visit our website: {website_url}
- Learn more about the project: {project_url}

Best regards,
The Mars Challenge Team
```

#### Francés
- **Asunto**: Merci pour votre intérêt dans le Mars Challenge !
- **Cuerpo**:
```
Bonjour {name},

Merci pour votre intérêt dans le Mars Challenge ! Votre profil a été classé comme prioritaire (HOT Lead).

Nous sommes ravis d'apprendre que vous souhaitez participer à cette révolution éducative. Nous vous contacterons bientôt.

En attendant, nous vous invitons à :
- Visiter notre site web : {website_url}
- En savoir plus sur le projet : {project_url}

Cordialement,
L'équipe du Mars Challenge
```

---

### 2. PLANTILLAS PARA WARM LEADS

#### Español
- **Asunto**: Bienvenido al Mars Challenge
- **Cuerpo**:
```
Hola {name},

Gracias por tu interés en el Mars Challenge. Hemos registrado tu información y estás clasificado como un lead de interés (WARM Lead).

Mantente atento a nuestras comunicaciones donde te informaremos sobre las novedades del proyecto.

Si tienes alguna pregunta, no dudes en contactarnos.

Saludos cordiales,
El equipo del Mars Challenge
```

#### Portugués
- **Asunto**: Bem-vindo ao Mars Challenge
- **Cuerpo**:
```
Olá {name},

Obrigado pelo seu interesse no Mars Challenge. Registramos sua informação e você está classificado como um lead de interesse (WARM Lead).

Fique atento às nossas comunicações onde informaremos as novidades do projeto.

Se tiver alguma dúvida, não hesite em nos contactar.

Atenciosamente,
Equipe do Mars Challenge
```

#### Inglés
- **Asunto**: Welcome to the Mars Challenge
- **Cuerpo**:
```
Hi {name},

Thank you for your interest in the Mars Challenge. We've registered your information and you're classified as an interest lead (WARM Lead).

Stay tuned to our communications where we'll inform you about project updates.

If you have any questions, please don't hesitate to contact us.

Best regards,
The Mars Challenge Team
```

#### Francés
- **Asunto**: Bienvenue au Mars Challenge
- **Cuerpo**:
```
Bonjour {name},

Merci pour votre intérêt dans le Mars Challenge. Nous avons enregistré vos informations et vous êtes classé comme lead d'intérêt (WARM Lead).

Restez à l'écoute de nos communications où nous vous informerons des mises à jour du projet.

Si vous avez des questions, n'hésitez pas à nous contacter.

Cordialement,
L'équipe du Mars Challenge
```

---

### 3. PLANTILLAS PARA COLD LEADS

#### Español
- **Asunto**: Mars Challenge - Confirmación de registro
- **Cuerpo**:
```
Hola {name},

Hemos recibido tu información y te agradecemos tu interés en el Mars Challenge.

Mantendremos tus datos registrados y te contactaremos en caso de nuevas oportunidades relacionadas.

Te invitamos a seguir nuestras redes sociales para mantenerte informado.

Saludos cordiales,
El equipo del Mars Challenge
```

#### Portugués
- **Asunto**: Mars Challenge - Confirmação de registro
- **Cuerpo**:
```
Olá {name},

Recebemos sua informação e agradecemos seu interesse no Mars Challenge.

Manteremos seus dados registrados e entraremos em contato em caso de novas oportunidades relacionadas.

Convidamos você a seguir nossas redes sociais para se manter informado.

Atenciosamente,
Equipe do Mars Challenge
```

#### Inglés
- **Asunto**: Mars Challenge - Registration Confirmation
- **Cuerpo**:
```
Hi {name},

We've received your information and thank you for your interest in the Mars Challenge.

We'll keep your data registered and contact you in case of related opportunities.

We invite you to follow our social networks to stay informed.

Best regards,
The Mars Challenge Team
```

#### Francés
- **Asunto**: Mars Challenge - Confirmation d'inscription
- **Cuerpo**:
```
Bonjour {name},

Nous avons reçu vos informations et vous remercions pour votre intérêt dans le Mars Challenge.

Nous conserverons vos données enregistrées et vous contacterons en cas d'opportunités liées.

Nous vous invitons à suivre nos réseaux sociaux pour rester informé.

Cordialement,
L'équipe du Mars Challenge
```

---

## ARCHIVOS RELACIONADOS

1. **`multilingual-email-templates.php`** - Sistema completo de plantillas
2. **`email-template-integration.php`** - Integración con webhook handler
3. **Clase `MultilingualEmailTemplates`** - Sistema de gestión de plantillas

## CARACTERÍSTICAS DEL SISTEMA

- ✅ **Sistema de Fallback**: Si no existe una plantilla en el idioma especificado, usa español como fallback
- ✅ **Placeholders Dinámicos**: `{name}`, `{website_url}`, `{project_url}`
- ✅ **Clasificación Automática**: Según el tipo de lead (HOT/WARM/COLD)
- ✅ **Detección de Idioma**: Basada en la columna de idioma de Monday
- ✅ **Integración Ready**: Listo para integrarse con el webhook handler existente

## EJEMPLO DE USO

```php
$template = MultilingualEmailTemplates::getTemplate('HOT', 'es');
// Devuelve: ['subject' => 'Asunto...', 'body' => 'Cuerpo...']
```