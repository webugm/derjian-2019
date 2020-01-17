<?php

error_reporting(0); // Set E_ALL for debuging

// load composer autoload before load elFinder autoload If you need composer
//require __DIR__ . '/vendor/autoload.php';

// elFinder autoload
require __DIR__ . '/autoload.php';
// ===============================================

// Enable FTP connector netmount
elFinder::$netDrivers['ftp'] = 'FTP';
// ===============================================

/**
 * # Dropbox volume driver need `composer require dropbox-php/dropbox-php:dev-master@dev`
 *  OR "dropbox-php's Dropbox" and "PHP OAuth extension" or "PEAR's HTTP_OAUTH package"
 * * dropbox-php: http://www.dropbox-php.com/
 * * PHP OAuth extension: http://pecl.php.net/package/oauth
 * * PEAR's HTTP_OAUTH package: http://pear.php.net/package/http_oauth
 *  * HTTP_OAUTH package require HTTP_Request2 and Net_URL2
 * @param mixed $attr
 * @param mixed $path
 * @param mixed $data
 * @param mixed $volume
 */
// // Required for Dropbox.com connector support
// // On composer
// elFinder::$netDrivers['dropbox'] = 'Dropbox';
// // OR on pear
// require_once __DIR__.DIRECTORY_SEPARATOR.'elFinderVolumeDropbox.class.php';

// // Dropbox driver need next two settings. You can get at https://www.dropbox.com/developers
// define('ELFINDER_DROPBOX_CONSUMERKEY',    '');
// define('ELFINDER_DROPBOX_CONSUMERSECRET', '');
// define('ELFINDER_DROPBOX_META_CACHE_PATH',''); // optional for `options['metaCachePath']`
// ===============================================

// // Required for Google Drive network mount
// // Installation by composer
// // `composer require google/apiclient:^2.0`
// // Enable network mount
// elFinder::$netDrivers['googledrive'] = 'GoogleDrive';
// // GoogleDrive Netmount driver need next two settings. You can get at https://console.developers.google.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL?cmd=netmount&protocol=googledrive&host=1"
// define('ELFINDER_GOOGLEDRIVE_CLIENTID',     '');
// define('ELFINDER_GOOGLEDRIVE_CLIENTSECRET', '');
// // Required case of without composer
// define('ELFINDER_GOOGLEDRIVE_GOOGLEAPICLIENT', '/path/to/google-api-php-client/vendor/autoload.php');
// ===============================================

// // Required for Google Drive network mount with Flysystem
// // Installation by composer
// // `composer require nao-pon/flysystem-google-drive:~1.1 nao-pon/elfinder-flysystem-driver-ext`
// // Enable network mount
// elFinder::$netDrivers['googledrive'] = 'FlysystemGoogleDriveNetmount';
// // GoogleDrive Netmount driver need next two settings. You can get at https://console.developers.google.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL?cmd=netmount&protocol=googledrive&host=1"
// define('ELFINDER_GOOGLEDRIVE_CLIENTID',     '');
// define('ELFINDER_GOOGLEDRIVE_CLIENTSECRET', '');
// ===============================================

// // Required for One Drive network mount
// //  * cURL PHP extension required
// //  * HTTP server PATH_INFO supports required
// // Enable network mount
// elFinder::$netDrivers['onedrive'] = 'OneDrive';
// // GoogleDrive Netmount driver need next two settings. You can get at https://dev.onedrive.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL/netmount/onedrive/1"
// define('ELFINDER_ONEDRIVE_CLIENTID',     '');
// define('ELFINDER_ONEDRIVE_CLIENTSECRET', '');
// ===============================================

// // Required for Box network mount
// //  * cURL PHP extension required
// // Enable network mount
// elFinder::$netDrivers['box'] = 'Box';
// // Box Netmount driver need next two settings. You can get at https://developer.box.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL"
// define('ELFINDER_BOX_CLIENTID',     '');
// define('ELFINDER_BOX_CLIENTSECRET', '');
// ===============================================

/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume)
{
    return 0 === mb_strpos(basename($path), '.')// if file/folder begins with '.' (dot)
     ? !('read' == $attr || 'write' == $attr) // set read+write to false, other (locked+hidden) set to true
     : null; // else elFinder decide it itself
}
require_once dirname(dirname(dirname(__DIR__))) . '/head.php';
$mdir = "ck";

$image_max_width =  640;
$image_max_height = 640;
// Documentation for connector options:
// https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
$opts = [
    'bind' => [
        'upload.presave' => [
            'Plugin.AutoResize.onUpLoadPreSave',
        ],
    ],
    'plugin' => [
        'AutoResize' => [
            'enable' => true, // For control by volume driver
            'maxWidth' => $image_max_width, // Path to Water mark image
            'maxHeight' => $image_max_height, // Margin right pixel
            'quality' => 95, // JPEG image save quality
        ],
    ],
    // 'debug' => true,
    'locale' => 'zh_TW.UTF-8',
    'roots' => [
        [
            'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
            'path' => _WEB_PATH . "/uploads/{$mdir}/{$_GET['type']}/", // path to files (REQUIRED)
            'URL' => _WEB_URL . "/uploads/{$mdir}/{$_GET['type']}/", // URL to files (REQUIRED),
            'plugin' => [
                'AutoResize' => [
                    'enable' => true, // For control by volume driver
                    'maxWidth' => $image_max_width, // Path to Water mark image
                    'maxHeight' => $image_max_height, // Margin right pixel
                ],
            ],
            'uploadDeny' => ['text/php', 'text/x-php', 'application/php', 'application/x-php', 'application/x-httpd-php', 'application/x-httpd-php-source'], // All Mimetypes not allowed to upload
            'uploadAllow' => ['all'], // Mimetype `image` and `text/plain` allowed to upload
            'uploadOrder' => ['allow', 'deny'], // allowed Mimetype `image` and `text/plain` only
            'accessControl' => 'access', // disable and hide dot starting files (OPTIONAL)
            // 'acceptedName'  => '/^\w[\w\s\.\%\-\(\)\[\]]*$/u',
        ],
    ],
];

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();
