<?php namespace App\Library;

class Testera
{

    /**
     * Sanitizes a string, replacing whitespace and a few other characters with dashes.
     *
     * Limits the output to alphanumeric characters, underscore (_) and dash (-).
     * Whitespace becomes a dash.
     *
     * @param string $string The string to be sanitized.
     * @return string The sanitized string.
     */
    public static function string($string = null)
    {
        return ucfirst($string);
    }

    public function index()
    {
        return 'index';
    }
} 