CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  perfil VARCHAR(20) NOT NULL
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
  nivel VARCHAR(50) NOT NULL,
  preco FLOAT NOT NULL,
  preco_original FLOAT NOT NULL,
  em_destaque BOOLEAN NOT NULL DEFAULT 0,

  UNIQUE (nome, nivel),
  
  CONSTRAINT fk_cursos_categoria
    FOREIGN KEY (categoria_id)
    REFERENCES categorias(id)
    ON DELETE RESTRICT
) ENGINE=InnoDB;