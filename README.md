# laravel-documentation-commands

This package adds a laravel command that allows you to generate a HTML file that lists all your commands.

https://packagist.org/packages/thicha0/laravel-documentation-commands

## How to use ?
```
composer require thicha0/laravel-documentation-commands
```

Add the ServiceProvider to your `config/app.php`
```
'providers' => [
  ...
      Thicha0\LaravelDocumentationCommands\LaravelDocumentationCommandsServiceProvider::class,
  ...
]
```

The new command `php artisan generate:documentation-commands` should appear in the `php artisan list` command.

When launching the command, the HTML file will be generated to `public/documentation-commands.html`.

## Features

- Show signature and description of command
- Group commands by directory
- Ignores abstract commands
- Show if command is called a cron in Laravel Scheduler