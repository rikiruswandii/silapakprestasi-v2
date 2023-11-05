<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use splitbrain\PHPArchive\Zip;

class Predeploy extends BaseCommand
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
    protected $name = 'pre:deploy';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = '';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'pre:deploy';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * This function copy $source directory and all files
     * and sub directories to $destination folder
     * @param string $source
     * @param string $destination
     * @return void
     */
    private function recursiveCopy($source, $destination)
    {
        $dir = opendir($source);
        @mkdir($destination, 0777, true);
        $exclude = ['node_modules'];

        while ($file = readdir($dir)) {
            if ($file != '.' &&
                $file != '..' &&
                !in_array($file, $exclude)
            ) {
                if (is_dir($source . DIRECTORY_SEPARATOR . $file)) {
                    $this->recursiveCopy(
                        $source . DIRECTORY_SEPARATOR . $file,
                        $destination . DIRECTORY_SEPARATOR . $file
                    );
                } else {
                    @copy($source . DIRECTORY_SEPARATOR . $file, $destination . DIRECTORY_SEPARATOR . $file);
                }
            }
        }

        closedir($dir);
    }

    /**
     * Remove directory recursively
     * @param string $dir
     * @return void
     */
    private function rmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);

            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object) &&
                        !is_link($dir . DIRECTORY_SEPARATOR . $object)
                    ) {
                        $this->rmdir($dir . DIRECTORY_SEPARATOR . $object);
                    } else {
                        @unlink($dir . DIRECTORY_SEPARATOR . $object);
                    }
                }
            }

            @rmdir($dir);
        }
    }

    /**
     * Create archive file
     * @param string $dir
     * @param string $filename
     * @return void
     */
    private function archive($dir, $filename)
    {
        $zip = new Zip();
        $zip->create($filename);

        // directory listing
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // skip directories (they would be added automatically)
            if ($file->isDir()) {
                continue;
            }

            // get real and relative path for current file
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($dir) + 1);

            // add current file to archive
            $zip->addFile($filePath, $relativePath);
        }

        // zip archive will be created only after closing object
        $zip->close();
    }

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $build = ROOTPATH . 'build';
        // load filesystem helper first
        helper('filesystem');

        // clears cache
        CLI::write('Clearing cache ...', 'yellow');
        $this->call('cache:clear');
        CLI::newLine();

        // restore ".gitignore" file
        write_file(WRITEPATH . 'cache/.gitignore', "*\n!.gitignore\n");

        // clears all debugbar files
        CLI::write('Clearing debugbar ...', 'yellow');
        $this->call('debugbar:clear');

        // clears all log files
        CLI::write('Clearing logs ...', 'yellow');
        $this->call('logs:clear', [
            'force' => true
        ]);

        // clears all session
        CLI::write('Clearing session ...', 'yellow');
        delete_files(WRITEPATH . 'session');
        CLI::write('Clearing session [done]', 'green');
        CLI::newLine();

        // clean build folder
        CLI::write('Cleaning up build folder ...', 'yellow');
        if (file_exists($build) && is_dir($build)) {
            $this->rmdir($build);
        }

        @mkdir($build, 0777, true);
        CLI::write('Cleaning up build folder [done]', 'green');
        CLI::newLine();

        // copy public folder to build folder
        CLI::write('Copying public folder ...', 'yellow');
        $this->recursiveCopy(ROOTPATH . 'public', "$build/web");
        @copy(ROOTPATH . '.gitignore', "$build/web/.gitignore");

        CLI::write('Copying public folder [done]', 'green');
        CLI::newLine();

        // copy core files & folders to build folder
        CLI::write('Copying core files and folders to build folder ...', 'yellow');

        $folders = [
            'app',
            'writable'
        ];
        foreach ($folders as $folder) {
            @mkdir("$build/web_core/" . $folder, 0777, true);
            $this->recursiveCopy(ROOTPATH . $folder, "$build/web_core/$folder");
        }

        $files = [
            '.gitignore',
            'composer.json',
            'composer.lock',
            'env',
            'spark'
        ];
        foreach ($files as $file) {
            @copy(ROOTPATH . $file, "$build/web_core/$file");
        }

        CLI::write('Copying core files and folders to build folder [done]', 'green');
        CLI::newLine();

        // replace paths config file
        CLI::write('Replacing paths config file ...', 'yellow');
        $indexContent = @file_get_contents("$build/web/index.php");
        $indexContent = str_replace('../app/Config/Paths.php', '../web_core/app/Config/Paths.php', $indexContent);

        @file_put_contents("$build/web/index.php", $indexContent);
        CLI::write('Replacing paths config file [done]', 'green');
        CLI::newLine();

        CLI::write('Creating archive files ...', 'yellow');
        // create "web" archive file
        $this->archive("$build/web", "$build/web.zip");
        // create "web_core" archive file
        $this->archive("$build/web_core", "$build/web_core.zip");

        // done :3
        CLI::write('Creating archive files [done]', 'green');
    }
}
