CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    valor_total NUMERIC(10, 2) NOT NULL,
    data_compra DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE itens_compra (
    compra_id INT NOT NULL,
    curso_id INT NOT NULL,
    valor_pago NUMERIC(10, 2) NOT NULL,

    PRIMARY KEY (compra_id, curso_id),

    CONSTRAINT fk_compra_id
        FOREIGN KEY (compra_id) 
        REFERENCES compras(id) 
        ON DELETE CASCADE,

    CONSTRAINT fk_curso_id
        FOREIGN KEY (curso_id) 
        REFERENCES curso_id(id)
        ON DELETE CASCADE
);

CREATE TABLE itens_carrinho (
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,

    PRIMARY KEY (usuario_id, curso_id),

    CONSTRAINT fk_usuario_id
        FOREIGN KEY (usuario_id) 
        REFERENCES usuarios(id) 
        ON DELETE CASCADE,

    CONSTRAINT fk_curso_id
        FOREIGN KEY (curso_id) 
        REFERENCES curso_id(id)
        ON DELETE CASCADE
);