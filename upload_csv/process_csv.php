<?php
    
    if (!$link = mysql_connect('localhost', 'loveluxe_luser', 'OA39E}q?6xEa')) {
        die();
    }
    
    if (!@mysql_select_db('loveluxe_live')) {
        mysql_close($link);
        die();
    }

    $sql = "SELECT * FROM guest_list WHERE last_update < NOW() - INTERVAL 1 MINUTE";
    
    $result = mysql_query($sql);

    $rows = array();
    
    while ($row = mysql_fetch_object($result)) {
        $rows[] = $row;   
    }

    mysql_free_result($result);

    mysql_close($link);

    foreach ($rows as &$row) {        
        //see if avatar is not set?

        if ($row->avatar == '' || is_null($row->avatar)) {

            //echo = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $row->email ) ) ) . "?&s=small";
            //die();
            
            //get the avatar from twitter?
            if ($row->twitter_name != '' && !is_null($row->twitter_name)) {
                $row->avatar = "http://api.twitter.com/1/users/profile_image/?scren_name=" . str_replace('@', '', $row->twitter_name);
            }
        }
        
        
    }