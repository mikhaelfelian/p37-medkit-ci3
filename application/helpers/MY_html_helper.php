<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('pre')) {
    /**
     * Debug variable with pre tags
     * 
     * @param mixed $data Data to debug
     * @param bool $die Stop execution after output (default: false)
     * @param bool $add_style Add styling to pre tag (default: false)
     * @return void
     */
    function pre($data, $die = false, $add_style = false) {
        $style = '';
        if ($add_style) {
            $style = 'style="
                background: #f4f4f4;
                border: 1px solid #ddd;
                border-left: 3px solid #f36d33;
                color: #666;
                page-break-inside: avoid;
                font-family: monospace;
                font-size: 15px;
                line-height: 1.6;
                margin-bottom: 1.6em;
                max-width: 100%;
                overflow: auto;
                padding: 1em 1.5em;
                display: block;
                word-wrap: break-word;
                position: relative;
                z-index: 9999; "';
        }
        
        echo "<pre {$style}>";
        
        if (is_array($data) || is_object($data)) {
            print_r($data);
        } else {
            var_dump($data);
        }
        
        echo "</pre>";
        
        if ($die) {
            die();
        }
    }
}

if (!function_exists('pre_json')) {
    /**
     * Debug variable as formatted JSON
     * 
     * @param mixed $data Data to debug as JSON
     * @param bool $die Stop execution after output
     * @return void
     */
    function pre_json($data, $die = false) {
        pre(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), $die);
    }
}

if (!function_exists('pre_debug')) {
    /**
     * Debug variable with backtrace information
     * 
     * @param mixed $data Data to debug
     * @param bool $die Stop execution after output
     * @return void
     */
    function pre_debug($data, $die = false) {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        
        $debug_info = [
            'File' => $trace['file'],
            'Line' => $trace['line'],
            'Time' => date('Y-m-d H:i:s'),
            'Data' => $data
        ];
        
        pre($debug_info, $die);
    }
}

if (!function_exists('pre_table')) {
    /**
     * Display array data as HTML table
     * 
     * @param array $data Array data to display
     * @param bool $die Stop execution after output
     * @return void
     */
    function pre_table($data, $die = false) {
        if (!is_array($data)) {
            pre($data, $die);
            return;
        }
        
        echo '<table style="
            border-collapse: collapse;
            width: 100%;
            margin: 1em 0;
            background: #f4f4f4;
            font-family: monospace;
            font-size: 14px;">';
        
        // Headers
        if (count($data) > 0) {
            echo '<tr>';
            foreach (array_keys(reset($data)) as $header) {
                echo '<th style="
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                    background: #f36d33;
                    color: white;">' . htmlspecialchars($header) . '</th>';
            }
            echo '</tr>';
        }
        
        // Data
        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $value) {
                echo '<td style="border: 1px solid #ddd; padding: 8px;">';
                if (is_array($value) || is_object($value)) {
                    pre($value);
                } else {
                    echo htmlspecialchars((string)$value);
                }
                echo '</td>';
            }
            echo '</tr>';
        }
        
        echo '</table>';
        
        if ($die) {
            die();
        }
    }
}

if (!function_exists('pre_log')) {
    /**
     * Log debug data to file
     * 
     * @param mixed $data Data to log
     * @param string $type Log type (debug|info|error)
     * @return void
     */
    function pre_log($data, $type = 'debug') {
        $CI =& get_instance();
        
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        $log_data = [
            'Time' => date('Y-m-d H:i:s'),
            'File' => $trace['file'],
            'Line' => $trace['line'],
            'Data' => $data
        ];
        
        $CI->load->helper('file');
        $log_path = APPPATH . 'logs/pre_debug_' . date('Y-m-d') . '.log';
        
        $log_message = "\n" . str_repeat('=', 80) . "\n";
        $log_message .= "{$type} Log @ " . date('Y-m-d H:i:s') . "\n";
        $log_message .= str_repeat('-', 80) . "\n";
        $log_message .= print_r($log_data, true);
        $log_message .= str_repeat('=', 80) . "\n";
        
        write_file($log_path, $log_message, 'a');
    }
}

if (!function_exists('pre_r')) {
    /**
     * Shorthand for print_r with pre tags
     */
    function pre_r($data) {
        pre($data, false);
    }
}

if (!function_exists('pre_d')) {
    /**
     * Short
     */
    function pre_d($data) {
        pre($data, false);
    }
}