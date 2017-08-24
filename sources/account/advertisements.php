 <!-- Page Title-->
    	<div class="container-fluid blue-banner page-title bg-image">
		 
        </div>
    <!-- Page Title--><?php
$c = protect($_GET['c']);
$id = protect($_GET['id']);
?>
	<div class="container ex_padding" style="padding-top:20px;padding-bottom:20px;font-size:15px;">
		<div class="row">
			<div class="col-md-3">
				
				<div class="list-group">
				  <a href="<?php echo $settings['url']; ?>account/wallet" class="list-group-item"><i class="fa fa-bitcoin"></i> <?php echo $lang['menu_wallet']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/transactions" class="list-group-item"><i class="fa fa-exchange"></i> <?php echo $lang['menu_transactions']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/advertisements" class="list-group-item active"><i class="fa fa-globe"></i> <?php echo $lang['menu_advertisements']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/trades" class="list-group-item"><i class="fa fa-refresh"></i> <?php echo $lang['menu_trades']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/settings" class="list-group-item"><i class="fa fa-cogs"></i> <?php echo $lang['menu_settings']; ?></a>
				  
				  <a href="<?php echo $settings['url']; ?>account/verification" class="list-group-item"><i class="fa fa-check"></i> <?php echo $lang['menu_verification']; ?></a>
				</div>
			
			</div>
			<div class="col-md-9">
			
				<div class="panel panel-default">
					<div class="panel-body">
					<?php

