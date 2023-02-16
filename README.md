# Laravel Logger Adapter

## Descrição
Biblioteca para gerenciamento de eventos de log para aplicações desenvolvidas com Laravel.

## Instalação
Para instalar esta dependência, é necessário ter o Composer disponível em sua máquina. Baixe e instale o Composer a partir deste link: https://getcomposer.org/download/

Após ter instalado o composer, execute o seguinte comando para instalar a dependência no seu projeto Laravel:

```
composer require felipemenezesdm/laravel-logger-adapter
```

## Uso
No arquivo de configuração de log do laravel _logging.php_, é necessário configurar os canais de log:
```php
<?php

return [
    # ...
    'channels' => [
        # ...
        'gcp' => [
            'driver' => 'custom',
            'via' => \FelipeMenezesDM\LaravelLoggerAdapter\Loggers\GCPLogger::class,
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'aws' => [
            'driver' => 'custom',
            'via' => \FelipeMenezesDM\LaravelLoggerAdapter\Loggers\AWSLogger::class,
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        # ...
    ],
    # ...
]
```
No arquivo de variáveis de ambiente _.env_, é necessário definir qual canal a ser utilizado, por exemplo:
```dotenv
APP_LOG_CHANNEL=gcp
```
Crie as fronteiras de log na aplicação usando a classe _LogHandler_, conforme o exemplo abaixo. É possível também usar o payload padronizado _LogPayload_, que foi implementado usando o _pattern builder_:
```php
LogHandler::info(__('validate.access.token'), LogPayload::build()->setEndPoint("/test"));
```

## Configuração
Abaixo, as variáveis de ambiente disponíveis para configurar a biblioteca:

| Name                           | Valor padrão            | Observação                                                                       |
|--------------------------------|-------------------------|----------------------------------------------------------------------------------|
| APP_LOG_CHANNEL                | stack, aws ou gcp       | Driver de log: gcp, aws, stack                                                   |
| APP_NAME                       | ***                     | Nome da aplicação                                                                |
| APP_SERVICE_ID                 | ***                     | ID do serviço da aplicação                                                       |
| APP_ENV                        | LOCAL, DEV, HOM ou PROD | Ambiente onde a aplicação está alocada                                           |
| AWS_ACCOUNT_ID                 | 000000000000            | Definir a ID da conta AWS para a aplicação                                       |
| AWS_ENDPOINT                   | http:\/\/127.0.0.1      | Definir o endpoint dos serviços AWS (indicado quando houver o uso do localstack) |
| AWS_DEFAULT_REGION             | us-east-1               | Definir a região padrão para uma aplicação alocada na AWS                        |
| GCP_PROJECT_ID                 | N/A                     | ID do projeto no Google Cloud Plataform                                          |
| GOOGLE_APPLICATION_CREDENTIALS | N/A                     | Arquivo de credenciais do Google Cloud Platform                                  |

## Links úteis
- [Laravel Logger Adapter on GitHub](https://github.com/FelipeMenezesDM/laravel-logger-adapter)
- [Laravel Logger Adapter on Packagist](https://packagist.org/packages/felipemenezesdm/laravel-logger-adapter)