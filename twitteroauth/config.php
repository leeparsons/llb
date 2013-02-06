<?php

/**
 * @file
 * A single location to store configuration.
 */

define('CONSUMER_KEY', 'L2JKySqFM3xXLK4GQeiPA');
define('CONSUMER_SECRET', 'kVHEYZx5soFVGrJfp28nNSBOTpRm592Og9FvY7EYQ0');
    if (!isset($oauth_callback)) {
define('OAUTH_CALLBACK', 'http://www.loveluxeblog.com/twitteroauth/callback.php');
    } else {
        define('OAUTH_CALLBACK', $oauth_callback);
        
    }
