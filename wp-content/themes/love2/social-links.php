<div class="fb-like soc" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="200" data-show-faces="false"></div>
<a class="soc soc-twitter" href="https://twitter.com/share" class="twitter-share-button" target="_blank" data-url="<?php the_permalink() ?>">Tweet</a>
<div class="soc">
<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id())); ?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
</div>