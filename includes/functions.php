<?php
function protect($string) {
	$protection = htmlspecialchars(trim($string), ENT_QUOTES);
	return $protection;
}

function randomHash($lenght = 7) {
	$random = substr(md5(rand()),0,$lenght);
	return $random;
}

function isValidURL($url) {
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

function formatBytes($bytes, $precision = 2) { 
    if ($bytes > pow(1024,3)) return round($bytes / pow(1024,3), $precision)."GB";
    else if ($bytes > pow(1024,2)) return round($bytes / pow(1024,2), $precision)."MB";
    else if ($bytes > 1024) return round($bytes / 1024, $precision)."KB";
    else return ($bytes)."B";
} 

function get_verify_type() {
	global $settings;
	if($settings['document_verification'] == "1" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "1") {
		$status = '1';
	} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "0") {
		$status = '2';
	} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "1") {
		$status = '3'; 
	} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "1") {
		$status = '4';
	} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "0") {
		$status = '5';
	} elseif($settings['document_verification'] == "1" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "0") {
		$status = '6';
	} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "1" && $settings['phone_verification'] == "0") {
		$status = '7';
	} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "1") {
		$status = '8';
	} elseif($settings['document_verification'] == "0" && $settings['email_verification'] == "0" && $settings['phone_verification'] == "0") {
		$status = '9';
	} else {
		$status = '0';
	}
	return $status;
}

function getLanguage($url, $ln = null, $type = null) {
	// Type 1: Output the available languages
	// Type 2: Change the path for the /requests/ folder location
	// Set the directory location
	if($type == 2) {
		$languagesDir = '../languages/';
	} else {
		$languagesDir = './languages/';
	}
	// Search for pathnames matching the .png pattern
	$language = glob($languagesDir . '*.php', GLOB_BRACE);

	if($type == 1) {
		// Add to array the available images
		foreach($language as $lang) {
			// The path to be parsed
			$path = pathinfo($lang);
			
			// Add the filename into $available array
			$available .= '<li><a href="'.$url.'index.php?lang='.$path['filename'].'">'.ucfirst(strtolower($path['filename'])).'</a></li>';
		}
		return substr($available, 0, -3);
	} else {
		// If get is set, set the cookie and stuff
		$lang = 'English'; // DEFAULT LANGUAGE
		if($type == 2) {
			$path = '../languages/';
		} else {
			$path = './languages/';
		}
		if(isset($_GET['lang'])) {
			if(in_array($path.$_GET['lang'].'.php', $language)) {
				$lang = $_GET['lang'];
				setcookie('lang', $lang, time() +  (10 * 365 * 24 * 60 * 60)); // Expire in one month
			} else {
				setcookie('lang', $lang, time() +  (10 * 365 * 24 * 60 * 60)); // Expire in one month
			}
		} elseif(isset($_COOKIE['lang'])) {
			if(in_array($path.$_COOKIE['lang'].'.php', $language)) {
				$lang = $_COOKIE['lang'];
			}
		} else {
			setcookie('lang', $lang, time() +  (10 * 365 * 24 * 60 * 60)); // Expire in one month
		}

		if(in_array($path.$lang.'.php', $language)) {
			return $path.$lang.'.php';
		}
	}
}

function checkAdminSession() {
	if(isset($_SESSION['btc_admin_uid'])) {
		return true;
	} else {
		return false;
	}
}

function isValidUsername($str) {
    return preg_match('/^[a-zA-Z0-9-_]+$/',$str);
}

function isValidEmail($str) {
	return filter_var($str, FILTER_VALIDATE_EMAIL);
}

function checkSession() {
	if(isset($_SESSION['btc_uid'])) {
		return true;
	} else {
		return false;
	}
}

function success($text) {
	return '<div class="alert alert-success"><i class="fa fa-check"></i> '.$text.'</div>';
}

function error($text) {
	return '<div class="alert alert-danger"><i class="fa fa-times"></i> '.$text.'</div>';
}

function info($text) {
	return '<div class="alert alert-info"><i class="fa fa-info-circle"></i> '.$text.'</div>';
}

function admin_pagination($query,$ver,$per_page = 10,$page = 1, $url = '?') { 
    	global $db;
		$query = $db->query("SELECT * FROM $query");
    	$total = $query->num_rows;
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='active'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='disabled'>...</li>";
    				$pagination.= "<li><a href='$ver&page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='$ver&page=1'>1</a></li>";
    				$pagination.= "<li><a href='$ver&page=2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>...</a></li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='$ver&page=1'>1</a></li>";
    				$pagination.= "<li><a href='$ver&page=2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='$ver&page=$next'>Next</a></li>";
                $pagination.= "<li><a href='$ver&page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='disabled'>Next</a></li>";
                $pagination.= "<li><a class='disabled'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
} 

