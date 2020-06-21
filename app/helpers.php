<?php declare(strict_types=1);

use Slim\Exception\HttpException;

function abort($request, $msg, $code)
{
    throw new HttpException($request, $msg, $code);
}

function abort_if($condition, $request, $msg, $code)
{
    if ($condition) {
        throw new HttpException($request, $msg, $code);
    }
}

function getFileList($dir)
{
    // array to hold return value
    $retval = [];

    // add trailing slash if missing
    if (substr($dir, -1) != "/") {
        $dir .= "/";
    }

    // open pointer to directory and read list of files
    $d = @dir($dir) or die("getFileList: Failed opening directory {$dir} for reading");
    while (false !== ($entry = $d->read())) {
        // skip hidden files
        if ($entry{0} == "." || $entry{0} == "..") {
            continue;
        }
        if (is_dir("{$dir}{$entry}")) {
            $retval[] = [
              'name' => "{$dir}{$entry}/",
              'type' => filetype("{$dir}{$entry}"),
              'size' => 0,
              'lastmod' => filemtime("{$dir}{$entry}")
            ];
        }
    }
    $d->close();

    return $retval;
}
