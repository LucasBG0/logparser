# Resposta do teste Quake log parser
A aplicação foi construida a partir de containers do Docker. Serão criados 3 containers:

* *Nginx* ou parser-webserver (Servidor web)
* *PHP-FPM* ou parser-app (aplicação com PHP-FPM 7.4 - *FastCGI Process Manager* )
	O composer já vem instalado no container acima. Para conseguirmos utilizar o PHPunit para realizar a suíte de testes.
* *MySql* ou parser-mysql (servidor de banco de dados MySql) - As tabelas do banco de dados são criadas automaticamente, porém se necessitar, tem um dump.sql no diretório `mysql/dump.sql`.


## Estrutura de diretórios
		logparser
			|
			|-- mysql (arquivos e configs do banco de dados)
				|
				|-- dbdata (arquivos binários do mysql)
				|-- dump.sql (Dump das tabelas com os dados)
			|-- docker-compose.yml (arquivo de configuração docker)
			|-- nginx (diretório do servidor web nginx)
			|-- README.md (documentação do teste)			
			|-- src (arquivos do composer, PHPunit e diretório da aplicação)
				|
				|-- public (diretório da aplicação)
					|
					|-- classes (as classes que são utilizadas)
						|
						|-- Database (classes responsáveis pela conexão e CRUDS)
						|-- Game.php (Classe com dados das partidas)
						|-- Parser.php (Classe principal responsável por percorrer o log)
						|-- Player.php (Classe com o modelo do Player. Usado para um jogador ou uma arma
					|-- static (diretório dos arquivos estáticos. Ex: css, scss, js, svg, gif)
					|-- controller.php (controlador de ajax requests)
					|-- loader_classes.php (carrega as classes)
					|-- index.php (Arquivo principal index que chama todos os outros arquivos)
				|-- test (Suíte de testes - PHPunit)
				|-- phpunit.xml.dist (arquivo de configuração PHPunit)
				|-- composer.json (Dependências do projeto)
				|-- composer.lock (Dependências do projeto com as versões exatas)
					


## Pré-requisitos para o setup:
* [Docker](https://www.docker.com/products/docker-desktop)
* [Docker-compose](https://docs.docker.com/compose/install/)
* (Opcional) Caso queiria compilar os arquivos scss novamente, vai ser necessário instalar o NPM [Node JS](https://nodejs.org/)


### Instalação
1. Clone o repositório para o seu ambiente de desenvolvimento.

2. Vá para a raiz do projeto e crie o arquivo das variaveis de ambiente a partir do arquivo `.env.example`. Se estiver usando um terminal linux utilize o comando para copiar:

    cp.env.example .env

3. Caso queira, altere as váriaveis de ambiente no arquivo copiado `.env`. É nesse arquivo que as credenciais do banco de dados estão definidas.
**Obs.:** Se as credenciais de acesso ao banco de dados forem alteradas, vai ser necessário alterar as variáveis no arquivo src/public/classes/Database.php também. O host para se conectar no banco é o nome do container do MySQL.

4. Para criar os containers, utilize o comando:

    docker-compose up -d

5. Para confirmar o processo de criação dos containers, rode o comando:

    docker ps

**Obs.:** Caso algo de errado, você pode forçar a recriação com o comando:
	
    docker-compose up --force-recreate

6. Acesse o url da aplicação: 

	* http://127.0.0.1

### Compilar arquivos .scss com o Sass
1. Se você está usando o Node.js, pode instalar o Sass usando o npm.

    npm install -g sass

2. Assista a folhas de estilo e recompile quando elas mudarem:

    sass --watch src/public/static/scss:src/public/static/css


# Docker
Relação de comandos mais usados no docker

### Lista containers em execução
    docker ps

### Acessar o container
    docker exec -it NOMEDOCONTAINER bash

### Parar todos os containers
    docker stop $(docker ps -a -q)

### Liberar espaço em disco 
    docker volume prune

### Remover images/containers
    docker-compose rm #remove containers criados pelo docker-compose
    docker rm $(docker ps -a -q) #remove todos os containers
    docker rmi $(docker images -q -a) #remove todas as imagens

### Listar imagens
    docker images

### Listar redes
    docker network ls