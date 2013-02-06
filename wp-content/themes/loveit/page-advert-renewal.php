<?php
/*
 *  Template Name: Advert Renewal
 */

	$query = array();
	
	if (isset($_REQUEST['aid'])) {
		
		$query = $wpdb->get_results(
									$wpdb->prepare( 
												   "SELECT
												   
												   aid,
												   name,
												   business,
												   email,
												   price,
												   url,
												   description,
												   duration,
												   UNIX_TIMESTAMP(startdatetime) AS startdate,
												   UNIX_TIMESTAMP(enddatetime) AS enddate,
												   image,
												   token,
												   status,
												   payerid,paypal_email,
												   correlationid,
												   fee,
												   edit_token,
												   option_id
												
												   FROM adverts_submissions
												   WHERE aid = %s
												   ", 						   
												   $_REQUEST['aid']
												   )
									);
	}
	
	if (!empty($query)) {
		
		
		$errorMessage = array();
		
		if (isset($_POST['et']) && isset($_POST['aid'])) {

			//saving information!
			
			if (!isset($_POST['n']) || str_replace(' ', '', $_POST['n']) == '') {
				$errorMessage['n'] = 'Please enter your name';
			} else {
				$newName = stripslashes($_POST['n']);
			}
			
			if (!isset($_POST['b']) || str_replace(' ', '', $_POST['b']) == '') {
				$errorMessage['b'] = 'Please enter your business name';
			} else {
				$newBusiness = stripslashes($_POST['b']);
			}
			
			if (!isset($_POST['e']) || filter_var($_POST['e'], FILTER_VALIDATE_EMAIL) === false) {
				$errorMessage['e'] = 'Please enter your email';
			} else {
				$newEmail = stripslashes($_POST['e']);
			}
			
			if (!isset($_POST['url']) || filter_var($_POST['url'], FILTER_VALIDATE_URL) === false) {
				$errorMessage['url'] = 'Please enter the url link';
			} else {
				$newUrl = stripslashes($_POST['url']);
			}		
			
			$imageUrl = '';
			
			if (isset($_FILES['image']) && !empty($_FILES['image'])) {
				
				
				
				if ($_FILES['image']['error'] > 0) {
					if ($_FILES['image']['error'] == 4) {
						if ($_FILES['image']['tmp_name'] != '') {
							$errorMessage['image'] = 'Please select an image';	
						} else {
							$imageUrl = $_POST['oimage'];
						}
					} else {
						$errorMessage['image'] = 'Your image has an error in it. Please select another one.';
					}
				} else {
					
					
					switch ($_FILES['image']['type']) {
						case 'image/jpg':
						case 'image/jpeg':
						case 'image/pjpeg':
						case 'image/pjpg':
						case 'image/gif':
						case 'image/png':
							//move the image across!
							
							if ($_FILES['image']['size']/1024 > 200) {
								$errorMessage['image'] = 'Please choose an image smaller than 200KB';
							} else {
								
								//get the image dimensions!
								
								list($w, $h) = getimagesize($_FILES['image']['tmp_name']);
								
								if ($w != 200 || $h != 90) {
									$errorMessage['image'] = 'The image needs to be exactly 200x90 pixels';
								}
								
								
								if (empty($errorMessage)) {
									
									$imageBase = md5($newName);
									
									if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/adverts_temp_store/' . $imageBase . '/')) {
										mkdir($_SERVER['DOCUMENT_ROOT'] . '/adverts_temp_store/' . $imageBase);
										chmod($_SERVER['DOCUMENT_ROOT'] . '/adverts_temp_store/' . $imageBase, 0777);
									}
									$imageUrl = '/adverts_temp_store/' . $imageBase . '/' . time() . '_' . $_FILES['image']['name'];

									if (!@move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $imageUrl)) {
										$errorMessage['image'] = 'There was a problem with your image.';
									}
								}
							}
							break;
							
							
						default:
							
							$errorMessage['image'] = 'Please choose a jpeg, png or gif image.';
							break;
							
					}
				}
				
			} else {
				$imageUrl = $_POST['oimage'];	
			}
			
			if (empty($errorMessage)) {
				
				set_time_limit(120);
				if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				        $ip=$_SERVER['HTTP_CLIENT_IP'];
			    	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			        } else {
				        $ip=$_SERVER['REMOTE_ADDR'];
				}

				 $wpdb->insert(
			                          'adverts_logs',
                        			  array(
			                                'message'           =>  'Starting advert renewal',
			                                'data'              =>  serialize($_POST),
                        			        'client_name'       =>  $query[0]->name,
			                                'stage'             =>  'set-express-checkout',
                        			        'ip'                =>  $ip,
			                                'client_id'         =>  $query[0]->aid,
                        			        'client_business'   =>  $query[0]->b,
			                                'user_agent'        =>  $_SERVER['HTTP_USER_AGENT']
                        			        ),
			                          array(
                        			        '%s',
			                                '%s',
                        			        '%s',
			                                '%s',
                        			        '%s',
			                                '%s',
                        			        '%s',
			                                '%s'
                        			        )
			                          );
					

				$durationQuery = $wpdb->get_results($wpdb->prepare("SELECT quantity_duration FROM advert_options WHERE id = %s", $_POST['t']));

				//sort out the paypal stuff!
				$adInfoArr = array(
						'name'			=>	$newName,
						'business'		=>	$newBusiness,
						'email'			=>	$newEmail,
						'url'			=>	$newUrl,
						'image'			=>	$imageUrl,
						'edit_token'		=>	$_POST['et'],
						'aid'			=>	$_POST['aid'],
						'option_id'		=>	$_POST['t'],
						'logid'			=>	$wpdb->insert_id,
						'startdate'		=>	$_POST['d'],
						'quantity_duration'	=>	$durationQuery[0]->quantity_duration
						);
				$adInfo = serialize($adInfoArr);

	   	   		 $apiUser = 'rosie_api1.rosieparsons.com';
				$apiPWD = 'K5ULLT635CMGSQTY';
				$apiSig = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AYuaOvrjEMsmQ-G05RxBaojuwCj3';
				$apiUrl  = 'https://api-3t.paypal.com/nvp';					

				//get the prices from the database!


				$query2 = $wpdb->get_results(
									$wpdb->prepare( 
												   "SELECT renewal_cost, duration, description FROM advert_options WHERE id = %s",
												   $_POST['t']
												   )
									);


				$fields = array(								
			                        'USER'						=>	$apiUser,
                        			'PWD'						=>	$apiPWD,
			                        'SIGNATURE'					=>	$apiSig,
			                        'VERSION'					=>	'72.0',
                        			'PAYMENTACTION'					=>	'AUTHORIZATION',
			                        'METHOD'					=>	'SetExpressCheckout',
                        			'PAYMENTREQUEST_0_NUMBER'			=>	'123',
			                        'PAYMENTACTION'					=>	'Sale',
                        			'PAYMENTREQUEST_0_AMT'				=>	$query2[0]->renewal_cost,
			                        'PAYMENTREQUEST_0_ITEMAMT'			=>	$query2[0]->renewal_cost,
                        			'PAYMENTREQUEST_0_TAXAMT'			=>	'0.00',
			                        'PAYMENTREQUEST_0_SHIPPINGAMT'			=>	'0.00',
                        			'PAYMENTREQUEST_0_HANDLINGAMT'			=>	'0.00',
			                        'PAYMENTREQUEST_0_INSURANCEAMT'			=>	'0.00',
                        			'PAYMENTREQUEST_0_CURRENCYCODE'			=>	'GBP',
			                        'L_PAYMENTREQUEST_0_NAME0'			=>	'Advert Signup: ' . $query2[0]->duration,
                        			'L_PAYMENTREQUEST_0_DESCRIPTION0'		=>	$query2[0]->description,
			                        'L_PAYMENTREQUEST_0_AMT0'			=>	$query2[0]->renewal_cost,
                        			'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID'	=>	'rosie@rosieparsons.com',
			                        'CANCELURL'					=>	'http://' . $_SERVER['SERVER_NAME'] . '/advertise/renewal-cancelled',
           			                'RETURNURL'					=>	'http://' . $_SERVER['SERVER_NAME'] . '/advertise/renewal-complete',
			                        'PAYMENTREQUEST_0_ALLOWEDPAYMENTMETHOD'		=>	'InstantPaymentOnly'
                        			);


				$fields_string = '';
			        foreach($fields as $key=>$value) {
			            $fields_string .= $key.'='.$value.'&';
			        }
			        rtrim($fields_string, '&');
        
			        $ch = curl_init();
        
			        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        
			        curl_setopt($ch, CURLOPT_POST, count($fields));
			        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
			        $res = curl_exec($ch);
			        curl_close($ch);

			        $result = explode('&', $res);
        
        
			        $token = '';
			        $success = false;
			        foreach ($result as $tmpArr) {
            
			            $tmp = explode('=', $tmpArr);
			            if ($tmp[0] == 'TOKEN') {
			                $token = urldecode($tmp[1]);
			            } elseif ($tmp[0] == 'ACK') {
			                if (strtolower($tmp[1]) == 'success') {
			                    $success = true;
			                }
			            }
            
			        }

        
        $wpdb->update(
                      'adverts_logs',
                      array(
                            'message'           =>  'Starting advert renewal payment',
                            'stage'             =>  'pending-payment',
                            'ip'                =>  $ip,
                            'user_agent'        =>  $_SERVER['HTTP_USER_AGENT']
                            ),
                      array(
                            'id'         =>  $adInfoArr['logid']
                            ),
                      array(
                            '%s',
                            '%s',
                            '%s',
                            '%s'
                            ),
                      array(
                            '%s'
                            )
                      );