function web_pagination($query,$ver,$per_page = 10,$page = 1, $url = '?') { 
    	global $db;
		$query = $db->query("SELECT * FROM $query");
    	$total = $query->num_rows;
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='active'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='$ver/$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver/$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='disabled'>...</li>";
    				$pagination.= "<li><a href='$ver/$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver/$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='$ver/1'>1</a></li>";
    				$pagination.= "<li><a href='$ver/2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>...</a></li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver/$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				$pagination.= "<li><a href='$ver/$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver/$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='$ver/1'>1</a></li>";
    				$pagination.= "<li><a href='$ver/2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver/$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='$ver/$next'>Next</a></li>";
                $pagination.= "<li><a href='$ver/$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='disabled'>Next</a></li>";
                $pagination.= "<li><a class='disabled'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
} 

function idinfo($uid,$value) {
	global $db;
	$query = $db->query("SELECT * FROM btc_users WHERE id='$uid'");
	$row = $query->fetch_assoc();
	return $row[$value];
}	


function walletinfo($uid,$value) {
	global $db;
	$query = $db->query("SELECT * FROM btc_users_addresses WHERE uid='$uid'");
	$row = $query->fetch_assoc();
	return $row[$value];
}	

function tradeinfo($tid,$value) {
	global $db;
	$query = $db->query("SELECT * FROM btc_trades WHERE id='$tid'");
	$row = $query->fetch_assoc();
	return $row[$value];
}	

function adinfo($aid,$value) {
	global $db;
	$query = $db->query("SELECT * FROM btc_ads WHERE id='$aid'");
	$row = $query->fetch_assoc();
	return $row[$value];
}	

function get_service_id($name) {
	if($name == "PayPal") { $id = '1'; }
	elseif($name == "Skrill") { $id = '2'; }
	elseif($name == "WebMoney") { $id = '3'; }
	elseiF($name == "Payeer") { $id = '4'; }
	elseif($name == "Perfect Money") { $id = '5'; }
	elseif($name == "Payoneer") { $id = '6'; }
	elseif($name == "AdvCash") { $id = '7'; }
	elseif($name == "OKPay") { $id = '8'; }
	elseif($name == "Entromoney") { $id = '9'; }
	elseif($name == "SolidTrust Pay") { $id = '10'; }
	elseif($name == "Neteller") { $id = '11'; }
	elseif($name == "UQUID") { $id = '12'; }
	elseiF($name == "Yandex Money") { $id = '13'; }
	elseif($name == "QIWI") { $id = '14'; }
	elseif($name == "Payza") { $id = '15'; }
	elseif($name == "Bank Transfer") { $id = '16'; }
	elseif($name == "Western Union") { $id = '17'; }
	elseif($name == "Moneygram") { $id = '18'; }
	else {
		$id = '0';
	}
	return $id;
}	

function get_service_name($id) {
	if($id == "1") { $name = 'PayPal'; }
	elseif($id == "2") { $name = 'Skrill'; }
	elseif($id == "3") { $name = 'WebMoney'; }
	elseiF($id == "4") { $name = 'Payeer'; }
	elseif($id == "5") { $name = 'Perfect Money'; }
	elseif($id == "6") { $name = 'Payoneer'; }
	elseif($id == "7") { $name = 'AdvCash'; }
	elseif($id == "8") { $name = 'OKPay'; }
	elseif($id == "9") { $name = 'Entromoney'; }
	elseif($id == "10") { $name = 'SolidTrust Pay'; }
	elseif($id == "11") { $name = 'Neteller'; }
	elseif($id == "12") { $name = 'UQUID'; }
	elseiF($id == "13") { $name = 'Yandex Money'; }
	elseif($id == "14") { $name = 'QIWI'; }
	elseif($id == "15") { $name = 'Payza'; }
	elseif($id == "16") { $name = 'Bank Transfer'; }
	elseif($id == "17") { $name = 'Western Union'; }
	elseif($id == "18") { $name = 'Moneygram'; }
	else {
		$name = 'Unknown';
	}
	return $name;
}

function StdClass2array($class)
{
    $array = array();

    foreach ($class as $key => $item)
    {
            if ($item instanceof StdClass) {
                    $array[$key] = StdClass2array($item);
            } else {
                    $array[$key] = $item;
            }
    }

    return $array;
}

