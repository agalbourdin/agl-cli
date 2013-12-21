<?php
$currentDir = dirname(__FILE__) . DIRECTORY_SEPARATOR;

return array(

    // Copy main script.
    'file:copy' => array(
        array(
            $currentDir . 'agl',
            APP_PATH    . 'agl'
        )
    )
);
