</div><?php 
    
    //this div ends the content left div
    
    ?><div class="content-right"><section class="col2">
<?php

    
    date_default_timezone_set('Europe/London');
    
    $sql = "SELECT image, url, business
	FROM adverts_submissions s 
    LEFT JOIN advert_options o ON s.option_id = o.id 
	WHERE
    startdatetime <= NOW()
    AND
    enddatetime >= NOW()
	AND status = 'complete'
    AND o.type = 1
	ORDER BY RAND()
    LIMIT 1";
    
    $query = $wpdb->get_results($sql);
    if (count($query) > 0) {
        
        ?><div class="sidebar-wrap">
            <a href="<?php echo $query[0]->url ?>" style="float: left; width: 100%; height: auto;"><img alt="<?php echo str_replace('"', '', $query[0]->business) ?>" style="float: left; width: 100%; height: auto;" src="<?php echo $query[0]->image ?>"></a></div><?php
    }
    
            $sql = "SELECT image, url, business
            FROM adverts_submissions s 
            LEFT JOIN advert_options o ON s.option_id = o.id 
            WHERE
            startdatetime <= NOW()
            AND
            enddatetime >= NOW()
            AND status = 'complete'
            AND o.type = 2
            ORDER BY RAND()";
    

?><div class="sidebar-wrap large-button"><aside class="widget widget_sp_image"><a href="/advertise/"><img src="/images/advertise.jpg" alt="advertise" /></a></aside></div><?php


	$query = $wpdb->get_results($sql);



    if (count($query) > 0) {
        
?><div class="sidebar-wrap">

    <aside class="widget widget_sp_image">
<?php

    $image_count = 0;
    
    $total_images = count($query);
    
    foreach ($query as $image) {
            
        $image_count++;
            
        if ($image_count == 7) { ?>
            </aside>
        </div>
        <div class="sidebar-wrap">
            <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Floveluxeblog&amp;width=410&amp;height=325&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color=%23cccccc&amp;header=true&amp;appId=195485953818125" style="border:none; overflow:hidden; width:410px; height:325px;"></iframe>
        </div>
        <div class="sidebar-wrap">
            <aside class="widget widget_sp_image">
        <?php } ?>

        <a target="_blank" href="<?php echo $image->url; ?>" onclick="_gaq.push(['_trackEvent', 'Sidebar Advert', 'Click', '<?php echo str_replace(array('"', "'"), ' ', $image->business); ?>']);" class="widget_sp_image-image-link <?php echo ($image_count > 4 && $image_count < 7 || (($total_images % 2 == 0 && $image_count > $total_images - 2) || ($total_images % 2 == 1 && $image_count == $total_images) )) ? 'no-mg-bottom' : '' ?>"><img alt="" class="aligncenter" width="200" src="http://www.loveluxeblog.com/<?php echo str_replace(' ', '%20', $image->image); ?>"></a><?php

    } 
        ?>
        </aside>
   <?php
    }

    if ($image_count < 7) { ?>
        
        </aside>
        <div class="sidebar-wrap">
            <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Floveluxeblog&amp;width=410&amp;height=325&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color=%23cccccc&amp;header=true&amp;appId=195485953818125" style="border:none; overflow:hidden; width:410px; height:325px;"></iframe>
        </div>
        
    <?php 
        
    }
    
?>    </div>
</section></div><?php