function btc_generate_address($username) {
	global $db, $settings;
	$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE default_license='1' ORDER BY id");
	if($license_query->num_rows>0) {
		$license = $license_query->fetch_assoc();
		$user_query = $db->query("SELECT * FROM btc_users WHERE username='$username'");
		$user = $user_query->fetch_assoc();
		$label = 'usr_'.$username;
		$apiKey = $license['license'];
		$pin = $license['secret_pin'];
		$version = 2; // the API version
		$block_io = new BlockIo($apiKey, $pin, $version);
		$new_address = $block_io->get_new_address(array('label' => $label));
		if($new_address->status == "success") {
			$addr = $new_address->data->address;
			$time = time();
			$insert = $db->query("INSERT btc_users_addresses (uid,label,address,lid,available_balance,pending_received_balance,status,created) VALUES ('$user[id]','$label','$addr','$license[id]','0.00000000','0.00000000','1','$time')");
			$update = $db->query("UPDATE btc_blockio_licenses UPDATE addresses=addresses+1 WHERE id='$license[id]'");
		}
	}
}

function btc_update_balance($uid) {
	global $db, $settings;
	$get_address = $db->query("SELECT * FROM btc_users_addresses WHERE uid='$uid'");
	if($get_address->num_rows>0) {
		$get = $get_address->fetch_assoc();
		$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$get[lid]' ORDER BY id");
		$license = $license_query->fetch_assoc();
		$user_address = $get['address'];
		$apiKey = $license['license'];
		$pin = $license['secret_pin'];
		$version = 2; // the API version
		$block_io = new BlockIo($apiKey, $pin, $version);
		$balance = $block_io->get_address_balance(array('addresses' => $user_address));
		if($balance->status == "success") {
			$time = time();
			$available_balance = $balance->data->available_balance;
			$pending_received_balance = $balance->data->pending_received_balance;
			$update = $db->query("UPDATE btc_users_addresses SET available_balance='$available_balance',pending_received_balance='$pending_received_balance' WHERE id='$get[id]' and uid='$uid'");
		}
	}
}

function admin_get_profit() {
	global $db, $settings;
	$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE default_license='1' ORDER BY id");
	$license = $license_query->fetch_assoc();
	$user_address = $license['address'];
	$apiKey = $license['license'];
	$pin = $license['secret_pin'];
	$version = 2; // the API version
	$block_io = new BlockIo($apiKey, $pin, $version);
	$balance = $block_io->get_address_balance(array('addresses' => $user_address));
	if($balance->status == "success") {
		$time = time();
		$available_balance = $balance->data->available_balance;
		$pending_received_balance = $balance->data->pending_received_balance;
		return $available_balance.' BTC';
	} else {
		return '0.0000 BTC';
	}
}

function btc_update_transactions($uid) {
	global $db, $settings;
	$get_address = $db->query("SELECT * FROM btc_users_addresses WHERE uid='$uid'");
	if($get_address->num_rows>0) {
		$get = $get_address->fetch_assoc();
		$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$get[lid]' ORDER BY id");
		$license = $license_query->fetch_assoc();
		$apiKey = $license['license'];
		$pin = $license['secret_pin'];
		$version = 2; // the API version
		$block_io = new BlockIo($apiKey, $pin, $version);
		$received = $block_io->get_transactions(array('type' => 'received', 'addresses' => $get[address]));
		if($received->status == "success") {	
			$data = $received->data->txs;
			$dt = StdClass2array($data);
			foreach($dt as $k=>$v) {
				$txid = $v['txid'];
				$time = $v['time'];
				$amounts = $v['amounts_received'];
				$amounts = StdClass2array($amounts);
				foreach($amounts as $a => $b) {
					$recipient = $b['recipient'];
					$amount = $b['amount'];
				} 
				$senders = $v['senders'];
				$senders = StdClass2array($senders);
				foreach($senders as $c => $d) {
					 $sender = $d;
				}
				$confirmations = $v['confirmations'];
					$check = $db->query("SELECT * FROM btc_users_transactions WHERE uid='$uid' and txid='$txid'");
					if($check->num_rows>0) {
						$update = $db->query("UPDATE btc_users_transactions SET confirmations='$confirmations' WHERE uid='$uid' and txid='$txid'");
					} else {
						$insert = $db->query("INSERT btc_users_transactions (uid,type,recipient,sender,amount,time,confirmations,txid) VALUES ('$uid','received','$recipient','$sender','$amount','$time','$confirmations','$txid')");
					}
			}
		}
		$sent = $block_io->get_transactions(array('type' => 'sent', 'addresses' => $get[address]));
		if($sent->status == "success") {	
			$data = $sent->data->txs;
			$dt = StdClass2array($data);
			foreach($dt as $k=>$v) {
				$txid = $v['txid'];
				$time = $v['time'];
				$amounts = $v['amounts_sent'];
				$amounts = StdClass2array($amounts);
				foreach($amounts as $a => $b) {
					$recipient = $b['recipient'];
					$amount = $b['amount'];
				} 
				$senders = $v['senders'];
				$senders = StdClass2array($senders);
				foreach($senders as $c => $d) {
					 $sender = $d;
				}
				$confirmations = $v['confirmations'];
					$check = $db->query("SELECT * FROM btc_users_transactions WHERE uid='$uid' and txid='$txid'");
					if($check->num_rows>0) {
						$update = $db->query("UPDATE btc_users_transactions SET confirmations='$confirmations' WHERE uid='$uid' and txid='$txid'");
					} else {
						$insert = $db->query("INSERT btc_users_transactions (uid,type,recipient,sender,amount,time,confirmations,txid) VALUES ('$uid','sent','$recipient','$sender','$amount','$time','$confirmations','$txid')");
					}
			}
		}
	}
}

