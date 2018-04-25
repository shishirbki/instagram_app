<?php
/*
  Here we are define some configs variable for site uses.
 * **************** SITE SETTING ******************** */
$siteFolder = dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])));
$config['App.siteFolder'] = $siteFolder;
$config['App.SiteUrl'] = 'http://'.$_SERVER['HTTP_HOST'].$siteFolder;
$site_url = 'http://'.$_SERVER['HTTP_HOST'].$siteFolder;
if (isset($_SERVER['HTTPS'])) {
    if ($_SERVER['HTTPS'] == 'on') {
        $config['App.SiteUrl'] = 'https://'.$_SERVER['HTTP_HOST'].$siteFolder;
        $site_url = 'https://'.$_SERVER['HTTP_HOST'].$siteFolder;
    }
}
$config['App.SiteUrl'] = $site_url;

define('SITE_URL', $site_url);
define('SITE_ROOT', __DIR__);
