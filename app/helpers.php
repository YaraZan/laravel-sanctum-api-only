<?php

use Illuminate\Support\Facades\File;

if (!function_exists('write_env')) {
    /**
     * Set or update an environment variable in the .env file.
     */
    function write_env($key, $value)
    {
        $envPath = base_path('.env');

        if (File::exists($envPath)) {
            $content = File::get($envPath);

            if (strpos($content, "$key=") !== false) {
                $content = preg_replace("/^$key=.*/m", "$key=$value", $content);
            } else {
                $content .= "\n$key=$value\n";
            }

            File::put($envPath, $content);
        }
    }
}
