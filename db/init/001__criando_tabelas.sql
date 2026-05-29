CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(50) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  perfil ENUM('comum', 'admin') NOT NULL,
  data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  nivel ENUM('iniciante', 'intermediario', 'avancado') NOT NULL,
  preco NUMERIC(10, 2) NOT NULL,
  preco_original NUMERIC(10, 2) NOT NULL,
  em_destaque BOOLEAN NOT NULL DEFAULT 0,

  UNIQUE (nome, nivel),
  
  CONSTRAINT fk_cursos_categoria
    FOREIGN KEY (categoria_id)
    REFERENCES categorias(id)
    ON DELETE RESTRICT
) ENGINE=InnoDB;