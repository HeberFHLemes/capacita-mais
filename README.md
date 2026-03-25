# Capacita+

<br>

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) ![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E) ![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white) ![MariaDB](https://img.shields.io/badge/MariaDB-003545?style=for-the-badge&logo=mariadb&logoColor=white) ![Nginx](https://img.shields.io/badge/nginx-%23009639.svg?style=for-the-badge&logo=nginx&logoColor=white) ![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white) ![cypress](https://img.shields.io/badge/-cypress-%23E5E5E5?style=for-the-badge&logo=cypress&logoColor=058a5e)

## Descrição

Um portal aberto para descoberta de cursos de capacitação online.

Versão estática acessível em: 
[https://heberfhlemes.github.io/capacita-mais](https://heberfhlemes.github.io/capacita-mais)

## Objetivo

Projeto desenvolvido com fins educacionais para praticar:
- Tecnologias front-end (HTML, CSS, JavaScript e Bootstrap 5)
- Acessibilidade e Responsividade
- UX/UI
- Back-end com PHP
- Integração com banco de dados
- Arquitetura básica de APIs e projetos web
- Uso de Docker no desenvolvimento
- Testes de software (casos de teste e automação)


## Executando localmente

Você pode rodar o projeto com um interpretador PHP ou com Docker:

### 1. Configure as variáveis de ambiente

Crie um arquivo `.env` na raiz do projeto com base no `.env.example`.

### 2. Execute

#### Com interpretador PHP
```bash
php -S localhost:8080 -t public
```

#### Com Docker (Nginx + PHP-FPM + MariaDB)
```bash
docker compose up -d
```
Acesse em: http://localhost:8080

--- 

### Observações
- Arquivo `.env` deve estar corretamente configurado para se comunicar com o banco de dados
- O banco de dados deve estar acessível para a aplicação

---

### Nota
> Este é um projeto educacional.
> Toda menção, imagem ou logotipo de terceiros são utilizados como exemplos, sem nenhum contrato,
> promoção ou parceria real. O propósito é puramente educacional.
