# laravel-documentation-commands

This package adds a laravel command that allows you to generate a HTML file that lists all your commands.

https://packagist.org/packages/thicha0/laravel-documentation-commands

## Requirements

| Package version | Laravel   | PHP   |
|-----------------|-----------|-------|
| 2.x             | 12.x, 13.x | 8.2+ |
| 1.x             | 8.x - 11.x | 8.0+ |

## How to use ?
```
composer require thicha0/laravel-documentation-commands
```

The ServiceProvider is registered automatically through Laravel package discovery.

The new command `php artisan generate:doc-commands` should appear in the `php artisan list` command.

When launching the command, the HTML file will be generated to `public/documentation-commands.html`.

## Features

- Show signature and description of commands located in `app/Console/Commands`
- Group commands by directory
- Ignores abstract commands
- Show if command is scheduled in the Laravel Scheduler, with its cron expression (works with `routes/console.php`, `bootstrap/app.php` and the legacy `app/Console/Kernel.php`)
