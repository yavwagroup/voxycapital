<?php
$b = protect($_GET['b']);

if($b == "edit") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM btc_ads WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=advertisements"); }
	$row = $query->fetch_assoc();
	?>
	<script type="text/javascript">
	function btc_calculate_price() {
		var url = $("#url").val();
		var amount = $("#btc_amount").val();
		var currency = $("#btc_currency").val();
		var data_url = "requests/btc_calculate_price.php?amount="+amount+"&currency="+currency;
		$.ajax({
			type: "GET",
			url: data_url,
			dataType: "html",
			success: function (data) {
				$("#your_btc_price").html(data);
			}
		});
	}
	</script>
	
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=advertisements">Advertisements</a></li>
		<li class="active">Edit advertisement</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Edit advertisement
		</div>
		<div class="panel-body">
			<?php
			if(isset($_POST['btn_save'])) {
				$payment_method = protect($_POST['payment_method']);
							$currency = protect($_POST['currency']);
							$amount = protect($_POST['amount']);
							$payment_instructions = protect($_POST['payment_instructions']);
							$min_amount = protect($_POST['min_amount']);
							$max_amount = protect($_POST['max_amount']);
							$process_time = protect($_POST['process_time']);
							$terms = protect($_POST['terms']);
							if(empty($payment_method) or empty($currency) or empty($amount) or empty($payment_instructions) or empty($min_amount) or empty($max_amount) or empty($process_time) or empty($terms)) { echo error("All fields are required."); }
							elseif(!is_numeric($amount)) { echo error("Enter Bitcoin price with numbers."); }
							elseif(!is_numeric($min_amount)) { echo error("Enter minimal trade amount with numbers."); }
							elseif(!is_numeric($max_amount)) { echo error("Enter maximum trade amount with numbers."); }
							elseif(!is_numeric($process_time)) { echo error("Enter trade process time with numbers."); }
							else {
								$update = $db->query("UPDATE btc_ads SET payment_method='$payment_method',currency='$currency',price='$amount',payment_instructions='$payment_instructions',min_amount='$min_amount',max_amount='$max_amount',process_time='$process_time',terms='$terms' WHERE id='$row[id]'");
								$query = $db->query("SELECT * FROM btc_ads WHERE id='$row[id]'");
								$row = $query->fetch_assoc();
								echo success("Your changes was saved.");
							}
			}
			?>
			
			<form action="" method="POST">
				
				<div class="col-md-12">
							<?php
							if($row['type'] == "sell") {
							?>Trader current ad type is <b>Sell bitcoins</b>, thats mean clients will buy bitcoins from trader.<?php
							} else {
							?>Trader current ad type is <b>Buy bitcoins</b>, thats mean clients will sell bitcoins to trader.<?php
							}
							?>
							<br><br>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Payment method</label>
									<select class="form-control" name="payment_method">
										<option value="PayPal" <?php if($row['payment_method'] == "PayPal") { echo 'selected'; } ?>>PayPal</option>
										<option value="Skrill" <?php if($row['payment_method'] == "Skrill") { echo 'selected'; } ?>>Skrill</option>
										<option value="Payeer" <?php if($row['payment_method'] == "Payeer") { echo 'selected'; } ?>>Payeer</option>
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
								<br><span class="text text-muted">Choose method of payment wich trader receive money if sell bitcoins or send money if trader buy bitcoins.</span>
							</div>
							<div class="col-md-12"><br></div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Currency</label>
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
								<br><span class="text text-muted">Choose a currency of trader ad. If trader sell bitcoins will, clients will pay bitcoin price via this currency. If trader buy bitcoins, clients will pay to trader bitcoin price via this currency.</span>
							</div>
							<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Enter trader comission with percentage (without %)</label>
										<input type="text" class="form-control" name="amount" value="<?php echo $row['price']; ?>" onkeyup="btc_calculate_price();" onkeydown="btc_calculate_price();" id="btc_amount">
										Current Bitcoin price: <?php echo get_current_bitcoin_price(); ?> USD<br/>
										<span id="your_btc_price">Trader Bitcoin price: <?php echo convertBTCprice($row['price'],$row['currency']); ?> <?php echo $row['currency']; ?></span>
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted">Enter trader comission percentage without %. Example: If enter 2 (thats mean 2%) and current Bitcoin price is 600 USD, your price in ad will be 588 USD. If you enter -2 (thats mean -2%) and current Bitcoin price is 600 USD, your price in ad will be 612 USD. If you choose other currency code, price will be converted automatically.</span>
								</div>
							<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Payment instructions</label>
										<textarea class="form-control" name="payment_instructions" rows="5"><?php echo $row['payment_instructions']; ?></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted">If trader sell bitcoins, here can enter trader account details for payment to receive amount before trader give bitcoins to client.</span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Minimal trade amount</label>
										<input type="text" class="form-control" name="min_amount" value="<?php echo $row['min_amount']; ?>">
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted">Enter the minimal amount for trade. Example: if enter 10, in ad list will be showed limit from 10 to max trade amount, and client can not buy or sell bitcoins if their amount converted to trader currency is at least 10</span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Maximum trade amount</label>
										<input type="text" class="form-control" name="max_amount" value="<?php echo $row['max_amount']; ?>">
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted">Enter the maximum amount for trade. Example: if enter 1000, in ad list will be showed limit from min amount to 1000, and client can not buy or sell bitcoins if their amount converted to trader currency is exceed 1000</span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Trade process time</label>
										<input type="text" class="form-control" name="process_time" value="<?php echo $row['process_time']; ?>">
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted">Enter trader trade process time in minutes. If trader enter 30, trader and client have 30 minutes to complete trade. I.e client need to send money/bitcoins or trader need to send money/bitcoins to client before expire time.</span>
								</div>
								<div class="col-md-12"><br></div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Terms of trade</label>
										<textarea class="form-control" name="terms" rows="5"><?php echo $row['terms']; ?></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<br><span class="text text-muted">Here trader can enter own terms of trade, and when client make trade by this ad, automatically agree it.</span>
								</div>
							<div class="col-md-12">
				<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
				</div>
			</form>
		</div>
	</div>
	<?php
} elseif($b == "delete") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM btc_ads WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=advertisements"); }
	$row = $query->fetch_assoc();
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=advertisements">Advertisements</a></li>
		<li class="active">Delete advertisement</li>
	</ol>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Delete advertisement
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$delete = $db->query("DELETE FROM btc_ads WHERE id='$row[id]'");
				$delete = $db->query("DELETE FROM btc_trades WHERE ad_id='$row[id]'");
				echo success("Advertisement <b>#$row[id]</b> was deleted.");
			} else {
				echo info("Are you sure you want to delete this advertisement <b>#$row[id]</b>?");
				echo '<a href="./?a=advertisements&b=delete&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=advertisements" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} else {
?>
<ol class="breadcrumb">
	<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
	<li class="active">Advertisements</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Advertisements
	</div>
	<div class="panel-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="5%">ID</th>
					<th width="20%">Trader</th>
					<th width="15%">Ad Type</th>
					<th width="15%">Payment method</th>
					<th width="10%">Bitcoin Price</th>
					<th width="10%">Process time</th>
					<th width="10%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;
				if($page == 1) {
					$i = 1;
				} else {
					$i = $page * $limit;
				}
				if($b == "by_user") {
					$uid = protect($_GET['uid']);
					$statement = "btc_ads WHERE uid='$uid'";
					$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC");
				} else {
					$statement = "btc_ads";
					$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
				}
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						$currency = $row['currency'];
						if($row['currency'] == "USD") {
							$btcprice = get_current_bitcoin_price();
							$com = $row['price'];
							$com2 = ($btcprice * $com) / 100;
							$amm = $btcprice - $com2;
							$price = ceil($amm).' '.$currency;
						} else {
							$btcprice = get_current_bitcoin_price();
							$com = $row['price'];
							$com2 = ($btcprice * $com) / 100;
							$com3 = $btcprice - $com2;
							$amm = currencyConvertor($com3,"USD",$currency);
							$price = ceil($amm).' '.$currency.' ('.$com3.' USD)';
						}
						?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><a href="./?a=advertisements&b=by_user&uid=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"username"); ?></a></td>
							<td><?php if($row['type'] == "sell") { echo 'Sell bitcoins'; } elseif($row['type'] == "buy") { echo 'Buy bitcoins'; } else { } ?></td>
							<td><?php echo $row['payment_method']; ?></td>
							<td><?php echo $price; ?></td>
							<td><?php echo $row['process_time']; ?> minutes</td>
							<td>
								<a href="./?a=advertisements&b=edit&id=<?php echo $row['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
								<a href="./?a=advertisements&b=delete&id=<?php echo $row['id']; ?>" title="Delete"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<?php
					}
				} else {
					echo '<tr><td colspan="4">Still no have faq.</td></tr>';
				}
				?>
			</tbody>
		</table>
		<?php
		$ver = "./?a=advertisements";
		if(admin_pagination($statement,$ver,$limit,$page)) {
			echo admin_pagination($statement,$ver,$limit,$page);
		}
		?>
	</div>
</div>
<?php
}
?>