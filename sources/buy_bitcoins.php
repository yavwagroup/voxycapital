 <?php
 if(isset($_GET['pm'])) { 
									$expl = explode("/",$_GET['pm']);
									$_GET['pm'] = $expl[0];
									$_GET['page'] = $expl[1];
								}
								?><!-- Page Title-->
    	<div class="container-fluid blue-banner page-title bg-image">
		 
        </div>
    <!-- Page Title-->
	<div class="jobs_filters">
                    <div class="container">
                        	<form action="<?php echo $settings['url']; ?>search" method="POST">
                    	<!--col-lg-3 filter_width -->
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h3 class="white-heading" style="font-size:30px;"><?php echo $lang['welcome_screen_text']; ?></h3>
							<br>
						</div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 filter_width bgicon">
							<div class="form-group">
								<select class="form-control" name="type">
									<option value="sell"><?php echo $lang['buy_bitcoins']; ?></option>
									<option value="buy"><?php echo $lang['sell_bitcoins']; ?></option>
								</select>
							</div>
                        </div>
                         <!--col-lg-3 filter_width -->
                         
                         <!-- col-lg-5 filter_width -->
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 filter_width bgicon">
                                <div class="form-group">
                                    <input type="text" class="form-control form_style_1 input-lg" name="amount" placeholder="<?php echo $lang['amount']; ?>">
                                    <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                                </div>
                            </div>
                         <!-- col-lg-5 filter_width -->
                         
                        	<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 filter_width bgicon location">
                                <div class="form-group">
                                    <select class="form-control" name="currency">
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
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 filter_width bgicon location">
                                <div class="form-group">
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
                            <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12 filter_width bgicon submit">
                                <div class="form-group">
                                   <input type="submit" class="customsubmit" name="submit" value="Search"/>
                                   <span class="glyphicon fa fa-search" aria-hidden="true"></span>
                                </div>
                            </div>
                            </form>
                    </div>
         
         	</div>
			
	<div class="container main-container list-style3">
		<div class="row">
			<div class="col-lg-12">
			 <div class="tab_filters">
                        <div class="col-lg-4">
                            <h5><?php echo $lang['buy_bitcoins']; ?></h5>
                         </div>
                        
                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 filters pull-right filter-category">
                            <ul class="nav nav-pills">
                                      <li class="web-designer <?php if($_GET['pm'] == "PayPal") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>buy-bitcoins-PayPal">PayPal</a></li>
                                      <li class="fianance <?php if($_GET['pm'] == "Perfect-Money") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>buy-bitcoins-Perfect-Money">Perfect Money</a></li>
                                      <li class="education <?php if($_GET['pm'] == "Payeer") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>buy-bitcoins-Payeer">Payeer</a></li>
                                      <li class="food-service <?php if($_GET['pm'] == "Skrill") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>buy-bitcoins-Skrill">Skrill</a></li>
                                      <li class="health-services <?php if($_GET['pm'] == "Neteller") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>buy-bitcoins-Neteller">Neteller</a></li>
                                      <li class="automative <?php if($_GET['pm'] == "AdvCash") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>buy-bitcoins-AdvCash">AdvCash</a></li>
									  <li class="automative <?php if($_GET['pm'] == "Bank-Transfer") { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>buy-bitcoins-Bank-Transfer">Bank Transfer</a></li>
                                      <li class="all <?php if(!$_GET['pm']) { echo 'active'; } ?>"><a href="<?php echo $settings['url']; ?>buy-bitcoins">All</a></li>
                            </ul>
                        </div>
                 </div>
          		<div class="jobs-result"> 
                        <!--Search Result 01-->
                        <div class="jobs list-style2">
								<?php
								$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
								$limit = 30;
								$startpoint = ($page * $limit) - $limit;
								if($page == 1) {
									$i = 1;
								} else {
									$i = $page * $limit;
								}
								$qadd = '';
								if(isset($_GET['pm'])) {
									$pm = protect($_GET['pm']);
									$pm = str_ireplace("-"," ",$pm);
									$qadd = "and payment_method='$pm'";
								}
								$statement = "btc_ads WHERE type='sell' $qadd";
								$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
								if($query->num_rows>0) {
										while($row = $query->fetch_assoc()) {
										$pm = str_ireplace(" ","-",$row['payment_method']);
										?>
										<div class="filter-result 01">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="desig">
                                        <span class="pull-left"><a href="<?php echo $settings['url']; ?>user/<?php echo idinfo($row['uid'],"username"); ?>" id="user_status" data-toggle="tooltip" data-placement="top" title="<?php echo activity_time($row['uid']); ?>"><h3><?php echo idinfo($row['uid'],"username"); ?></h3></a>
                                        <small><?php echo activity_time($row['uid']); ?></small>
										</span>
										<span class="pull-right">
										<a href="<?php echo $settings['url'];?>ad/<?php echo $pm; ?>-to-Bitcoin/<?php echo $row['id']; ?>"><span class="label job-type job-contract "><?php echo $lang['btn_buy']; ?></span></a>
                                       </span>
                                    </div>
                                    
                                    <div class="job-footer">
                                    	<ul>
                                        	<li><?php echo $lang['price']; ?>: <?php echo convertBTCprice($row['price'],$row['currency']); ?> <?php echo $row['currency']; ?>/BTC</li>
                                            <li><?php echo $lang['limits']; ?>: <?php echo $row['min_amount']; ?> - <?php echo $row['max_amount']; ?> <?php echo $row['currency']; ?></li>
                                            <li><?php echo $row['payment_method']; ?></a>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                                
                            </div> 
                            <!--jobs result-->
										<?php
									}
								} else {
									echo info($lang[no_ad_for_display]);
								}
								?>
				 </div>
                             <!--jobs result--> 
                         	<div class="clearfix"></div>
							<div class="col-md-12">
							<?php
							if(isset($_GET['pm'])) {
								$pm = protect($_GET['pm']);
								$ver = $settings['url']."buy-bitcoins-$pm";
							} else {
								$ver = $settings['url']."buy-bitcoins";
							}
						if(web_pagination($statement,$ver,$limit,$page)) {
							echo web_pagination($statement,$ver,$limit,$page);
						}
						?>
							</div>
                         </div> 
                         <!--Search Result 01-->
                    </div>
				</div>
			</div>
			<!-- Blue Banner-->
    	<div class="container-fluid blue-banner" style="background:#3668d1">
        	<div class="row">
            <div class="container main-container v-middle">
            	<div class="col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
                	<h3 class="white-heading">Earn money. <span>Start trading with Bitcoin</span></h3>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 no-padding-left">
                	<a href="<?php echo $settings['url']; ?>login" class="btn btn-getstarted bg-red">get started now</a>
                </div>
            </div>
            </div>
        </div>
    <!-- Blue Banner-->
	<?php
						$queryFeedbacks = $db->query("SELECT * FROM btc_users_ratings ORDER BY id DESC LIMIT 5");
						if($queryFeedbacks->num_rows>0) {
							?>
    <!-- Testimionals Slider-->
    	<div class="container-fluid testimionals" style="background:url(assets/images/testbg.png);">
			<div class="row">
            <div class="container main-container">
            	<div class="col-lg-12">
                    <div id="testio" class="owl-carousel owl-template">
                      <!--Slides-->
					  <?php while($fb = $queryFeedbacks->fetch_assoc()) {
								$adid = tradeinfo($fb['trade_id'],"ad_id");
								$adpaymentmethod = adinfo($adid,"payment_method");
								$adtype = adinfo($adid,"type");
								if($adtype == "buy") {
									$pm = str_ireplace(" ","-",$adpaymentmethod);
									$adlink = $settings['url']."ad/Bitcoin-to-".$pm."/".$adid;
								} elseif($adtype == "sell") {
									$pm = str_ireplace(" ","-",$adpaymentmethod);
									$adlink = $settings['url']."ad/".$pm."-to-Bitcoin/".$adid;
								} else { }
								?>
                      <div class="item">
                      		
                            <div class="info">
                            	<h5><a href="<?php echo $settings['url']; ?>user/<?php echo idinfo($fb['author'],"username"); ?>"><?php echo idinfo($fb['author'],"username"); ?></a> <i class="fa fa-angle-right"></i> <a href="<?php echo $settings['url']; ?>user/<?php echo idinfo($fb['uid'],"username"); ?>"><?php echo idinfo($fb['uid'],"username"); ?></a></h5>
                                <span><?php echo $lang['for_advertisement']; ?> <a href="<?php echo $adlink; ?>">#<?php echo $adid; ?></a></span>
                                <p><?php echo $fb['comment']; ?></p>
                            </div>
                       </div>
                      <?php } ?>
                     
                    </div>
                </div>
            </div>     
        </div>
        </div>
    <!-- Testimionals Slider-->
						<?php } ?>