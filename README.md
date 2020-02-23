# Quake log parser

## Task 1

Parser construído para analisar o arquivo de log `src/public/logs/games.log`.

O arquivo games.log é gerado pelo servidor de quake 3 arena. Ele registra todas as informações dos jogos, quando um jogo começa, quando termina, quem matou quem, quem morreu pq caiu no vazio, quem morreu machucado, entre outros.

O parser é capaz de ler o arquivo, agrupar os dados de cada jogo, e em cada jogo deve coletar as informações de morte.

### Exemplo

  	21:42 Kill: 1022 2 22: <world> killed Isgalamido by MOD_TRIGGER_HURT
  
  O player "Isgalamido" morreu pois estava ferido e caiu de uma altura que o matou.

  	2:22 Kill: 3 2 10: Isgalamido killed Dono da Bola by MOD_RAILGUN
  
  O player "Isgalamido" matou o player Dono da Bola usando a arma Railgun.
  
Para cada jogo o parser deve gerar algo como:

    game_1: {
	    total_kills: 45;
	    players: ["Dono da bola", "Isgalamido", "Zeh"]
	    kills: {
	      "Dono da bola": 5,
	      "Isgalamido": 18,
	      "Zeh": 20
	    }
	  }

### Observações

1. Quando o `<world>` mata o player ele perde -1 kill.
2. `<world>` não é um player e não deve aparecer na lista de players e nem no dicionário de kills.
3. `total_kills` são os kills dos games, isso inclui mortes do `<world>`.

## Task 2

Tabela modelada em um banco de dados relacional como o MySQL e populada com o parser da Task 1.

As tabelas do banco de dados são criadas automaticamente, porém se necessitar, tem um dump.sql no diretório `mysql/dump.sql`

## Task 3

Ranking geral de kills por jogador com campo de busca por nome do usuário. Os dados são consultados a partir da tabela gerada na Task 2. __Aplicação é um SPA.__

## Plus

Relatório de mortes agrupando pelo motivo da morte, por partida.

Causas de morte (retirado do [código fonte](https://github.com/id-Software/Quake-III-Arena/blob/master/code/game/bg_public.h))

	// means of death
	typedef enum {
		MOD_UNKNOWN,
		MOD_SHOTGUN,
		MOD_GAUNTLET,
		MOD_MACHINEGUN,
		MOD_GRENADE,
		MOD_GRENADE_SPLASH,
		MOD_ROCKET,
		MOD_ROCKET_SPLASH,
		MOD_PLASMA,
		MOD_PLASMA_SPLASH,
		MOD_RAILGUN,
		MOD_LIGHTNING,
		MOD_BFG,
		MOD_BFG_SPLASH,
		MOD_WATER,
		MOD_SLIME,
		MOD_LAVA,
		MOD_CRUSH,
		MOD_TELEFRAG,
		MOD_FALLING,
		MOD_SUICIDE,
		MOD_TARGET_LASER,
		MOD_TRIGGER_HURT,
	#ifdef MISSIONPACK
		MOD_NAIL,
		MOD_CHAINGUN,
		MOD_PROXIMITY_MINE,
		MOD_KAMIKAZE,
		MOD_JUICED,
	#endif
		MOD_GRAPPLE
	} meansOfDeath_t;

Exemplo:

	"game-1": {
		kills_by_means: {
			"MOD_SHOTGUN": 10,
			"MOD_RAILGUN": 2,
			"MOD_GAUNTLET": 1,
			"XXXX": N
		}
	}


## Aplicação

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

3. Caso queira, altere as variáveis de ambiente no arquivo copiado `.env`. É nesse arquivo que as credenciais do banco de dados estão definidas. A aplicação utiliza as variáveis de ambiente para realizar todas as operações com o banco de dados.
**Obs.:** O host para se conectar no banco é o nome do container do MySQL.

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