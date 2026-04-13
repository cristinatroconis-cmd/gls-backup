# Arquitectura – Granada Luxury Suites

## Filosofía
- WordPress como CMS
- ACF como motor de contenido
- PHP templates como capa de render
- ICNEA como sistema externo de disponibilidad
- WordPress controla la experiencia de usuario; ICNEA aporta datos y reserva final

---

## Estructura clave

### ACF JSON
- Export automático de ACF
- **Fuente de verdad de campos** — debe versionarse siempre
- Commit inmediato tras crear o editar cualquier Field Group

### `/css/`
- Todos los estilos del proyecto
- No usar `style.css` para desarrollo de componentes
- Cada componente reutilizable tiene su propio archivo CSS (nunca meter estilos de componente en `page-home.css` ni en `style.css`)
- Los tokens de diseño (`:root`) van **únicamente** en `gls-root.css`

### `/inc/`
Funciones auxiliares e integraciones:
- `acf-json.php` → configuración ACF JSON
- `gls-icnea.php` → lógica integración ICNEA
- `gls-migrate-icnea.php` → migración temporal de `icnea_id` (debe eliminarse tras uso)
- `enqueues.php` → pendiente de modularización estable

### `/template-parts/`
Componentes reutilizables:
- heroes
- cards
- bloques ACF
- secciones compartidas

Cada componente tiene su propio CSS en `/css/` y su propia función de enqueue condicional en `inc/enqueues.php`. No reutilizar `page-home.css` fuera de Home.

### `/bloques/`
Templates de bloques ACF:
- cada bloque en su archivo PHP propio

---

## ACF

### Tipos usados
- Field Groups
- Flexible Content
- Options Page
- Blocks

### Flujo
1. Crear/editar campo en WP
2. Guardar
3. Export a `/acf-json`
4. Commit a Git

### Campo técnico nuevo
#### `icnea_id`
- Tipo: Number
- Uso: enlazar cada apartamento WordPress con su unidad real en ICNEA
- No se expone en frontend
- Prioridad sobre el parser de URL

---

## Home y buscador

### Home nueva
- `page-home-nueva.php` = home modular nueva
- Basada en ACF flexible + componentes reutilizables

### Litepicker
- Se mantiene como capa UX del buscador
- El frontend envía ahora:
  - `arrival`
  - `departure`
  - `guests`

### Compatibilidad backward
La capa de request parsing acepta:
- `arrival / departure`
- `checkin / checkout`

Esto se centraliza en:
- `gls_icnea_get_query_var()`
- `gls_icnea_get_search_args_from_request()`

ubicadas en `inc/gls-icnea.php`

---

## CPTs

### `apartamentos`
- CPT principal
- Archive custom
- Integración de disponibilidad con ICNEA

### `alquiler-temporada`
- Similar a apartamentos
- A revisar en siguientes fases si comparte lógica

### `experiencias`
- Contenido adicional

---

## Integración ICNEA

### Flujo actual
1. Home recoge fechas y huéspedes
2. Redirect a `/apartamentos/`
3. `archive-apartamentos.php` obtiene args ya normalizados
4. `gls_icnea_get_available_post_ids()` consulta disponibilidad
5. Cada apartamento usa preferentemente `icnea_id`
6. Fallback a extracción de ID desde `boton_de_reserva`
7. CTA final enlaza con ICNEA conservando fechas y huéspedes

### Decisiones tomadas
- No usar el buscador visual nativo de ICNEA como frontend principal
- Mantener Litepicker + archive propio por control UX, diseño y SEO
- No depender de la URL de reserva como fuente única del ID ICNEA

### Estado de auditoría
#### Completado
- Fase 1: unificación de parámetros y compatibilidad
- Fase 2: `icnea_id` + fallback + migración temporal

#### Pendiente
- Fase 3: endurecer fallback cuando ICNEA falle
- Fase 4: mejorar rendimiento y cache del mapping
- Fase 5: observabilidad y logging

---

## Higiene Git – artefactos locales

### Política de sandbox artifacts
El repositorio versiona **únicamente el código del theme**. Los artefactos generados en entornos locales o de sandbox quedan explícitamente excluidos:

| Artefacto | Motivo de exclusión |
|-----------|---------------------|
| `app/sql/*.sql` | Dumps de base de datos local; pueden ser enormes y contienen datos de instancia |
| `*.sql` | Cualquier dump SQL en cualquier nivel del árbol |
| `app/public/wp-content/uploads/` | Media de producción/local; no pertenece al theme |
| `*.log` | Logs de PHP, servidor o WP; datos efímeros |
| `node_modules/`, `vendor/` | Dependencias regenerables |

Estas reglas se gestionan en `.gitignore` en la raíz del repo.

### Fuente de verdad
- **Código del theme** (`/css/`, `/js/`, `/inc/`, templates PHP): Git.
- **Estructura de contenido ACF**: `/acf-json/` versionado en Git.
- **Base de datos local**: nunca versionada. Cada entorno gestiona la suya.
- **Media (uploads)**: gestionada fuera del repo (servidor, servicio de almacenamiento o backup independiente).

### Qué hacer si un push falla por archivo grande
1. Identificar el archivo: `git show --stat HEAD`
2. Revertir el commit: `git reset --soft HEAD~1` (mantiene los cambios en staging) o `git reset HEAD~1` (mantiene los cambios en working directory sin staging)
3. Añadir la regla correspondiente a `.gitignore`
4. Re-hacer el commit sin el archivo problemático
5. Verificar con `git status` antes de volver a hacer push

