<?php

namespace Jpu4\LaravelExtras\Console;

use Illuminate\Console\Command;
use Jpu4\LaravelExtras\LaravelExtras as LaravelExtrasService;
use Illuminate\Support\Str;

class MakeCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud 
                            {name : The name of the resource (e.g., Post)}
                            {--force : Overwrite existing files}
                            {--m|migration : Create a new migration file}
                            {--c|controller : Create a new controller}
                            {--r|requests : Create form request classes}
                            {--v|views : Create views}
                            {--a|all : Generate all CRUD files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a CRUD controller, model, migration, request, and views in one command.';

    /**
     * The LaravelExtras service instance.
     *
     * @var \Jpu4\LaravelExtras\LaravelExtras
     */
    protected $laravelExtras;

    /**
     * Create a new command instance.
     *
     * @param  \Jpu4\LaravelExtras\LaravelExtras  $laravelExtras
     * @return void
     */
    public function __construct(LaravelExtrasService $laravelExtras)
    {
        parent::__construct();
        $this->laravelExtras = $laravelExtras;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        
        if (!preg_match('/^[a-zA-Z_]+$/', $name)) {
            $this->error('The name may only contain letters and underscores.');
            return Command::FAILURE;
        }
        
        $name = Str::studly($name);
        
        try {
            $files = $this->laravelExtras->generateCrud($name);
            
            $this->info('CRUD generated successfully!');
            $this->line('');
            $this->info('Generated files:');
            
            foreach ($files as $file) {
                $this->line("- <info>" . str_replace(base_path(), '', $file) . "</info>");
            }
            
            $this->line('');
            $this->info('Don\'t forget to register the routes in your web.php file!');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to generate CRUD: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}
