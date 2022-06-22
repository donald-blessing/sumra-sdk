<?php

namespace Sumra\SDK\Console;
use Illuminate\Console\Command;

class PublishSettingsConfigCommand extends Command
{
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sumra:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Settings config';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Publishing Settings');
         
         $this->publish(
            realpath(__DIR__ . '/../../config') . '/settings.php',
            base_path('config'), 'settings.php');
    }

    private function publish($source, $destination, $filename) {

        if (! is_dir($destination)) {
            if (! mkdir($destination, 0755, true)) {
                \Log::error("Can't create path");
            }
        }

        if (! is_writable($destination)) {
            if (! chmod($destination, 0755)) {
                \Log::error('Destination path is not writable');
            }
        }

        if (file_exists($source)) {
            if (! copy($source, $destination . '/' . $filename)) {
                \Log::error('File was not copied');
            }
        }
    }
}