function btc_delete_fee_transactions($uid) {
	global $db, $settings;
	$get_address = $db->query("SELECT * FROM btc_users_addresses WHERE uid='$uid'");
	if($get_address->num_rows>0) {
		$get = $get_address->fetch_assoc();
		$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$get[lid]' ORDER BY id");
		$license = $license_query->fetch_assoc();
		$addr = $license['address'];
		$query = $db->query("SELECT * FROM btc_users_transactions WHERE uid='$uid' and type='sent'");
		if($query->num_rows>0) {
			while($row = $query->fetch_assoc()) {
				if($license['address'] >= $row['recipient']) {
					$delete = $db->query("DELETE FROM btc_users_transactions WHERE id='$row[id]' and uid='$uid'");
				}
			}
		}
	}
}

function btc_get_bitcoin_prices() {
	global $db, $settings;
	$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE default_license='1' ORDER BY id");
	if($license_query->num_rows>0) {
		$license = $license_query->fetch_assoc();
		$apiKey = $license['license'];
		$pin = $license['secret_pin'];
		$version = 2; // the API version
		$block_io = new BlockIo($apiKey, $pin, $version);
		$price = $block_io->get_current_price();
		$prices = $price->data->prices;
		$prices = StdClass2array($prices);
		foreach($prices as $k => $v) {
			foreach($v as $a => $b) {
				$rows[$a] = $b;
			}
			$query = $db->query("SELECT * FROM btc_prices WHERE source='$rows[exchange]' and currency='$rows[price_base]'");
			if($query->num_rows>0) {
				$update = $db->query("UPDATE btc_prices SET price='$rows[price]' WHERE source='$rows[exchange]' and currency='$rows[price_base]'");
			} else {
				$insert = $db->query("INSERT btc_prices (source,price,currency) VALUES ('$rows[exchange]','$rows[price]','$rows[price_base]')");
			}
		}
	}
}

function get_current_bitcoin_price() {
	global $db, $settings;
	$query = $db->query("SELECT * FROM btc_prices WHERE currency='USD' ORDER BY price DESC LIMIT 1");
	if($query->num_rows>0) {
		$row = $query->fetch_assoc();
		return $row['price'];
	}
}

function update_activity($uid) {
	global $db;
	$time = time();
	$update = $db->query("UPDATE btc_users SET time_activity='$time' WHERE id='$uid'");
}

function timeago($time)
{
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference $periods[$j] ago ";
}
	
function activity_time($uid) {
	global $db, $settings;
	$currenttime = time()-300;
	$onlinetime = idinfo($uid,"time_activity");
	if($onlinetime > $currenttime) {
		return 'Is online';
	} else {
		return 'Last seen '.timeago($onlinetime);
	}
}

function is_online($uid) {
	global $db, $settings;
	$currenttime = time()-300;
	$onlinetime = idinfo($uid,"time_activity");
	if($onlinetime > $currenttime) {
		return 1;
	} else {
		return 0;
	}
}

function convertBTCprice($amount,$currency) {
	if(is_numeric($amount)) {
		if($currency == "USD") {
			$btcprice = get_current_bitcoin_price();
			$com = $amount;
			$com2 = ($btcprice * $com) / 100;
			$amm = $btcprice - $com2;
			return ceil($amm);
		} else {
			$btcprice = get_current_bitcoin_price();
			$com = $amount;
			$com2 = ($btcprice * $com) / 100;
			$com3 = $btcprice - $com2;
			$amm = currencyConvertor($com3,"USD",$currency);
			return ceil($amm);
		}
	}
}


