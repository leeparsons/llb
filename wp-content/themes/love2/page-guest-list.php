<?php
/*
 *  Template Name: Guest List
 */
    if (!session_id()) {
        session_start();
    }

    $qs = explode('&', $_SERVER['QUERY_STRING']);
    
    $extraHref = '';
    
    if (count($qs) > 0) {
        
        foreach ($qs as $str) {
            $tmp = explode('=', $str);
            if ($tmp[0] != 'l') {
                $extraHref .= ($extraHref == '') ? $tmp[0] . '='. $tmp[1] : '&amp;' . $tmp[0] . '='. $tmp[1];
            }
            
        }
        
    }
    
get_header(); 
    
    ?><div class="col1"><div class="clear-with-margin"></div><a name="location"></a><?php
    
    $where = '';

    /*get the twitter guest list!
    if (isset($_GET['l']) && $_GET['l'] != '') {
        $where = $wpdb->prepare(" WHERE location = '%s'", $_GET['l']);
    }
    */
    $sql = "SELECT * FROM guest_list " . $where. " ORDER BY real_name";
    unset($where);
    $guests = $wpdb->get_results($sql, OBJECT);
    unset($sql);
    
    if (count($guests) > 0) {
        
        ?><section class="twit-feed"><article class="twit-feed"><header><h2 class="section-title"><span>Guest List</span><span class="stripe"></span><span class="time" style="padding:0 8px;margin-top:-5px;float:right;font-size:22px;width:auto">
            <select id="filter-select">
            <?php
                
                $sql = "SELECT DISTINCT(location) FROM guest_list WHERE location IS NOT NULL AND location <> '' ORDER BY location ASC";
                
                $locations = $wpdb->get_results($sql, OBJECT);
                ?><option value=""><?php if (!isset($_GET['l']) || $_GET['l'] == '') { echo '-- filter by location --';} else { echo '-- reset filter --';} ?></option><?php
                foreach ($locations as $location) {

                    ?><option <?php if (isset($_GET['l']) && $location->location == $_GET['l']) {echo 'selected="selected"';} ?> value="<?php echo $location->location; ?>"><?php echo ucwords($location->location); ?></option><?php
                    
                }
                
                ?>
</select><script type="text/javascript">/*<![CDATA[*/<?php
    
    /*
    $('#filter-select').change(function() {window.location.href = './?<?php echo urldecode($extraHref); ?>&l=' + $(this).find('option:selected').val() + '#location';});
    */ ?>
$('#filter-select').change(function() {if ($(this).find('option:selected').val() != '') {
                           $(this).find('option').eq(0).text('-- Reset Filter --');
                           $('.commentlist').find('li').hide();
                           $('.commentlist').find('li[data-location="' + $(this).find('option:selected').val() + '"]').show();
                           } else {$(this).find('option').eq(0).text('-- Filter By Location --');$('.commentlist').find('li').show();}});
/*]]>*/</script><?php
                unset($locations);
            ?></span></h2></header></article><ol class="commentlist"><?php
            
            foreach ($guests as $g => $guest) {
                
                ?><li data-location="<?php echo $guest->location; ?>" class="comment <?php echo ($g %2 == 0) ? 'even thread-even' : 'odd thread-odd'; ?> twit"><span class="time fr"><?php
                    
                    
                    if (!is_null($guest->location) && $guest->location != '') {
                        
                        echo '<a href="?l=' . $guest->location;
                  
                        
                        echo $extraHref;                        
                    
                        ?>"><?php echo $guest->location; ?></a><?php
                        
                    }
                    
                    ?></span><?php
                    
                    //figure out the avatar
                    
                    ?><a class="tweeter" href="<?php



                        if (!is_null($guest->website) && $guest->website != '') {
                            $href = $guest->website;
                        } elseif (!is_null($guest->blog) && $guest->blog != '') {
                            $href = $guest->blog;
                        } elseif (!is_null($guest->facebook_url) && $guest->facebook_url != '') {
                            $href = $guest->facebook_url;
                        } elseif (!is_null($guest->twitter_name) && $guest->twitter_name != '') {
                            $href = 'http://twitter.com/' . str_replace('@', '', $guest->twitter_name);
                        } else {
                            $href = '" onclick="return false;" style="cursor:default';
                        }


                        echo $href;

                    ?>"><?php
                    
                    if ((is_null($guest->avatar) || $guest->avatar == '') && ($guest->twitter_name == '' || is_null($guest->twitter_name))) {    
                        echo '<img src="http://www.gravatar.com/avatar/?d=mm&s=48" alt="' . $row->real_name . '"/>';
                    } else {
                        echo '<img src="http://api.twitter.com/1/users/profile_image/?screen_name=' . str_replace('@', '', $guest->twitter_name) . '" alt="' . $guest->twitter_name . '"/>';
                    }
                    
                    echo '</a>';
                    
                    ?><div class="fl">
                        <div class="ctext"><a href="<?php

                            echo $href;

                        ?>"><?php echo $guest->real_name; ?></a><?php

                        if (!is_null($guest-company) && $guest->company != '') {
    
                            ?> @ <a href="<?php echo $href; ?>"><?php echo $guest->company; ?></a><?php
                            
                        }


                        ?></div>
                        <p class="ctext"><?php
                            
                            if (!is_null($guest->bio) && $guest->bio != '') {
                                echo $guest->bio;
                            }
                            
                            ?></p></div>
                            <div class="ctext">
                                <?php 
                                    
                                    
                                    if (!is_null($guest->website) && $guest->website != '') {
                                        ?><a href="<?php echo $guest->website; ?>" class="fl" style="margin:3px 10px 0 0" target="_blank">website</a><?php
                                    }
                                            
                                    if (!is_null($guest->blog) && $guest->blog != '') {
                                        ?><a href="<?php echo $guest->blog; ?>" class="fl" style="margin:3px 10px 0 0;" target="_blank">blog</a><?php
                                    }                                            
                                    
                                    if (!is_null($guest->twitter_name) && $guest->twitter_name != '') {
                                        ?><a target="_blank" href="https://twitter.com/intent/user?screen_name=<?php echo str_replace('@', '', $guest->twitter_name); ?>" class="twitter-follow">Follow <?php echo $guest->twitter_name; ?></a><?php
                                    }

                                            
                                    if (!is_null($guest->facebook_url) && $guest->facebook_url != '') {

                                        ?><a target="_blank" href="<?php echo $guest->facebook_url; ?>" class="fb-connect"></a><?php
                                        
                                    }
                                            
                            
                    ?></li><?php
                
                        
            }
            
            
                        ?></ol></section><?php
            
    }
    
           
        ?>
