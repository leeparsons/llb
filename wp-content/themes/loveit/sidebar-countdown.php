<aside class="widget countdown">
<span class="countdown-s fl uc">counting down to</span><span class="fr countdown-date uc">Aug 8, 2012</span>
<a href="/loveluxelaunch/"><strong class="countdown-strong cp fl">#LoveLuxeLaunch</strong></a>
<div class="countdown-sep fl"></div>
<span class="countdown-days fl"><?php
    
	$cdate = mktime(0, 0, 0, 8, 8, 2012, 0);
	$today = time();
	$difference = $cdate - $today;
	if ($difference < 0) { $difference = 0; }
    
	echo floor($difference/60/60/24);
    
	?><span class="fr">days</span></span>
<div class="clear fl"></div>
<span class="countdown-digit tc fl" style="margin-left:-8px"><?php
    
	//difference between 13 and now hour:
	$hour = Date('H');
	
	if (substr($h, 0, 1) == 0) {
		$h = (int)substr($h, 1);
	}
    
	$hour = (int)$hour;
    
	if ($hour == 13) {
		echo '00';
	} elseif ($hour > 13) {
		echo (12 + 23 - $hour > 9) ? 12 + 23 - $hour : '0' . (12 + 23 - $hour);
	} else {
		echo (13 - $hour > 9) ? 13 - $hour : '0' . (13 - $hour);
	}
    
    
	?></span><span class="countdown-digit tc fl"><?php
        
        $minute = Date('i');
        
        if (substr($minute, 0) == '0') {
            $minute = (int)substr($minute, 1);
        } else {
            $minute = (int)$minute;
        }
        
        if ($minute == 0) {
            echo '00';
        } elseif ($minute > 50) {
            echo '0' . (60 - $minute);
        } else {
            echo 60 - $minute;
        }
        
        
        
        
        ?></span><span class="countdown-digit tc fl nb"><?php
            
            $seconds = Date('s');
            
            if (substr($seconds, 0, 1) == 0) {
                $seconds = (int)substr($seconds, 1);
            } else {
                $seconds = (int)$seconds;
            }
            
            if ($seconds == 0) {
                echo '00';
            } else {
                if ($seconds > 50) {
                    echo '0' . (60 - $seconds);   
                } else {
                    echo 60 - $seconds;
                }
            }
            
            ?></span>
<div class="clear fl"></div>
<span class="countdown-unit tc fl" style="margin-left:-8px">Hours</span>
<span class="countdown-unit tc fl">Minutes</span>
<span class="countdown-unit tc fl">Seconds</span>
</aside>
<script type="text/javascript">/*<![CDATA*/
<?php /*
String.prototype.LLminifyDigit = function() {
    var str = this.toString();
    if (str.indexOf('0') == 0) {
        str = str.substr(1,1);
        console.log(str);
    }
    return str;
}
function recalcTime() {
    var seconds = $('.countdown-digit').eq(2).text().toString().LLminifyDigit();
    seconds = seconds*1;
    seconds--;
    if (seconds >= 0) {
        if (seconds >= 10) {
            $('.countdown-digit').eq(2).text(seconds);
        } else {
            $('.countdown-digit').eq(2).text('0' + '' + seconds);
        }
    } else {
        $('.countdown-digit').eq(2).text('59');
        var minutes = $('.countdown-digit').eq(1).text().toString().LLminifyDigit()*1;
        minutes = minutes*1;
        minutes--;
        if (minutes >= 0) {
            if (minutes >= 10) {
                $('.countdown-digit').eq(1).text(minutes);
            } else {
                $('.countdown-digit').eq(1).text('0' + minutes);  
            }
        } else {
            $('.countdown-digit').eq(1).text('59');
            var hours = $('.countdown-digit').eq(0).text().toString().LLminifyDigit()*1;
            hours = hours*1;
            hours--;
            if (hours >= 0) {
                if (hours >= 10) {
                    $('.countdown-digit').eq(0).text(hours);
                } else {
                    $('.countdown-digit').eq(0).text('0' + hours);  
                }
            } else {
                var days = $('.countdown-days').text.toString().substr(0, 1);
                days = days*1;
                days--;
                if (days > 0) {
                    $('.countdown-days').html(days + '<span class="fr">days</span>');
                } else {
                    $('.countdown-days').html('0<span class="fr">days</span>');
                }
            }
        }
    }
}
$(document).ready(function() {setInterval(function() {recalcTime();},1000);});
*/ ?>function recalcTime(){var a=$(".countdown-digit").eq(2).text().toString().LLminifyDigit();a=a*1;a--;if(a>=0){if(a>=10){$(".countdown-digit").eq(2).text(a)}else{$(".countdown-digit").eq(2).text("0"+""+a)}}else{$(".countdown-digit").eq(2).text("59");var b=$(".countdown-digit").eq(1).text().toString().LLminifyDigit()*1;b=b*1;b--;if(b>=0){if(b>=10){$(".countdown-digit").eq(1).text(b)}else{$(".countdown-digit").eq(1).text("0"+b)}}else{$(".countdown-digit").eq(1).text("59");var c=$(".countdown-digit").eq(0).text().toString().LLminifyDigit()*1;c=c*1;c--;if(c>=0){if(c>=10){$(".countdown-digit").eq(0).text(c)}else{$(".countdown-digit").eq(0).text("0"+c)}}else{var d=$(".countdown-days").text.toString().substr(0,1);d=d*1;d--;if(d>0){$(".countdown-days").html(d+'<span class="fr">days</span>')}else{$(".countdown-days").html('0<span class="fr">days</span>')}}}}}String.prototype.LLminifyDigit=function(){var a=this.toString();if(a.indexOf("0")==0){a=a.substr(1,1);console.log(a)}return a};$(document).ready(function(){setInterval(function(){recalcTime()},1e3)})/*]]>*/</script>