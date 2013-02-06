<?php
    
    $result = $wpdb->get_results("SELECT tweet, lasttime FROM twitfeed WHERE feed = 'luxerosie' AND lasttime >= " . strtotime('-4 minutes'));
    
    
    if (isset($result[0]) && !is_null($result[0]->tweet)) {
        
        //show the current dataset!
        
        foreach ($result as $row) {

            ?><div class="tweet"><?php
            
                echo $row->tweet;
                
            ?></div><?php
        }
        
        
    } else {
    
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, "http://twitter.com/statuses/user_timeline/luxerosie.xml?count=10");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Expect:'));
        $xmlData = new SimpleXMLElement(curl_exec($curl_handle));
        curl_close($curl_handle);
    

        if ((!isset($xmlData->error) || !$xmlData->error) && isset($xmlData->status)) {
            $wpdb->query("UPDATE twitfeed SET lasttime = '" . time() . "'");
            $twitcount = 1;
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
                
                $sql .= "('" . $wpdb->escape($text) . "', '" . time() . "', 'luxerosie')";
                
                
        ?><p class="twit"><?php echo $text; ?></p><?php

            }
        
            unset($xmlData);
            unset($twitcount);
            unset($info);
    
            if ($sql != "") {
                $wpdb->query("DELETE FROM twitfeed WHERE feed = 'luxerosie'");
                $wpdb->query("INSERT INTO twitfeed (tweet, lasttime, feed) VALUES " . $sql);
            }
            
    ?><?php
    
        } else {
                
            
            //errors at twitter so show some kind of information?
                
        }

    }