---

## Componentes de sección

### Patrón GLS para secciones reutilizables

Cada sección sigue esta estructura:

| Pieza | Ubicación | Notas |
|-------|-----------|-------|
| Template part | `template-parts/gls-section-<nombre>.php` | Lógica + render |
| CSS | `css/gls-section-<nombre>.css` | Solo estilos de esa sección |
| Enqueue | `inc/enqueues.php` | Condicional por template o slug |
| ACF Field Group | `acf-json/group_gls_<nombre>*.json` | Adjunto por Page Template, no globalmente |

Reglas:
- El CSS va **siempre** en `/css/`, nunca en `style.css`.
- No reutilizar `page-home.css` para componentes fuera de Home.
- Cada componente tiene su propio enqueue condicional (`is_page_template()`).
- El Field Group de ACF se adjunta por **Page Template** (no globalmente).
- `/acf-json/` es fuente de verdad; hacer commit tras cada cambio de campo.

---

### `gls-section-stack-cta`

**Descripción:** Sección tipo "stack header" — H2 a la izquierda + 3 botones CTA secundarios a la derecha.  
Inspiración conceptual: patrón `section-content_stack` de Elementor, implementado en modo GLS (ACF + PHP + CSS propio).

**Archivos:**
- `template-parts/gls-section-stack-cta.php`
- `css/gls-section-stack-cta.css`
- `acf-json/group_gls_stack_cta01.json`
- Enqueue: `gls_enqueue_section_stack_cta_css()` en `inc/enqueues.php`

**ACF Fields (Field Group: "GLS – Stack CTA Section (Luxury Demo)"):**

| Campo | Tipo | Fallback |
|-------|------|---------|
| `gls_stack_title` | Textarea | "Descubre Granada Luxury Suites" |
| `gls_stack_cta_1` | Link | `{ url: '#', title: 'turístico' }` |
| `gls_stack_cta_2` | Link | `{ url: '#', title: 'empresas' }` |
| `gls_stack_cta_3` | Link | `{ url: '#', title: 'propietarios' }` |

- Los CTAs usan estilo secundario `.btn-fix-outline` (definido en `gls-root.css`).
- Si un campo Link está vacío, el fallback renderiza `href="#"` para que la sección no quede rota.
- El Field Group se adjunta por Page Template: `page-luxury-section-demo.php`.

**Enqueue condicional:**
```
is_page_template('page-luxury-section-demo.php') || is_page_template('page-home-nueva.php')
```

**Demo / QA:** Usar la página con template `Luxury Section Demo` (`page-luxury-section-demo.php`).

---

### `page-propietarios.php`

**Template Name:** `Propietarios`  
Cargado también por jerarquía WP para el slug `propietarios`.

**Estructura de secciones:**
1. `gls-page-hero` — cabecera de página (ACF)
2. `gls-section-intro` — intro editorial (ACF)
3. `gls-section-split` — layout image-right, prefix `gls_split` (ACF)
4. `gls-section-split` — layout image-left, prefix `gls_split_b` (ACF)
5. Sección contacto *(markup legacy Bootstrap)* — ACF + GF shortcode
6. `the_content()` — contenido del editor

**Decisión: sección contacto con markup legacy**  
La sección contacto usa Bootstrap grid heredada en lugar del template-part `gls-section-lead-contact`, para preservar el `id` de la sección (`contacto-home-block_183f14bd8cd37e7c607d2bd9cf0118a6`), que es referenciado por CSS, JS y herramientas de tracking. Cambiar el markup rompería esos vínculos.

**Campos ACF del contacto** (dos grupos por compatibilidad):
- Preferentes: `gls_contact_title`, `gls_contact_text`, `gls_contact_form_shortcode`, `gls_contact_media_type`, `gls_contact_video_mp4` (Field Group `group_gls_lead_contact_01`)
- Fallback legacy: `titulo`, `subtitulo`, `formulario`, `video` (`group_602a0f8454873`)

---

### Patrón de publicación segura: `Propietarios V2`

Objetivo: permitir edición de contenido por cliente sin tocar la página pública existente.

#### Flujo recomendado

1. Mantener la página pública actual (`/propietarios/`) sin cambios de estructura.
2. Crear página nueva en borrador con slug alterno (`/propietarios-nueva/`).
3. Asignar plantilla nueva (`page-propietarios-v2.php`).
4. Habilitar los mismos enqueues CSS de la versión pública también para V2.
5. Ajustar location rules ACF para que muestren campos en V2 por template (no por ID fijo).
6. Editar y validar contenido en borrador.
7. Hacer switch controlado de slug cuando se apruebe publicación.

#### Regla de bajo riesgo para producción

- Evitar reemplazos completos de `functions.php` cuando no sea necesario.
- Preferir cambios mínimos de alcance local:
  - condiciones de enqueue
  - templates específicos
  - field groups ACF necesarios

#### Checklist de switch a `/propietarios/`

1. Backup previo de `functions.php` y de la página a reemplazar.
2. Liberar slug `propietarios` en la página antigua.
3. Cambiar slug de la nueva página a `propietarios`.
4. Confirmar plantilla activa correcta en la nueva página.
5. Purgar cachés (plugin + navegador).
6. Validar frontend, formulario y enlaces internos.

---

## Decisiones importantes
- No usar Gutenberg nativo como constructor principal
- No usar Elementor como base estructural
- ACF manda
- No romper tema padre
- Mejorar sobre base existente, no rehacer sin necesidad
- No versionar dumps SQL ni artefactos locales (ver sección Higiene Git)
