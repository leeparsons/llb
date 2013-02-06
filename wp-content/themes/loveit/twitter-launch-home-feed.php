<article class="twit-feed"><?php

    
    $result = $wpdb->get_results("SELECT tweet, tweet_by, profile_image, retweet_count, UNIX_TIMESTAMP(lasttime) AS lasttime, tweettime FROM twitfeed GROUP BY plain_tweet_text ORDER BY tweettime_unix DESC");//AND lasttime >= NOW() - INTERVAL 4 MINUTE");
    
    if (isset($result[0]) && !is_null($result[0]->tweet)) {
        
        
        
        //show the current dataset!
        
        
        //t is number of seconds since last update.
        
        //figure how many minutes between t and lasttime + 1 minutes

        
        $timeLeft = ($result[0]->lasttime/60) + 1 - (time()/60);

        $minutes = floor($timeLeft);

        $seconds = substr(($timeLeft - $minutes)*60/100, 2, 2);
        
        unset($timeLeft);
        
        if ($seconds == '') {
            $seconds = '0';
        } elseif (substr($seconds, 0, 1) == '0') {
            $seconds = substr($seconds, 1, 1);
        } elseif (strlen($seconds) == 1) {
            $seconds.= '0';
        }
        
        if ((int)$minutes > 0) {
            $str = $minutes . ' Minute' . ($minutes > 1 ? 's ' : ' ') . $seconds . ' second' . ($seconds > 1 || $seconds == 0 ? 's' : '');
        } else {
            $str = $seconds . ' second' . ($seconds > 1 || $seconds == 0 ? 's' : '');
        }
        unset($minutes);
        unset($seconds);
        
        ?><header class="article-header"><h2 class="article-title no-link">Live Twitter Stream: <?php echo count($result); ?> Tweets<span style="float:right;font-size:22px;width:auto" class="time">Next update in: <?php echo $str; ?></span></h2></header>
            <div class="fl">
                <a href="https://twitter.com/loveluxeblog" class="twitter-follow-button" data-show-count="false" data-dnt="true">Follow @loveluxeblog</a>
            </div>
            <div style="margin:0 0 10px 10px;" class="fl">
                <a href="https://twitter.com/intent/tweet?button_hashtag=LoveLuxeLaunch&amp;text=%23LoveLuxeLaunch" class="twitter-hashtag-button" data-url="http://wwwloveluxeblog.com/loveluxelaunch" data-dnt="true">Tweet #LoveLuxeLaunch</a>
            </div><?php

            unset($str);

/*
        <div style="width:100%;position:relative;float:left;text-align:center;"><div class="cycle-prev"></div>
            */
            
            ?><ol class="commentlist"><?php
            
        foreach ($result as $i => $row) {

            ?><li class="comment <?php 


                if ($i%2 == 0) {
                    echo 'even thread-even';
                } else {
                    
                    echo 'odd thread-odd';
                }

?> twit"><span class="time fr<?php

$t = time() - strtotime($row->tweettime);

    if ($t / 60 < 1) {
        //seconds!
        echo '">just now';
    } elseif ($t / 3600 < 1) {
        //minutes
        echo '">' . floor($t / 60 ) . ' m';
    } elseif ($t / 3600 / 24 < 1) {
        //hours
        echo '">' . floor($t / 3600) . ' h';
    } else {
        //days
        echo '">' .  date('d M', strtotime($row->tweettime));
    }
    

?></span><a class="tweeter" href="//twitter.com/<?php echo $row->tweet_by; ?>"><img src="<?php

                echo $row->profile_image;

                    ?>" class="tweet-profile-pic" alt=""/></a><div class="fl"><div class="ctext"><a href="//twitter.com/<?php echo $row->tweet_by; ?>" class="tweet-by"><?php
            
echo $row->tweet_by;


?> tweeted:</a></div><p class="ctext"><?php
            
                echo $row->tweet;
                
    ?></p></div><div class="ctext"><?php
        

        ?><a href="https://twitter.com/intent/tweet?original_referer=http%3A%2F%2Fwww.loveluxeblog.com%2Floveluxelaunch&text=RT%20<?php echo urlencode(strip_tags($row->tweet)); ?>" class="retweet-button"></a><span>&nbsp;&nbsp;</span><a href="https://twitter.com/intent/tweet?screen_name=<?php echo $row->tweet_by; ?>&text=" class="twitter-mention-button" data-dnt="true">Tweet to @<?php echo $row->tweet_by; ?></a></div></li><?php
        }
        
                
                ?></ol><?php
                    
                    /*
                    <div class="cycle-next"></div></div><script type="text/javascript">
var maxHeight = -1;
$('article,twit-feed ol').find('li').each(function() {maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();});
$('.cycle-next, .cycle-prev').css({visibility:'visible', height:maxHeight+'px'});
$('article.twit-feed ol.commentlist').cycle({next:'.cycle-next',prev:'.cycle-prev'}).css({marginLeft:(602 - $('article.twit-feed ol.commentlist').width())/2});
</script><?php
                     
                     */
        
    } else {
    
        
        
        
        
        //Nothing from the db yet!
        //should not really come in here now
                
        
    }
?></article>