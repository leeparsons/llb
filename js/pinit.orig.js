var pinitButtons = {
init: function() {
if ($('.entry-content').length == 1) {
    $('.entry-content').find('a').each(pinitButtons.initiate);
}
},
initiate: function() {
if ($(this).find('img').length > 0) {
    $(this).addClass('attachment').click(pinitButtons.Pin);
    $(this).find('img').each(pinitButtons.create);
}
},
create: function() {
    var sp = document.createElement('span');
    $(sp).addClass('pinitbutton');
    var rm = 0;

    if ($(this).width() < 600 && $(this).position().left > 0) {
        //determine the remainder:

        rm = (600 - $(this).width()*1)/2

        //this gives how far in the image is from the anchor.
        //so add in the remainder + positioning of the span!
        rm = (rm*1);
        
    } else {
        rm = (600 - $(this).width()*1);
    }
        $(sp).css({right:rm + 'px'});
        rm = 0;
    
    //figure out the height of the image and then position the pin in the middle
    
    if ($(this).attr('title') != null) {
        $(sp).data('hrf', 'http://pinterest.com/pin/create/button/?url=' + encodeURI(document.location.href) + '&media=' + encodeURI($(this).prop('src')) + '&description=' + encodeURI($(this).attr('title'))).data('gaq', $(this).prop('src')).click(pinitButtons.click);
    } else {
        $(sp).data('hrf', 'http://pinterest.com/pin/create/button/?url=' + encodeURI(document.location.href) + '&media=' + encodeURI($(this).prop('src')) + '&description=Wedding and Party styles inspired by Loveluxe Blog').data('gaq', $(this).prop('src')).click(pinitButtons.click);
    }
    $(this).parent('a').append(sp);
    sp = '';
},
click: function() {
    _gaq.push(['_trackEvent', 'Pinterest', 'Pin', $(this).data('gaq')]);
    window.open($(this).data('hrf'), "Pinterest", "scrollbars=no,menubar=no,width=600,height=380,resizable=yes,toolbar=no,location=no,status=no");
},
Pin: function() {
    return false;
}
}
$(document).ready(function() {pinitButtons.init();});