<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['pre'] = [
    // Default styling
    'style' => [
        'background' => '#f4f4f4',
        'border' => '1px solid #ddd',
        'border-left' => '3px solid #f36d33',
        'color' => '#666',
        'font-family' => 'monospace',
        'font-size' => '15px',
        'padding' => '1em 1.5em'
    ],
    
    // Logging options
    'log' => [
        'enabled' => true,
        'path' => APPPATH . 'logs/pre_debug/',
        'file_prefix' => 'debug_',
        'extension' => '.log'
    ],
    
    // Table styling
    'table' => [
        'header_bg' => '#f36d33',
        'header_color' => '#ffffff',
        'cell_padding' => '8px',
        'border_color' => '#ddd'
    ]
]; 