# Granada Luxury Suites – Child Theme

Tema hijo de `identoFramework`.

## 🧱 Stack
- WordPress + ACF Pro
- Child theme: `granadaluxurysuites`
- Parent theme: `identofmk`
- Uso intensivo de ACF (Flexible Content + Blocks)

---

## ⚠️ Reglas del proyecto

### 1. CSS
- ❌ NO editar `style.css`
- ✅ Usar `/css/` (ej: `gls-components.css`, `page-home.css`, etc.)
- ❌ No meter estilos inline ni en templates

---

### 2. ACF (MUY IMPORTANTE)
- ACF se versiona en `/acf-json/`
- ❌ NO crear campos “a mano” sin guardar cambios
- ✅ Siempre guardar grupo ACF tras editar

Después de editar ACF:
```bash
git add acf-json
git commit -m "Update ACF fields"
git push
3. Templates

Usar template-parts/ para componentes reutilizables

No duplicar lógica

Mantener separación clara entre:

estructura (PHP)

contenido (ACF)

estilos (CSS)

4. functions.php

Mantener limpio

No meter lógica pesada

Usar /inc/ para modularizar (cuando aplique)

5. Home

page-home-nueva.php = futura home

Puede convivir con la actual mientras se construye

🚀 Flujo de trabajo

Cambios en local (LocalWP)

Commit a GitHub

Deploy/replicación a hosting

📌 Notas clave

Este proyecto depende fuertemente de ACF

El frontend está desacoplado de WP editor clásico

Muchas vistas son dinámicas vía Flexible Content
