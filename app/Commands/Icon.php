<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use GuzzleHttp\Client;

class Icon extends BaseCommand
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
    protected $name = 'icon:update';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Collecting icons from multiple providers.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'icon:update <provider>';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'provider' => 'Icon provider name. Default: "tabler"'
    ];

    /**
     * Tabler icon parser
     */
    private function tabler()
    {
        $baseurl = 'https://tabler-icons.io/icons.json';

        CLI::write('Initialing scraper client', 'green');
        $client = new Client([
            'verify' => false
        ]);
        CLI::wait(2);

        CLI::write('Send request to destination url ...', 'yellow');
        $crawler = $client->request('GET', $baseurl);
        $response = $crawler->getBody();
        $icons = json_decode($response);
        CLI::write('Successfully sent request', 'green');
        CLI::newLine();

        CLI::write('Scraping existing icons', 'yellow');
        $result = [];
        CLI::wait(2);

        $totalSteps = (int) count($icons);
        $currentStep = 1;

        foreach ($icons as $icon) {
            CLI::showProgress($currentStep++, $totalSteps);

            $result[] = [
                'name' => $icon->n,
                'svg' => $icon->s
            ];
        }

        CLI::showProgress(false);

        @unlink(WRITEPATH . '/data/tabler-icons.json');
        write_file(WRITEPATH . '/data/tabler-icons.json', json_encode($result));
    }

    /**
     * Method for displaying "done" message.
     *
     * @param string $provider
     */
    private function done(string $provider)
    {
        CLI::newLine();
        CLI::write("$provider icon parsing was successful", 'green');
        CLI::newLine();
    }

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $provider = array_shift($params);
        $provider = strtolower(trim($provider));
        $name = ucwords($provider) ?: 'Tabler';

        switch ($provider) {
            case 'help':
                $this->showHelp();
                break;

            case 'tabler':
            default:
                $this->tabler();
                $this->done($name);
        }
    }
}
