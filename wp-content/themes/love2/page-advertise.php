<?php
/*
 *  Template Name: Advertise
 */

    set_time_limit(120);
    
	if (!session_id()) {
        session_start();
    }

	if (isset($_GET['dev'])) {
		$_SESSION['dev'] = true;
	}

    if (!empty($_POST) && isset($_POST['option'])) {
        //see if the option exists

        $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM advert_options WHERE id = %d", $_POST['option']));
        
        if (!empty($result)) {
            $_SESSION['advert_info']['option'] = $result[0];
            header('location: /advertise/advert-details/');
            die();
        }
    }
    

    if (isset($_SESSION['advert_log_id']) && !isset($_POST['t'])) {
        unset($_SESSION['advert_log_id']);
    }


	get_header(); 
    
    ?><section class="col1"><?php
        

        
        if (have_posts()) {
            while ( have_posts() ) {
                the_post();
				
               
                
            ?><div class="entry-content"><?php
                ?><article><header><h1 class="section-title"><span><?php

                    the_title();
                    
                    ?></span><span class="stripe"></span></h1></header><?php
                the_content();
             
                ?></article></div><?php
            }
        }


		?>

<h2 class="section-title"><span>Enter your details below</span><span class="stripe"></span></h2>
<div class="entry-content">
<form action="/advertise/" name="payment" class="aform fl w100" method="post" enctype="multipart/form-data">
    <p>Choose your ad length</p>

    <table class="w100 advert-options-table">
        <thead>
            <tr>
                <th>Choose your ad length</th>
                <th>One Month</th>
                <th>2 Months</th>
                <th>3 Months</th>
            </tr>
        </thead>
        <tbody>
            <?php
                
                $res = $wpdb->get_results("SELECT * FROM advert_options GROUP BY type, ordering ORDER BY priority ASC, type, ordering");
                
                $type = 0;
                
                foreach ($res as $row) {

                    if ($type != $row->type) {
                        if ($type == 0) { ?>
                            <tr>
                    <?php
                        } else {
                            ?></tr><tr><?php
                        }
                    }
                    $type = $row->type;
                    
                    if ($row->ordering == 1) {
                        ?><td><label><?php echo $row->description; ?></label></td><?php
                    }
                            

                            ?><td><label>&pound;<?php echo $row->price; ?> <input type="radio" name="option" value="<?php echo $row->id ?>" /></label></td><?php
                    
                }
                
                ?></tr>
        </tbody>
    </table>
    <input type="submit" value="next &gt; Your Details" class="fr" />
</form>
<script type="text/javascript">/*<![CDATA[*/

$('input[type="submit"]').on('click', function(e) {e.preventDefault();
                             if ($('input[name="option"]:checked').length == 0) {
                                alert('Please select an advert option');
                             } else {
                                $('form.aform').submit();
                             }
                             });
/*]]>*/</script>
</div>
</section>
<script type="text/javascript">/*<![CDATA[*/!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");/*]]>*/</script>
<?php
    
    get_sidebar();
    ?><div id="fb-root"></div>
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
(function() {
 var e = document.createElement('script'); e.async = true;
 e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
 document.getElementById('fb-root').appendChild(e);
 }());
/*]]>*/</script><?php
    get_footer();