<?php
    

    function renewalEmails($period = 14, $flag = 1) {
        
        //    $host = '127.0.0.1';    
        $host = 'localhost';
        
        //    $user = 'root';
        $user = 'loveluxe_luser';
        
        $pw = 'OA39E}q?6xEa';
        //    $pw = '';
        
        //    $db = 'loveluxeblog_wp';
        $db = 'loveluxe_live';
        
        if (!$link = mysql_connect($host, $user, $pw)) {
            die();
        }    
        if (!@mysql_select_db($db)) {
            mysql_close($link);
            die();
        }
        
        $sql = "SELECT a_s.aid, a_s.name, a_s.enddatetime, email,
        ao.renewal_cost 
        
        FROM adverts_submissions AS a_s
        
        LEFT JOIN advert_options AS ao ON ao.id = a_s.option_id
        
        WHERE a_s.status = 'complete' 
        AND a_s.startdatetime < NOW() 
        AND a_s.enddatetime - INTERVAL 14 DAY < NOW()
        AND reminder = " . ($flag - 1);
        
        $result = mysql_query($sql);
        $update = '';    
        if (mysql_num_rows($result) > 0) {
            
            while($row = mysql_fetch_array($result)) {
                $renewals[] = array(
                                    'aid'        =>  $row['aid'],
                                    'enddate'    =>  $row['enddatetime'],
                                    'name'       =>  $row['name'],
                                    'email'      =>  $row['email'],
                                    'cost'       =>  $row['renewal_cost']
                                    );
            }
            
            mysql_free_result($result);
            
            
            $headers = "From: advertise@loveluxeblog.com\r\n";
            $headers .= "Reply-To: advertise@loveluxeblog.com\r\n";
            $headers .= "Return-Path: advertise@loveluxeblog.com\r\n";
            $headers .= "Organization: Loveluxe Blog\r\n";
            $headers .= "MIME-Version: 1.0\n";			
            $headers .= "Content-type: text/html; charset=iso-8859-1\n"; 
            
            $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
            
            
            
            $messageBase = '<html><head><meta content="text/html; charset=UTF-8" http-equiv="Content-Type"></head>
            <body style="width:100%%;margin:auto;text-align:center;background-color:#fcfcfc">
            <table style="color:#5E5E5D;text-align:left;">
            <tbody>
            <tr>
            <td><h1 style="background:#F6F1E7;padding:10px;font-size:14px;border:1px solid #A89D87;min-width:200px;">Hello from LoveLuxe Blog</h1></td>
            </tr>
            <tr>
            %s
            </tr>
            </tbody>
            </table>
            </body>
            </html>';
            
            $renewalsAids = array();
            
            foreach ($renewals as $renewal) {
                //email the person!
                
                $name = strtok(trim($renewal['name']) , " ");
                
                $message = '<p>Hello ' . ucfirst($name) . '!<br/></p>';
                $message .= '<p>Thank you for advertising on LoveLuxe Blog.<br/><br/>Your advert with reference: <a href="http://www.loveluxeblog.com/advertise/advert-renewal/?aid=' . $renewal['aid'] . '">' . $renewal['aid'] . '</a> is due to expire in just ' . $period . ' day' . ($period > 1 ? 's':'') . '.<br/><br/>You can renew it now easily by going to: <a href="http://www.loveluxeblog.com/advertise/advert-renewal/?aid=' . $renewal['aid'] . '">http://www.loveluxeblog.com/advertise/advert-renewal/?aid=' . $renewal['aid'] . '</a><br/></p>';
                $message .= '<p>Thanks again for all your support!<br/></p>';
                $message .= '<p>If you have any questions please contact us: <a href="mailto:advertise@loveluxeblog.com">advertise@loveluxeblog.com</a><br/></p>';
                $message .= '<p>Thank you!<br/></p><p>Rosie<br/><a href="http://www.loveluxeblog.com/">LoveLuxe Blog</a><br/>The weddings and parties blog</p>';
                
                mail($renewal['email'],
                     'Reminder Notice: advert due to expire in ' . $period . ' day' . ($period > 1?'s':''), 
                     str_replace(
                                 array('<p>',
                                       '<a ',
                                       '<strong>'
                                       ), 
                                 array('<p style="color:#8B8A8A">', 
                                       '<a style="color:#FA8A70" ',
                                       '<strong style="font-weight:600;color:#FA8A70">'
                                       ), 
                                 sprintf($messageBase, $message)
                                 ),
                     $headers,
                     '-fadvertise@loveluxeblog.com');
                
                $renewalsAids[] = $renewal['aid'];
                
            }
            
            $update = "UPDATE adverts_submissions SET renewal = " . $flag . " WHERE aid IN ('" . implode("', '", $renewalsAids) . "')";
            //cycle through each one and email out:
            
           mysql_query($update);
            
        } else {
            mysql_free_result($result);
        }
        mysql_close($link);
        
    }
    
    renewalEmails(1, 3);
    renewalEmails(7, 2);
    renewalEmails(14, 1);


    die();