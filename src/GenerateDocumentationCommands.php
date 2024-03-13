<?php

namespace Thicha0\LaravelDocumentationCommands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class GenerateDocumentationCommands extends Command
{
    protected $signature = 'generate:doc-commands';

    protected $description = 'Generate a HTML documentation of your custom commands';

    public function handle()
    {
        $commandsDirectory = app_path('Console/Commands');
        $customCommands = $this->getCustomCommands($commandsDirectory);

        $this->info('Found ' . count($customCommands) . ' custom commands.');

        // Render the Blade template 'documentation-commands' with the customCommands data
        $html = view('laravel-documentation-commands::documentation-commands', ['customCommands' => $customCommands])->render();

        // Define the path where you want to save the HTML file
        $htmlFilePath = public_path('documentation-commands.html');

        // Save the rendered HTML to the file
        file_put_contents($htmlFilePath, $html);

        $this->info('Custom command list generated at ' . $htmlFilePath);
    }

    protected function getCustomCommands($directory)
    {
        $cronCommands = $this->extractCommandsAndCron();

        $customCommands = [];

        foreach (File::allFiles($directory) as $file) {
            $className = str_replace(
                [base_path(), '/', '.php'],
                ['', '\\', ''],
                $file->getPathname()
            );

            // Get the folder name where the command is located
            $folderName = substr($className, 0, strrpos($className, '\\'));

            $reflectionClass = new ReflectionClass($className);
            if (!$reflectionClass->isAbstract()) {
                $command = resolve($className);

                if ($command instanceof Command) {
                    $signature = strtok($command->getSynopsis(), ' ');
                    $cronCommand = $this->findCommand($signature, $cronCommands);

                    // Use the folder name as the key to group the commands
                    $customCommands[basename($folderName)][] = [
                        'name' => basename($className),
                        'description' => $command->getDescription(),
                        'signature' => $command->getSynopsis(),
                        'cron' => $cronCommand,
                    ];
                }
            }
        }

        return $customCommands;
    }

    private function extractCommandsAndCron()
    {
        $scheduleDefinition = file_get_contents(app_path('Console/Kernel.php'));

        $matches = [];
        $pattern = '/\$schedule->command\(\'([^\']+)\'(?:\s*\.\s*\$[a-zA-Z0-9_]+\->[a-zA-Z0-9_]+)*\)\s*->(\w+)(?:\(([^)]*)\))?/';
        preg_match_all($pattern, $scheduleDefinition, $matches, PREG_SET_ORDER);

        $commandsAndCron = [];

        // Extract commands defined directly in schedule() method
        foreach ($matches as $match) {
            $commandName = $match[1];
            $method = $match[2];
            $parameter = $match[3];
            $commandsAndCron[] = [
                'command' => $commandName,
                'method' => $method,
                'parameter' => $parameter,
            ];
        }

        return $commandsAndCron;
    }

    private function findCommand($signature, $cronCommands)
    {
        foreach ($cronCommands as $cronCommand) {
            if ($cronCommand['command'] === $signature) {
                return $cronCommand;
            }
            if ($cronCommand['command'] === $signature . ' ') {
                return $cronCommand;
            }
        }

        return null;
    }

}
