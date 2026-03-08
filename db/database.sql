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

CREATE TABLE quiz_questions (
  id INT NOT NULL AUTO_INCREMENT,
  slug VARCHAR(120) NOT NULL,
  question_text VARCHAR(255) NOT NULL,
  expected_bytes INT NOT NULL,
  tolerance_bytes INT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uniq_quiz_questions_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO quiz_questions (slug, question_text, expected_bytes, tolerance_bytes)
VALUES (
  'mercadona_aac_size',
  '¿Cuánto ocupa el archivo mercadona.wav convertido a AAC 128 kbps?',
  32000,
  1024
)
ON DUPLICATE KEY UPDATE
  question_text = VALUES(question_text),
  tolerance_bytes = VALUES(tolerance_bytes);