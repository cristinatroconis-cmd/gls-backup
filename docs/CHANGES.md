# Cambios – Granada Luxury Suites

## 2026-04

### 2026-04-13 — Flujo seguro Propietarios V2 (borrador en producción)

#### Hecho hoy

1. Se crea en WP Admin la nueva página en borrador:
  - Título: "Propietarios Nueva"
  - Slug: `propietarios-nueva`
  - Estado: `Borrador`
  - Plantilla: `Propietarios V2`
2. Se trabaja con una plantilla duplicada para no tocar la página pública existente:
  - `page-propietarios.php` (actual en producción)
  - `page-propietarios-v2.php` (nueva versión para edición)
3. Se añade soporte de estilos para V2 en condiciones de enqueue (objetivo: que V2 herede los estilos luxury/intro/contact igual que la plantilla anterior).
4. Se revisan reglas ACF para que los grupos aparezcan también al editar la V2 (evitar dependencia de un ID de página concreto).

#### Backup operativo

- Se deja copia de seguridad de `functions.php` con nombre:
  - `functions-antes-de-propietarios-nueva.php`
- Ruta de respaldo:
  - `Google Drive/Mi unidad/functions-antes-de-propietarios-nueva.php`

#### Siguiente paso para pasar de `/propietarios-nueva/` a `/propietarios/`

1. Validar en borrador que diseño, ACF, formularios y media estén correctos.
2. Congelar cambios de contenido durante la ventana de publicación (15-30 min).
3. En WP Admin:
  - Renombrar/guardar la página pública actual para liberar slug `propietarios`.
  - Cambiar slug de la nueva página de `propietarios-nueva` a `propietarios`.
4. Verificar que la nueva página mantiene plantilla `Propietarios V2`.
5. Revisar menús/enlaces internos que apunten al slug antiguo.
6. Purgar caché:
  - plugin de caché (WP Fastest Cache)
  - caché de navegador
7. QA post-publicación:
  - desktop + móvil
  - carga de CSS de secciones
  - envío de formulario
  - indexación SEO esperada

### 2026-04-06 — Página Propietarios + limpieza de ACF

#### Página Propietarios — nueva estructura con secciones GLS (PRs #15, #16, #17)

Se reconstruye `page-propietarios.php` para usar el sistema de secciones GLS.

**Estructura final del template:**
1. `gls-page-hero` — cabecera de página
2. `gls-section-intro` — intro editorial (ACF-driven)
3. `gls-section-split` (variant A, `layout: image-right`, prefix `gls_split`)
4. `gls-section-split` (variant B, `layout: image-left`, prefix `gls_split_b`)
5. Sección contacto legacy — Bootstrap grid + ACF + GF shortcode (ver decisión abajo)
6. `the_content()` — contenido del editor (si existe)

**Archivos modificados:**
- `page-propietarios.php`
- `template-parts/gls-section-lead-contact.php` — se corrige que el texto del botón usa `link['title']` de ACF (no texto hardcoded)
- `template-parts/gls-section-split.php` — limpieza menor
- `inc/enqueues.php` — CSS de secciones se carga condicionalmente para el template propietarios

**Decisión: sección contacto con markup legacy**
La sección contacto se implementa con markup Bootstrap heredado en lugar de `gls-section-lead-contact` template-part para preservar:
- El `id` de la sección (`contacto-home-block_183f14bd8cd37e7c607d2bd9cf0118a6`) que usan CSS, JS y tracking existentes
- Las clases y estructura Bootstrap que mantienen el formulario funcionando
- La lógica de ACF admite dos grupos de campos por compatibilidad con instancias existentes:
  - `gls_contact_*` (Field Group `group_gls_lead_contact_01`, adjunto al template propietarios)
  - `titulo` / `subtitulo` / `formulario` / `video` (grupo legacy como fallback)

---

#### ACF — mejoras en labels e instrucciones de editor

Se actualizan los Field Groups para mejorar la experiencia del editor. No hay cambios de estructura de datos.

**Archivos modificados:**
- `acf-json/group_6803gls_split01.json` — labels e instrucciones de campos split A
- `acf-json/group_6803gls_split02.json` — labels e instrucciones de campos split B
- `acf-json/group_gls_stack_cta01.json` — ajuste menor de labels
- `acf-json/group_intro_section_01.json` — labels e instrucciones de sección intro

---

#### ACF — nuevos campos en grupo Contacto

Se añaden campos al grupo ACF `group_602a0f8454873` (sección Contacto):
- `titulo` — texto del encabezado
- `subtitulo` — texto secundario / descripción
- `formulario` — relación al formulario GF
- `video` — URL del vídeo de fondo

Estos campos son el fallback legacy leído en `page-propietarios.php` cuando los campos `gls_contact_*` están vacíos.

---

### 2026-04-05 — Sección Stack CTA + reglas de arquitectura CSS/ACF

#### Nueva sección: Stack CTA

Se implementa la sección `gls-section-stack-cta`: cabecera horizontal con H2 a la izquierda y 3 botones CTA secundarios a la derecha.

**Archivos nuevos/modificados:**
- `template-parts/gls-section-stack-cta.php` — template part, render con ACF + fallbacks
- `css/gls-section-stack-cta.css` — estilos propios de la sección (responsive)
- `acf-json/group_gls_stack_cta01.json` — Field Group versionado
- `inc/enqueues.php` — función `gls_enqueue_section_stack_cta_css()` (enqueue condicional)
- `page-luxury-section-demo.php` — se añade la sección al template de demo (posición 5)

