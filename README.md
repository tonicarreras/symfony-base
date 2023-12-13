# Symfony base
> - Version **Symfony 7.0.***

## 📖 Table of contents 
- [Introduction](#-introduction)
- [Installation](#-installation)
    - [Docker](#-docker)
    - [Manual installation](#-manual-installation)
- [Bundles](#-bundles)
- [Acknowledgments](#-acknowledgments)


## 🌟 Introduction
This project is a template for creating a Symfony application using the hexagonal architecture. It is based on the [php-ddd-example](https://github.com/CodelyTV/php-ddd-example) project, but with some changes and improvements.

## 🚀 Installation

- **Clone the repository from GitHub.**

```shell
git clone https://github.com/tonicarreras/symfony-base.git
```

### 🐳 Docker

- **Build and run the Docker containers (Makefile).**

```shell
# Build and run Docker containers
make install
``` 

- **Terminal**

```shell
# Enter the Docker container's terminal
make sh
```

- **Database MySql (MariaDB)**

```
- Database: symfony-database 
- user: root
- password: root
```

- **Access the application**

You can access the application in your web browser at:
- http://localhost:8000/

### 🖥 Manual installation

#### Prerequisites for manual installation
- PHP 8.3 or higher
- Composer
- MySQL or MariaDB
- Symfony CLI (optional)

> [!IMPORTANT]
> #### Required PHP extensions
> This project requires the following PHP extensions to be installed and enabled:
> - **ext-ctype**: Used for character type checking.
> - **ext-iconv**: For character encoding conversion.
> - **ext-pdo**: Essential for PHP Data Object (PDO) database connections.

- Install dependencies:
```shell
composer install
```

- Database migrations:

You will need to configure the database connection by modifying the DATABASE_URL in the .env file to match your MySQL settings.
```shell
php bin/console doctrine:migrations:migrate
```

- Start Symfony Server:
```shell
#Symfony CLI
symfony server:start
```
For more details on setting up Symfony, please refer to the [official Symfony documentation](https://symfony.com/doc/current/setup.html)

## 🛠 Bundles
[bundles.php](config/bundles.php)

## 🤭 Acknowledgments

This project has benefited from ideas and code from the following projects and resources:
- [php-ddd-example](https://github.com/CodelyTV/php-ddd-example): Example of a PHP application using Domain-Driven Design (DDD) and Command Query Responsibility Segregation (CQRS) principles keeping the code as simple as possible (CodelyTV).
- [modular-monolith-example](https://github.com/codenip-tech/modular-monolith-example): Modular Monolith Example (Codenip).