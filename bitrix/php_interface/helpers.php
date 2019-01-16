<?php

/**
 * Given a file, i.e. /css/base.css, replaces it with a string containing the
 * file's mtime, i.e. /css/base.1221534296.css
 * Need: RewriteRule ^(.*)\.[\d]{10}\.(css|js)$ $1.$2 [L]
 * https://stackoverflow.com/a/118886
 *
 * @param $file  The file to be loaded. Must be an absolute path (i.e. starting with slash).
 */
function autoVersion($file)
{
    if(strpos($file, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
        return $file;

    $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
    //return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
    return $file . "?m={$mtime}";
}
