# tito-parser

This project consists of 2 parts: Server and Client. The server parses TITO formatted bankstatements and outputs it in a human-readable format as JSON. The Client is a simple webapp that gives the server parse-requests and presents the output as HTML.

### TITO
The TITO-format is an old ASCII-format (7-bit, ISO 646) dating back to 1990 but is still widely in use for representing electronic account statements in Finland.
To interpret the contents of the bank-statement, a TITO record description manual is needed and was jointly created by the Finnish banks, managed through Finanssiala ry.
There are small bank-specific variations in the implmenentation, every finnish bank have their own technical manual, two examples below:

- http://www-2.danskebank.com/Link/Tito/$file/Tito.pdf
- https://www.nordea.fi/Images/147-84478/xml-tiliote-en.pdf

### Scope of this parser
At this point, this parser *only takes transactions into account* and skips basic account information, cumulative summaries etc.

## Server

Requirements:

- PHP 7.4+
- Composer
- Apache 2.4 (SlimFramework works with several webservers, but tested with Apache, .htaccess in source)

### Installation instructions for server

1.) Install dependencies
> composer install

2.) Edit .env file
Set value for key CORS_ALLOWED_DOMAIN to match the intended origin for the client (e.g. serving webapp from localhost or webserver)

*Default is *CORS_ALLOWED_DOMAIN="http://127.0.0.1:5500"* for simple testing from VSCode > LiveServer

**Virtual Host config***
```
<VirtualHost *:80>
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




