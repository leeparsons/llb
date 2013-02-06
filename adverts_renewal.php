<?php
    
    
    //$host = '127.0.0.1';
    
    $host = 'localhost';
    
    //$user = 'root';
    
    $user = 'loveluxe_luser';
    
    $pw = 'OA39E}q?6xEa';
    //$pw = '';
    
    //$db = 'loveluxeblog_wp';
    $db = 'loveluxe_live';
    
    /**
     
     This script gets the 10 most recent hashtags and then gets all the social posts about those ten.
     
     Another script handles the rest!
     
     **/
    
    
    
    if (!$link = mysql_connect($host, $user, $pw)) {
        die();
    }
    
    
    
    if (!@mysql_select_db($db)) {
        mysql_close($link);
        die();
    }
    
    $sql = "select 
    
    DISTINCT(meta_value) AS meta_value
    
    from wp_postmeta
    
    inner join wp_posts on wp_posts.ID = wp_postmeta.post_id and post_status = 'publish' and post_date < now()
    
    where meta_key = 'social_media_hash_tag'
    
    ORDER BY post_date DESC LIMIT 10
    ";
    
    
    
    $result = mysql_query($sql);
    $hashes = array();
    
    if (mysql_num_rows($result) > 0) {
        
        while($row = mysql_fetch_array($result)) {
            $mv = str_replace('#', '', $row['meta_value']);
            $hashes[$mv] = array($mv, '', '');
        }
    }
    
    mysql_free_result($result);
    
    $feeds = array();

    //now we have all the possible meta values, get the possible tweets and facebook posts
    if (!empty($hashes)) {
        
        $implodeHashes = array();
        
        foreach ($hashes as $hashKey => $hash) {
            $implodeHashes[$hashKey] = $hashKey;
        }
        
        $sql = "UPDATE twitfeed SET fetching = 1 WHERE (lasttime <= NOW() - INTERVAL 4 MINUTE OR refresh_url IS NOT NULL)
        
        AND 
        
        feed IN ('" . implode("','", $implodeHashes)  . "') 
        
        AND tweet <> ''
        
        AND fetching = 0";

        mysql_query($sql);
        
        $sql = "SELECT feed, tweet, lasttime, refresh_url FROM twitfeed  WHERE (lasttime <= NOW() - INTERVAL 4 MINUTE OR refresh_url IS NOT NULL)
        
        AND 
        
        feed IN ('" . implode("','", $implodeHashes)  . "') 
        
        AND tweet <> ''
        
        GROUP BY feed
        
        ORDER BY tweettime_unix DESC";
        

        
        $result = mysql_query($sql);
        
        if (mysql_num_rows($result) > 0) {
            
            while($row = mysql_fetch_array($result)) {
                $feeds[$row['feed']] = array($row['feed'], $row['tweet'], $row['refresh_url']);
            }
            
        }
        
    	mysql_free_result($result);
        
        
    }

    
    
    mysql_close($link);
    
    //if key exists in hashes and does not exist in feeds keep it
    $feeds = array_merge($hashes, $feeds);
    
    //close the db connection and reopen it later!
    if (!empty($feeds)) {
        $results = array();
        foreach ($feeds as $feedKey => $feed) {

            set_time_limit(35);
            
            //get something from the twitter feed!
            $curl_handle = curl_init();
            
            if (isset($feed[2]) && !empty($feed[2])) {
                curl_setopt($curl_handle, CURLOPT_URL, "http://search.twitter.com/search.json" . $feed[2]);   
            } else {
                curl_setopt($curl_handle, CURLOPT_URL, "http://search.twitter.com/search.json?q=" . $feedKey . "&rpp=10&include_entities=true&result_type=mixed&show_user=true");
            }
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Expect:'));
            $result = curl_exec($curl_handle);
            curl_close($curl_handle);
            
            
            $result = json_decode($result);

            if (!is_array($result->results) || isset($result->error)) {
                continue;
            }
            
            $result->wp_feed = $feed;
            
            $results[] = $result;
            
            
        }
        
        if (!$link = mysql_connect($host, $user, $pw)) {
            die();
            
        }
        
        if (!@mysql_select_db($db)) {
            mysql_close($link);
            die();
        }
        
        
        
        $sql = "";

        $sqlArr = array();
        
        foreach ($results as $i => $result) {


            //see if the tweets are any different?
            if (empty($result->results)) {
                //no tweets
                continue;
            }
            
            //results contains array of tweets!
            $sqlArr[$i] = array('sql' => '');            
            foreach ($result->results as $stat) {


                $twitterarr = explode(" ",(string)($stat->text));
                
                $text = "";
                foreach ($twitterarr as $bit) {
                    if (stripos($bit,"@") !== false) {
                        $text .= "<a onclick=\"pageTracker._trackEvent('Twitter', 'View " . str_replace("@","",$bit) . "');\" href=\"http://twitter.com/" . str_replace("@","",$bit) . "\">" . $bit . "</a> ";
                    } elseif (stripos($bit, "http://") !== false) {
                        $text .= "<a href=\"" . $bit . "\" onclick=\"pageTracker._trackEvent('Twitter', 'View " .  $bit . "');\">" . $bit . "</a> ";
                    } else {
                        $text .= $bit . " ";
                    }
                }
                unset($twitterarr);
                
                
                $twitterarr = explode(" ", (string)($text));
                
                $text = '';
                foreach ($twitterarr as $bit) {
                    if (stripos($bit,"#") !== false) {
                        $text .= "<a onclick=\"pageTracker._trackEvent('Twitter', 'View " . str_replace("#","",$bit) . "');\" href=\"http://twitter.com/search?q=%23" . str_replace("#","",$bit) . "\">" . $bit . "</a> ";
                    } else {
                        $text .= $bit . " ";
                    }
                }
                unset($twitterarr);
                
                if (strcmp($result->wp_feed[1], $text) != 0) {
                    $sqlArr[$i]['sql'] .= ($sqlArr[$i]['sql'] == "") ? "" : ",";
                    $sqlArr[$i]['sql'] .= "('" . mysql_real_escape_string($text) . "', NOW(), '" . $result->wp_feed[0] . "', '" . mysql_real_escape_string((string)$stat->created_at) . "', '" . mysql_real_escape_string(strtotime((string)$stat->created_at)) . "', '0', '" . mysql_real_escape_string((string)$stat->from_user) . "', '" . mysql_real_escape_string((string)$stat->profile_image_url) . "', '" . MD5(strip_tags((string)$stat->text))  . "', '" . mysql_real_escape_string((string)$result->refresh_url) . "')";
                } else {
                    $sqlArr[$i]['discard'] = true;
                }
            }
        }

        $sqlUseArray = array();
        
        
        foreach ($sqlArr as $sqlPart) {
            if (!isset($sqlPart['discard'])) {
                $sqlUseArray[] = $sqlPart['sql'];
            }
        }
        
        $sql = implode(' ', $sqlUseArray);
        
        
        if ($sql != "") {
            mysql_query("INSERT INTO twitfeed (tweet, lasttime, feed, tweettime, tweettime_unix, retweet_count, tweet_by, profile_image, plain_tweet_text, refresh_url) VALUES " . $sql);
        }
        
        
        if (isset($implodeHashes)) {
            $sql = "UPDATE twitfeed SET fetching = 0 WHERE 
            
	       	feed IN ('" . implode("','", $implodeHashes)  . "') ";
            
            mysql_query($sql);
        }
        
        mysql_close($link);
        
        
        
    }
    
    if (!isset($stayAlive)) {
	    die();
    }
    
    
    
