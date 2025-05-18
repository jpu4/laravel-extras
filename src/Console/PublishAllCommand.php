<?php

namespace Jpu4\LaravelExtras\Console;

use Illuminate\Console\Command;

class PublishAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-extras:publish 
                            {--force : Overwrite any existing files} 
                            {--config : Publish only the config file} 
                            {--stubs : Publish only the stubs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all Laravel Extras resources and config files';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $force = $this->option('force');
        $publishConfig = $this->option('config') || !$this->option('stubs');
        $publishStubs = $this->option('stubs') || !$this->option('config');

        if ($publishConfig) {
            $this->call('vendor:publish', [
                '--provider' => 'Jpu4\\LaravelExtras\\Providers\\ExtrasServiceProvider',
                '--tag' => 'laravel-extras-config',
                '--force' => $force,
            ]);
            $this->info('Published configuration file.');
        }

        if ($publishStubs) {
            $this->call('vendor:publish', [
                '--provider' => 'Jpu4\\LaravelExtras\\Providers\\ExtrasServiceProvider',
                '--tag' => 'laravel-extras-stubs',
                '--force' => $force,
            ]);
            $this->info('Published stubs.');
        }

        if (!$publishConfig && !$publishStubs) {
            $this->info('No resources published. Use --config, --stubs, or no options to publish all.');
        } else {
            $this->info('Laravel Extras resources published successfully!');
        }

        return Command::SUCCESS;
    }
}