</div>
<?php
    
    get_sidebar('launch');
    ?><div id="fb-root"></div>
<script type="text/javascript">
//twitter without dependancies!
    
if (!window.__twitterIntentHandler) {
    
    var intentRegex = /twitter\.com(\:\d{2,4})?\/intent\/(\w+)/,
    
    windowOptions = 'scrollbars=yes,resizable=yes,toolbar=no,location=yes',
    
    width = 550,
    
    height = 420,
    
    winHeight = screen.height,
    
    winWidth = screen.width;
    
    
    
    function handleIntent(e) {
        e = e || window.event;
        
        var target = e.target || e.srcElement,
        
        m, left, top;
        
        
        
        while (target && target.nodeName.toLowerCase() !== 'a') {
            
            target = target.parentNode;
            
        }
        
        
        
        if (target && target.nodeName.toLowerCase() === 'a' && target.href) {
            
            m = target.href.match(intentRegex);
            
            if (m) {
                
                left = Math.round((winWidth / 2) - (width / 2));
                
                top = 0;
                
                
                
                if (winHeight > height) {
                    
                    top = Math.round((winHeight / 2) - (height / 2));
                    
                }
                
                
                
                window.open(target.href, 'intent', windowOptions + ',width=' + width +
                            
                            ',height=' + height + ',left=' + left + ',top=' + top);
                
                e.returnValue = false;
                
                e.preventDefault && e.preventDefault();
                
            }
            
        }
        
    }
    
    
    
    if (document.addEventListener) {
        
        document.addEventListener('click', handleIntent, false);
        
    } else if (document.attachEvent) {
        
        document.attachEvent('onclick', handleIntent);
        
    }
    
    window.__twitterIntentHandler = true;
}

</script>
<script type="text/javascript">/*<![CDATA[*/
window.fbAsyncInit = function() {
    FB.init({appId: '259581140813728', status: true, cookie: true,xfbml: true});
    FB.Event.subscribe('edge.create', function(url) {
                       _gaq.push(['_trackSocial', 'facebook', 'like', url]);
                       });
    FB.Event.subscribe('edge.remove', function(url) {
                       _gaq.push(['_trackSocial', 'facebook', 'unlike', url]);
                       });
};
/*]]>*/</script>
<?php
    get_footer();