# AUTOMATIZACIONES DE EMAIL MULTILINGÜES POR PERFIL EN MONDAY.COM
## Mars Challenge CRM Integration 2026

### CONFIGURACIONES DE AUTOMATIZACIONES

#### PERFIL: "institucion" (Universidad/Escuela)

**1. institucion + Español (HOT Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Rector/Director"
Y "Idioma" cambia a "Español"
Y "Clasificación" cambia a "HOT"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Oportunidad exclusiva para instituciones educativas - Mars Challenge"
  - Cuerpo:
    "Estimado Rector/Director {{Name}},
    
    ¡Gracias por su interés en el Mars Challenge! Su perfil institucional ha sido clasificado como prioritario.
    
    Estamos emocionados de saber que una institución educativa como la suya está interesada en esta revolución educativa. Pronto nos pondremos en contacto con usted para explorar oportunidades de colaboración.
    
    Mientras tanto, le invitamos a:
    - Visitar nuestro sitio web: https://mars-challenge.org
    - Conocer más sobre el proyecto: https://mars-challenge.org/info
    
    Saludos cordiales,
    El equipo del Mars Challenge"
```

**2. institucion + Español (WARM Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Rector/Director"
Y "Idioma" cambia a "Español"  
Y "Clasificación" cambia a "WARM"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Bienvenido al Mars Challenge - Oportunidades para instituciones"
  - Cuerpo:
    "Estimado Rector/Director {{Name}},
    
    Gracias por su interés en el Mars Challenge. Hemos registrado su información y estamos interesados en explorar oportunidades con su institución.
    
    Manténgase atento a nuestras comunicaciones donde le informaremos sobre novedades relevantes para instituciones educativas.
    
    Si tiene alguna pregunta, no dude en contactarnos.
    
    Saludos cordiales,
    El equipo del Mars Challenge"
```

**3. institucion + Español (COLD Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Rector/Director"  
Y "Idioma" cambia a "Español"
Y "Clasificación" cambia a "COLD"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Mars Challenge - Confirmación de registro institucional"
  - Cuerpo:
    "Estimado Rector/Director {{Name}},
    
    Hemos recibido su información y agradecemos su interés en el Mars Challenge.
    
    Mantendremos registrada la información de su institución y le contactaremos en caso de oportunidades relacionadas.
    
    Le invitamos a seguir nuestras redes sociales para mantenerse informado.
    
    Saludos cordiales,
    El equipo del Mars Challenge"
```

**4. institucion + Portugués (HOT Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Rector/Director"
Y "Idioma" cambia a "Portugués"
Y "Clasificación" cambia a "HOT"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Oportunidade exclusiva para instituições educacionais - Mars Challenge"
  - Cuerpo:
    "Caro Reitor/Diretor {{Name}},
    
    Obrigado pelo seu interesse no Mars Challenge! Seu perfil institucional foi classificado como prioritário.
    
    Estamos animados em saber que uma instituição educacional como a sua está interessada nesta revolução educacional. Em breve entraremos em contato para explorar oportunidades de colaboração.
    
    Enquanto isso, convidamos você a:
    - Visitar nosso site: https://mars-challenge.org
    - Conhecer mais sobre o projeto: https://mars-challenge.org/info
    
    Atenciosamente,
    Equipe do Mars Challenge"
```

**5. institucion + Inglés (HOT Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Rector/Director"
Y "Idioma" cambia a "Inglés"
Y "Clasificación" cambia a "HOT"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Exclusive opportunity for educational institutions - Mars Challenge"
  - Cuerpo:
    "Dear Principal/Director {{Name}},
    
    Thank you for your interest in the Mars Challenge! Your institutional profile has been classified as priority.
    
    We're excited to know that an educational institution like yours is interested in this educational revolution. We'll be in touch soon to explore collaboration opportunities.
    
    In the meantime, we invite you to:
    - Visit our website: https://mars-challenge.org
    - Learn more about the project: https://mars-challenge.org/info
    
    Best regards,
    The Mars Challenge Team"
```

**6. institucion + Francés (HOT Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Rector/Director"
Y "Idioma" cambia a "Francés"
Y "Clasificación" cambia a "HOT"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Opportunité exclusive pour les institutions éducatives - Mars Challenge"
  - Cuerpo:
    "Cher Recteur/Directeur {{Name}},
    
    Merci pour votre intérêt dans le Mars Challenge ! Votre profil institutionnel a été classé comme prioritaire.
    
    Nous sommes ravis d'apprendre qu'une institution éducative comme la vôtre souhaite participer à cette révolution éducative. Nous vous contacterons bientôt pour explorer les opportunités de collaboration.
    
    En attendant, nous vous invitons à :
    - Visiter notre site web : https://mars-challenge.org
    - En savoir plus sur le projet : https://mars-challenge.org/info
    
    Cordialement,
    L'équipe du Mars Challenge"
```

#### PERFIL: "mentor" (Maestro/Mentor)

**7. mentor + Español (HOT Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Maestro/Mentor"
Y "Idioma" cambia a "Español"
Y "Clasificación" cambia a "HOT"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Oportunidad para maestros y mentores - Mars Challenge"
  - Cuerpo:
    "Estimado/a {{Name}},
    
    ¡Gracias por su interés en el Mars Challenge! Su perfil como maestro/mentor ha sido clasificado como prioritario.
    
    Estamos emocionados de contar con educadores apasionados como usted en esta revolución educativa. Pronto nos pondremos en contacto para explorar su participación.
    
    Mientras tanto, le invitamos a:
    - Visitar nuestro sitio web: https://mars-challenge.org
    - Conocer más sobre el proyecto: https://mars-challenge.org/info
    
    Saludos cordiales,
    El equipo del Mars Challenge"
```

**8. mentor + Español (WARM Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Maestro/Mentor"
Y "Idioma" cambia a "Español"
Y "Clasificación" cambia a "WARM"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Bienvenido/a al Mars Challenge - Comunidad de educadores"
  - Cuerpo:
    "Estimado/a {{Name}},
    
    Gracias por su interés en el Mars Challenge. Hemos registrado su información y estamos interesados en su participación como educador/a.
    
    Manténgase atento a nuestras comunicaciones donde le informaremos sobre novedades relevantes para maestros y mentores.
    
    Si tiene alguna pregunta, no dude en contactarnos.
    
    Saludos cordiales,
    El equipo del Mars Challenge"
```

#### PERFIL: "pioneer" (Mission Partner)

**9. pioneer + Español (HOT Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Mission Partner"
Y "Idioma" cambia a "Español"
Y "Clasificación" cambia a "HOT"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Socio estratégico para la Misión Mars Challenge"
  - Cuerpo:
    "Estimado/a socio/a {{Name}},
    
    ¡Gracias por su interés en el Mars Challenge! Su perfil como Mission Partner ha sido clasificado como extremadamente prioritario.
    
    Estamos emocionados de explorar oportunidades estratégicas con socios como usted para esta revolución educativa. Pronto nos pondremos en contacto para discutir colaboraciones.
    
    Mientras tanto, le invitamos a:
    - Visitar nuestro sitio web: https://mars-challenge.org
    - Conocer más sobre el proyecto: https://mars-challenge.org/info
    
    Saludos cordiales,
    El equipo del Mars Challenge"
```

#### PERFIL: "zer" (Joven)

**10. zer + Español (HOT Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Joven"
Y "Idioma" cambia a "Español"
Y "Clasificación" cambia a "HOT"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "¡Te invitan al Mars Challenge - Revolución Educativa!"
  - Cuerpo:
    "¡Hola {{Name}}!
    
    ¡Gracias por tu interés en el Mars Challenge! Tu perfil como joven talento ha sido clasificado como prioritario.
    
    Estamos emocionados de saber que jóvenes como tú están interesados en ser parte de esta revolución educativa. Pronto nos pondremos en contacto contigo para explorar tu participación.
    
    Mientras tanto, te invitamos a:
    - Visitar nuestro sitio web: https://mars-challenge.org
    - Conocer más sobre el proyecto: https://mars-challenge.org/info
    
    ¡Saludos cordiales,
    El equipo del Mars Challenge!"
```

#### PERFIL: "empresa" (Corporate)

**11. empresa + Español (HOT Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Corporate"
Y "Idioma" cambia a "Español"
Y "Clasificación" cambia a "HOT"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Oportunidad de colaboración corporativa - Mars Challenge"
  - Cuerpo:
    "Estimado/a representante de {{Company}} - {{Name}},
    
    ¡Gracias por su interés en el Mars Challenge! Su perfil corporativo ha sido clasificado como prioritario.
    
    Estamos emocionados de explorar oportunidades de colaboración corporativa para esta revolución educativa. Pronto nos pondremos en contacto para discutir posibles alianzas.
    
    Mientras tanto, le invitamos a:
    - Visitar nuestro sitio web: https://mars-challenge.org
    - Conocer más sobre el proyecto: https://mars-challenge.org/info
    
    Saludos cordiales,
    El equipo del Mars Challenge"
```

#### PERFIL: "ciudad" (Alcalde/Gobierno)

**12. ciudad + Español (HOT Lead):**
```
CUANDO:
- El valor de la columna "Rol Detectado" cambia a "Alcalde/Gobierno"
Y "Idioma" cambia a "Español"
Y "Clasificación" cambia a "HOT"

HACER:
- Enviar email desde mi cuenta de correo
- Usar estos valores:
  - Para: {{Email}}
  - Asunto: "Oportunidad para gobiernos locales - Mars Challenge"
  - Cuerpo:
    "Estimado/a {{Name}},
    
    ¡Gracias por su interés en el Mars Challenge! Su perfil como representante gubernamental ha sido clasificado como prioritario.
    
    Estamos emocionados de explorar oportunidades de inclusión de comunidades locales en esta revolución educativa. Pronto nos pondremos en contacto para discutir colaboraciones.
    
    Mientras tanto, le invitamos a:
    - Visitar nuestro sitio web: https://mars-challenge.org
    - Conocer más sobre el proyecto: https://mars-challenge.org/info
    
    Saludos cordiales,
    El equipo del Mars Challenge"
```

### PASOS PARA CREAR ESTAS AUTOMATIZACIONES EN MONDAY

1. **Ve a tu tablero MC – Lead Master Intake**
2. **Clic en el menú de configuración del tablero (engranaje)**
3. **Selecciona "Automatization"**
4. **Crea una nueva automatización**
5. **Configura las condiciones como se describe arriba**
6. **Añade la acción: "Send email"**
7. **Completa los campos: destinatario, asunto y cuerpo**
8. **Repite para cada combinación de perfil, idioma y clasificación**

### RECOMENDACIÓN

Dado que hay múltiples perfiles y combinaciones, crearías las automatizaciones como se describe arriba, adaptando cada plantilla según:
- El **perfil** detectado (institucion, mentor, pioneer, zer, empresa, ciudad)
- El **idioma** seleccionado (español, portugués, inglés, francés)  
- La **clasificación** (HOT, WARM, COLD)

Esto te permitirá enviar mensajes personalizados directamente desde Monday.com según las condiciones que mencionaste: **idioma + perfil**.