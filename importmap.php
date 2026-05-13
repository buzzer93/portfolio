<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo' => [
        'version' => '8.0.23',
    ],
    'scrollreveal' => [
        'version' => '4.0.9',
    ],
    'tealight' => [
        'version' => '0.3.6',
    ],
    'rematrix' => [
        'version' => '0.3.0',
    ],
    'miniraf' => [
        'version' => '1.0.0',
    ],
    'is-dom-node' => [
        'version' => '1.0.4',
    ],
    'is-dom-node-list' => [
        'version' => '1.2.1',
    ],
];
