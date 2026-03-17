CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE plataformas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  nome_normalizado VARCHAR(150) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  nome_normalizado VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE cursos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  descricao TEXT,
  categoria_id INT NOT NULL,
  plataforma_id INT NOT NULL,
  url TEXT NOT NULL,
  gratuito BOOLEAN NOT NULL,

  UNIQUE (nome, plataforma_id),

  CONSTRAINT fk_cursos_categoria
    FOREIGN KEY (categoria_id)
    REFERENCES categorias(id)
    ON DELETE RESTRICT,

  CONSTRAINT fk_cursos_plataforma
    FOREIGN KEY (plataforma_id)
    REFERENCES plataformas(id)
    ON DELETE RESTRICT
) ENGINE=InnoDB;