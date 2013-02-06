<div class="excerpt-comments margin-reset">
<?php
    
    if ($feed = get_post_custom_values('social_media_hash_tag', get_the_ID())) {
        $feed = str_replace('#', '', $feed[0]);
    } else {
        $feed = 'loveluxelive';
    }
    
    $resultTotal = $wpdb->get_results("SELECT COUNT(id) as c FROM (SELECT id FROM twitfeed WHERE feed = '" . $feed . "' GROUP BY plain_tweet_text) as t1");

    
    $result = $wpdb->get_results("SELECT tweet, tweet_by, id, profile_image, retweet_count, UNIX_TIMESTAMP(lasttime) AS lasttime, tweettime FROM twitfeed WHERE feed = '" . $feed . "' GROUP BY plain_tweet_text ORDER BY tweettime_unix LIMIT 10");
    
    if (!isset($resultTotal[0]) || is_null($resultTotal[0]->c)) {
        $resultTotal = array();
        $resultTotal[0] = new StdClass();
        $resultTotal[0]->c = 0;
    }

    ?>
    <header class="article-header"><h2 class="article-title no-link">Live Broadcast Stream: <?php echo $resultTotal[0]->c; ?> Comment<?php echo $resultTotal[0]->c == 1?'':'s'; ?></h2></header>
    <div style="margin:0 0 10px 10px;" class="fr">
        <a target="_blank" href="https://twitter.com/intent/tweet?button_hashtag<?php echo $feed; ?>&amp;text=" class="twitter-hashtag-button" data-url="<?php the_permalink(); ?>" data-dnt="true">Tweet #<?php echo $feed; ?></a>
    </div>
    <div class="fr">
        <a target="_blank" href="https://twitter.com/loveluxeblog" class="twitter-follow-button" data-show-count="false" data-dnt="true">Follow @loveluxeblog</a>
    </div>
    <div class="clear"></div>
    <div class="live-broadcast-wrap">
        <form class="live-broadcast-submit-form" action="" name="social_feed_submission-<?php the_ID(); ?>">
            <div class="dn">
                <input type="radio" id="post_to_facebook-<?php the_ID(); ?>" name="social_feed[fb]" value="fb"/>
                <label for="post_to_facebook-<?php the_ID(); ?>">Post to Facebook</label>
            </div>
            <div class="clear"></div>
            <div>
                <input type="radio" checked="checked" class="dn" name="social_feed[tw]" id="post_to_twitter-<?php the_ID(); ?>" value="tw"/>
                <label class="dn" for="post_to_twitter-<?php the_ID(); ?>">Post to Twitter</label>
                <input type="hidden" name="params[tw][original_referrer]" value="<?php the_permalink(); ?>" />
                <input type="hidden" name="actn[tw]" value="https://twitter.com/intent/tweet"/>
                <input type="hidden" name="params[tw][textarea_name]" value="text"/>
            </div>
            <div class="clear"></div>
            <div>
                <label class="fl" for="message_to_post-<?php the_ID(); ?>">Comment:</label>
                <textarea name="text" id="message_to_post-<?php the_ID(); ?>">#<?php echo $feed ?> </textarea>
                <script type="text/javascript">/*<!CDATA*/document.getElementById('message_to_post-<?php the_ID(); ?>').value = '#<?php echo $feed ?> ';/*]]>*/</script>
            </div>
            <div class="clear"></div>
            <div>
                <label class="dn" for="submit_comment-<?php the_ID(); ?>">Submit</label>
                <input type="submit" class="fr" id="submit_comment-<?php the_ID(); ?>" value="comment" />
            </div>
        </form>
        <div class="clear"></div>
        <div class="live-broadcast-comments">
            <?php               
                $thisID = 0;
                if (isset($result[0]) && !is_null($result[0]->tweet)) {                
                    $c = count($result);    
                } else {
                    $c = 0;
                }
                
                ?>
                <div class="article-header">
                    <h2 class="article-title no-link">Latest <?php echo $c > 1?$c:''; ?> comment<?php $c > 1?'s':''; ?></h2>
                </div>
                <ol class="commentlist" data-start="<?php echo $c > 0? $result[0]->id : 0; ?>" data-feed="<?php echo $feed; ?>" data-referrer="<?php the_permalink(); ?>"><?php
        
                    if ($c > 0) {
                    
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
    
                        ?></span><a target="_blank" class="tweeter" href="//twitter.com/<?php echo $row->tweet_by; ?>"><img src="<?php

                            echo $row->profile_image;

                        ?>" class="tweet-profile-pic" alt=""/></a><div class="fl"><div class="ctext"><a target="_blank" href="//twitter.com/<?php echo $row->tweet_by; ?>" class="tweet-by"><?php

                            echo $row->tweet_by;

                        ?> tweeted:</a><p class="ctext"><?php
    
                            echo $row->tweet;
    
                        ?></p><p class="ctext">
                            <a target="_blank" href="https://twitter.com/intent/tweet?original_referer=<?php echo urlencode(get_permalink()); ?>&amp;text=RT%20<?php echo urlencode(strip_tags($row->tweet)); ?>" class="retweet-button"></a><span>&nbsp;&nbsp;</span><a target="_blank" href="https://twitter.com/intent/tweet?screen_name=<?php echo $row->tweet_by; ?>&amp;text=" class="twitter-mention-button" data-dnt="true">Tweet to @<?php echo $row->tweet_by; ?></a>
                            </p>
                            </div>
                        </li>
                <?php

                    }
                    }
            ?></ol>

