### Para automatizar os comandos de build/run e remoção do container Docker

.PHONY: all build clean run

all: clean build run

# Constrói a imagem, se ela não existir
build:
	docker image inspect capacita-frontend >/dev/null 2>&1 || \
	docker build -t capacita-frontend .

# Sobe o container ou o reinicia
run:
	docker ps -a --format '{{.Names}}' | grep -q '^capacita-container$$' && \
	docker start capacita-container >/dev/null || \
	docker run -d -p 8080:80 --name capacita-container capacita-frontend

# Para o container e o remove
clean:
	-@docker stop capacita-container 2>/dev/null || true
	-@docker rm capacita-container 2>/dev/null || true
