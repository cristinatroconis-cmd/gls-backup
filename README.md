# Granada Luxury Suites – Child Theme

Tema hijo de `identofmk` para Granada Luxury Suites.

## Stack
- WordPress + ACF Pro
- Child theme: `granadaluxurysuites`
- Parent theme: `identofmk`
- Local: LocalWP
- Repo: GitHub
- Integración externa: ICNEA

---

## Reglas del proyecto

### 1. CSS
- No editar `style.css`
- Usar siempre `/css/`
- No meter estilos inline en templates salvo caso excepcional y justificado

### 2. ACF
- ACF se versiona en `/acf-json/`
- No crear campos “a mano” y olvidarse de guardarlos
- Siempre guardar el grupo ACF después de editarlo para que exporte JSON

Después de editar ACF:
```bash
git add acf-json
git commit -m "chore: update ACF fields"
git push origin main
```

### 3. Templates
- Usar `template-parts/` para piezas reutilizables
- No duplicar lógica
- Mantener separación entre:
  - estructura (PHP)
  - contenido (ACF)
  - estilos (CSS)

### 4. functions.php
- Mantener limpio
- No meter lógica pesada
- Usar `/inc/` para helpers, integraciones y utilidades
- Las rutinas temporales deben eliminarse tras usarse

### 5. Git / LocalWP
- Los cambios hechos en WP Admin no sustituyen el flujo correcto de Git
- La fuente de verdad del código debe ser la carpeta activa del theme en LocalWP + el repo Git
- Flujo correcto:
  1. editar archivos en local
  2. probar en LocalWP
  3. `git add / commit / push`
  4. `git pull` solo para traer cambios del remoto

### 6. Home
- `page-home-nueva.php` es la home modular nueva
- Puede convivir con la home actual mientras se termina

---

## Integración ICNEA – estado actual

### Fase 1 completada
Se corrigió el puente entre el buscador y el archive de apartamentos:
- `js/scripts.js` ahora envía `arrival` y `departure`
- `inc/gls-icnea.php` incorpora helpers para aceptar ambas nomenclaturas:
  - `arrival / departure`
  - `checkin / checkout`
- `archive-apartamentos.php` consume los parámetros ya normalizados desde helper centralizado

Impacto:
- El buscador home → archive → ICNEA queda funcional
- Se mantiene compatibilidad con URLs antiguas

### Fase 2 completada
Se redujo la fragilidad del ID ICNEA:
- Se crea el campo ACF técnico `icnea_id`
- `inc/gls-icnea.php` usa primero `icnea_id`
- Si `icnea_id` no existe, hace fallback a extracción desde `boton_de_reserva`
- Se añadió una rutina temporal de migración para poblar `icnea_id` desde la URL de reserva

Impacto:
- Menos dependencia del formato de URL de ICNEA
- Base más sólida para disponibilidad y mantenimiento

### Pendiente inmediato
- Ejecutar/validar migración en todos los apartamentos y retirar la rutina temporal cuando termine
- Continuar con fases 3, 4 y 5 de la auditoría ICNEA

---

## Flujo de trabajo recomendado

### Código
```bash
git status
git add .
git commit -m "feat: descripción corta y real del cambio"
git push origin main
```

### Traer cambios del remoto
```bash
git pull origin main
```

### ACF
- Crear/editar en WP Admin
- Guardar grupo
- Confirmar export en `/acf-json/`
- Commit a Git

---

## Notas clave
- Este proyecto depende fuertemente de ACF
- El frontend está desacoplado del editor clásico
- Muchas vistas son dinámicas vía Flexible Content
- ICNEA se usa como motor de disponibilidad, no como frontend principal
- Litepicker sigue siendo la capa de UX del buscador
