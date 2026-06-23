# Capacita+

<br>

![PHP](https://img.shields.io/badge/php-777BB3?style=for-the-badge&logo=php&logoColor=white) ![Angular](https://img.shields.io/badge/angular-C3002F.svg?style=for-the-badge&logo=angular&logoColor=EAEAEA) ![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white) ![MariaDB](https://img.shields.io/badge/MariaDB-003545?style=for-the-badge&logo=mariadb&logoColor=white) ![Nginx](https://img.shields.io/badge/nginx-009900?style=for-the-badge&logo=nginx&logoColor=white) ![Docker](https://img.shields.io/badge/docker-1d63ed?style=for-the-badge&logo=docker&logoColor=white) ![cypress](https://img.shields.io/badge/-cypress-%23E5E5E5?style=for-the-badge&logo=cypress&logoColor=058a5e)

## Descrição

Um portal aberto de cursos de capacitação on-line.

Versão estática acessível em: 
[https://heberfhlemes.github.io/capacita-mais](https://heberfhlemes.github.io/capacita-mais)

## Objetivo

Projeto desenvolvido com fins educacionais para praticar:
- Tecnologias front-end (HTML, CSS, JavaScript, TypeScript e Bootstrap 5)
- Frameworks front-end (Angular)
- Acessibilidade e Responsividade
- UX/UI
- Back-end com PHP
- Integração com banco de dados
- Arquitetura de APIs e projetos web
- Comunicação assíncrona entre cliente e servidor
- Uso de Docker no desenvolvimento
- Testes de software (casos de teste e automação com Cypress)

## Configurando o ambiente local

### 1. Configure as variáveis de ambiente
Crie um arquivo `.env` na raiz do projeto com base no `.env.example` e defina nele as variáveis de ambiente necessárias

### 2. Instale as dependências necessárias
> Se for executar fora do Docker
```bash
# Para o back-end
cd backend/
composer install

# Para o front-end
cd ../frontend/
npm install
```

## Executando localmente

Você pode rodar o projeto com um interpretador PHP + npm ou com Docker:

### Com interpretador PHP
```bash
cd backend/
php -S localhost:9000 -t public

cd ../frontend
npm run start # ou ng serve
```
Acesse em: http://localhost:4200

### Com Docker (Nginx + PHP + MariaDB)
```bash
docker compose up -d
```
Acesse em: http://localhost:8080

--- 

### Observações
- Arquivo `.env` deve estar corretamente configurado para se comunicar com o banco de dados
- O banco de dados deve estar acessível para a aplicação