if (!session_id()) {
	session_start();
}

if (isset($_REQUEST['dev'])) {
$_SESSION['dev'] = 1;
}

	 if (isset($_SESSION['dev'])) {
            //				 dev
            $apiUser = 'rosie_api1.rosieparsons.com';
            $apiPWD = 'LR3X8R7NGPVYFFGD';
            $apiSig = 'ALO1jE.eI2fzLRNPuc9giY898XkvAcppLX01gHUqDoLFq0h5TqGTZMMp';
            $apiUrl = 'https://api-3t.sandbox.paypal.com/nvp';
            $checkOutUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout';
            
        } else {				
            /* live */
            $apiUser = 'rosie_api1.rosieparsons.com';
            $apiPWD = 'K5ULLT635CMGSQTY';
            $apiSig = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AYuaOvrjEMsmQ-G05RxBaojuwCj3';
            $apiUrl  = 'https://api-3t.paypal.com/nvp';
            $checkOutUrl = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout';
        }


        $_SESSION['advert_payment']['token'] = $token;
	$_SESSION['advert_payment']['serialized'] = $adInfo;
        header('location: ' . $checkOutUrl . '&token=' . $token);
        die();


			}	
		}
		
		
	}
	
	get_header();
	
	?><section class="col1"><?php
		
	while(have_posts()) {
	
		the_post();
		
	?><article><header class="article-header"><h1 class="no-link article-title"><?php
		
		the_title();
		
	?></h1></header><div class="entry-content"><?php

		
		if (!empty($errorMessage)) {
			echo '<p class="error">There were a few errors with your update &ndash; please check below for more information.</p>';
		} elseif ($changed === true) {
			echo '<p class="success">Thank you for your changes. We have sent you an email with a link which you need to click to confirm the changes before we can apply them to your advert.</p>';
		}
		
		the_content();
		

		
		
		
	?></div><div class="entry-content aform-complete"><?php

		

		
		if (!empty($query)) {

			
			?><form class="aform" method="post" enctype="multipart/form-data" action=""><?php
			
				$editToken = uniqid();

				$wpdb->insert(
							  'adverts_submissions',
							  array('edit_token'	=>	$editToken),
							  array('%s'),
							  array('aid'	=>	$_GET['aid']),
							  array('%s')
							  );

				
				echo '<input type="hidden" value="' .  $_GET['ed'] . '" name="ed"/>';
				echo '<input type="hidden" value="' . $_GET['aid'] . '" name="aid"/>';
				echo '<input type="hidden" value="' . $editToken . '" name="et"/>';




			if ((int)$query[0]->enddate < time()) {
				$renewable = true;
			} elseif ((int)$query[0]->startdate < time() && (int)$query[0]->enddate > time() && (int)$query[0]->enddate <= time() + 30*24*60*60) {
				$renewable = true;
			} elseif ((int)$query[0]->startdate < time() && (int)$query[0]->enddate < time()) {
				$renewable = true;
			} else {
				$renewable = false;
				echo '<p class="error">Your advert can not be renewed yet, please come back on ' . date('l, j, M, Y', (int)$query[0]->enddate - 60*60*24*30) . '</p>';
			}

	
			?><p><span>Name:</span> <?php 
				
				
				
					
					if (isset($errorMessage['n'])) {echo '<span class="clear"></span><span class="error">' . $errorMessage['n'] . '</span><span class="clear"></span>';}

				
				?><input type="text" name="n" value="<?php 

if (isset($_POST['n'])) {
	echo htmlspecialchars(stripslashes($_POST['n']));
} else {
	echo htmlspecialchars(stripslashes($query[0]->name));
}

?>"/><?php 
				
				
					?></p>

		<p><span>Business name:</span><?php
			
				if (isset($errorMessage['b'])) {echo '<span class="clear"></span><span class="error">' . $errorMessage['b'] . '</span><span class="clear"></span>';}

				
			?><input type="text" name="b" value="<?php 

if (isset($_POST['b'])) {
	echo htmlspecialchars(stripslashes($_POST['b']));
} else {
	echo htmlspecialchars(stripslashes($query[0]->business));
}

?>"/><?php
				
				
				?></p>

		<p><span>Email:</span><?php
			
			

				if (isset($errorMessage['e'])) {echo '<span class="clear"></span><span class="error">' . $errorMessage['e'] . '</span><span class="clear"></span>';}

				
			?><input type="text" name="e" value="<?php 
if (isset($_POST['e'])) {
	echo htmlspecialchars(stripslashes($_POST['e']));
} else {
	echo htmlspecialchars(stripslashes($query[0]->email));
}
?>"/><?php



				
			?></p>

		<p><span>Start Date:</span><?php 
	
			
			if ((int)$query[0]->enddate < time()) {
				echo 'Your advert has expired so you will need to select a new start date';
			} elseif ((int)$query[0]->startdate < time() && (int)$query[0]->enddate > time() && (int)$query[0]->enddate <= time() + 30*24*60*60) {
				echo 'Your advert can be renewed, your advert will continue rolling until the period you set it to expire from: 9am on: ' . date('l, j, M, Y', (int)$query[0]->enddate);
			} elseif ((int)$query[0]->startdate < time() && (int)$query[0]->enddate < time()) {
				echo 'Your advert can be renewed, start date will be taken from: 9am on: ' . date('l, j, M, Y', (int)$query[0]->enddate);
			} else {
				echo '<p class="error">Your advert can not be renewed yet, please come back on ' . date('l, j, M, Y', (int)$query[0]->enddate - 60*60*24*30) . '</p>';
			}


		?>


		<p><span>Url to link to:</span><?php
			
			

				if (isset($errorMessage['url'])) {echo '<span class="clear"></span><span class="error">' . $errorMessage['url'] . '</span><span class="clear"></span>';}

				
			
			?><input type="text" name="url" value="<?php

if (isset($_POST['url'])) {
	echo htmlspecialchars(stripslashes($_POST['url']));
} else {

	echo htmlspecialchars(stripslashes($query[0]->url)); 

}
?>"/></p>

		<p><span class="fl">Image:</span><?php 
			
			echo ($query[0]->image == '') ? 'Not uploaded. You will need to confirm this before your advert goes live!' : '<img src="' . $query[0]->image . '"/>';
			
			
			?></p><?php
			
			
			
if ($renewable === true) {
					
					echo '<span class="clear"></span>';
					
					echo '<p><span style="width:100%">Upload new image (200px wide by 90px high):</span></p>';

					if (isset($errorMessage['image'])) {echo '<span class="clear"></span><span class="error">' . $errorMessage['image'] . '</span><span class="clear"></span>';}

					echo '<p><input type="file" name="image"/><input type="hidden" name="oimage" value="' . $query[0]->image . '"</p>';


?><p><strong>Details:</strong></p>


	<p><span style="width:100%">Select renew option</span></p>



		<?php

			$result = $wpdb->get_results("SELECT * FROM advert_options ORDER BY price ASC, description ASC");
			$prices = array();

			foreach ($result as $option) {
				$prices[$option->id] = $option;
			}

		
		foreach ($prices as $k => $option) {
		
		?>
	<p>
		<input <?php if ((isset($_POST['t']) && $_POST['t'] == $k) || (!isset($_POST['t']) && $k == 1)) {echo 'checked="checked"';} ?> type="radio" id="<?php echo str_replace(' ', '-', $option->duration); ?>" name="t" value="<?php echo $k; ?>">
		<label for="<?php echo str_replace(' ', '-', $option->duration); ?>">£<?php echo $option->renewal_cost; ?> for <?php echo $option->duration; ?></label>
	</p>
	<?php
			
		}
		

				echo '<p><input type="submit" class="fr" value="Renew"/><a href="/advertise/advert-information/?aid=' . $_GET['aid'] . '" class="fr pseudo-submit" style="margin-right:10px;">Cancel</a></p></form>';	

}
			}
			
			?>
		</div>

	</article><?php
	}
					
?></section><?php
	
	unset($_SESSION['advert_payment']);
	
	get_sidebar();
	
	get_footer();
