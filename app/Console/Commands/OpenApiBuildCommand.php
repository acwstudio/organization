<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\CssSelector\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

final class OpenApiBuildCommand extends Command
{
    protected $signature = 'openapi-build';

    protected $description = 'Collects dock totals from sources in the spec/folder in .yaml format';

    private string $srcPath = 'docs/v1/src/';
    private string $openApiFilePath = 'docs/v1/openapi.yaml';
    private string $buildFilePath = 'docs/v1/src/build.yaml';


    public function handle(): void
    {
        $fileName = $this->build();

        $this->info('Final documentation file ' . $fileName . ' successfully build!');
    }

    public function build(): string
    {
        $openApiFile = $this->parseYamlFile($this->buildFilePath);

        foreach ($openApiFile['paths'] as $key => $path) {
            $openApiFile['paths'][$key] = $this->parseYamlFile("{$this->srcPath}/$path");
        }

        foreach ($openApiFile['components'] as $type => $componentsPaths) {
            $components = [];

            foreach ($componentsPaths as $componentPath) {
                $components = array_merge($components, $this->parseYamlFile("/{$this->srcPath}$componentPath"));
            }
            $openApiFile['components'][$type] = $components;
        }

        return $this->buildOpenApiFile($openApiFile);
    }

    private function parseYamlFile(string $path)
    {
        try {
            return Yaml::parseFile(base_path($path));
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }

    private function buildOpenApiFile(array $openApiFile): string
    {
//        dd($openApiFile);
        $openApiFile = Yaml::dump($openApiFile, 2, 2);

        file_put_contents(base_path($this->openApiFilePath), $openApiFile);

        return $this->openApiFilePath;
    }
}
