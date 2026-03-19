# Arquitectura – Granada Luxury Suites

## Filosofía
- WordPress como CMS
- ACF como motor de contenido
- PHP templates como capa de render
- ICNEA como sistema externo de disponibilidad
- WordPress controla la experiencia de usuario; ICNEA aporta datos y reserva final

---

## Estructura clave

### `/acf-json/`
- Export automático de ACF
- Fuente de verdad de campos
- Versionado en Git

### `/css/`
- Todos los estilos del proyecto
- No usar `style.css` para desarrollo de componentes

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

## Decisiones importantes
- No usar Gutenberg nativo como constructor principal
- No usar Elementor como base estructural
- ACF manda
- No romper tema padre
- Mejorar sobre base existente, no rehacer sin necesidad
