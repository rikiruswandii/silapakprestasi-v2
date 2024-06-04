<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;
use Ifsnop\Mysqldump\Mysqldump;
use Throwable;

class Backup extends BaseCommand
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
    protected $name = 'db:backup';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Backup records from database.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'db:backup <filename>.sql [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'filename' => 'Destination database filename.'
    ];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [
        '--database-group' => 'Database group to be backed up. Default: "default"',
        '--auto-increment' => 'Reset auto increment. Default: true',
        '--add-locks' => 'Add locks. Default: false',
        '--no-info' => 'No create info. Default: true',
        '--skip-comments' => 'Skip comments. Default: true',
        '--foreign-keys-check' => 'Enable foreign keys check. Default: false'
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        try {
            $filename = array_shift($params);
            $filename = strtolower(trim($filename));

            if (empty($filename)) {
                $filename = CLI::prompt('Database filename', null, 'required');
            }

            /**
             * @var string
             */
            $databaseGroup = $params['database-group'] ??
                CLI::getOption('database-group') ?? 'default';
            /**
             * @var boolean
             */
            $autoIncrement = $params['auto-increment'] ??
                CLI::getOption('auto-increment') ?? true;
            /**
             * @var boolean
             */
            $addLocks = $params['add-locks'] ??
                CLI::getOption('add-locks') ?? false;
            /**
             * @var boolean
             */
            $noCreateInfo = $params['no-info'] ??
                CLI::getOption('no-info') ?? true;
            /**
             * @var boolean
             */
            $skipComments = $params['skip-comments'] ??
                CLI::getOption('skip-comments') ?? true;
            /**
             * @var boolean
             */
            $foreignKeys = $params['foreign-keys-check'] ??
                CLI::getOption('foreign-keys-check') ?? false;

            if (!$filename) {
                return $this->showHelp();
            }

            $fileinfo = pathinfo(ROOTPATH . $filename);
            $dirname = $fileinfo['dirname'];
            $filename = [
                $fileinfo['filename'],
                'sql'
            ];
            $filename = implode('.', $filename);

            $filepath = $dirname . DIRECTORY_SEPARATOR . $filename;
            if (file_exists($filepath)) {
                CLI::write('A file with the name "' . $filename . '" already exists.', 'light_gray', 'red');
                CLI::write('Please choose a different file name.', 'light_gray', 'red');
                return CLI::newLine();
            }

            $database = new Database();
            $connection = $database->{$databaseGroup};

            $db_host = $connection['hostname'] ?? 'localhost';
            $db_user = $connection['username'] ?? 'root';
            $db_pass = $connection['password'] ?? '';
            $db_name = $connection['database'] ?? 'codeigniter4';

            $settings = [
                'exclude-tables' => [
                    'migrations'
                ],
                'reset-auto-increment' => (bool) $autoIncrement,
                'add-locks' => (bool) $addLocks,
                'no-create-info' => (bool) $noCreateInfo,
                'skip-comments' => (bool) $skipComments,
                'disable-foreign-keys-check' => (bool) $foreignKeys
            ];

            CLI::write('Starting the backup process ...', 'yellow');

            $dump = new Mysqldump(
                "mysql:host=$db_host;dbname=$db_name",
                $db_user,
                $db_pass,
                $settings
            );
            $dump->start($filepath);

            CLI::wait(2);
            CLI::write('Successfully backed up data', 'green');
            CLI::newLine();
        } catch (Throwable $e) {
            $this->showError($e);
        }
    }
}
