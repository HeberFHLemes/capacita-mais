### Para automatizar os comandos de build/run e remoção do container Docker
imagem := capacita-mais
container := capacita-mais-container

.PHONY: all build clean clean-image run

all: clean build run

# Constrói a imagem, se ela não existir
build:
	@echo "Verificando se a imagem $(imagem) existe..."
	@docker image inspect $(imagem) >/dev/null 2>&1 || \
	(docker build -t $(imagem) . && echo "=> Imagem construída com sucesso.")

# Sobe o container ou o reinicia
run:
	@echo "Iniciando container $(container)..."
	@if docker ps -a --format '{{.Names}}' | grep -q '^$(container)$$'; then \
		docker start $(container) >/dev/null && echo "=> Container iniciado."; \
	else \
		docker run -d -p 8080:80 --name $(container) $(imagem) && echo "=> Container criado e em execução."; \
	fi

# Para o container e o remove
clean:
	@echo "Parando container $(container)..."
	-@docker stop $(container) >/dev/null 2>&1 || echo "=> Container não está em execução."
	@echo "Removendo container $(container)..."
	-@docker rm $(container) >/dev/null 2>&1 || echo "=> Container não encontrado."

# Tenta remover a imagem, depois de tentar parar o container e o remover.
clean-image: clean
	@echo "Removendo imagem $(imagem)..."
	-@docker rmi $(imagem) >/dev/null 2>&1 || echo "=> Imagem não encontrada."
