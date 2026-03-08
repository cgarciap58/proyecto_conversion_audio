# Proyecto Conversión Audio

Este proyecto está diseñado para acompañar una presentación oral sobre los formatos de audio (con mayor énfasis en MP3, WAV, AAC y OGG).

## Flujo de clase

1. `presentacion.php`: explicación teórica.
2. `transformador.php`: práctica de conversión de archivos de audio.
3. `test.php`: evaluación final (permanece bloqueada hasta que Felipe o César la habilite).

## Funcionalidades del test

- César o Felipe habilitan el test desde `activar_test.php` con un PIN (`TEST_ADMIN_PIN`, por defecto `1234`).
- Mientras esté bloqueado:
  - en el menú aparece como "Bloqueado"
  - `test.php` muestra aviso y no deja responder.
- Las preguntas del test se cargan desde la tabla `test_questions`.
- Cada intento se guarda en `test_attempts`.
- `test.php` muestra automáticamente quién fue el **primer estudiante** en responder todo correctamente.

La presentación la realizan Felipe Manosalva y César García.