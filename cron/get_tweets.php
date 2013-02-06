<?php

    
    
    if (!$link = mysql_connect('localhost', 'loveluxe_luser', 'OA39E}q?6xEa')) {
        die();
    }
    
    if (!@mysql_select_db('loveluxe_live')) {
        mysql_close($link);
        die();
    }
    
    $sql = "SELECT id, tweettime FROM twitfeed WHERE feed = 'loveluxeblog' AND lasttime <= NOW() - INTERVAL 4 MINUTE";

    $result = mysql_query($sql);

    $continue = false;
    
    if (mysql_num_rows($result) > 0) {
        $continue = true;
        
        $tweets = array();

        while($row = mysql_fetch_array($result)) {
            $tweets[$row['tweettime']] = $row['id'];
        }
    }

    mysql_free_result($result);
    
    mysql_close($link);
    //close the db connection and reopen it later!
    if ($continue === true) {
        
        //get something from the twitter feed!
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, "http://twitter.com/statuses/user_timeline/loveluxeblog.xml?count=10");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Expect:'));
        $result = curl_exec($curl_handle);
        curl_close($curl_handle);
        
        
        
        
        if ($result === false) {
            die();
        }
        $xmlData = new SimpleXMLElement($result);
        
        
        if (!$link = mysql_connect('localhost', 'loveluxe_luser', 'OA39E}q?6xEa')) {
            die();
        }
        
        if (!@mysql_select_db('loveluxe_live')) {
            mysql_close($link);
            die();
        }

        
        if ((!isset($xmlData->error) || !$xmlData->error) && isset($xmlData->status)) {
            $sql = "";
            foreach ($xmlData->status as $stat) {
                $twitterarr = explode(" ",(string)($stat->text));
                $text = "";
                foreach ($twitterarr as $bit) {
                    if (stripos($bit,"@") !== false) {
                        $text .= "<a onclick=\"pageTracker._trackEvent('Twitter', 'View " . str_replace("@","",$bit) . "');\" href=\"http://twitter.com/" . str_replace("@","",$bit) . "\">" . $bit . "</a> ";
                    } elseif (stripos($bit,"http://") !== false) {
                        $text .= "<a href=\"" . $bit . "\" onclick=\"pageTracker._trackEvent('Twitter', 'View " .  $bit . "');\">" . $bit . "</a> ";
                    } else {
                        $text .= $bit . " ";
                    }
                }
                unset($twitterarr);
                $sql .= ($sql == "") ? "" : ",";
                $sql .= "('" . mysql_real_escape_string($text) . "', NOW(), 'loveluxeblog', '" . mysql_real_escape_string((string)$stat->created_at) . "', '" . mysql_real_escape_string(strtotime((string)$stat->created_at)) . "', '" . mysql_real_escape_string((string)$stat->retweet_count) . "', '" . mysql_real_escape_string((string)$stat->user->screen_name) . "', '" . mysql_real_escape_string((string)$stat->user->profile_image_url) . "', '" . MD5(strip_tags((string)$stat->text))  . "')";
            }
            
            
            
            if ($sql != "") {
                
                //see if the tweets are any different?
                
                if (isset($tweets[(string)$xmlData->status[0]->created_at])) {
                    //no new tweets!
                    //so do not insert into db!
                    $continue = false;
                }
                
                
                if ($continue === true) {
                    mysql_query("INSERT INTO twitfeed (tweet, lasttime, feed, tweettime, tweettime_unix, retweet_count, tweet_by, profile_image, plain_tweet_text) VALUES " . $sql);
                    if (is_array($tweets) && !empty($tweets)) {
                        mysql_query("DELETE FROM twitfeed WHERE feed = 'loveluxeblog' AND id IN (" . implode($tweets, ',') . ")");
                    }
                }
                unset($tweets);
            }
            unset($xmlData);

            mysql_close($link);
            
        }   
        
    }
    
    
    
    
