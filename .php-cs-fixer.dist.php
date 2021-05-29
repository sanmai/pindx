<?php

$header = <<<'EOF'
Copyright 2018 Alexey Kopytko <alexey@kopytko.com>

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
EOF;

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        'header_comment' => ['header' => $header, 'separate' => 'bottom', 'location' => 'after_open', 'comment_type' => 'PHPDoc'],

        '@Symfony:risky' => true,
        '@PHP71Migration:risky' => true,
        '@PHPUnit75Migration:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,

        'ordered_class_elements' => false,
        'phpdoc_to_comment' => false,
        'strict_comparison' => true,
        'comment_to_phpdoc' => true,
        'native_function_invocation' => ['include' => ['@internal'], 'scope' => 'namespaced'],
        'php_unit_test_case_static_method_calls' => false,
        'yoda_style' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
        ->in(__DIR__)
    )
    ->setCacheFile(__DIR__.'/build/cache/.php_cs.cache')
;

return $config;
