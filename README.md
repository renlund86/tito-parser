# tito-parser

This project consists of 2 parts: Server and Client.

## Server

Requirements:

- PHP 7.4+
- Composer
- Apache 2.4 (SlimFramework works with several webservers, but tested with Apache, .htaccess in source)

### Installation instructions for server

> composer install

**Virtual Host config***
```
<VirtualHost *:8090>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/tito-parser/public
<Directory /var/www/tito-parser/public>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
        ErrorLog ${APACHE_LOG_DIR}/tito-error.log
        CustomLog ${APACHE_LOG_DIR}/tito-access.log combined
</VirtualHost>
```

## Client (web-app)

Requirements:

- NPM
- TypeScript

### Installation instructions for client

Transpile TS code to public folder by running the tsc command in terminal:
> tsc

output in public folder

### Demo server http://tito-test.mrenlund.com/

>**POST** http://tito-test.mrenlund.com/parse

JSON payload:

>{"fileName":"input.txt"}




