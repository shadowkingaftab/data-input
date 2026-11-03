# Mission Control — Student Registration

A PHP registration project using HTML, CSS, JavaScript, jQuery, and PHP. Valid applications are checked on the server, stored in the session for a one-time confirmation page, and given a random reference. No database is used; PHP sessions must be enabled.

## Run locally

Install PHP 8 or later, open a terminal in this directory, and run:

```sh
php -S localhost:8000
```

Open <http://localhost:8000>. jQuery and fonts load from CDNs and need an internet connection.

## Deploy

Upload the contents of this directory to the document root of a PHP-compatible host (such as PHP shared hosting). Use PHP 8 or later, enable sessions, and serve the site over HTTPS. No database or build step is required.

## Flow

`index.php` renders the form. `process.php` validates the POST on the server and issues a 303 redirect to `success.php`. Registration details live in the PHP session and are consumed once by the confirmation page. Displayed submitted values are escaped with `htmlspecialchars()`.
