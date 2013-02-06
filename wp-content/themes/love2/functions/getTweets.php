<?php

    $return = array();
    
    if (isset($_GET['feeds']) && !empty($_GET['feeds'])) {
        
        $stayAlive = true;
        include_once $_SERVER['DOCUMENT_ROOT'] . '/cron/get_tweets_by_hash.php';
        
        
        include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';
        
        $when = '';
        foreach ($_GET['feeds'] as $feed => $arr) {
            $when .= " WHEN '" . $wpdb->escape($feed) . "' THEN id > " . $wpdb->escape($arr['start']);
        }
        
        $sql = "SELECT id, tweet, tweettime_unix, feed, tweet_by, profile_image
        
        FROM twitfeed
        
        WHERE
        CASE feed
        " . $when . "
        END
        GROUP BY plain_tweet_text

        ORDER BY id DESC, feed, lasttime DESC
        ";
        
        $results = $wpdb->get_results($sql);
        
        
        
        foreach ($results as $result) {
            
            
            if (!isset($return[$result->feed])) {
                $return[$result->feed] = array(
                                               'start'      =>  $result->id,
                                               'feed'       =>  $result->feed,
                                               'referrer'   =>  $_GET['feeds'][$result->feed]['referrer']
                                               );
            }
            
            //number of seconds ago
            $timeAgo =  time() - $result->tweettime_unix;

            if ($timeAgo / 60 < 1) {
                //seconds!
                $timeAgo = 'just now';
            } elseif ($timeAgo / 3600 < 1) {
                //minutes
                $timeAgo = floor($timeAgo / 60 ) . ' m';
            } elseif ($timeAgo / 3600 / 24 < 1) {
                //hours
                $timeAgo = floor($timeAgo / 3600) . ' h';
            } else {
                //days
                $timeAgo = date('d M', $row->tweettime_unix);
            }
            
            $return[$result->feed]['feeds'][] = array(
                                                      'tweet'           =>  $result->tweet,
                                                      'tweet_by'        =>  $result->tweet_by,
                                                      'profile_pic'     =>  $result->profile_image,
                                                      'time'            =>  $timeAgo,
                                                      'plain_text'      =>  strip_tags($result->tweet)
                                                      );
        }
     
    }
    
    $data = array('tweets' => $return);
    
    header('Content-type: Application/json');
    echo json_encode($data);
    exit;