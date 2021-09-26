<?php

namespace App\Utilities;
use \App\Utilities\Response;
class CacheUtility
{
    protected static $cache_file = null;
    protected static $cache_enabled = CACHE_ENABLED;
    const EXPIRE_TIME = 3600; // 1 hour

    public static function init()
    {
        self::$cache_file = CACHE_DIR . '/cache' . md5($_SERVER['REQUEST_URI']) . '.json';
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            self::$cache_enabled = 0;
        }
    }
    public static function cache_exists()
    {
        
        return (file_exists(self::$cache_file) && (time() - self::EXPIRE_TIME) < filemtime(self::$cache_file));
    }

    public static function start()
    {
        self::init();
        if (!self::$cache_enabled)
            return;
            
        if (self::cache_exists()) {
            Response::setHeaders();
            // echo "<!-- Cached copy, generated " .date('H:i',filemtime(self::$cache_file)) . "-->\n";
            readfile(self::$cache_file);
            exit;
        }
        ob_start();
    }

    public static function end()
    {
        if (!self::$cache_enabled)
            return;
        # Cache the contents to a cache file
        $cachedfile = fopen(self::$cache_file, 'w');
        fwrite($cachedfile, ob_get_contents());
        fclose($cachedfile);
        // Alternative solution: file_put_contents(self::$cache_file,ob_get_contents());
        # Send the output to the browser
        ob_end_flush();
    }

    public static function flush()
    {
        $files = glob(CACHE_DIR . '*');     //get all file name
        foreach ($files as $file)           ////iterate files
            if (is_file($file))
                unlink($file);
    }
}
