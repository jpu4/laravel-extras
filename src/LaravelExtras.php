<?php

namespace Jpu4\LaravelExtras;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LaravelExtras
{
    /**
     * Generate CRUD files for a given model.
     *
     * @param  string  $model
     * @return array
     */
    public function generateCrud(string $model): array
    {
        $model = Str::studly($model);
        $stubPath = __DIR__.'/../stubs/';
        $config = config('laravel-extras');
        
        $files = [];
        
        // Generate model
        $files[] = $this->generateFile(
            $stubPath.'model.stub',
            $config['paths']['models'] . "/{$model}.php",
            $this->getReplacements($model, 'Model')
        );
        
        // Generate controller
        $files[] = $this->generateFile(
            $stubPath.'controller.stub',
            $config['paths']['controllers'] . "/{$model}Controller.php",
            $this->getReplacements($model, 'Controller')
        );
        
        // Generate request
        $files[] = $this->generateFile(
            $stubPath.'request.stub',
            $config['paths']['requests'] . "/{$model}Request.php",
            $this->getReplacements($model, 'Request')
        );
        
        // Generate migration
        $migrationName = date('Y_m_d_His') . '_create_' . Str::snake(Str::plural($model)) . '_table';
        $files[] = $this->generateFile(
            $stubPath.'migration.stub',
            $config['paths']['migrations'] . "/{$migrationName}.php",
            $this->getReplacements($model, 'Migration')
        );
        
        // Generate views
        $viewPath = $config['paths']['views'] . '/' . Str::kebab(Str::plural($model));
        File::ensureDirectoryExists($viewPath);
        
        foreach (['index', 'create', 'edit', 'show', 'form'] as $view) {
            $files[] = $this->generateFile(
                $stubPath.'views.stub',
                "{$viewPath}/{$view}.blade.php",
                array_merge($this->getReplacements($model, 'View'), ['{{ view }}' => $view])
            );
        }
        
        // Add routes
        $routeContent = view('laravel-extras::routes', [
            'model' => $model,
            'modelVariable' => Str::camel($model),
            'routeName' => Str::kebab(Str::plural($model)),
        ])->render();
        
        File::append(
            base_path('routes/web.php'),
            "\n" . $routeContent . "\n"
        );
        
        return $files;
    }
    
    /**
     * Generate a file from a stub.
     */
    protected function generateFile(string $stubPath, string $targetPath, array $replacements): string
    {
        $content = file_get_contents($stubPath);
        $content = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $content
        );
        
        File::ensureDirectoryExists(dirname($targetPath));
        file_put_contents($targetPath, $content);
        
        return $targetPath;
    }
    
    /**
     * Get the replacements for the given model and type.
     */
    protected function getReplacements(string $model, string $type): array
    {
        $config = config('laravel-extras');
        $modelPlural = Str::plural($model);
        $modelVariable = Str::camel($model);
        $modelPluralVariable = Str::camel($modelPlural);
        $modelKebab = Str::kebab($model);
        $modelKebabPlural = Str::kebab($modelPlural);
        
        $replacements = [
            'DummyNamespace' => $config['namespace'][strtolower($type)] ?? $config['namespace']['models'],
            'DummyClass' => $model . ($type === 'Controller' ? 'Controller' : $type),
            'DummyModel' => $model,
            'DummyModelPlural' => $modelPlural,
            'dummy' => Str::camel($model),
            'dummies' => Str::camel($modelPlural),
            'Dummy' => $model,
            'Dummies' => $modelPlural,
            'dummy_model' => Str::snake($model),
            'dummy_models' => Str::snake($modelPlural),
            'dummy-model' => $modelKebab,
            'dummy-models' => $modelKebabPlural,
            'dummyVariable' => $modelVariable,
            'dummyVariables' => $modelPluralVariable,
            'DummyVariable' => ucfirst($modelVariable),
            'DummyVariables' => ucfirst($modelPluralVariable),
            'dummy_route' => $modelKebab,
            'dummy_routes' => $modelKebabPlural,
            'DummyRoute' => Str::studly($modelKebab),
            'DummyRoutes' => Str::studly($modelKebabPlural),
            'dummy.view' => $modelKebabPlural . '.index',
            'dummy_table' => Str::snake($modelPlural),
            'DummyRequest' => $model . 'Request',
        ];
        
        return $replacements;
    }
}
