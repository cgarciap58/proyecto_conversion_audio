DROP DATABASE IF EXISTS lamp_db;
CREATE DATABASE lamp_db CHARSET=utf8mb4;
USE lamp_db;

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

CREATE TABLE users (
  id int(11) NOT NULL auto_increment,
  name varchar(100) NOT NULL,
  age int(3) NOT NULL,
  email varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE app_settings (
  id INT NOT NULL AUTO_INCREMENT,
  setting_key VARCHAR(80) NOT NULL,
  setting_value VARCHAR(255) NOT NULL,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uniq_setting_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO app_settings (setting_key, setting_value)
VALUES ('test_enabled', '0')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);

CREATE TABLE test_questions (
  id INT NOT NULL AUTO_INCREMENT,
  question_text VARCHAR(255) NOT NULL,
  question_type ENUM('multiple_choice', 'open_text') NOT NULL DEFAULT 'multiple_choice',
  option_a VARCHAR(255) NULL,
  option_b VARCHAR(255) NULL,
  option_c VARCHAR(255) NULL,
  option_d VARCHAR(255) NULL,
  correct_option CHAR(1) NULL,
  correct_text VARCHAR(255) NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- B, A, C, C, D, B, D C, C, A, 26, 
INSERT INTO test_questions (question_text, question_type, option_a, option_b, option_c, option_d, correct_option, correct_text) VALUES
('¿Qué formato guarda el audio sin compresión y suele ocupar más espacio?', 'multiple_choice', 'AAC', 'WAV', 'MP3', 'OGG', 'B', NULL),
('Si buscas buena compatibilidad con tamaño reducido, ¿que formato es habitual?', 'multiple_choice', 'MP3', 'WAV', 'PCM sin contenedor', 'FLAC sin perdida', 'A', NULL),
('¿Qué formato usa Spotify en Android y PC?', 'multiple_choice', 'MP3', 'AAC', 'OGG Vorbis', 'WAV', 'C', NULL),
('¿Cuál es la principal ventaja del AAC frente al MP3?', 'multiple_choice', 'Es más antiguo y compatible', 'No tiene patentes', 'Mejor calidad a igual tamaño de archivo', 'Solo funciona en Apple', 'C', NULL),
('¿Qué significa que un formato tiene compresión con pérdida?', 'multiple_choice', 'Que el archivo se puede recuperar completamente', 'Que usa el mismo algoritmo que ZIP', 'Que solo funciona en streaming', 'Que elimina partes del sonido de forma irreversible', 'D', NULL),
('¿En qué se basa el enmascaramiento temporal?', 'multiple_choice', 'En que el oído no percibe frecuencias por encima de 20.000 Hz', 'En que tras un sonido fuerte el oído tarda en recuperarse y no percibe sonidos suaves', 'En que dos sonidos a la vez se anulan', 'En que el cerebro ignora sonidos graves', 'B', NULL),
('¿En qué año se creó el formato OGG?', 'multiple_choice', '1991', '1993', '1997', '2000', 'D', NULL),
('¿Por qué los servicios de streaming no usan WAV?', 'multiple_choice', 'Porque WAV no es compatible con móviles', 'Porque WAV tiene patentes muy caras', 'Porque WAV ocupa 10 veces más que un MP3 y dispararía el coste de red', 'Porque WAV no admite estéreo', 'C', NULL),
('¿Con qué concepto de videojuegos se puede comparar la frecuencia de muestreo en audio?', 'multiple_choice', 'La resolución de la pantalla', 'La memoria VRAM de la tarjeta gráfica', 'Los FPS', 'La tasa de refresco del monitor en ms', 'C', NULL),
('Si tuvieras que optimizar el tamaño del juego sin perder calidad perceptible, ¿qué profundidad de bits usarías para cada caso?', 'multiple_choice', 'Sonidos del menú: 8-bit | Banda sonora: 24-bit', 'Sonidos del menú: 24-bit | Banda sonora: 8-bit', 'Sonidos del menú: 16-bit | Banda sonora: 16-bit', 'Sonidos del menú: 8-bit | Banda sonora: 8-bit', 'A', NULL),
('¿Cuánto ocupa en KB, aproximadamente, el archivo ejemplo.mp3 después de convertirlo a OGG con la herramienta? (redondeando, sin decimales)', 'open_text', NULL, NULL, NULL, NULL, NULL, '26');


CREATE TABLE test_attempts (
  id INT NOT NULL AUTO_INCREMENT,
  student_name VARCHAR(120) NOT NULL,
  correct_answers INT NOT NULL,
  total_questions INT NOT NULL,
  all_correct TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_all_correct_created (all_correct, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;