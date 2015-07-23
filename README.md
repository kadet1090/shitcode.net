[Shitcode](http://shitcode.net) [codename happycode]
====================================================

Shitty code can occur almost everywhere, on every moment of your life,
[Shitcode](http://shitcode.net) is place for storing (And sharing too!) worst of our programming
nightmares. Created as weekend project (So it's shitty as well) because... why not?

So if you have some shitty project or code and want to share it go ahead. 
Any contributions are welcome, including PRs, and bug reports.


REQUIREMENTS
------------

PHP >= 5.4 (5.5 recommended because of `array_column`), some server, and cup of coffee (for me).

INSTALLATION
------------

Just clone this repo into some working directory (you should know how to do that) and install dependencies with composer:
```
php /path/to/composer.phar install
```

### WebServer

Your domain (I recommend using something like shitcode.dev) should point to `/web/` folder, example config in apache:
```apache
<VirtualHost *:80>
    ServerAdmin webmaster@shitcode.dev
    DocumentRoot "/path/to/shitcode/web"
    ServerName shitcode.dev
    ErrorLog "logs/shitcode-error.log"
    CustomLog "logs/shitcode-access.log" common
</VirtualHost>
```

Or in nginx (including rewrite!):
```nginx
server {
    listen 80;
    root /path/to/shitcode/web/;
    server_name shitcode.dev;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }
}
```

You can define alias too, but I assume that you know how to do it.

### Database

Create database on your server, import tables from file `schema.sql` and fill `config/db.php` with your data, for example:

```php
<?php return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=shitcode',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

Oh, and you have to configure mailer in `config/mailer.php`:
```php
<?php return [
    'class' => 'yii\swiftmailer\Mailer',
    'useFileTransport' => true,
];
```

Now you're ready to go and login using admin `admin@shitcode.test` and password `admin`.

License
=======
[CreativeCommons BY-NC-SA](https://creativecommons.org/licenses/by-nc-sa/3.0/us/)


Oh, and yes, I know about [r/badcode](https://www.reddit.com/r/badcode) and [govnokod.ru](http://govnokod.ru).
