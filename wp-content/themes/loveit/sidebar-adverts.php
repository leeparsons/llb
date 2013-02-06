<div class="sas"><?php


date_default_timezone_set('Europe/London');

$sql = "SELECT image, url, business
	FROM adverts_submissions
	WHERE
		startdatetime <= NOW()
		AND
		enddatetime >= NOW()
	
	ORDER BY RAND()
	
	LIMIT 10";


	$query = $wpdb->get_results($sql);
if (count($query) > 0) {

?><aside class="widget widget_sp_image"><?php


	
	
	
	
	foreach ($query as $image) {
	
		?><a target="_blank" href="<?php

		echo $image->url;

		?>" onclick="_gaq.push(['_trackEvent', 'Sidebar Advert', 'Click', '<?php echo str_replace(array('"', "'"), ' ', $image->business); ?>']);" class="widget_sp_image-image-link"><img alt="" class="aligncenter" width="200" height="90" src="<?php

		echo $image->image;

		?>"></a><?php
		
			
	}
	

	?>
</aside><?php

}

	?><aside class="widget sidebar-button-small"><h3 class="widget-title"><a href="/advertise/">Advertise</a></h3><a class="button-link" href="/advertise/">Advertise on loveluxe blog!</a></aside></div><?php
		
		
