<?php

    get_header();
    
    ?><section class="col1">
        <div class="entry-content">
			<article class="post error404 not-found">
				<header>
					<h1 class="section-title"><span>Sorry, page not found</span><span class="stripe"></span></h1>
				</header>
                <div><p>It seems we can&rsquo;t find what you&rsquo;re looking for.</p><?php
    
    get_template_part('main-search');
    
    ?></div>
			</article>
        </div>
	</section><?php
    
    get_sidebar();
    get_footer();