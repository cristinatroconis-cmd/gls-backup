# Granada Luxury Suites – Child Theme

## Base del proyecto
- Tema padre: `identoframework`
- Tema hijo: `granadaluxurysuites`

## Reglas de trabajo
- No editar `style.css` del tema hijo
- No editar `style.css` del tema padre
- No romper estructura existente del tema
- Reutilizar lógica antes de duplicarla
- Priorizar cambios en archivos CSS dedicados, `template-parts`, ACF y lógica modular

## Arquitectura
- El contenido estructural y flexible se gestiona con ACF
- Las secciones reutilizables se renderizan mediante `template-parts`
- El objetivo es mantener una web escalable, visualmente limpia y orientada a captación

## Buenas prácticas
- Cada cambio debe ser mantenible
- Cada ajuste visual debe respetar jerarquía visual y estética luxury
- No introducir dependencias innecesarias
- Evitar tocar plantillas base si puede resolverse con una capa más limpia

## Versionado
Este repositorio contiene únicamente el tema hijo `granadaluxurysuites`.
No incluye:
- core de WordPress
- plugins
- uploads
- base de datos
