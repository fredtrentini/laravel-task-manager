# laravel-task-manager

Projeto demonstrativo de um sistema de gerenciamento de tarefas usando Laravel.

## Como executar

### Opção 1: execução local

#### 1. Instalar PHP + Composer + Laravel ([fonte: documentação do Laravel 12.x](https://laravel.com/docs/12.x/installation))

- Se for windows (Executar no powershell como administrador): `Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))`

- Se for linux: `/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"`

- Se for macOS: `/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.4)"`

#### 2. Instalar NodeJS + NPM

- Se for windows: [use o instalador](https://nodejs.org/en/download/current)
- Se for linux/macOS: `sudo apt install nodejs npm`

#### 3. Instalar MySQL

- [Siga as instruções de acordo com seu sistema operacional](https://dev.mysql.com/downloads/mysql/)

#### 4. Instalar dependências do projeto

```sh
composer install
npm install
```

#### 5. Configurar o arquivo `.env`

Copie o arquivo de exemplo:

```sh
cp .env.example .env
```

Edite os dados do banco:

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_task_manager
DB_USERNAME=root
DB_PASSWORD=root
```

#### 6. Gerar key da aplicação

```sh
php artisan key:generate
```

#### 7. Rodar migrations

```sh
php artisan migrate
```

#### 8. Executar o projeto (back-end + front-end)

```sh
composer run dev
```

---

### Opção 2: execução via docker

#### 1. Criar o arquivo `.env`

```sh
cp .env.example .env
````

Edite o arquivo `.env`

```sh
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_task_manager
DB_USERNAME=root
DB_PASSWORD=root
```

#### 2. Subir os containers

```sh
docker compose up -d --build
```

#### 3. Acessar o projeto

* Laravel: [http://localhost:8000](http://localhost:8000)
* Vite (hot reload): [http://localhost:5173](http://localhost:5173)

## Testes

O projeto possui alguns testes com pest, para executá-los use o seguinte comando:

```sh
php artisan test
```
