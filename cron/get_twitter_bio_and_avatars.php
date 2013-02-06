<?php

    
    
    if (!$link = mysql_connect('localhost', 'loveluxe_luser', 'OA39E}q?6xEa')) {
        die();
    }
    
    if (!@mysql_select_db('loveluxe_live')) {
        mysql_close($link);
        die();
    }
    
    $sql = "SELECT id, twitter_name, avatar, bio FROM guest_list WHERE  last_update <= NOW() - INTERVAL 4 MINUTE AND ((avatar IS NULL OR avatar = '') OR (bio = '' OR bio IS NULL)) AND (twitter_name IS NOT NULL AND twitter_name <> '') LIMIT 50";

    $result = mysql_query($sql);

    $continue = false;
    
    if (mysql_num_rows($result) > 0) {
        $continue = true;
        
        $guests = array();

        while($row = mysql_fetch_object($result)) {
            $guests[] = $row;
        }
    }

    mysql_free_result($result);
    
    mysql_close($link);
    //close the db connection and reopen it later!

    
    if ($continue === true) {

        
        $sql = false;        
        foreach ($guests as &$guest) {

            if (!is_null($guest->twitter_name) && $guest->twitter_name != '') {
                //get bio and avatar from the twitter feed!
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, "https://api.twitter.com/1/users/show.xml?screen_name=" . str_replace('@', '', $guest->twitter_name));
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Expect:'));
                $result = curl_exec($curl_handle);
                curl_close($curl_handle);

                if ($result === false) {
                    continue;
                }

                $xmlData = new SimpleXMLElement($result);
                if ((!isset($xmlData->error) || !$xmlData->error) && (isset($xmlData->description) && isset($xmlData->profile_image_url))) {

                    $guest->bio = $xmlData->description;
                    $guest->avatar = $xmlData->profile_image_url;
                    $sql = true;
                }
                unset($xmlData);

            }
        }        

        if ($sql === true) {

            if (!$link = mysql_connect('localhost', 'loveluxe_luser', 'OA39E}q?6xEa')) {
                die();
            }
        
            if (!@mysql_select_db('loveluxe_live')) {
                mysql_close($link);
                die();
            }
            $sql = "";
            foreach ($guests as $guest) {
                if (!is_null($guest->bio) && $guest->bio != '') {
                    $sql = "UPDATE guest_list SET bio = '" . mysql_real_escape_string($guest->bio) . "', avatar = '" . mysql_real_escape_string($guest->avatar) . "' WHERE id = " . $guest->id . ";";
                    mysql_query($sql);   
                }

            }
            mysql_close($link);
            
        }
    }