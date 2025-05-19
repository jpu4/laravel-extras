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
                            {names* : The names of the resources (e.g., Post Comment)}
                            {--force : Overwrite existing files}
                            {--m|migration : Create a new migration file}
                            {--c|controller : Create a new controller}
                            {--r|requests : Create form request classes}
                            {--w|views : Create views}
                            {--a|all : Generate all CRUD files (default)}';

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
        $names = $this->argument('names');
        
        // If no specific options are provided, default to --all
        if (!$this->option('migration') && 
            !$this->option('controller') && 
            !$this->option('requests') && 
            !$this->option('views')) {
            $this->input->setOption('all', true);
        }
        
        $success = true;
        
        foreach ($names as $name) {
            if (!preg_match('/^[a-zA-Z_]+$/', $name)) {
                $this->error("Skipping '$name': Name may only contain letters and underscores.");
                $success = false;
                continue;
            }
            
            $name = Str::studly($name);
            
            try {
                $files = $this->laravelExtras->generateCrud($name);
                
                $this->info("✅ CRUD for '$name' generated successfully!");
                $this->line('');
                $this->info('📁 Generated files:');
                
                foreach ($files as $file) {
                    $this->line("  - <info>" . str_replace(base_path(), '', $file) . "</info>");
                }
                
                $this->line('');
            } catch (\Exception $e) {
                $this->error("❌ Failed to generate CRUD for '$name': " . $e->getMessage());
                if ($this->getOutput()->isVerbose()) {
                    $this->error($e->getTraceAsString());
                }
                $success = false;
            }
        }
        
        $this->info('🔗 Don\'t forget to register the routes in your web.php file!');
        
        return $success ? Command::SUCCESS : Command::FAILURE;
    }
}
