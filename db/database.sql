DROP DATABASE IF EXISTS lamp_db;
CREATE DATABASE lamp_db CHARSET utf8mb4;
USE lamp_db;

CREATE TABLE users (
  id int(11) NOT NULL auto_increment,
  name varchar(100) NOT NULL,
  age int(3) NOT NULL,
  email varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  option_a VARCHAR(255) NOT NULL,
  option_b VARCHAR(255) NOT NULL,
  option_c VARCHAR(255) NOT NULL,
  option_d VARCHAR(255) NOT NULL,
  correct_option CHAR(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO test_questions (question_text, option_a, option_b, option_c, option_d, correct_option) VALUES
('¿Qué formato guarda el audio sin compresión y suele ocupar más espacio?', 'AAC', 'WAV', 'MP3', 'OGG', 'B'),
('Si buscas buena compatibilidad con tamaño reducido, ¿qué formato es habitual?', 'MP3', 'WAV', 'PCM sin contenedor', 'FLAC sin pérdida', 'A'),
('¿Qué página se usa para convertir los audios durante la práctica?', 'index.php', 'presentacion.php', 'transformador.php', 'test.php', 'C'),
('En transformador.php, ¿qué acción debe hacer el estudiante antes de convertir?', 'Elegir un color de tema', 'Subir un archivo de audio válido', 'Crear una cuenta de administrador', 'Editar el código fuente', 'B'),
('Tras convertir el archivo, ¿qué señal confirma que la conversión terminó correctamente?', 'Aparece un botón para descargar el archivo convertido', 'Se recarga la página sin mensajes', 'El navegador se cierra automáticamente', 'Se borra el archivo original del equipo', 'A');

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