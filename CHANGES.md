# Cambios – Granada Luxury Suites

## 📅 2026-03

### ✔ ACF JSON activado en child theme
- Se crea `/acf-json/`
- Se añade `inc/acf-json.php`
- Se sincronizan todos los field groups

Impacto:
- Ahora ACF está versionado
- Proyecto portable

---

### ✔ Exportación completa de ACF
- +30 grupos exportados
- Incluye:
  - Home
  - Apartamentos
  - Bloques
  - Opciones

---

### ✔ Limpieza de functions.php
- Se elimina dependencia peligrosa de `inc/enqueues.php`
- Se añade carga segura con `file_exists`

Impacto:
- Evita fatal errors en hosting
- Mejora estabilidad entre entornos

---

### ✔ Preparación arquitectura modular
- Se define uso de:
  - `/inc/`
  - `/template-parts/`
  - `/css/`

---

## 📌 Pendiente

- Modularizar enqueues correctamente
- Terminar `page-home-nueva.php`
- Limpiar CSS legacy
- Revisar taxonomías de apartamentos
