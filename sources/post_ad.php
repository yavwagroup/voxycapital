<?php 
if(!checkSession()) { $redirect = $settings['url']."login"; header("Location:$redirect"); } 
?>
<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
                		<h3 class="white-heading"><?php echo $lang['post_ad']; ?></h3>
                    </div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	 <!-- full width section -->
    	<div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
						<?php
					if(isset($_POST['btc_post_ad'])) {
						$type = protect($_POST['type']);
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
						if(empty($type) or empty($payment_method) or empty($currency) or empty($amount) or empty($payment_instructions) or empty($min_amount) or empty($max_amount) or empty($process_time) or empty($terms)) { echo error($lang['error_7']); }
						elseif(!is_numeric($amount)) { echo error($lang['error_14']); }
						elseif(!is_numeric($min_amount)) { echo error($lang['error_15']); }
						elseif(!is_numeric($max_amount)) { echo error($lang['error_16']); }
						elseif(!is_numeric($process_time)) { echo error($lang['error_17']); }
						else {
							$insert = $db->query("INSERT btc_ads (uid,type,payment_method,currency,payment_instructions,price,min_amount,max_amount,process_time,terms,require_document,require_email,require_mobile) VALUES ('$_SESSION[btc_uid]','$type','$payment_method','$currency','$payment_instructions','$amount','$min_amount','$max_amount','$process_time','$terms','$require_document','$require_email','$require_mobile')");
							$query = $db->query("SELECT * FROM btc_ads WHERE uid='$_SESSION[btc_uid]' ORDER BY id DESC LIMIT 1");
							$row = $query->fetch_assoc();
							$pm = str_ireplace(" ","-",$payment_method);
							if($type == "sell") {
								$ad_link = '<a href="'.$settings[url].'ad/'.$pm.'-to-Bitcoin/'.$row[id].'">'.$settings[url].'ad/'.$pm.'-to-Bitcoin/'.$row[id].'</a>';
							} else {
								$ad_link = '<a href="'.$settings[url].'ad/Bitcoin-to-'.$pm.'/'.$row[id].'">'.$settings[url].'ad/Bitcoin-to-'.$pm.'/'.$row[id].'</a>';
							}
							echo success("$lang[success_3] $ad_link");
						}	
					}
					?>
					<form action="" method="POST">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?php echo $lang['ad_type']; ?></label>
									<br>
									<div class="radio">
									  <label>
										<input type="radio" name="type" id="optionsRadios1" value="buy" checked>
										<?php echo $lang['buy_bitcoins']; ?>
									  </label>
									</div>
									<br>
									<div class="radio">
									  <label>
										<input type="radio" name="type" id="optionsRadios2" value="sell">
										<?php echo $lang['sell_bitcoins']; ?>
									  </label>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<br><span class="text text-muted"><?php echo $lang['ad_type_info']; ?></span>
							</div>
							<div class="col-md-12"><br></div>
							<div class="col-md-6">
								<div class="form-group">
									<label><?php echo $lang['payment_method']; ?></label>
									<select class="form-control" name="payment_method">
										<option value="PayPal">PayPal</option>
										<option value="Skrill">Skrill</option>
										<option value="Payeer">Payeer</option>
										<option value="Xoomwallet">Xoomwallet</option>
										<option value="Perfect Money">Perfect Money</option>
										<option value="Payoneer">Payoneer</option>
										<option value="AdvCash">AdvCash</option>
										<option value="OKPay">OKPay</option>
										<option value="Entromoney">Entromoney</option>
										<option value="SolidTrust Pay">SolidTrust Pay</option>
										<option value="Neteller">Neteller</option>
										<option value="UQUID">UQUID</option>
										<option value="Yandex Money">Yandex Money</option>
										<option value="QIWI">QIWI</option>
										<option value="Bank Transfer">Bank Transfer</option>
										<option value="Western Union">Western Union</option>
										<option value="Moneygram">Moneygram</option>
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
										<option value="AED">AED - United Arab Emirates Dirham</option>
											<option value="AFN">AFN - Afghanistan Afghani</option>
											<option value="ALL">ALL - Albania Lek</option>
											<option value="AMD">AMD - Armenia Dram</option>
											<option value="ANG">ANG - Netherlands Antilles Guilder</option>
											<option value="AOA">AOA - Angola Kwanza</option>
											<option value="ARS">ARS - Argentina Peso</option>
											<option value="AUD">AUD - Australia Dollar</option>
											<option value="AWG">AWG - Aruba Guilder</option>
											<option value="AZN">AZN - Azerbaijan New Manat</option>
											<option value="BAM">BAM - Bosnia and Herzegovina Convertible Marka</option>
											<option value="BBD">BBD - Barbados Dollar</option>
											<option value="BDT">BDT - Bangladesh Taka</option>
											<option value="BGN">BGN - Bulgaria Lev</option>
											<option value="BHD">BHD - Bahrain Dinar</option>
											<option value="BIF">BIF - Burundi Franc</option>
											<option value="BMD">BMD - Bermuda Dollar</option>
											<option value="BND">BND - Brunei Darussalam Dollar</option>
											<option value="BOB">BOB - Bolivia Boliviano</option>
											<option value="BRL">BRL - Brazil Real</option>
											<option value="BSD">BSD - Bahamas Dollar</option>
											<option value="BTN">BTN - Bhutan Ngultrum</option>
											<option value="BWP">BWP - Botswana Pula</option>
											<option value="BYR">BYR - Belarus Ruble</option>
											<option value="BZD">BZD - Belize Dollar</option>
											<option value="CAD">CAD - Canada Dollar</option>
											<option value="CDF">CDF - Congo/Kinshasa Franc</option>
											<option value="CHF">CHF - Switzerland Franc</option>
											<option value="CLP">CLP - Chile Peso</option>
											<option value="CNY">CNY - China Yuan Renminbi</option>
											<option value="COP">COP - Colombia Peso</option>
											<option value="CRC">CRC - Costa Rica Colon</option>
											<option value="CUC">CUC - Cuba Convertible Peso</option>
											<option value="CUP">CUP - Cuba Peso</option>
											<option value="CVE">CVE - Cape Verde Escudo</option>
											<option value="CZK">CZK - Czech Republic Koruna</option>
											<option value="DJF">DJF - Djibouti Franc</option>
											<option value="DKK">DKK - Denmark Krone</option>
											<option value="DOP">DOP - Dominican Republic Peso</option>
											<option value="DZD">DZD - Algeria Dinar</option>
											<option value="EGP">EGP - Egypt Pound</option>
											<option value="ERN">ERN - Eritrea Nakfa</option>
											<option value="ETB">ETB - Ethiopia Birr</option>
											<option value="EUR">EUR - Euro Member Countries</option>
											<option value="FJD">FJD - Fiji Dollar</option>
											<option value="FKP">FKP - Falkland Islands (Malvinas) Pound</option>
											<option value="GBP">GBP - United Kingdom Pound</option>
											<option value="GEL">GEL - Georgia Lari</option>
											<option value="GGP">GGP - Guernsey Pound</option>
											<option value="GHS">GHS - Ghana Cedi</option>
											<option value="GIP">GIP - Gibraltar Pound</option>
											<option value="GMD">GMD - Gambia Dalasi</option>
											<option value="GNF">GNF - Guinea Franc</option>
											<option value="GTQ">GTQ - Guatemala Quetzal</option>
											<option value="GYD">GYD - Guyana Dollar</option>
											<option value="HKD">HKD - Hong Kong Dollar</option>
											<option value="HNL">HNL - Honduras Lempira</option>
											<option value="HPK">HRK - Croatia Kuna</option>
											<option value="HTG">HTG - Haiti Gourde</option>
											<option value="HUF">HUF - Hungary Forint</option>
											<option value="IDR">IDR - Indonesia Rupiah</option>
											<option value="ILS">ILS - Israel Shekel</option>
											<option value="IMP">IMP - Isle of Man Pound</option>
											<option value="INR">INR - India Rupee</option>
											<option value="IQD">IQD - Iraq Dinar</option>
											<option value="IRR">IRR - Iran Rial</option>
											<option value="ISK">ISK - Iceland Krona</option>
											<option value="JEP">JEP - Jersey Pound</option>
											<option value="JMD">JMD - Jamaica Dollar</option>
											<option value="JOD">JOD - Jordan Dinar</option>
											<option value="JPY">JPY - Japan Yen</option>
											<option value="KES">KES - Kenya Shilling</option>
											<option value="KGS">KGS - Kyrgyzstan Som</option>
											<option value="KHR">KHR - Cambodia Riel</option>
											<option value="KMF">KMF - Comoros Franc</option>
											<option value="KPW">KPW - Korea (North) Won</option>
											<option value="KRW">KRW - Korea (South) Won</option>
											<option value="KWD">KWD - Kuwait Dinar</option>
											<option value="KYD">KYD - Cayman Islands Dollar</option>
											<option value="KZT">KZT - Kazakhstan Tenge</option>
											<option value="LAK">LAK - Laos Kip</option>
											<option value="LBP">LBP - Lebanon Pound</option>
											<option value="LKR">LKR - Sri Lanka Rupee</option>
											<option value="LRD">LRD - Liberia Dollar</option>
											<option value="LSL">LSL - Lesotho Loti</option>
											<option value="LYD">LYD - Libya Dinar</option>
											<option value="MAD">MAD - Morocco Dirham</option>
											<option value="MDL">MDL - Moldova Leu</option>
											<option value="MGA">MGA - Madagascar Ariary</option>
											<option value="MKD">MKD - Macedonia Denar</option>
											<option value="MMK">MMK - Myanmar (Burma) Kyat</option>
											<option value="MNT">MNT - Mongolia Tughrik</option>
											<option value="MOP">MOP - Macau Pataca</option>
											<option value="MRO">MRO - Mauritania Ouguiya</option>
											<option value="MUR">MUR - Mauritius Rupee</option>
											<option value="MVR">MVR - Maldives (Maldive Islands) Rufiyaa</option>
											<option value="MWK">MWK - Malawi Kwacha</option>
											<option value="MXN">MXN - Mexico Peso</option>
											<option value="MYR">MYR - Malaysia Ringgit</option>
											<option value="MZN">MZN - Mozambique Metical</option>
											<option value="NAD">NAD - Namibia Dollar</option>
											<option value="NGN">NGN - Nigeria Naira</option>
											<option value="NTO">NIO - Nicaragua Cordoba</option>
											<option value="NOK">NOK - Norway Krone</option>
											<option value="NPR">NPR - Nepal Rupee</option>
											<option value="NZD">NZD - New Zealand Dollar</option>
											<option value="OMR">OMR - Oman Rial</option>
											<option value="PAB">PAB - Panama Balboa</option>
											<option value="PEN">PEN - Peru Nuevo Sol</option>
											<option value="PGK">PGK - Papua New Guinea Kina</option>
											<option value="PHP">PHP - Philippines Peso</option>
											<option value="PKR">PKR - Pakistan Rupee</option>
											<option value="PLN">PLN - Poland Zloty</option>
											<option value="PYG">PYG - Paraguay Guarani</option>
											<option value="QAR">QAR - Qatar Riyal</option>
											<option value="RON">RON - Romania New Leu</option>
											<option value="RSD">RSD - Serbia Dinar</option>
											<option value="RUB">RUB - Russia Ruble</option>
											<option value="RWF">RWF - Rwanda Franc</option>
											<option value="SAR">SAR - Saudi Arabia Riyal</option>
											<option value="SBD">SBD - Solomon Islands Dollar</option>
											<option value="SCR">SCR - Seychelles Rupee</option>
											<option value="SDG">SDG - Sudan Pound</option>
											<option value="SEK">SEK - Sweden Krona</option>
											<option value="SGD">SGD - Singapore Dollar</option>
											<option value="SHP">SHP - Saint Helena Pound</option>
											<option value="SLL">SLL - Sierra Leone Leone</option>
											<option value="SOS">SOS - Somalia Shilling</option>
											<option value="SRL">SPL* - Seborga Luigino</option>
											<option value="SRD">SRD - Suriname Dollar</option>
											<option value="STD">STD - Sao Tome and Principe Dobra</option>
											<option value="SVC">SVC - El Salvador Colon</option>
											<option value="SYP">SYP - Syria Pound</option>
											<option value="SZL">SZL - Swaziland Lilangeni</option>
											<option value="THB">THB - Thailand Baht</option>
											<option value="TJS">TJS - Tajikistan Somoni</option>
											<option value="TMT">TMT - Turkmenistan Manat</option>
											<option value="TND">TND - Tunisia Dinar</option>
											<option value="TOP">TOP - Tonga Pa'anga</option>
											<option value="TRY">TRY - Turkey Lira</option>
											<option value="TTD">TTD - Trinidad and Tobago Dollar</option>
											<option value="TVD">TVD - Tuvalu Dollar</option>
											<option value="TWD">TWD - Taiwan New Dollar</option>
											<option value="TZS">TZS - Tanzania Shilling</option>
											<option value="UAH">UAH - Ukraine Hryvnia</option>
											<option value="UGX">UGX - Uganda Shilling</option>
											<option value="USD" selected>USD - United States Dollar</option>
											<option value="UYU">UYU - Uruguay Peso</option>
											<option value="UZS">UZS - Uzbekistan Som</option>
											<option value="VEF">VEF - Venezuela Bolivar</option>
											<option value="VND">VND - Viet Nam Dong</option>
											<option value="VUV">VUV - Vanuatu Vatu</option>
											<option value="WST">WST - Samoa Tala</option>
											<option value="XAF">XAF - Communaute Financiere Africaine (BEAC) CFA Franc BEAC</option>
											<option value="XCD">XCD - East Caribbean Dollar</option>
											<option value="XDR">XDR - International Monetary Fund (IMF) Special Drawing Rights</option>
											<option value="XOF">XOF - Communaute Financiere Africaine (BCEAO) Franc</option>
											<option value="XPF">XPF - Comptoirs Francais du Pacifique (CFP) Franc</option>
											<option value="YER">YER - Yemen Rial</option>
											<option value="ZAR">ZAR - South Africa Rand</option>
											<option value="ZMW">ZMW - Zambia Kwacha</option>
											<option value="ZWD">ZWD - Zimbabwe Dollar</option>
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
										<input type="text" class="form-control" name="amount" onkeyup="btc_calculate_price();" onkeydown="btc_calculate_price();" id="btc_amount">
										<?php echo $lang['currenct_bitcoin_price']; ?>: <?php echo get_current_bitcoin_price(); ?> USD<br/>
										<span id="your_btc_price"></span>
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['enter_comission_info']; ?></span>
								</div>
							<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $lang['payment_instructions']; ?></label>
										<textarea class="form-control" name="payment_instructions" rows="5"></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['payment_instructions_info']; ?></span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $lang['minimal_trade_amount']; ?></label>
										<input type="text" class="form-control" name="min_amount">
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['minimal_trade_amount_info']; ?></span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $lang['maximum_trade_amount']; ?></label>
										<input type="text" class="form-control" name="max_amount">
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['maximum_trade_amount_info']; ?></span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $lang['trade_process_time']; ?></label>
										<input type="text" class="form-control" name="process_time">
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['trade_process_time_info']; ?></span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?php echo $lang['terms_of_trade']; ?></label>
										<textarea class="form-control" name="terms" rows="5"></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted"><?php echo $lang['terms_of_trade_info']; ?></span>
								</div>
								<?php if($settings['document_verification'] == "1") { ?>
								<div class="col-md-12">
									 <div class="checkbox">
										<label>
										  <input type="checkbox" name="require_document" value="yes"> <?php echo $lang['require_document']; ?>
										</label>
									  </div>
								</div>
								<?php } ?>
								<?php if($settings['email_verification'] == "1") { ?>
								<div class="col-md-12">
									 <div class="checkbox">
										<label>
										  <input type="checkbox" name="require_email" value="yes"> <?php echo $lang['require_email']; ?>
										</label>
									  </div>
								</div>
								<?php } ?>
								<?php if($settings['phone_verification'] == "1") { ?>
								<div class="col-md-12">
									 <div class="checkbox">
										<label>
										  <input type="checkbox" name="require_mobile" value="yes"> <?php echo $lang['require_mobile']; ?>
										</label>
									  </div>
								</div>
								<?php } ?>
								<div class="col-md-12">
									<button type="submit" class="btn btn-warning" name="btc_post_ad"><?php echo $lang['btn_submit']; ?></button>
								</div>
						</div>
					</form>
						</div>
					</div>
				</div>
			</div>
		</div>