<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'phpDocumentor\\Reflection\\' => array($vendorDir . '/phpdocumentor/reflection-common/src', $vendorDir . '/phpdocumentor/reflection-docblock/src', $vendorDir . '/phpdocumentor/type-resolver/src'),
    'Webmozart\\Assert\\' => array($vendorDir . '/webmozart/assert/src'),
    'Symfony\\Polyfill\\Ctype\\' => array($vendorDir . '/symfony/polyfill-ctype'),
    'Symfony\\Component\\Yaml\\' => array($vendorDir . '/symfony/yaml'),
    'Psr\\Http\\Message\\' => array($vendorDir . '/psr/http-factory/src', $vendorDir . '/psr/http-message/src'),
    'Psr\\Http\\Client\\' => array($vendorDir . '/psr/http-client/src'),
    'Prophecy\\' => array($vendorDir . '/phpspec/prophecy/src/Prophecy'),
    'Openpay\\Client\\' => array($baseDir . '/lib', $baseDir . '/test'),
    'GuzzleHttp7\\Psr7\\' => array($baseDir . '/vendor-static/guzzlehttp/psr7/src'),
    'GuzzleHttp7\\Promise\\' => array($baseDir . '/vendor-static/guzzlehttp/promises/src'),
    'GuzzleHttp7\\' => array($baseDir . '/vendor-static/guzzlehttp/guzzle/src'),
    'Doctrine\\Instantiator\\' => array($vendorDir . '/doctrine/instantiator/src/Doctrine/Instantiator'),
    'BusinessLayer\\Openpay\\' => array($baseDir . '/../businessLayer'),
);
