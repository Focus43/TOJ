<?php
	$env = $_SERVER['SERVER_NAME'];
  if($env === 'localhost'){
    $creds = 'local';
  } else if($env === 'toj.stage01.focusfortythree.com'){
    $creds = 'stage';
  } else {
    $creds = 'prod';
  }
  require_once dirname(__FILE__).'/site.'.$creds.'.php';

  // enable all url rewriting
  define('URL_REWRITING_ALL', true);
  // connect to Redis cache
  define('REDIS_CONNECTION_HANDLE', '127.0.0.1:6379');
  // the following depend on the constant REDIS_CONNECTION_HANDLE being defined
  if( defined('REDIS_CONNECTION_HANDLE') ){
      // use Redis as the page cache library
      define('PAGE_CACHE_LIBRARY', 'Redis');
      // if using the FluidDNS package
      define('PAGE_TITLE_FORMAT', '%2$s');
  }

	// server variables are set by Pagoda, or by you in site.local.php
	define('DB_SERVER',     $_SERVER['DB1_HOST']);
  define('DB_USERNAME',   $_SERVER['DB1_USER']);
  define('DB_PASSWORD',   $_SERVER['DB1_PASS']);
	define('DB_DATABASE',   $_SERVER['DB1_NAME']);
	define('PASSWORD_SALT', '6NVukfgwAgqaOi3SMlsWwEqURSe4Xh8pBApvhOauP7blC2kx1FKsHxcjGSXMqP3N');
	
	// marketplace settings and such
	define('ENABLE_MARKETPLACE_SUPPORT', false);
	
	// sitemap.xml file
	define('SITEMAPXML_FILE', 'files/sitemap.xml');

    // needed for the news page attribute updating to propagate immediately
    define('ENABLE_PROGRESSIVE_PAGE_REINDEX', false);

    define('EMAIL_DEFAULT_FROM_ADDRESS', 'website@townofjackson.com');
    define('EMAIL_ADDRESS_FORGOT_PASSWORD', EMAIL_DEFAULT_FROM_ADDRESS);
    define('EMAIL_DEFAULT_FROM_NAME', 'Town Of Jackson');