<script type="text/javascript">
if (typeof clickToActivate === 'undefined') {
    var clickToActivate = {
    tweetFeeds: {},
    si:0,
    winsi:0,
    win:null,
    init: function() {
        //$('.click-to-interact').click(clickToActivate.toggler);
        $(document).on('submit', '.live-broadcast-submit-form', clickToActivate.submit);
        //$('.click-to-interact').each(clickToActivate.setData);
        if ($('ol.commentlist').length > 0) {
            clickToActivate.getTweetsSetUpData();
            clickToActivate.startInterval();
        }
        $('.live-broadcast-iframe').on('click', '.popup-click', clickToActivate.showPopup);
    },
    closePopup: function(e) {
        if (typeof e !== 'undefined') {
            e.preventDefault();
        }
        $(clickToActivate.overLay).remove();
        $(clickToActivate.popupIframe).remove();
    },
    showPopup: function(e) {
        e.preventDefault();
        clickToActivate.overLay = document.createElement('div');
        $(clickToActivate.overLay).click(clickToActivate.closePopup);
        $(clickToActivate.overLay).css({'position':'fixed','left':0,'right':0,'top':0,'bottom':0,'zIndex':30000,'background':'#000000', 'opacity':0.65});
        clickToActivate.popupIframe = document.createElement('div');
        
        var tp = ($(window).height()*1 - 390 > 0) ? ($(window).height()*1 - 390)/2 : '15%';
        
        $(clickToActivate.popupIframe).css({'position':'fixed','left':($(document).width()*1 - 950)/2 + 'px', 'width':'950px','top':tp, 'height':'390px','zIndex':30001,'background':'url("/images/textured-background.jpg") repeat scroll 0 0 transparent', 'overflow':'hidden'});
        
        var hd = document.createElement('header');

        var h2 = document.createElement('h2');
        $(h2)
            .text($(this).parent('p').parent('div').parent('article').find('h2').eq(0).text())
            .addClass('article-title')
        .css({'width':'100%'});
        $(hd)
            .addClass('article-header')
            .append(h2)
            .css({'position':'absolute', 'left':'0','right':'0', 'top':'0', 'height':'50px', 'width':'auto'});
        
        var aClose = document.createElement('span');
        $(aClose)
        .css({'position':'absolute', 'right':'15px', 'top':'12px', 'borderRadius':'16px', 'background':'#000000', 'color':'#FFFFFF', 'height':'22px', 'fontSize':'16px', 'textAlign':'center', 'padding':'0 5px', 'width':'12px', 'lineHeight':'18px', 'border':'1px solid #FFFFFF', 'cursor':'pointer'})
            .html('&#10005;')
            .click(clickToActivate.closePopup);
        
        $(h2).append(aClose);
        
        var wrap = document.createElement('div');
        $(wrap).css({'position':'relative', 'top':'60px', 'bottom':'20px', 'left':'20px', 'right':'20px'});
        
        var ifr = $(this).parent('p').parent('div').find('iframe').eq(0).clone();
        $(ifr).addClass('fl');

        var frm = $(this).parent('p').parent('div').next('div').find('form').clone();
        $(frm).addClass('fl').css({'marginLeft':'10px', 'marginTop':'-19px', 'width':'360px', 'overflow':'hidden'}).find('div, label, textarea').css('width','90%');
        $(frm).find('label').css({'marginLeft':'15px', 'textAlign':'left', 'marginBottom':'10px'});
        
        $(wrap).append(ifr, frm);
        
        $(clickToActivate.popupIframe).append(hd, wrap);
        
        
        
        $('body').append(clickToActivate.overLay, clickToActivate.popupIframe);
            
    },
    windowWatcher: function() {
        if (clickToActivate.win == null || clickToActivate.win.closed === true) {
            clickToActivate.win = null;
            clearInterval(clickToActivate.winsi);
            clearInterval(clickToActivate.si);
            clickToActivate.getTweets('clickToActivate.startInterval()');
        }
    },
    startInterval: function() {
        clickToActivate.si = setInterval(clickToActivate.getTweets, 7500);
    },
    getTweetsSetUpData: function() {
        $('ol.commentlist').each(function() {
                                 clickToActivate.tweetFeeds[$(this).attr('data-feed')] = {start: $(this).attr('data-start'), referrer: $(this).attr('data-referrer')};
                                 });
    },
    getTweets: function(callBack) {
        clickToActivate.getTweetsSetUpData();
        $.getJSON('/wp-content/themes/loveit/functions/getTWeets.php', 
                  {feeds: clickToActivate.tweetFeeds},
                  function(data) {
                    if (data.tweets) {
                        var eo = 'odd';
                        var li = '';
                        var l = 0;
                        for (var x in data.tweets) {
                            if (data.tweets[x].feed) {
                                if ($('ol[data-feed="' + data.tweets[x].feed + '"]').length == 1) {
                                    $('ol[data-feed="' + data.tweets[x].feed + '"]').attr('data-start', data.tweets[x].start);
                  
                                    for (var k in data.tweets[x].feeds) {
                                        if ($('ol[data-feed="' + data.tweets[x].feed + '"]').find('li').eq(0).hasClass('even')) {
                                            eo = 'odd';
                                        } else {
                                            eo = 'even';
                                        }
                                        li = document.createElement('li');
                                        $(li).addClass('comment ' + eo + ' thread-' + eo + ' twit');
                                        
                                        $(li).html('<span class="time fr">' + data.tweets[x].feeds[k].time + '</span><a href="//twitter.com/' + data.tweets[x].feeds[k].tweet_by + '" class="tweeter" target="_blank"><img alt="" class="tweet-profile-pic" src="' + data.tweets[x].feeds[k].profile_pic + '"></a><div class="fl"><div class="ctext"><a class="tweet-by" href="//twitter.com/' + data.tweets[x].feeds[k].tweet_by + '" target="_blank">' + data.tweets[x].feeds[k].tweet_by +  ' tweeted:</a><p class="ctext">' + data.tweets[x].feeds[k].tweet + '</p><p class="ctext"><a class="retweet-button" href="https://twitter.com/intent/tweet?original_referer=' + data.tweets[x].referrer + '&amp;text=RT%20' + encodeURIComponent(data.tweets[x].feeds[k].plain_text) + '" target="_blank"></a><span>&nbsp;&nbsp;</span><a data-dnt="true" class="twitter-mention-button" href="https://twitter.com/intent/tweet?screen_name=' + data.tweets[x].feeds[k].tweet_by + '&amp;text=" target="_blank">Tweet to @' + data.tweets[x].feeds[k].tweet_by + '</a></p></div></div>');
                                            $(li).slideUp().css({'opacity': 0});

                                        $('ol[data-feed="' + data.tweets[x].feed + '"]').prepend(li);
                                        
                                        if ($('ol[data-feed="' + data.tweets[x].feed + '"]').find('li').length == 10) {
                                            console.log('s');
                                            $('ol[data-feed="' + data.tweets[x].feed + '"]').find('li:last').fadeOut(function() {$(this).remove();});
                                        }
                                        $(li).slideDown(750, function() {$(this).animate({'opacity': 1}, 1500);});
                                        li = '';
                                    }

                                    l = $('ol[data-feed="' + data.tweets[x].feed + '"]').find('li').length;
                                    if (l == 0) {
                                        $('ol[data-feed="' + data.tweets[x].feed + '"]').prev('div').find('h2').text('Latest Comments');
                                        $('ol[data-feed="' + data.tweets[x].feed + '"]').parent('div').parent('div').parent('div').find('header').find('h2').text('Live Broadcast Stream: 0 Comments');
                                    } else if (l == 1) {
                                        $('ol[data-feed="' + data.tweets[x].feed + '"]').prev('div').find('h2').text('Latest Comment');
                                        $('ol[data-feed="' + data.tweets[x].feed + '"]').parent('div').parent('div').parent('div').find('header').find('h2').text('Live Broadcast Stream: 1 Comment');
                                    } else {
                                        $('ol[data-feed="' + data.tweets[x].feed + '"]').prev('div').find('h2').text('Latest ' + l + ' Comments');
                                        $('ol[data-feed="' + data.tweets[x].feed + '"]').parent('div').parent('div').parent('div').find('header').find('h2').text('Live Broadcast Stream: ' + l + ' Comments');

                                    }
                                }
                            }
                        }
                    }
                  if (typeof callBack !== 'undefined') {
                    eval(callBack);
                  }
                  });
    },
    submit: function(e) {
        e.preventDefault();
        var params = '';
        var ind = $(e.currentTarget).find('input[name^="social_feed"]:checked').val();
        var base = '';
        $(e.currentTarget).find('input[name^="social_feed"]:checked').parent(0).find('input').each(function() {
                                                                                                   if ($(this).prop('name').indexOf('params[' + ind + '][') == 0) {
                                                                                                   if (params == '') {
                                                                                                   params += '?';
                                                                                                   } else {
                                                                                                   params += '&'; 
                                                                                                   }
                                                                                                   
                                                                                                   if ($(this).prop('name').indexOf('textarea_name') > -1) {
                                                                                                   params += $(this).val() + '=' + encodeURIComponent($(e.currentTarget).find('textarea').val());
                                                                                                   } else {
                                                                                                   params += $(this).prop('name').replace('params[' + ind + '][', '').replace(']', '') + '=' + encodeURIComponent($(this).val());
                                                                                                   }
                                                                                                   } else if ($(this).prop('name').indexOf('actn[' + ind + ']') == 0) {
                                                                                                   base = $(this).val();
                                                                                                   }
                                                                                                   });  
        clickToActivate.win = window.open(base + params, 'new_window', 'width=640, height=480, left=0, top=0');
        clickToActivate.winsi = setInterval(clickToActivate.windowWatcher, 500);
    },
    setData: function() {
        $(this).data('open', 0);
        $(this).text('Click to interact');
        $(this).next('div').next('div').stop().slideUp(function() {$(this).css('visibility', 'visible');});
    },
    toggler: function() {
        if ($(this).data('open') === 0) {
            $(this).data('open', 1);
            $(this).next('div').next('div').slideDown();
            $(this).text('Click to hide');
        } else {
            $(this).data('open', 0);
            $(this).next('div').next('div').stop().slideUp();
            $(this).text('Click to interact');
        }
    }
    };
    $(document).ready(clickToActivate.init);
}
</script>
        </div>
    </div>
</div>