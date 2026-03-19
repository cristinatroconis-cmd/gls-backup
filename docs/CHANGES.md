# Cambios – Granada Luxury Suites

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
