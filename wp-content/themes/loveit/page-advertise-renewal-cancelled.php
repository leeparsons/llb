<?php
/*
 *  Template Name: Advertise Renewal Cancelled Paypal Payment Process
 */

	if (!session_id()) {
        session_start();
    }
	
	
	

unset($_SESSION['advert_payment']);


	get_header();

	?><section class="col1"><?php
		
		while(have_posts()) {
			
			the_post();
			
		?><article><header class="article-header"><h1 class="no-link article-title"><?php
				
			the_title();
				
		?></h1></header><div class="entry-content"><?php
		

				the_content();
					
		?></article><?php
	}
	
	?></section><?php
	get_sidebar();

	get_footer();