function currencyConvertor($amount,$from_Currency,$to_Currency) {
	 $amount = urlencode($amount);
	  $from_Currency = urlencode($from_Currency);
	  $to_Currency = urlencode($to_Currency);
	   $get = "https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";
	  $ch = curl_init();
										$url = $get;
										// Disable SSL verification
										curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
										// Will return the response, if false it print the response
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										// Set the url
										curl_setopt($ch, CURLOPT_URL,$url);
										// Execute
										$result=curl_exec($ch);
										// Closing
										curl_close($ch);
	  $get = explode("<span class=bld>",$result);
	  $get = explode("</span>",$get[1]);  
	  $converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
	  return ceil($converted_amount);
}

function btc_check_expired_trades() {
	global $db, $settings;
	$time = time();
	$query = $db->query("SELECT * FROM btc_trades WHERE status < 3 and timeout < $time");
	if($query->num_rows>0) {
		while($row = $query->fetch_assoc()) {
			$update = $db->query("UPDATE btc_trades SET status='6' WHERE id='$row[id]'");
		}
	} 
}

function get_user_balance($uid) {
	global $db, $settings;
	$balance = walletinfo($uid,"available_balance");
	$query = $db->query("SELECT * FROM btc_trades WHERE uid='$uid' and type='sell' and status < 3");
	if($query->num_rows>0) {
		while($row = $query->fetch_assoc()) {
			$balance = $balance-$row['btc_amount'];
			$balance = $balance-0.0009;
				if (strpos($settings['sell_comission'],'%') !== false) { 
					$bamount = $row['btc_amount'];
					$explode = explode("%",$settings['sell_comission']);
					$fee_percent = $explode[0];
					$new_amount = ($bamount * $fee_percent) / 100;
					$new_amount = round($new_amount,8);
					//$fee_amount = $bamount-$new_amount;
					$bamount = $fee_amount;
					$admincomission = $new_amount;
				} else {
					$admincomission = $settings['sell_comission'];
				}
			$balance = $balance-$admincomission;
		}
	}
	$query = $db->query("SELECT * FROM btc_trades WHERE trader='$uid' and type='buy' and status < 3");
	if($query->num_rows>0) {
		while($row = $query->fetch_assoc()) {
			$balance = $balance-$row['btc_amount'];
			$balance = $balance-0.0009;
			if (strpos($settings['buy_comission'],'%') !== false) { 
					$bamount = $row['btc_amount'];
					$explode = explode("%",$settings['buy_comission']);
					$fee_percent = $explode[0];
					$new_amount = ($bamount * $fee_percent) / 100;
					$new_amount = round($new_amount,8);
					//$fee_amount = $bamount-$new_amount;
					$bamount = $fee_amount;
					$admincomission = $new_amount;
				} else {
					$admincomission = $settings['buy_comission'];
				}
			$balance = $balance-$admincomission;
		}
	}
	return number_format($balance,8);
}

function emailsys_verification_email($username) {
	global $db, $settings;
	$eQuery = $db->query("SELECT * FROM btc_users WHERE username='$username'");
	if($eQuery->num_rows>0) {
		$row = $eQuery->fetch_assoc();
		$email = $row['email'];
		$msubject = '['.$settings[name].'] Account verification';
		$mreceiver = $email;
		$message = 'Hello, '.$row[username].'
		
To unlock '.$settings[name].' full features need to activate your account with link below.
'.$settings[url].'email-verify/'.$row[hash].'
	
If you have some problems please feel free to contact with us on '.$settings[supportemail];
		$headers = 'From: '.$settings[infoemail].'' . "\r\n" .
					'Reply-To: '.$settings[infoemail].'' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
		$mail = mail($mreceiver, $msubject, $message, $headers);
		if($mail) { 
			return true;
		} else {
			return false;
		}
	}
}

function emailsys_reset_password($uid) {
	global $db, $settings;
	$eQuery = $db->query("SELECT * FROM btc_users WHERE id='$uid'");
	if($eQuery->num_rows>0) {
		$row = $eQuery->fetch_assoc();
		$email = $row['email'];
		$msubject = '['.$settings[name].'] Reset password request';
		$mreceiver = $email;
		$message = 'Hello, '.$row[username].'
		
You use form to reset password in our website. To change it click on link below.
'.$settings[url].'password/change/'.$row[hash].'

If this email was not requested by you, please ignore it.
	
If you have some problems please feel free to contact with us on '.$settings[supportemail];
		$headers = 'From: '.$settings[infoemail].'' . "\r\n" .
					'Reply-To: '.$settings[infoemail].'' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
		$mail = mail($mreceiver, $msubject, $message, $headers);
		if($mail) { 
			return true;
		} else {
			return false;
		}
	}
}
?>