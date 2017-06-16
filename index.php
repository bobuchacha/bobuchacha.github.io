<?php
/**
 * Created by PhpStorm.
 * User: bobuchacha
 * Date: 2/25/17
 * Time: 2:12 PM
 */

include_once('../_version_control.php');
global $APP_VERSION, $APP_PATH;

$requestedFile = $_GET['f'];
$filePath = "{$APP_PATH}/locales/{$requestedFile}";


if (file_exists($filePath))
{

    $fp = fopen($filePath, 'rb');

    if ($fp)
    {

        // Optional never cache
        //  header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
        //  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        //  header('Pragma: no-cache');

        // Optional cache if not changed
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($filePath)).' GMT');

        // Optional send not modified
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) and
            filemtime($filePath) == strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']))
        {
            header('HTTP/1.1 304 Not Modified');
        }

        header('Content-Type: application/javascript');
        header('Content-Length: '.filesize($filePath));

        fpassthru($fp);

        exit;
    }
}else{
    echo "{'message':'FILE NOT FOUND!'}";
}