if($c == "edit") {
$query = $db->query("SELECT * FROM btc_ads WHERE id='$id' and uid='$_SESSION[btc_uid]'");
if($query->num_rows==0) { $redirect = $settings['url']."account/advertisements"; header("Location: $redirect"); }
$row = $query->fetch_assoc();
?>
						<h4><?php echo $lang['menu_advertisements']; ?> <small><?php echo $lang['edit']; ?></small></h4>
						<hr/>
						<?php
						if(isset($_POST['btc_save'])) { 
							$payment_method = protect($_POST['payment_method']);
							$currency = protect($_POST['currency']);
							$amount = protect($_POST['amount']);
							$payment_instructions = protect($_POST['payment_instructions']);
							$min_amount = protect($_POST['min_amount']);
							$max_amount = protect($_POST['max_amount']);
							$process_time = protect($_POST['process_time']);
							$terms = protect($_POST['terms']);
							if(isset($_POST['require_document'])) { $require_document = '1'; } else { $require_document = '0'; }
							if(isset($_POST['require_email'])) { $require_email = '1'; } else { $require_email = '0'; }
							if(isset($_POST['require_mobile'])) { $require_mobile = '1'; } else { $require_mobile = '0'; }
							if(empty($payment_method) or empty($currency) or empty($amount) or empty($payment_instructions) or empty($min_amount) or empty($max_amount) or empty($process_time) or empty($terms)) { echo error($lang['error_7']); }
							elseif(!is_numeric($amount)) { echo error($lang['error_14']); }
							elseif(!is_numeric($min_amount)) { echo error($lang['error_15']); }
							elseif(!is_numeric($max_amount)) { echo error($lang['error_16']); }
							elseif(!is_numeric($process_time)) { echo error($lang['error_17']); }
							else {
								$update = $db->query("UPDATE btc_ads SET require_document='$require_document',require_email='$require_email',require_mobile='$require_mobile',payment_method='$payment_method',currency='$currency',price='$amount',payment_instructions='$payment_instructions',min_amount='$min_amount',max_amount='$max_amount',process_time='$process_time',terms='$terms' WHERE id='$row[id]'");
								$query = $db->query("SELECT * FROM btc_ads WHERE id='$row[id]'");
								$row = $query->fetch_assoc();
								echo success($lang['success_12']);
							}
						}
						?>
						<form action="" method="POST">
							<div class="col-md-12">
							<?php
							if($row['type'] == "sell") {
								echo $lang['current_ad_type_sell'];
							} else {
								echo $lang['current_ad_type_buy'];
							}
							?>
							<br><br>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label><?php echo $lang['payment_method']; ?></label>
									<select class="form-control" name="payment_method">
										<option value="PayPal" <?php if($row['payment_method'] == "PayPal") { echo 'selected'; } ?>>PayPal</option>
										<option value="Skrill" <?php if($row['payment_method'] == "Skrill") { echo 'selected'; } ?>>Skrill</option>
										<option value="Payeer" <?php if($row['payment_method'] == "Payeer") { echo 'selected'; } ?>>Payeer</option>
										<option value="Xoomwallet" <?php if($row['payment_method'] == "Xoomwallet") { echo 'selected'; } ?>>Xoomwallet</option>
										<option value="Perfect Money" <?php if($row['payment_method'] == "Perfect Money") { echo 'selected'; } ?>>Perfect Money</option>
										<option value="Payoneer" <?php if($row['payment_method'] == "Payoneer") { echo 'selected'; } ?>>Payoneer</option>
										<option value="AdvCash" <?php if($row['payment_method'] == "AdvCash") { echo 'selected'; } ?>>AdvCash</option>
										<option value="OKPay" <?php if($row['payment_method'] == "OKPay") { echo 'selected'; } ?>>OKPay</option>
										<option value="Entromoney" <?php if($row['payment_method'] == "Entromoney") { echo 'selected'; } ?>>Entromoney</option>
										<option value="SolidTrust Pay" <?php if($row['payment_method'] == "SolidTrust Pay") { echo 'selected'; } ?>>SolidTrust Pay</option>
										<option value="Neteller" <?php if($row['payment_method'] == "Neteller") { echo 'selected'; } ?>>Neteller</option>
										<option value="UQUID" <?php if($row['payment_method'] == "UQUID") { echo 'selected'; } ?>>UQUID</option>
										<option value="Yandex Money" <?php if($row['payment_method'] == "Yandex Money") { echo 'selected'; } ?>>Yandex Money</option>
										<option value="QIWI" <?php if($row['payment_method'] == "QIWI") { echo 'selected'; } ?>>QIWI</option>
										<option value="Bank Transfer" <?php if($row['payment_method'] == "Bank Transfer") { echo 'selected'; } ?>>Bank Transfer</option>
										<option value="Western Union" <?php if($row['payment_method'] == "Western Union") { echo 'selected'; } ?>>Western Union</option>
										<option value="Moneygram" <?php if($row['payment_method'] == "Moneygram") { echo 'selected'; } ?>>Moneygram</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<br><span class="text text-muted"><?php echo $lang['payment_method_info']; ?></span>
							</div>
							<div class="col-md-12"><br></div>
							<div class="col-md-6">
								<div class="form-group">
									<label><?php echo $lang['currency']; ?></label>
									<select class="form-control" name="currency" onchange="btc_calculate_price();" id="btc_currency">
											<option value="AED" <?php if($row['currency'] == "AED") { echo 'selected'; } ?>>AED - United Arab Emirates Dirham</option>
											<option value="AFN" <?php if($row['currency'] == "AFN") { echo 'selected'; } ?>>AFN - Afghanistan Afghani</option>
											<option value="ALL" <?php if($row['currency'] == "ALL") { echo 'selected'; } ?>>ALL - Albania Lek</option>
											<option value="AMD" <?php if($row['currency'] == "AMD") { echo 'selected'; } ?>>AMD - Armenia Dram</option>
											<option value="ANG" <?php if($row['currency'] == "ANG") { echo 'selected'; } ?>>ANG - Netherlands Antilles Guilder</option>
											<option value="AOA" <?php if($row['currency'] == "AOA") { echo 'selected'; } ?>>AOA - Angola Kwanza</option>
											<option value="ARS" <?php if($row['currency'] == "ARS") { echo 'selected'; } ?>>ARS - Argentina Peso</option>
											<option value="AUD" <?php if($row['currency'] == "AUD") { echo 'selected'; } ?>>AUD - Australia Dollar</option>
											<option value="AWG" <?php if($row['currency'] == "AWG") { echo 'selected'; } ?>>AWG - Aruba Guilder</option>
											<option value="AZN" <?php if($row['currency'] == "AZN") { echo 'selected'; } ?>>AZN - Azerbaijan New Manat</option>
											<option value="BAM" <?php if($row['currency'] == "BAM") { echo 'selected'; } ?>>BAM - Bosnia and Herzegovina Convertible Marka</option>
											<option value="BBD" <?php if($row['currency'] == "BBD") { echo 'selected'; } ?>>BBD - Barbados Dollar</option>
											<option value="BDT" <?php if($row['currency'] == "BDT") { echo 'selected'; } ?>>BDT - Bangladesh Taka</option>
											<option value="BGN" <?php if($row['currency'] == "BGN") { echo 'selected'; } ?>>BGN - Bulgaria Lev</option>
											<option value="BHD" <?php if($row['currency'] == "BHD") { echo 'selected'; } ?>>BHD - Bahrain Dinar</option>
											<option value="BIF" <?php if($row['currency'] == "BIF") { echo 'selected'; } ?>>BIF - Burundi Franc</option>
											<option value="BMD" <?php if($row['currency'] == "BMD") { echo 'selected'; } ?>>BMD - Bermuda Dollar</option>
											<option value="BND" <?php if($row['currency'] == "BND") { echo 'selected'; } ?>>BND - Brunei Darussalam Dollar</option>
											<option value="BOB" <?php if($row['currency'] == "BOB") { echo 'selected'; } ?>>BOB - Bolivia Boliviano</option>
											<option value="BRL" <?php if($row['currency'] == "BRL") { echo 'selected'; } ?>>BRL - Brazil Real</option>
											<option value="BSD" <?php if($row['currency'] == "BSD") { echo 'selected'; } ?>>BSD - Bahamas Dollar</option>
											<option value="BTN" <?php if($row['currency'] == "BTN") { echo 'selected'; } ?>>BTN - Bhutan Ngultrum</option>
											<option value="BWP" <?php if($row['currency'] == "BWP") { echo 'selected'; } ?>>BWP - Botswana Pula</option>
											<option value="BYR" <?php if($row['currency'] == "BYR") { echo 'selected'; } ?>>BYR - Belarus Ruble</option>
											<option value="BZD" <?php if($row['currency'] == "BZD") { echo 'selected'; } ?>>BZD - Belize Dollar</option>
											<option value="CAD" <?php if($row['currency'] == "CAD") { echo 'selected'; } ?>>CAD - Canada Dollar</option>
											<option value="CDF" <?php if($row['currency'] == "CDF") { echo 'selected'; } ?>>CDF - Congo/Kinshasa Franc</option>
											<option value="CHF" <?php if($row['currency'] == "CHF") { echo 'selected'; } ?>>CHF - Switzerland Franc</option>
											<option value="CLP" <?php if($row['currency'] == "CLP") { echo 'selected'; } ?>>CLP - Chile Peso</option>
											<option value="CNY" <?php if($row['currency'] == "CNY") { echo 'selected'; } ?>>CNY - China Yuan Renminbi</option>
											<option value="COP" <?php if($row['currency'] == "COP") { echo 'selected'; } ?>>COP - Colombia Peso</option>
											<option value="CRC" <?php if($row['currency'] == "CRC") { echo 'selected'; } ?>>CRC - Costa Rica Colon</option>
											<option value="CUC" <?php if($row['currency'] == "CUC") { echo 'selected'; } ?>>CUC - Cuba Convertible Peso</option>
											<option value="CUP" <?php if($row['currency'] == "CUP") { echo 'selected'; } ?>>CUP - Cuba Peso</option>
											<option value="CVE" <?php if($row['currency'] == "CVE") { echo 'selected'; } ?>>CVE - Cape Verde Escudo</option>
											<option value="CZK" <?php if($row['currency'] == "CZK") { echo 'selected'; } ?>>CZK - Czech Republic Koruna</option>
											<option value="DJF" <?php if($row['currency'] == "DJF") { echo 'selected'; } ?>>DJF - Djibouti Franc</option>
											<option value="DKK" <?php if($row['currency'] == "DKK") { echo 'selected'; } ?>>DKK - Denmark Krone</option>
											<option value="DOP" <?php if($row['currency'] == "DOP") { echo 'selected'; } ?>>DOP - Dominican Republic Peso</option>
											<option value="DZD" <?php if($row['currency'] == "DZD") { echo 'selected'; } ?>>DZD - Algeria Dinar</option>
											<option value="EGP" <?php if($row['currency'] == "EGP") { echo 'selected'; } ?>>EGP - Egypt Pound</option>
											<option value="ERN" <?php if($row['currency'] == "ERN") { echo 'selected'; } ?>>ERN - Eritrea Nakfa</option>
											<option value="ETB" <?php if($row['currency'] == "ETB") { echo 'selected'; } ?>>ETB - Ethiopia Birr</option>
											<option value="EUR" <?php if($row['currency'] == "EUR") { echo 'selected'; } ?>>EUR - Euro Member Countries</option>
											<option value="FJD" <?php if($row['currency'] == "FJD") { echo 'selected'; } ?>>FJD - Fiji Dollar</option>
											<option value="FKP" <?php if($row['currency'] == "FKP") { echo 'selected'; } ?>>FKP - Falkland Islands (Malvinas) Pound</option>
											<option value="GBP" <?php if($row['currency'] == "GBP") { echo 'selected'; } ?>>GBP - United Kingdom Pound</option>
											<option value="GEL" <?php if($row['currency'] == "GEL") { echo 'selected'; } ?>>GEL - Georgia Lari</option>
											<option value="GGP" <?php if($row['currency'] == "GGP") { echo 'selected'; } ?>>GGP - Guernsey Pound</option>
											<option value="GHS" <?php if($row['currency'] == "GHS") { echo 'selected'; } ?>>GHS - Ghana Cedi</option>
											<option value="GIP" <?php if($row['currency'] == "GIP") { echo 'selected'; } ?>>GIP - Gibraltar Pound</option>
											<option value="GMD" <?php if($row['currency'] == "GMD") { echo 'selected'; } ?>>GMD - Gambia Dalasi</option>
											<option value="GNF" <?php if($row['currency'] == "GNF") { echo 'selected'; } ?>>GNF - Guinea Franc</option>
											<option value="GTQ" <?php if($row['currency'] == "GTQ") { echo 'selected'; } ?>>GTQ - Guatemala Quetzal</option>
											<option value="GYD" <?php if($row['currency'] == "GYD") { echo 'selected'; } ?>>GYD - Guyana Dollar</option>
											<option value="HKD" <?php if($row['currency'] == "HKD") { echo 'selected'; } ?>>HKD - Hong Kong Dollar</option>
											<option value="HNL" <?php if($row['currency'] == "HNL") { echo 'selected'; } ?>>HNL - Honduras Lempira</option>
											<option value="HPK" <?php if($row['currency'] == "HPK") { echo 'selected'; } ?>>HRK - Croatia Kuna</option>
											<option value="HTG" <?php if($row['currency'] == "HTG") { echo 'selected'; } ?>>HTG - Haiti Gourde</option>
											<option value="HUF" <?php if($row['currency'] == "HUF") { echo 'selected'; } ?>>HUF - Hungary Forint</option>
											<option value="IDR" <?php if($row['currency'] == "IDR") { echo 'selected'; } ?>>IDR - Indonesia Rupiah</option>
											<option value="ILS" <?php if($row['currency'] == "TLS") { echo 'selected'; } ?>>ILS - Israel Shekel</option>
											<option value="IMP" <?php if($row['currency'] == "IMP") { echo 'selected'; } ?>>IMP - Isle of Man Pound</option>
											<option value="INR" <?php if($row['currency'] == "INR") { echo 'selected'; } ?>>INR - India Rupee</option>
											<option value="IQD" <?php if($row['currency'] == "IDQ") { echo 'selected'; } ?>>IQD - Iraq Dinar</option>
											<option value="IRR" <?php if($row['currency'] == "IRR") { echo 'selected'; } ?>>IRR - Iran Rial</option>
											<option value="ISK" <?php if($row['currency'] == "ISK") { echo 'selected'; } ?>>ISK - Iceland Krona</option>
											<option value="JEP" <?php if($row['currency'] == "JEP") { echo 'selected'; } ?>>JEP - Jersey Pound</option>
											<option value="JMD" <?php if($row['currency'] == "JMD") { echo 'selected'; } ?>>JMD - Jamaica Dollar</option>
											<option value="JOD" <?php if($row['currency'] == "JOD") { echo 'selected'; } ?>>JOD - Jordan Dinar</option>
											<option value="JPY" <?php if($row['currency'] == "JPY") { echo 'selected'; } ?>>JPY - Japan Yen</option>
											<option value="KES" <?php if($row['currency'] == "KES") { echo 'selected'; } ?>>KES - Kenya Shilling</option>
											<option value="KGS" <?php if($row['currency'] == "KGS") { echo 'selected'; } ?>>KGS - Kyrgyzstan Som</option>
											<option value="KHR" <?php if($row['currency'] == "KHR") { echo 'selected'; } ?>>KHR - Cambodia Riel</option>
											<option value="KMF" <?php if($row['currency'] == "KMF") { echo 'selected'; } ?>>KMF - Comoros Franc</option>
											<option value="KPW" <?php if($row['currency'] == "KPW") { echo 'selected'; } ?>>KPW - Korea (North) Won</option>
											<option value="KRW" <?php if($row['currency'] == "KRW") { echo 'selected'; } ?>>KRW - Korea (South) Won</option>
											<option value="KWD" <?php if($row['currency'] == "KWD") { echo 'selected'; } ?>>KWD - Kuwait Dinar</option>
											<option value="KYD" <?php if($row['currency'] == "KYD") { echo 'selected'; } ?>>KYD - Cayman Islands Dollar</option>
											<option value="KZT" <?php if($row['currency'] == "KZT") { echo 'selected'; } ?>>KZT - Kazakhstan Tenge</option>
											<option value="LAK" <?php if($row['currency'] == "LAK") { echo 'selected'; } ?>>LAK - Laos Kip</option>
											<option value="LBP" <?php if($row['currency'] == "LBP") { echo 'selected'; } ?>>LBP - Lebanon Pound</option>
											<option value="LKR" <?php if($row['currency'] == "LKR") { echo 'selected'; } ?>>LKR - Sri Lanka Rupee</option>
											<option value="LRD" <?php if($row['currency'] == "LRD") { echo 'selected'; } ?>>LRD - Liberia Dollar</option>
											<option value="LSL" <?php if($row['currency'] == "LSL") { echo 'selected'; } ?>>LSL - Lesotho Loti</option>
											<option value="LYD" <?php if($row['currency'] == "LYD") { echo 'selected'; } ?>>LYD - Libya Dinar</option>
											<option value="MAD" <?php if($row['currency'] == "MAD") { echo 'selected'; } ?>>MAD - Morocco Dirham</option>
											<option value="MDL" <?php if($row['currency'] == "MDL") { echo 'selected'; } ?>>MDL - Moldova Leu</option>
											<option value="MGA" <?php if($row['currency'] == "MGA") { echo 'selected'; } ?>>MGA - Madagascar Ariary</option>
											<option value="MKD" <?php if($row['currency'] == "MKD") { echo 'selected'; } ?>>MKD - Macedonia Denar</option>
											<option value="MMK" <?php if($row['currency'] == "MMK") { echo 'selected'; } ?>>MMK - Myanmar (Burma) Kyat</option>
											<option value="MNT" <?php if($row['currency'] == "MNT") { echo 'selected'; } ?>>MNT - Mongolia Tughrik</option>
											<option value="MOP" <?php if($row['currency'] == "MOP") { echo 'selected'; } ?>>MOP - Macau Pataca</option>
											<option value="MRO" <?php if($row['currency'] == "MRO") { echo 'selected'; } ?>>MRO - Mauritania Ouguiya</option>
											<option value="MUR" <?php if($row['currency'] == "MUR") { echo 'selected'; } ?>>MUR - Mauritius Rupee</option>
											<option value="MVR" <?php if($row['currency'] == "MVR") { echo 'selected'; } ?>>MVR - Maldives (Maldive Islands) Rufiyaa</option>
											<option value="MWK" <?php if($row['currency'] == "MWK") { echo 'selected'; } ?>>MWK - Malawi Kwacha</option>
											<option value="MXN" <?php if($row['currency'] == "MXN") { echo 'selected'; } ?>>MXN - Mexico Peso</option>
											<option value="MYR" <?php if($row['currency'] == "MYR") { echo 'selected'; } ?>>MYR - Malaysia Ringgit</option>
											<option value="MZN" <?php if($row['currency'] == "MZN") { echo 'selected'; } ?>>MZN - Mozambique Metical</option>
											<option value="NAD" <?php if($row['currency'] == "NAD") { echo 'selected'; } ?>>NAD - Namibia Dollar</option>
											<option value="NGN" <?php if($row['currency'] == "NGN") { echo 'selected'; } ?>>NGN - Nigeria Naira</option>
											<option value="NTO" <?php if($row['currency'] == "NTO") { echo 'selected'; } ?>>NIO - Nicaragua Cordoba</option>
											<option value="NOK" <?php if($row['currency'] == "NOK") { echo 'selected'; } ?>>NOK - Norway Krone</option>
											<option value="NPR" <?php if($row['currency'] == "NPR") { echo 'selected'; } ?>>NPR - Nepal Rupee</option>
											<option value="NZD" <?php if($row['currency'] == "NZD") { echo 'selected'; } ?>>NZD - New Zealand Dollar</option>
											<option value="OMR" <?php if($row['currency'] == "OMR") { echo 'selected'; } ?>>OMR - Oman Rial</option>
											<option value="PAB" <?php if($row['currency'] == "PAB") { echo 'selected'; } ?>>PAB - Panama Balboa</option>
											<option value="PEN" <?php if($row['currency'] == "PEN") { echo 'selected'; } ?>>PEN - Peru Nuevo Sol</option>
											<option value="PGK" <?php if($row['currency'] == "PHK") { echo 'selected'; } ?>>PGK - Papua New Guinea Kina</option>
											<option value="PHP" <?php if($row['currency'] == "PHP") { echo 'selected'; } ?>>PHP - Philippines Peso</option>
											<option value="PKR" <?php if($row['currency'] == "PKR") { echo 'selected'; } ?>>PKR - Pakistan Rupee</option>
											<option value="PLN" <?php if($row['currency'] == "PLN") { echo 'selected'; } ?>>PLN - Poland Zloty</option>
											<option value="PYG" <?php if($row['currency'] == "PYG") { echo 'selected'; } ?>>PYG - Paraguay Guarani</option>
											<option value="QAR" <?php if($row['currency'] == "QAR") { echo 'selected'; } ?>>QAR - Qatar Riyal</option>
											<option value="RON" <?php if($row['currency'] == "RON") { echo 'selected'; } ?>>RON - Romania New Leu</option>
											<option value="RSD" <?php if($row['currency'] == "RSD") { echo 'selected'; } ?>>RSD - Serbia Dinar</option>
											<option value="RUB" <?php if($row['currency'] == "RUB") { echo 'selected'; } ?>>RUB - Russia Ruble</option>
											<option value="RWF" <?php if($row['currency'] == "RWF") { echo 'selected'; } ?>>RWF - Rwanda Franc</option>
											<option value="SAR" <?php if($row['currency'] == "SAR") { echo 'selected'; } ?>>SAR - Saudi Arabia Riyal</option>
											<option value="SBD" <?php if($row['currency'] == "SBD") { echo 'selected'; } ?>>SBD - Solomon Islands Dollar</option>
											<option value="SCR" <?php if($row['currency'] == "SCR") { echo 'selected'; } ?>>SCR - Seychelles Rupee</option>
											<option value="SDG" <?php if($row['currency'] == "SDG") { echo 'selected'; } ?>>SDG - Sudan Pound</option>
											<option value="SEK" <?php if($row['currency'] == "SEK") { echo 'selected'; } ?>>SEK - Sweden Krona</option>
											<option value="SGD" <?php if($row['currency'] == "SGD") { echo 'selected'; } ?>>SGD - Singapore Dollar</option>
											<option value="SHP" <?php if($row['currency'] == "SHP") { echo 'selected'; } ?>>SHP - Saint Helena Pound</option>
											<option value="SLL" <?php if($row['currency'] == "SLL") { echo 'selected'; } ?>>SLL - Sierra Leone Leone</option>
											<option value="SOS" <?php if($row['currency'] == "SOS") { echo 'selected'; } ?>>SOS - Somalia Shilling</option>
											<option value="SRL" <?php if($row['currency'] == "SRL") { echo 'selected'; } ?>>SPL* - Seborga Luigino</option>
											<option value="SRD" <?php if($row['currency'] == "SRD") { echo 'selected'; } ?>>SRD - Suriname Dollar</option>
											<option value="STD" <?php if($row['currency'] == "STD") { echo 'selected'; } ?>>STD - Sao Tome and Principe Dobra</option>
											<option value="SVC" <?php if($row['currency'] == "SVC") { echo 'selected'; } ?>>SVC - El Salvador Colon</option>
											<option value="SYP" <?php if($row['currency'] == "SYP") { echo 'selected'; } ?>>SYP - Syria Pound</option>
											<option value="SZL" <?php if($row['currency'] == "SZL") { echo 'selected'; } ?>>SZL - Swaziland Lilangeni</option>
											<option value="THB" <?php if($row['currency'] == "THB") { echo 'selected'; } ?>>THB - Thailand Baht</option>
											<option value="TJS" <?php if($row['currency'] == "TJS") { echo 'selected'; } ?>>TJS - Tajikistan Somoni</option>
											<option value="TMT" <?php if($row['currency'] == "TMT") { echo 'selected'; } ?>>TMT - Turkmenistan Manat</option>
											<option value="TND" <?php if($row['currency'] == "TND") { echo 'selected'; } ?>>TND - Tunisia Dinar</option>
											<option value="TOP" <?php if($row['currency'] == "TOP") { echo 'selected'; } ?>>TOP - Tonga Pa'anga</option>
											<option value="TRY" <?php if($row['currency'] == "TRY") { echo 'selected'; } ?>>TRY - Turkey Lira</option>
											<option value="TTD" <?php if($row['currency'] == "TTD") { echo 'selected'; } ?>>TTD - Trinidad and Tobago Dollar</option>
											<option value="TVD" <?php if($row['currency'] == "TVD") { echo 'selected'; } ?>>TVD - Tuvalu Dollar</option>
											<option value="TWD" <?php if($row['currency'] == "TWD") { echo 'selected'; } ?>>TWD - Taiwan New Dollar</option>
											<option value="TZS" <?php if($row['currency'] == "TZS") { echo 'selected'; } ?>>TZS - Tanzania Shilling</option>
											<option value="UAH" <?php if($row['currency'] == "UAH") { echo 'selected'; } ?>>UAH - Ukraine Hryvnia</option>
											<option value="UGX" <?php if($row['currency'] == "UGX") { echo 'selected'; } ?>>UGX - Uganda Shilling</option>
											<option value="USD"  <?php if($row['currency'] == "USD") { echo 'selected'; } ?>>USD - United States Dollar</option>
											<option value="UYU" <?php if($row['currency'] == "UYU") { echo 'selected'; } ?>>UYU - Uruguay Peso</option>
											<option value="UZS" <?php if($row['currency'] == "UZS") { echo 'selected'; } ?>>UZS - Uzbekistan Som</option>
											<option value="VEF" <?php if($row['currency'] == "VEF") { echo 'selected'; } ?>>VEF - Venezuela Bolivar</option>
											<option value="VND" <?php if($row['currency'] == "VND") { echo 'selected'; } ?>>VND - Viet Nam Dong</option>
											<option value="VUV" <?php if($row['currency'] == "VUV") { echo 'selected'; } ?>>VUV - Vanuatu Vatu</option>
											<option value="WST" <?php if($row['currency'] == "WST") { echo 'selected'; } ?>>WST - Samoa Tala</option>
											<option value="XAF" <?php if($row['currency'] == "XAF") { echo 'selected'; } ?>>XAF - Communaute Financiere Africaine (BEAC) CFA Franc BEAC</option>
											<option value="XCD" <?php if($row['currency'] == "XCD") { echo 'selected'; } ?>>XCD - East Caribbean Dollar</option>
											<option value="XDR" <?php if($row['currency'] == "XDR") { echo 'selected'; } ?>>XDR - International Monetary Fund (IMF) Special Drawing Rights</option>
											<option value="XOF" <?php if($row['currency'] == "XOF") { echo 'selected'; } ?>>XOF - Communaute Financiere Africaine (BCEAO) Franc</option>
											<option value="XPF" <?php if($row['currency'] == "XPF") { echo 'selected'; } ?>>XPF - Comptoirs Francais du Pacifique (CFP) Franc</option>
											<option value="YER" <?php if($row['currency'] == "YER") { echo 'selected'; } ?>>YER - Yemen Rial</option>
											<option value="ZAR" <?php if($row['currency'] == "ZAR") { echo 'selected'; } ?>>ZAR - South Africa Rand</option>
											<option value="ZMW" <?php if($row['currency'] == "ZMW") { echo 'selected'; } ?>>ZMW - Zambia Kwacha</option>
											<option value="ZWD" <?php if($row['currency'] == "ZWD") { echo 'selected'; } ?>>ZWD - Zimbabwe Dollar</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<br><span class="text text-muted"><?php echo $lang['currency_info']; ?></span>
							</div>
							<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $lang['enter_comission']; ?></label>
										<input type="text" class="form-control" name="amount" value="<?php echo $row['price']; ?>" onkeyup="btc_calculate_price();" onkeydown="btc_calculate_price();" id="btc_amount">
										<?php echo $lang['currenct_bitcoin_price']; ?>: <?php echo get_current_bitcoin_price(); ?> USD<br/>
										<span id="your_btc_price"><?php echo $lang['your_bitcoin_price']; ?>: <?php echo convertBTCprice($row['price'],$row['currency']); ?> <?php echo $row['currency']; ?></span>
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['enter_comission_info']; ?></span>
								</div>
							<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $lang['payment_instructions']; ?></label>
										<textarea class="form-control" name="payment_instructions" rows="5"><?php echo $row['payment_instructions']; ?></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['payment_instructions_info']; ?></span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $lang['minimal_trade_amount']; ?></label>
										<input type="text" class="form-control" name="min_amount" value="<?php echo $row['min_amount']; ?>">
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['minimal_trade_amount_info']; ?></span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $lang['maximum_trade_amount']; ?></label>
										<input type="text" class="form-control" name="max_amount" value="<?php echo $row['max_amount']; ?>">
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['maximum_trade_amount_info']; ?></span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $lang['trade_process_time']; ?></label>
										<input type="text" class="form-control" name="process_time" value="<?php echo $row['process_time']; ?>">
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['trade_process_time_info']; ?></span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $lang['terms_of_trade']; ?></label>
										<textarea class="form-control" name="terms" rows="5"><?php echo $row['terms']; ?></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['terms_of_trade_info']; ?></span>
								</div>
								<?php if($settings['document_verification'] == "1") { ?>
								<div class="col-md-12">
									 <div class="checkbox">
										<label>
										  <input type="checkbox" name="require_document" value="yes" <?php if($row['require_document'] == "1") { echo 'checked'; } ?>> <?php echo $lang['require_document']; ?>
										</label>
									  </div>
								</div>
								<?php } ?>
								<?php if($settings['email_verification'] == "1") { ?>
								<div class="col-md-12">
									 <div class="checkbox">
										<label>
										  <input type="checkbox" name="require_email" value="yes" <?php if($row['require_email'] == "1") { echo 'checked'; } ?>> <?php echo $lang['require_email']; ?>
										</label>
									  </div>
								</div>
								<?php } ?>
								<?php if($settings['phone_verification'] == "1") { ?>
								<div class="col-md-12">
									 <div class="checkbox">
										<label>
										  <input type="checkbox" name="require_mobile" value="yes" <?php if($row['require_mobile'] == "1") { echo 'checked'; } ?>> <?php echo $lang['require_mobile']; ?>
										</label>
									  </div>
								</div>
								<?php } ?>
								<div class="col-md-12">
								<button type="submit" class="btn btn-primary" name="btc_save"><i class="fa fa-check"></i> <?php echo $lang['btn_save_changes']; ?></button>
								</div>
						</form>
<?php
} elseif($c == "delete") {
$query = $db->query("SELECT * FROM btc_ads WHERE id='$id' and uid='$_SESSION[btc_uid]'");
if($query->num_rows==0) { $redirect = $settings['url']."account/advertisements"; header("Location: $redirect"); }
$row = $query->fetch_assoc();
?>
						<h4><?php echo $lang['menu_advertisements']; ?> <small><?php echo $lang['delete']; ?></small></h4>
						<hr/>
						<?php
						if(isset($_GET['confirm'])) {
							$delete = $db->query("DELETE FROM btc_ads WHERE id='$row[id]'");
							$delete = $db->query("DELETE FROM btc_trades WHERE ad_id='$row[id]'");
							$lang_ad_deleted = str_ireplace("%ad_id%",$row['id'],$lang['ad_deleted']);
							echo success($lang_ad_deleted);
						} else {
							echo info("$lang[info_4] <b>#$row[id]</b>?");
							echo '<a href="'.$settings[url].'account/advertisements/confirm/delete/'.$row[id].'" class="btn btn-success"><i class="fa fa-check"></i> '.$lang[yes].'</a> 
							<a href="'.$settings[url].'account/advertisements" class="btn btn-danger"><i class="fa fa-times"></i> '.$lang[no].'</a>';
						}
						?>
<?php
} else {
?>
						<h4><?php echo $lang['menu_advertisements']; ?></h4>
						<hr/>
						<?php
						$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
						$limit = 10;
						$startpoint = ($page * $limit) - $limit;
						if($page == 1) {
							$i = 1;
						} else {
							$i = $page * $limit;
						}
						$statement = "btc_ads WHERE uid='$_SESSION[btc_uid]'";
						$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
						if($query->num_rows>0) {
								echo '<table class="table table-striped">
									<thead>
										<tr>
											<th>'.$lang[ad_type].'</th>
											<th>'.$lang[payment_method].'</th>
											<th>'.$lang[price].'</th>
											<th>'.$lang[limits].'</th>
											<th>'.$lang[process_time].'</th>
											<th>'.$lang[action].'</th>
										</tr>
									</thead>
									<tbody>';
								while($row = $query->fetch_assoc()) {
									?>
									<tr>
										<td><?php if($row['type'] == "sell") { echo 'Sell bitcoins'; } else { echo 'Buy bitcoins'; } ?></td>
										<td><?php echo $row['payment_method']; ?></td>
										<td><?php echo convertBTCprice($row['price'],$row['currency']); ?> <?php echo $row['currency']; ?>/BTC</td>
										<td><?php echo $row['min_amount']; ?> - <?php echo $row['max_amount']; ?> <?php echo $row['currency']; ?></td>
										<td><?php echo $row['process_time']; ?> minutes</td>
										<td>
											<a href="<?php echo $settings['url']; ?>account/advertisements/edit/<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
											<a href="<?php echo $settings['url']; ?>account/advertisements/delete/<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
										</td>
									</tr>
									<?php
								}
								echo '</tbody>
								</table>';
						} else {
							echo info($lang['info_5']);
						}
						?>

						<?php
						$ver = $settings['url']."account/advertisements/page";
						if(web_pagination($statement,$ver,$limit,$page)) {
							echo web_pagination($statement,$ver,$limit,$page);
						}
						?>
<?php } ?>
				</div>
				</div>
			
			</div>
		</div>
	</div>