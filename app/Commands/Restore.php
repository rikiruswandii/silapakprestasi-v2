<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;

class Restore extends BaseCommand
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
    protected $name = 'db:restore';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Restore records to database.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'db:restore <filename>.sql [options]';

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
        '--database-group' => 'Database group to be backed up. Default: "default"'
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

            $fileinfo = pathinfo(ROOTPATH . $filename);
            $dirname = $fileinfo['dirname'];
            $filename = [
                $fileinfo['filename'],
                'sql'
            ];
            $filename = implode('.', $filename);

            $filepath = $dirname . DIRECTORY_SEPARATOR . $filename;
            if (!file_exists($filepath)) {
                CLI::write('File named "' . $filename . '" doesn\'t exist.', 'light_gray', 'red');
                return CLI::newLine();
            }

            CLI::write('Starting data restoration to database...', 'yellow');
            CLI::wait(2);
            CLI::newLine();

            $database = db_connect($databaseGroup);
            $tempLine = '';
            $lines = file($filepath);

            $totalSteps = count($lines);
            $currentStep = 1;

            foreach ($lines as $line) {
                // skip it if it's a comment
                if (substr($line, 0, 2) == '--' || $line == '') {
                    CLI::showProgress($currentStep++, $totalSteps);

                    continue;
                }
                CLI::showProgress($currentStep++, $totalSteps);

                // add this line to the current segment
                $tempLine .= $line;

                // if it has a semicolon at the end
                // it's the end of the query
                if (substr(trim($line), -1, 1) == ';') {
                    // perform the query
                    $perform = $database->query($tempLine);
                    if (!$perform) {
                        continue;
                    }

                    // reset temp variable to empty
                    $tempLine = '';
                }
            }

            CLI::showProgress(false);
            CLI::newLine();
            CLI::write('Successfully perform data restoration', 'green');
            CLI::newLine();
        } catch (Throwable $e) {
            $this->showError($e);
        }
    }
}
