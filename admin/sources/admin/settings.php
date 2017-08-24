<ol class="breadcrumb">
	<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
	<li class="active">Web Settings</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Web Settings
	</div>
	<div class="panel-body">
		<?php
		if(isset($_POST['btn_save'])) {
			$title = protect($_POST['title']);
			$description = protect($_POST['description']);
			$keywords = protect($_POST['keywords']);
			$name = protect($_POST['name']);
			$url = protect($_POST['url']);
			$infoemail = protect($_POST['infoemail']);
			$supportemail = protect($_POST['supportemail']);
			$sell_comission = protect($_POST['sell_comission']);
			$buy_comission = protect($_POST['buy_comission']);
			$withdrawal_comission = protect($_POST['withdrawal_comission']);
			if(isset($_POST['document_verification'])) { $document_verification = '1'; } else { $document_verification = '0'; }
			if(isset($_POST['email_verification'])) { $email_verification = '1'; } else { $email_verification = '0'; }
			if(isset($_POST['phone_verification'])) { $phone_verification = '1'; } else { $phone_verification = '0'; }
			$nexmo_api_key = protect($_POST['nexmo_api_key']);
			$nexmo_api_secret = protect($_POST['nexmo_api_secret']);
			if(empty($title) or empty($description) or empty($keywords) or empty($name) or empty($url) or empty($infoemail) or empty($supportemail)) {
				echo error("All fields are required."); 
			} elseif(!isValidURL($url)) { 
				echo error("Please enter valid site url address.");
			} elseif(!isValidEmail($infoemail)) { 
				echo error("Please enter valid info email address.");
			} elseif(!isValidEmail($supportemail)) { 
				echo error("Please enter valid support email address.");
			} elseif(!is_numeric($withdrawal_comission)) { 
				echo error("Please enter withdrawal comission with numbers.");
			} elseif($phone_verification == "1" && empty($nexmo_api_key)) {
				echo error("Please enter Nexmo API Key."); 
			} elseif($phone_verification == "1" && empty($nexmo_api_secret)) {
				echo error("Please enter Nexmo API Secret.");
			} else {
				$update = $db->query("UPDATE btc_settings SET title='$title',description='$description',keywords='$keywords',name='$name',url='$url',infoemail='$infoemail',supportemail='$supportemail',sell_comission='$sell_comission',buy_comission='$buy_comission',withdrawal_comission='$withdrawal_comission',document_verification='$document_verification',email_verification='$email_verification',phone_verification='$phone_verification',nexmo_api_key='$nexmo_api_key',nexmo_api_secret='$nexmo_api_secret'");
				$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
				$settings = $settingsQuery->fetch_assoc();
				echo success("Your changes was saved successfully.");
			}
		}
		?>
		<form action="" method="POST">
			<div class="form-group">
				<label>Title</label>
				<input type="text" class="form-control" name="title" value="<?php echo $settings['title']; ?>">
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea class="form-control" name="description" rows="2"><?php echo $settings['description']; ?></textarea>
			</div>
			<div class="form-group">
				<label>Keywords</label>
				<textarea class="form-control" name="keywords" rows="2"><?php echo $settings['keywords']; ?></textarea>
			</div>
			<div class="form-group">
				<label>Site name</label>
				<input type="text" class="form-control" name="name" value="<?php echo $settings['name']; ?>">
			</div>
			<div class="form-group">
				<label>Site url address</label>
				<input type="text" class="form-control" name="url" value="<?php echo $settings['url']; ?>">
			</div>
			<div class="form-group">
				<label>Info email address</label>
				<input type="text" class="form-control" name="infoemail" value="<?php echo $settings['infoemail']; ?>">
			</div>
			<div class="form-group">
				<label>Support email address</label>
				<input type="text" class="form-control" name="supportemail" value="<?php echo $settings['supportemail']; ?>">
			</div>
			<div class="form-group">
				<label>Comission when client buy Bitcoin from Trader</label>
				<div class="input-group">
					<input type="text" class="form-control" name="buy_comission" value="<?php echo $settings['buy_comission']; ?>">
					<span class="input-group-addon" id="basic-addon2">BTC</span>
				</div>
				<small>Trader will be charged with amount you enter in this field when client buy bitcoins from him/her, this comission automatically will be transfered in your Bitcoin address setuped in <a href="./?a=api_keys">Block.io API Keys</a>. You can setup comission with percentage <b>(Example: 0.2%)</b>, when enter comission with percentage, your comission for example will be 0.2% of 1 BTC = 0.002 BTC</small>
			</div>
			<div class="form-group">
				<label>Comission when client sell Bitcoin to Trader</label>
				<div class="input-group">
					<input type="text" class="form-control" name="sell_comission" value="<?php echo $settings['sell_comission']; ?>">
					<span class="input-group-addon" id="basic-addon2">BTC</span>
				</div>
				<small>Client will be charged with the amount entered in this field when he decided to buy Bitcoin from a Trader. It will be added to the amount he wants to exchange, this comission automatically will be transfered in your Bitcoin address setuped in <a href="./?a=api_keys">Block.io API Keys</a>.You can setup comission with percentage <b>(Example: 0.2%)</b>, when enter comission with percentage, your comission for example will be 0.2% of 1 BTC = 0.002 BTC</small>
			</div>
			<div class="form-group">
				<label>Comission when client withdrawal or send Bitcoins to other address</label>
				<div class="input-group">
					<input type="text" class="form-control" name="withdrawal_comission" value="<?php echo $settings['withdrawal_comission']; ?>">
					<span class="input-group-addon" id="basic-addon2">BTC</span>
				</div>
				<small>This comission automatically will be transfered in your Bitcoin address setuped in <a href="./?a=api_keys">Block.io API Keys</a>. </small>
			</div>
			<div class="checkbox">
					<label>
					  <input type="checkbox" name="document_verification" value="yes" <?php if($settings['document_verification'] == "1") { echo 'checked'; }?>> Enable documents verification (The traders can require clients to be verified their documents before use their ad)
					</label>
			</div>
			<div class="checkbox">
					<label>
					  <input type="checkbox" name="email_verification" value="yes" <?php if($settings['email_verification'] == "1") { echo 'checked'; }?>> Enable email verification (The traders can require clients to be verified their email address before use their ad)
			</div>
			<div class="checkbox">
					<label>
					  <input type="checkbox" name="phone_verification" value="yes" <?php if($settings['phone_verification'] == "1") { echo 'checked'; }?>> Enable mobile verification (The traders can require clients to be verified their mobile number before use their ad)
					</label>
			</div>
			<div class="form-group">
				<label>Nexmo API Key</label>
				<input type="text" class="form-control" name="nexmo_api_key" value="<?php echo $settings['nexmo_api_key']; ?>">
				<small>Type Nexmo API Key if you turned on mobile verification. Get api key form <a href="http://nexmo.com" target="_blank">www.nexmo.com</a></small>
			</div>
			<div class="form-group">
				<label>Nexmo API Secret</label>
				<input type="text" class="form-control" name="nexmo_api_secret" value="<?php echo $settings['nexmo_api_secret']; ?>">
				<small>Type Nexmo API Secret if you turned on mobile verification. Get api secret form <a href="http://nexmo.com" target="_blank">www.nexmo.com</a></small>
			</div>
			<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
		</form>
	</div>
</div>