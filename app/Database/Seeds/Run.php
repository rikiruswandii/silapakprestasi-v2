<?php

namespace App\Database\Seeds;

use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;
use Throwable;

class Run extends Seeder
{
    protected $seeds = [
        'settings',
        'users',
        'categories',
        'news',
        'sectors',
        'regulations'
    ];

    private function showError(Throwable $e)
    {
        $exception = $e;
        $message   = $e->getMessage();

        require APPPATH . 'Views/errors/cli/error_exception.php';
    }

    public function run()
    {
        try {
            foreach ($this->seeds as $seed) {
                $seed = ucfirst($seed);
                $this->call($seed);

                $class = APP_NAMESPACE . '\Database\Seeds\\' . $seed;
                $message = sprintf(
                    "\t%s %s",
                    CLI::color('Seeded: ', 'yellow'),
                    $class
                );
                CLI::write($message);
            }
        } catch (Throwable $e) {
            $this->showError($e);
        }
    }
}
