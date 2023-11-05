<?php

namespace App\Commands;

use CodeIgniter\Database\Seeder;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;
use Config\Services;
use Throwable;

class Reset extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Shafima';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'db:reset';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Reset structure and records on database.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'db:reset [options]';

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [
        '--structure-only' => 'Resetting without seeder'
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $argument = array_shift($params);
        $argument = strtolower(trim($argument));

        if ($argument == 'help') {
            return $this->showHelp();
        }

        try {
            CLI::write('Loading ...', 'yellow');

            $migration = Services::migrations();
            $seeder = new Seeder(new Database());

            CLI::wait(2);
            CLI::write('Loading [done]', 'green');

            // migrate:rollback
            CLI::write('Deleting database structure ...', 'yellow');

            $batch = $migration->getLastBatch() - 1;

            if (!$migration->regress($batch)) {
                CLI::error(lang('Migrations.generalFault'), 'light_gray', 'red');
            }

            $messages = $migration->getCliMessages();
            foreach ($messages as $message) {
                CLI::write($message);
            }

            CLI::write('Deleting database structure [done]', 'green');

            // migrate
            CLI::write('Rebuild database structure ...', 'yellow');

            $migration->clearCliMessages();
            $migration->setNamespace(null);

            if (!$migration->latest(null)) {
                CLI::error(lang('Migrations.generalFault'), 'light_gray', 'red');
            }

            $messages = $migration->getCliMessages();
            foreach ($messages as $message) {
                CLI::write($message);
            }

            CLI::write('Rebuild database structure [done]', 'green');

            // run seeder 'Run'
            CLI::write('Inserting default data into database ...', 'yellow');

            $seeder->setSilent(true);
            $structurOnly = CLI::getOption('structure-only');

            if (!$structurOnly) {
                $seeder->call('Run');

                CLI::write('Inserting default data into database [done]', 'green');
            } else {
                CLI::write('Ignores inserting default data', 'green');
            }

            CLI::newLine();
            CLI::write('All processes have been completed', 'green');
            CLI::newLine();
        } catch (Throwable $e) {
            $this->showError($e);
        }
    }
}
