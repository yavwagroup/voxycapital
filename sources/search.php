<?php
if(isset($_POST['type']) && isset($_POST['amount']) && isset($_POST['currency']) && isset($_POST['payment_method'])) {
	$_SESSION['search_type'] = protect($_POST['type']);
	$_SESSION['search_amount'] = ceil(protect($_POST['amount']));
	$_SESSION['search_currency'] = protect($_POST['currency']);
	$_SESSION['search_payment_method'] = protect($_POST['payment_method']);
} else {
	$_SESSION['search_error'] = true;
}
?>
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
									<option value="sell" <?php if($_SESSION['search_type'] == "sell") { echo 'selected'; } ?>><?php echo $lang['buy_bitcoins']; ?></option>
									<option value="buy" <?php if($_SESSION['search_type'] == "buy") { echo 'selected'; } ?>><?php echo $lang['sell_bitcoins']; ?></option>
								</select>
							</div>
                        </div>
                         <!--col-lg-3 filter_width -->
                         
                         <!-- col-lg-5 filter_width -->
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 filter_width bgicon">
                                <div class="form-group">
                                    <input type="text" class="form-control form_style_1 input-lg" name="amount" placeholder="<?php echo $lang['amount']; ?>" value="<?php echo $_SESSION['search_amount']; ?>">
                                    <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                                </div>
                            </div>
                         <!-- col-lg-5 filter_width -->
                         
                        	<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 filter_width bgicon location">
                                <div class="form-group">
                                    <select class="form-control" name="currency">
									<option value="AED" <?php if($_SESSION['search_currency'] == "AED") { echo 'selected'; } ?>>AED - United Arab Emirates Dirham</option>
											<option value="AFN"  <?php if($_SESSION['search_currency'] == "AFN") { echo 'selected'; } ?>>AFN - Afghanistan Afghani</option>
											<option value="ALL" <?php if($_SESSION['search_currency'] == "ALL") { echo 'selected'; } ?>>ALL - Albania Lek</option>
											<option value="AMD" <?php if($_SESSION['search_currency'] == "AMD") { echo 'selected'; } ?>>AMD - Armenia Dram</option>
											<option value="ANG" <?php if($_SESSION['search_currency'] == "ANG") { echo 'selected'; } ?>>ANG - Netherlands Antilles Guilder</option>
											<option value="AOA" <?php if($_SESSION['search_currency'] == "AOA") { echo 'selected'; } ?>>AOA - Angola Kwanza</option>
											<option value="ARS" <?php if($_SESSION['search_currency'] == "ARS") { echo 'selected'; } ?>>ARS - Argentina Peso</option>
											<option value="AUD" <?php if($_SESSION['search_currency'] == "AUD") { echo 'selected'; } ?>>AUD - Australia Dollar</option>
											<option value="AWG" <?php if($_SESSION['search_currency'] == "AWG") { echo 'selected'; } ?>>AWG - Aruba Guilder</option>
											<option value="AZN" <?php if($_SESSION['search_currency'] == "AZN") { echo 'selected'; } ?>>AZN - Azerbaijan New Manat</option>
											<option value="BAM" <?php if($_SESSION['search_currency'] == "BAM") { echo 'selected'; } ?>>BAM - Bosnia and Herzegovina Convertible Marka</option>
											<option value="BBD" <?php if($_SESSION['search_currency'] == "BBD") { echo 'selected'; } ?>>BBD - Barbados Dollar</option>
											<option value="BDT" <?php if($_SESSION['search_currency'] == "BDT") { echo 'selected'; } ?>>BDT - Bangladesh Taka</option>
											<option value="BGN" <?php if($_SESSION['search_currency'] == "BGN") { echo 'selected'; } ?>>BGN - Bulgaria Lev</option>
											<option value="BHD" <?php if($_SESSION['search_currency'] == "BHD") { echo 'selected'; } ?>>BHD - Bahrain Dinar</option>
											<option value="BIF" <?php if($_SESSION['search_currency'] == "BIF") { echo 'selected'; } ?>>BIF - Burundi Franc</option>
											<option value="BMD" <?php if($_SESSION['search_currency'] == "BMD") { echo 'selected'; } ?>>BMD - Bermuda Dollar</option>
											<option value="BND" <?php if($_SESSION['search_currency'] == "BND") { echo 'selected'; } ?>>BND - Brunei Darussalam Dollar</option>
											<option value="BOB" <?php if($_SESSION['search_currency'] == "BOB") { echo 'selected'; } ?>>BOB - Bolivia Boliviano</option>
											<option value="BRL" <?php if($_SESSION['search_currency'] == "BRL") { echo 'selected'; } ?>>BRL - Brazil Real</option>
											<option value="BSD" <?php if($_SESSION['search_currency'] == "BSD") { echo 'selected'; } ?>>BSD - Bahamas Dollar</option>
											<option value="BTN" <?php if($_SESSION['search_currency'] == "BTN") { echo 'selected'; } ?>>BTN - Bhutan Ngultrum</option>
											<option value="BWP" <?php if($_SESSION['search_currency'] == "BWP") { echo 'selected'; } ?>>BWP - Botswana Pula</option>
											<option value="BYR" <?php if($_SESSION['search_currency'] == "BYR") { echo 'selected'; } ?>>BYR - Belarus Ruble</option>
											<option value="BZD" <?php if($_SESSION['search_currency'] == "BZD") { echo 'selected'; } ?>>BZD - Belize Dollar</option>
											<option value="CAD" <?php if($_SESSION['search_currency'] == "CAD") { echo 'selected'; } ?>>CAD - Canada Dollar</option>
											<option value="CDF" <?php if($_SESSION['search_currency'] == "CDF") { echo 'selected'; } ?>>CDF - Congo/Kinshasa Franc</option>
											<option value="CHF" <?php if($_SESSION['search_currency'] == "CHF") { echo 'selected'; } ?>>CHF - Switzerland Franc</option>
											<option value="CLP" <?php if($_SESSION['search_currency'] == "CLP") { echo 'selected'; } ?>>CLP - Chile Peso</option>
											<option value="CNY" <?php if($_SESSION['search_currency'] == "CNY") { echo 'selected'; } ?>>CNY - China Yuan Renminbi</option>
											<option value="COP" <?php if($_SESSION['search_currency'] == "COP") { echo 'selected'; } ?>>COP - Colombia Peso</option>
											<option value="CRC" <?php if($_SESSION['search_currency'] == "CRC") { echo 'selected'; } ?>>CRC - Costa Rica Colon</option>
											<option value="CUC" <?php if($_SESSION['search_currency'] == "CUC") { echo 'selected'; } ?>>CUC - Cuba Convertible Peso</option>
											<option value="CUP" <?php if($_SESSION['search_currency'] == "CUP") { echo 'selected'; } ?>>CUP - Cuba Peso</option>
											<option value="CVE" <?php if($_SESSION['search_currency'] == "CVE") { echo 'selected'; } ?>>CVE - Cape Verde Escudo</option>
											<option value="CZK" <?php if($_SESSION['search_currency'] == "CZK") { echo 'selected'; } ?>>CZK - Czech Republic Koruna</option>
											<option value="DJF" <?php if($_SESSION['search_currency'] == "DJF") { echo 'selected'; } ?>>DJF - Djibouti Franc</option>
											<option value="DKK" <?php if($_SESSION['search_currency'] == "DKK") { echo 'selected'; } ?>>DKK - Denmark Krone</option>
											<option value="DOP" <?php if($_SESSION['search_currency'] == "DOP") { echo 'selected'; } ?>>DOP - Dominican Republic Peso</option>
											<option value="DZD" <?php if($_SESSION['search_currency'] == "DZD") { echo 'selected'; } ?>>DZD - Algeria Dinar</option>
											<option value="EGP" <?php if($_SESSION['search_currency'] == "EGP") { echo 'selected'; } ?>>EGP - Egypt Pound</option>
											<option value="ERN" <?php if($_SESSION['search_currency'] == "ERN") { echo 'selected'; } ?>>ERN - Eritrea Nakfa</option>
											<option value="ETB" <?php if($_SESSION['search_currency'] == "ETB") { echo 'selected'; } ?>>ETB - Ethiopia Birr</option>
											<option value="EUR" <?php if($_SESSION['search_currency'] == "EUR") { echo 'selected'; } ?>>EUR - Euro Member Countries</option>
											<option value="FJD" <?php if($_SESSION['search_currency'] == "FJD") { echo 'selected'; } ?>>FJD - Fiji Dollar</option>
											<option value="FKP" <?php if($_SESSION['search_currency'] == "FKP") { echo 'selected'; } ?>>FKP - Falkland Islands (Malvinas) Pound</option>
											<option value="GBP" <?php if($_SESSION['search_currency'] == "GBP") { echo 'selected'; } ?>>GBP - United Kingdom Pound</option>
											<option value="GEL" <?php if($_SESSION['search_currency'] == "GEL") { echo 'selected'; } ?>>GEL - Georgia Lari</option>
											<option value="GGP" <?php if($_SESSION['search_currency'] == "GGP") { echo 'selected'; } ?>>GGP - Guernsey Pound</option>
											<option value="GHS" <?php if($_SESSION['search_currency'] == "GHS") { echo 'selected'; } ?>>GHS - Ghana Cedi</option>
											<option value="GIP" <?php if($_SESSION['search_currency'] == "GIP") { echo 'selected'; } ?>>GIP - Gibraltar Pound</option>
											<option value="GMD" <?php if($_SESSION['search_currency'] == "GMD") { echo 'selected'; } ?>>GMD - Gambia Dalasi</option>
											<option value="GNF" <?php if($_SESSION['search_currency'] == "GNF") { echo 'selected'; } ?>>GNF - Guinea Franc</option>
											<option value="GTQ" <?php if($_SESSION['search_currency'] == "GTQ") { echo 'selected'; } ?>>GTQ - Guatemala Quetzal</option>
											<option value="GYD" <?php if($_SESSION['search_currency'] == "GYD") { echo 'selected'; } ?>>GYD - Guyana Dollar</option>
											<option value="HKD" <?php if($_SESSION['search_currency'] == "HKD") { echo 'selected'; } ?>>HKD - Hong Kong Dollar</option>
											<option value="HNL" <?php if($_SESSION['search_currency'] == "HNL") { echo 'selected'; } ?>>HNL - Honduras Lempira</option>
											<option value="HPK" <?php if($_SESSION['search_currency'] == "HPK") { echo 'selected'; } ?>>HRK - Croatia Kuna</option>
											<option value="HTG" <?php if($_SESSION['search_currency'] == "HTG") { echo 'selected'; } ?>>HTG - Haiti Gourde</option>
											<option value="HUF" <?php if($_SESSION['search_currency'] == "HUF") { echo 'selected'; } ?>>HUF - Hungary Forint</option>
											<option value="IDR" <?php if($_SESSION['search_currency'] == "IDR") { echo 'selected'; } ?>>IDR - Indonesia Rupiah</option>
											<option value="ILS" <?php if($_SESSION['search_currency'] == "ILS") { echo 'selected'; } ?>>ILS - Israel Shekel</option>
											<option value="IMP" <?php if($_SESSION['search_currency'] == "IMP") { echo 'selected'; } ?>>IMP - Isle of Man Pound</option>
											<option value="INR" <?php if($_SESSION['search_currency'] == "INR") { echo 'selected'; } ?>>INR - India Rupee</option>
											<option value="IQD" <?php if($_SESSION['search_currency'] == "IQD") { echo 'selected'; } ?>>IQD - Iraq Dinar</option>
											<option value="IRR" <?php if($_SESSION['search_currency'] == "IRR") { echo 'selected'; } ?>>IRR - Iran Rial</option>
											<option value="ISK" <?php if($_SESSION['search_currency'] == "ISK") { echo 'selected'; } ?>>ISK - Iceland Krona</option>
											<option value="JEP" <?php if($_SESSION['search_currency'] == "JEP") { echo 'selected'; } ?>>JEP - Jersey Pound</option>
											<option value="JMD" <?php if($_SESSION['search_currency'] == "JMD") { echo 'selected'; } ?>>JMD - Jamaica Dollar</option>
											<option value="JOD" <?php if($_SESSION['search_currency'] == "JOD") { echo 'selected'; } ?>>JOD - Jordan Dinar</option>
											<option value="JPY" <?php if($_SESSION['search_currency'] == "JPY") { echo 'selected'; } ?>>JPY - Japan Yen</option>
											<option value="KES" <?php if($_SESSION['search_currency'] == "KES") { echo 'selected'; } ?>>KES - Kenya Shilling</option>
											<option value="KGS" <?php if($_SESSION['search_currency'] == "KGS") { echo 'selected'; } ?>>KGS - Kyrgyzstan Som</option>
											<option value="KHR" <?php if($_SESSION['search_currency'] == "KHR") { echo 'selected'; } ?>>KHR - Cambodia Riel</option>
											<option value="KMF" <?php if($_SESSION['search_currency'] == "KMF") { echo 'selected'; } ?>>KMF - Comoros Franc</option>
											<option value="KPW" <?php if($_SESSION['search_currency'] == "KPW") { echo 'selected'; } ?>>KPW - Korea (North) Won</option>
											<option value="KRW" <?php if($_SESSION['search_currency'] == "KRW") { echo 'selected'; } ?>>KRW - Korea (South) Won</option>
											<option value="KWD" <?php if($_SESSION['search_currency'] == "KWD") { echo 'selected'; } ?>>KWD - Kuwait Dinar</option>
											<option value="KYD" <?php if($_SESSION['search_currency'] == "KYD") { echo 'selected'; } ?>>KYD - Cayman Islands Dollar</option>
											<option value="KZT" <?php if($_SESSION['search_currency'] == "KZT") { echo 'selected'; } ?>>KZT - Kazakhstan Tenge</option>
											<option value="LAK" <?php if($_SESSION['search_currency'] == "LAK") { echo 'selected'; } ?>>LAK - Laos Kip</option>
											<option value="LBP" <?php if($_SESSION['search_currency'] == "LBP") { echo 'selected'; } ?>>LBP - Lebanon Pound</option>
											<option value="LKR" <?php if($_SESSION['search_currency'] == "LKR") { echo 'selected'; } ?>>LKR - Sri Lanka Rupee</option>
											<option value="LRD" <?php if($_SESSION['search_currency'] == "LRD") { echo 'selected'; } ?>>LRD - Liberia Dollar</option>
											<option value="LSL" <?php if($_SESSION['search_currency'] == "LSL") { echo 'selected'; } ?>>LSL - Lesotho Loti</option>
											<option value="LYD" <?php if($_SESSION['search_currency'] == "LYD") { echo 'selected'; } ?>>LYD - Libya Dinar</option>
											<option value="MAD" <?php if($_SESSION['search_currency'] == "MAD") { echo 'selected'; } ?>>MAD - Morocco Dirham</option>
											<option value="MDL" <?php if($_SESSION['search_currency'] == "MDL") { echo 'selected'; } ?>>MDL - Moldova Leu</option>
											<option value="MGA" <?php if($_SESSION['search_currency'] == "MGA") { echo 'selected'; } ?>>MGA - Madagascar Ariary</option>
											<option value="MKD" <?php if($_SESSION['search_currency'] == "MKD") { echo 'selected'; } ?>>MKD - Macedonia Denar</option>
											<option value="MMK" <?php if($_SESSION['search_currency'] == "MMK") { echo 'selected'; } ?>>MMK - Myanmar (Burma) Kyat</option>
											<option value="MNT" <?php if($_SESSION['search_currency'] == "MNT") { echo 'selected'; } ?>>MNT - Mongolia Tughrik</option>
											<option value="MOP" <?php if($_SESSION['search_currency'] == "MOP") { echo 'selected'; } ?>>MOP - Macau Pataca</option>
											<option value="MRO" <?php if($_SESSION['search_currency'] == "MRO") { echo 'selected'; } ?>>MRO - Mauritania Ouguiya</option>
											<option value="MUR" <?php if($_SESSION['search_currency'] == "MUR") { echo 'selected'; } ?>>MUR - Mauritius Rupee</option>
											<option value="MVR" <?php if($_SESSION['search_currency'] == "MVR") { echo 'selected'; } ?>>MVR - Maldives (Maldive Islands) Rufiyaa</option>
											<option value="MWK" <?php if($_SESSION['search_currency'] == "MWK") { echo 'selected'; } ?>>MWK - Malawi Kwacha</option>
											<option value="MXN" <?php if($_SESSION['search_currency'] == "MXN") { echo 'selected'; } ?>>MXN - Mexico Peso</option>
											<option value="MYR" <?php if($_SESSION['search_currency'] == "MYR") { echo 'selected'; } ?>>MYR - Malaysia Ringgit</option>
											<option value="MZN" <?php if($_SESSION['search_currency'] == "MZN") { echo 'selected'; } ?>>MZN - Mozambique Metical</option>
											<option value="NAD" <?php if($_SESSION['search_currency'] == "NAD") { echo 'selected'; } ?>>NAD - Namibia Dollar</option>
											<option value="NGN" <?php if($_SESSION['search_currency'] == "NGN") { echo 'selected'; } ?>>NGN - Nigeria Naira</option>
											<option value="NTO" <?php if($_SESSION['search_currency'] == "NTO") { echo 'selected'; } ?>>NIO - Nicaragua Cordoba</option>
											<option value="NOK" <?php if($_SESSION['search_currency'] == "NOK") { echo 'selected'; } ?>>NOK - Norway Krone</option>
											<option value="NPR" <?php if($_SESSION['search_currency'] == "NPR") { echo 'selected'; } ?>>NPR - Nepal Rupee</option>
											<option value="NZD" <?php if($_SESSION['search_currency'] == "NZD") { echo 'selected'; } ?>>NZD - New Zealand Dollar</option>
											<option value="OMR" <?php if($_SESSION['search_currency'] == "OMR") { echo 'selected'; } ?>>OMR - Oman Rial</option>
											<option value="PAB" <?php if($_SESSION['search_currency'] == "PAB") { echo 'selected'; } ?>>PAB - Panama Balboa</option>
											<option value="PEN" <?php if($_SESSION['search_currency'] == "PEN") { echo 'selected'; } ?>>PEN - Peru Nuevo Sol</option>
											<option value="PGK" <?php if($_SESSION['search_currency'] == "PGK") { echo 'selected'; } ?>>PGK - Papua New Guinea Kina</option>
											<option value="PHP" <?php if($_SESSION['search_currency'] == "PHP") { echo 'selected'; } ?>>PHP - Philippines Peso</option>
											<option value="PKR" <?php if($_SESSION['search_currency'] == "PKR") { echo 'selected'; } ?>>PKR - Pakistan Rupee</option>
											<option value="PLN" <?php if($_SESSION['search_currency'] == "PLN") { echo 'selected'; } ?>>PLN - Poland Zloty</option>
											<option value="PYG" <?php if($_SESSION['search_currency'] == "PYG") { echo 'selected'; } ?>>PYG - Paraguay Guarani</option>
											<option value="QAR" <?php if($_SESSION['search_currency'] == "QAR") { echo 'selected'; } ?>>QAR - Qatar Riyal</option>
											<option value="RON" <?php if($_SESSION['search_currency'] == "RON") { echo 'selected'; } ?>>RON - Romania New Leu</option>
											<option value="RSD" <?php if($_SESSION['search_currency'] == "RSD") { echo 'selected'; } ?>>RSD - Serbia Dinar</option>
											<option value="RUB" <?php if($_SESSION['search_currency'] == "RUB") { echo 'selected'; } ?>>RUB - Russia Ruble</option>
											<option value="RWF" <?php if($_SESSION['search_currency'] == "RWF") { echo 'selected'; } ?>>RWF - Rwanda Franc</option>
											<option value="SAR" <?php if($_SESSION['search_currency'] == "SAR") { echo 'selected'; } ?>>SAR - Saudi Arabia Riyal</option>
											<option value="SBD" <?php if($_SESSION['search_currency'] == "SBD") { echo 'selected'; } ?>>SBD - Solomon Islands Dollar</option>
											<option value="SCR" <?php if($_SESSION['search_currency'] == "SCR") { echo 'selected'; } ?>>SCR - Seychelles Rupee</option>
											<option value="SDG" <?php if($_SESSION['search_currency'] == "SDG") { echo 'selected'; } ?>>SDG - Sudan Pound</option>
											<option value="SEK" <?php if($_SESSION['search_currency'] == "SEK") { echo 'selected'; } ?>>SEK - Sweden Krona</option>
											<option value="SGD" <?php if($_SESSION['search_currency'] == "SGD") { echo 'selected'; } ?>>SGD - Singapore Dollar</option>
											<option value="SHP" <?php if($_SESSION['search_currency'] == "SHP") { echo 'selected'; } ?>>SHP - Saint Helena Pound</option>
											<option value="SLL" <?php if($_SESSION['search_currency'] == "SLL") { echo 'selected'; } ?>>SLL - Sierra Leone Leone</option>
											<option value="SOS" <?php if($_SESSION['search_currency'] == "SOS") { echo 'selected'; } ?>>SOS - Somalia Shilling</option>
											<option value="SRL" <?php if($_SESSION['search_currency'] == "SRL") { echo 'selected'; } ?>>SPL* - Seborga Luigino</option>
											<option value="SRD" <?php if($_SESSION['search_currency'] == "SRD") { echo 'selected'; } ?>>SRD - Suriname Dollar</option>
											<option value="STD" <?php if($_SESSION['search_currency'] == "STD") { echo 'selected'; } ?>>STD - Sao Tome and Principe Dobra</option>
											<option value="SVC" <?php if($_SESSION['search_currency'] == "SVC") { echo 'selected'; } ?>>SVC - El Salvador Colon</option>
											<option value="SYP" <?php if($_SESSION['search_currency'] == "SYP") { echo 'selected'; } ?>>SYP - Syria Pound</option>
											<option value="SZL" <?php if($_SESSION['search_currency'] == "SZL") { echo 'selected'; } ?>>SZL - Swaziland Lilangeni</option>
											<option value="THB" <?php if($_SESSION['search_currency'] == "THB") { echo 'selected'; } ?>>THB - Thailand Baht</option>
											<option value="TJS" <?php if($_SESSION['search_currency'] == "TJS") { echo 'selected'; } ?>>TJS - Tajikistan Somoni</option>
											<option value="TMT" <?php if($_SESSION['search_currency'] == "TMT") { echo 'selected'; } ?>>TMT - Turkmenistan Manat</option>
											<option value="TND" <?php if($_SESSION['search_currency'] == "TND") { echo 'selected'; } ?>>TND - Tunisia Dinar</option>
											<option value="TOP" <?php if($_SESSION['search_currency'] == "TOP") { echo 'selected'; } ?>>TOP - Tonga Pa'anga</option>
											<option value="TRY" <?php if($_SESSION['search_currency'] == "TRY") { echo 'selected'; } ?>>TRY - Turkey Lira</option>
											<option value="TTD" <?php if($_SESSION['search_currency'] == "TTD") { echo 'selected'; } ?>>TTD - Trinidad and Tobago Dollar</option>
											<option value="TVD" <?php if($_SESSION['search_currency'] == "TVD") { echo 'selected'; } ?>>TVD - Tuvalu Dollar</option>
											<option value="TWD" <?php if($_SESSION['search_currency'] == "TWD") { echo 'selected'; } ?>>TWD - Taiwan New Dollar</option>
											<option value="TZS" <?php if($_SESSION['search_currency'] == "TZS") { echo 'selected'; } ?>>TZS - Tanzania Shilling</option>
											<option value="UAH" <?php if($_SESSION['search_currency'] == "UAH") { echo 'selected'; } ?>>UAH - Ukraine Hryvnia</option>
											<option value="UGX" <?php if($_SESSION['search_currency'] == "UGX") { echo 'selected'; } ?>>UGX - Uganda Shilling</option>
											<option value="USD"  <?php if($_SESSION['search_currency'] == "USD") { echo 'selected'; } ?>>USD - United States Dollar</option>
											<option value="UYU" <?php if($_SESSION['search_currency'] == "UYU") { echo 'selected'; } ?>>UYU - Uruguay Peso</option>
											<option value="UZS" <?php if($_SESSION['search_currency'] == "UZS") { echo 'selected'; } ?>>UZS - Uzbekistan Som</option>
											<option value="VEF" <?php if($_SESSION['search_currency'] == "VEF") { echo 'selected'; } ?>>VEF - Venezuela Bolivar</option>
											<option value="VND" <?php if($_SESSION['search_currency'] == "VND") { echo 'selected'; } ?>>VND - Viet Nam Dong</option>
											<option value="VUV" <?php if($_SESSION['search_currency'] == "VUV") { echo 'selected'; } ?>>VUV - Vanuatu Vatu</option>
											<option value="WST" <?php if($_SESSION['search_currency'] == "WST") { echo 'selected'; } ?>>WST - Samoa Tala</option>
											<option value="XAF" <?php if($_SESSION['search_currency'] == "XAF") { echo 'selected'; } ?>>XAF - Communaute Financiere Africaine (BEAC) CFA Franc BEAC</option>
											<option value="XCD" <?php if($_SESSION['search_currency'] == "XCD") { echo 'selected'; } ?>>XCD - East Caribbean Dollar</option>
											<option value="XDR" <?php if($_SESSION['search_currency'] == "XDR") { echo 'selected'; } ?>>XDR - International Monetary Fund (IMF) Special Drawing Rights</option>
											<option value="XOF" <?php if($_SESSION['search_currency'] == "XOF") { echo 'selected'; } ?>>XOF - Communaute Financiere Africaine (BCEAO) Franc</option>
											<option value="XPF" <?php if($_SESSION['search_currency'] == "XFF") { echo 'selected'; } ?>>XPF - Comptoirs Francais du Pacifique (CFP) Franc</option>
											<option value="YER" <?php if($_SESSION['search_currency'] == "YER") { echo 'selected'; } ?>>YER - Yemen Rial</option>
											<option value="ZAR" <?php if($_SESSION['search_currency'] == "ZAR") { echo 'selected'; } ?>>ZAR - South Africa Rand</option>
											<option value="ZMW" <?php if($_SESSION['search_currency'] == "ZMW") { echo 'selected'; } ?>>ZMW - Zambia Kwacha</option>
											<option value="ZWD" <?php if($_SESSION['search_currency'] == "ZWD") { echo 'selected'; } ?>>ZWD - Zimbabwe Dollar</option>
								</select>
                                </div>
                            </div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 filter_width bgicon location">
                                <div class="form-group">
									<select class="form-control" name="payment_method">
										<option value="PayPal" <?php if($_SESSION['search_payment_method'] == "PayPal") { echo 'selected'; } ?>>PayPal</option>
										<option value="Skrill" <?php if($_SESSION['search_payment_method'] == "Skrill") { echo 'selected'; } ?>>Skrill</option>
										<option value="Payeer" <?php if($_SESSION['search_payment_method'] == "Payeer") { echo 'selected'; } ?>>Payeer</option>
										<option value="Xoomwallet" <?php if($_SESSION['search_payment_method'] == "Xoomwallet") { echo 'selected'; } ?>>Xoomwallet</option>
										<option value="Perfect Money" <?php if($_SESSION['search_payment_method'] == "Perfect Money") { echo 'selected'; } ?>>Perfect Money</option>
										<option value="Payoneer" <?php if($_SESSION['search_payment_method'] == "Payoneer") { echo 'selected'; } ?>>Payoneer</option>
										<option value="AdvCash" <?php if($_SESSION['search_payment_method'] == "AdvCash") { echo 'selected'; } ?>>AdvCash</option>
										<option value="OKPay" <?php if($_SESSION['search_payment_method'] == "OKPay") { echo 'selected'; } ?>>OKPay</option>
										<option value="Entromoney" <?php if($_SESSION['search_payment_method'] == "Entromoney") { echo 'selected'; } ?>>Entromoney</option>
										<option value="SolidTrust Pay" <?php if($_SESSION['search_payment_method'] == "SolidTrust Pay") { echo 'selected'; } ?>>SolidTrust Pay</option>
										<option value="Neteller" <?php if($_SESSION['search_payment_method'] == "Neteller") { echo 'selected'; } ?>>Neteller</option>
										<option value="UQUID" <?php if($_SESSION['search_payment_method'] == "UQUID") { echo 'selected'; } ?>>UQUID</option>
										<option value="Yandex Money" <?php if($_SESSION['search_payment_method'] == "Yandex Money") { echo 'selected'; } ?>>Yandex Money</option>
										<option value="QIWI" <?php if($_SESSION['search_payment_method'] == "QIWI") { echo 'selected'; } ?>>QIWI</option>
										<option value="Bank Transfer" <?php if($_SESSION['search_payment_method'] == "Bank Transfer") { echo 'selected'; } ?>>Bank Transfer</option>
										<option value="Western Union" <?php if($_SESSION['search_payment_method'] == "Western Union") { echo 'selected'; } ?>>Western Union</option>
										<option value="Moneygram" <?php if($_SESSION['search_payment_method'] == "Moneygram") { echo 'selected'; } ?>>Moneygram</option>
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
								$amount = $_SESSION['search_amount'];
								$statement = "btc_ads WHERE min_amount <= $amount and max_amount >= $amount and type='$_SESSION[search_type]' and currency='$_SESSION[search_currency]' and payment_method='$_SESSION[search_payment_method]'";
								$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
								if($query->num_rows>0) {
									if($_SESSION['search_error']) {
										echo info("Some data is missing in search form.");
									} else {
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
										<?php if($row['type'] == "buy") { ?>
										<a href="<?php echo $settings['url'];?>ad/Bitcoin-to-<?php echo $pm; ?>/<?php echo $row['id']; ?>"><span class="label job-type job-contract "><?php echo $lang['btn_buy']; ?></span></a>
                                       <?php } else { ?>
										<a href="<?php echo $settings['url'];?>ad/<?php echo $pm; ?>-to-Bitcoin/<?php echo $row['id']; ?>"><span class="label job-type job-contract "><?php echo $lang['btn_buy']; ?></span></a>
                                        
										<?php } ?>
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
							$ver = $settings['url']."search";
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