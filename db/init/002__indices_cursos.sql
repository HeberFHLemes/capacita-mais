CREATE INDEX idx_cursos_nome
  ON cursos (nome);

CREATE INDEX idx_cursos_categoria
  ON cursos (categoria_id);

CREATE INDEX idx_cursos_plataforma
  ON cursos (plataforma_id);