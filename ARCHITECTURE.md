
# Arquitectura – Granada Luxury Suites

## 🧠 Filosofía

- WordPress como CMS
- ACF como motor de contenido
- PHP templates como capa de render

---

## 📁 Estructura clave

### `/acf-json/`
- Export automático de ACF
- Fuente de verdad de campos
- Versionado en Git

---

### `/css/`
- Todos los estilos del proyecto
- Ejemplos:
  - `gls-components.css`
  - `page-home.css`
  - `archive-apartamentos.css`

---

### `/inc/`
Funciones auxiliares:
- `acf-json.php` → configuración ACF JSON
- `gls-icnea.php` → lógica integración ICNEA
- (futuro) `enqueues.php`

---

### `/template-parts/`
Componentes reutilizables:
- hero
- cards
- bloques ACF
- secciones

---

### `/bloques/`
Templates de bloques ACF:
- cada bloque = 1 archivo PHP

---

## 🧩 ACF

### Tipos usados
- Field Groups
- Flexible Content
- Options Page
- Blocks

### Flujo
1. Crear/editar campo en WP
2. Guardar → se exporta a `/acf-json`
3. Commit a Git

---

## 🏠 Home

- `page-home-nueva.php` → nueva arquitectura modular
- Basada en:
  - ACF flexible
  - bloques reutilizables
  - Litepicker (buscador)

---

## 🏢 CPTs

### apartamentos
- CPT principal
- tiene archive + templates custom

### alquiler-temporada
- similar a apartamentos

### experiencias
- contenido adicional

---

## 🔌 Integraciones

### ICNEA
- disponibilidad
- helpers en `inc/gls-icnea.php`

### Litepicker
- calendario en home
- cargado solo en `page-home-nueva.php`

---

## ⚠️ Decisiones importantes

- No usar Gutenberg nativo como constructor
- No usar Elementor como base estructural
- ACF manda