**Decisiones:**
- Tres CTAs (`gls_stack_cta_1/2/3`) tipo ACF Link con etiquetas "turístico", "empresas", "propietarios".
- Si el campo está vacío, fallback a `href="#"` para que la sección no quede rota en editor.
- Field Group adjunto por **Page Template** (`page-luxury-section-demo.php`), no globalmente.
- CSS cargado únicamente cuando el template activo es `page-luxury-section-demo.php` o `page-home-nueva.php`.
- Botones usan `.btn-fix-outline` (token global de `gls-root.css`); no se duplican estilos.

**Estado:** Cambios locales. Sin PR abierto. Próximo paso: validar en demo page y hacer commit.

---

#### Reglas reforzadas de arquitectura

- **CSS siempre en `/css/`**, nunca en `style.css`.
- **Sin filtraciones de CSS**: `page-home.css` es exclusivo de Home; cada componente reutilizable tiene su propio CSS y su propio enqueue condicional.
- **ACF JSON es fuente de verdad**: versionar `/acf-json/` en cada cambio de campo, sin excepción.
- **Field Groups por Page Template**, no globales, para evitar campos irrelevantes en el editor.

---

### Incidente Git: commit accidental de dump SQL local

#### Qué pasó
Se añadió accidentalmente el archivo `app/sql/local.sql` (135 568 líneas) a un commit. Al intentar hacer `git push`, el push falló con los errores:

```
error: RPC failed; HTTP 400 curl 22 The requested URL returned error: 400
send-pack: unexpected disconnect while reading sideband packet
fatal: the remote end hung up unexpectedly
```

El archivo era demasiado grande para el transporte HTTP de GitHub, lo que bloqueó completamente el push de esa rama.

#### Qué se hizo
1. Se identificó el archivo problemático con `git show --stat HEAD`.
2. Se revirtió el commit con `git reset HEAD~1` (manteniendo los cambios útiles del mismo commit en staging).
3. Se añadieron reglas a `.gitignore` para excluir dumps SQL y artefactos locales:
   - `app/sql/*.sql`
   - `*.sql`
4. Se hizo commit limpio (`f802824`) con mensaje `chore: ignore local sql dumps`.
5. El push se completó sin errores.

#### Impacto
- Repo más limpio: sin archivos de base de datos locales versionados.
- Se evita la exposición accidental de datos de la instancia local.
- Se elimina el bloqueo de push por archivos sobredimensionados.
- El flujo Git queda restaurado con normalidad.

#### Lecciones aprendidas / Prevención
- **Nunca versionar dumps SQL**: contienen datos locales, pueden ser grandes y no aportan valor al control de versiones del theme.
- La **fuente de verdad de la estructura de contenido** es el código del theme + `/acf-json/`, no la base de datos local.
- Usar `.gitignore` proactivamente para `app/sql/`, `*.sql`, `uploads/` y otros artefactos locales.
- Antes de hacer `git add .`, revisar qué archivos se están añadiendo con `git status` y `git diff --stat`.
- Si un push falla con HTTP 400 o "remote end hung up", revisar `git show --stat HEAD` para detectar archivos grandes.

---

## 2026-03

### ACF JSON activado en child theme
- Se crea `/acf-json/`
- Se añade `inc/acf-json.php`
- Se sincronizan field groups

Impacto:
- ACF versionado
- Proyecto portable entre entornos

---

### Exportación completa de ACF
- Se exportan grupos de Home, Apartamentos, Bloques y Opciones

Impacto:
- Estructura de contenido replicable
- Menos dependencia de configuración manual

---

### Limpieza de `functions.php`
- Se revisa la carga de includes
- Se mejora estabilidad entre entornos
- Se deja camino abierto para modularizar enqueues

Impacto:
- Menos riesgo de fatales
- Mejor mantenimiento

---

### Integración ICNEA – Fase 1 completada

#### Cambio
Se corrige la incompatibilidad entre el buscador de home y el archive de apartamentos.

#### Archivos implicados
- `js/scripts.js`
- `inc/gls-icnea.php`
- `archive-apartamentos.php`

#### Hecho
- `scripts.js` pasa a enviar `arrival` y `departure`
- Se añaden helpers centralizados para leer request vars de búsqueda
- Se acepta compatibilidad con:
  - `arrival / departure`
  - `checkin / checkout`
- El archive consume parámetros ya normalizados desde helper centralizado

#### Impacto
- El buscador home → archive → ICNEA queda funcional
- No se rompen URLs antiguas
- Menos lógica duplicada

---

### Integración ICNEA – Fase 2 completada

#### Cambio
Se reduce la fragilidad del mapping entre apartamento WordPress e ID real de ICNEA.

#### Archivos implicados
- `inc/gls-icnea.php`
- `inc/gls-migrate-icnea.php`
- `functions.php`
- ACF: nuevo campo `icnea_id`

#### Hecho
- Se crea el campo técnico `icnea_id`
- La lógica ICNEA usa primero `icnea_id`
- Se mantiene fallback a extracción desde `boton_de_reserva`
- Se añade rutina temporal de migración para poblar `icnea_id`

#### Impacto
- Menos dependencia del formato de URL de ICNEA
- Arquitectura más sólida
- Base lista para endurecer disponibilidad y rendimiento

#### Nota operativa
- La rutina temporal de migración debe retirarse una vez ejecutada y validada

---

## Pendiente

### Fase 3 — Endurecer disponibilidad
- Evitar mostrar todos los apartamentos cuando ICNEA falle repetidamente
- Hacer configurable el fallback
- Mostrar mensaje neutro cuando no se pueda validar disponibilidad

### Fase 4 — Rendimiento
- Cachear mapping `post_id -> icnea_id`
- Reducir lecturas repetidas de ACF en loops
- Evaluar capa intermedia de disponibilidad si crece el volumen

### Fase 5 — Observabilidad
- Logging controlado en debug
- Detectar timeouts
- Detectar JSON inválido
- Detectar apartamentos sin ID ICNEA válido
