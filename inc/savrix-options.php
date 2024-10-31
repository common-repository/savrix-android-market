<?php
/*
Part of the plugin Savrix Play Store
*/
// Init plugin options to white list our options
function savrixplaystore_init(){
	register_setting('savrixplaystore_options', 'savrixplaystore', 'savrixplaystore_validate');
}

// Add menu page
function savrixplaystore_add_page() {
	add_options_page('Savrix Play Store Settings', 'Savrix Play Store', 'manage_options', 'savrixplaystore', 'savrixplaystore_do_page');
}

// Draw the menu page itself
function savrixplaystore_do_page() {
	?>
	<div class="wrap">
		<h2>Savrix Play Store Options</h2>
		<div style="float:left;width:100%;max-width:780px;">
		<form method="post" action="options.php" name="savrix_settings">
			<?php settings_fields('savrixplaystore_options'); ?>
			<?php $options = savrixplaystore_load_options(); ?>
			<table class="form-table">
				<tr valign="top"><th scope="row">Caching<br/>
				(Disable it if you experience problems)
				</th>
					<td>
						<fieldset>
							<input name="savrixplaystore[cache]" type="radio" value="0" <?php checked('0', $options['cache']); ?> />&emsp;<strong>Disable:</strong> Retrieve data from the Play Store every time the page is required<br/>
							<input name="savrixplaystore[cache]" type="radio" value="1" <?php checked('1', $options['cache']); if (!is_writable(SAVRIXPLAYSTORE_PATH . "pages/")){ ?> disabled="disabled" <?php } ?> />&emsp;<strong>Enable for data only:</strong> Stores application data (name, developer, rating) locally<br/>
							<input name="savrixplaystore[cache]" type="radio" value="2" <?php checked('2', $options['cache']); if ((!is_writable(SAVRIXPLAYSTORE_PATH . "pages/")) || !(extension_loaded('gd') && function_exists('gd_info'))){ ?> disabled="disabled" <?php } ?> />&emsp;<strong>Enable also for app icon:</strong> Stores application data (name, developer, rating) and icon locally<br/>
						</fieldset>
					</td>
				</tr>
				<tr valign="top"><th scope="row">AppBrain</th>
					<td>
						<input name="savrixplaystore[appbrain]" type="checkbox" value="1" <?php checked('1', $options['appbrain']); ?> />&emsp;Check this option to show both "Google Play" and "AppBrain" buttons.<br/>
						&emsp;&emsp;Uncheck it to show only the "Google Play" button.
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<br/>
						If you have enabled the caching, use the option below to specify after how many days the application data have to be updated.
					</td>
				</tr>
				<tr valign="top"><th scope="row">Data Cache Days</th>
					<td>
						<input type="text" name="savrixplaystore[phpcachedays]" value="<?php echo $options['phpcachedays']; ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" colspan="2"><br/><strong>Language Option</strong><br/>
						Here you can chose in which language the plugin will try to fetch the data from the Play Store.<br/>
						Please note that for some languages, Google Play Store uses the server location Country language to show some data.<br/>
						Please note that the currency depends on the server location Country.
					</th>
				</tr>
				<tr valign="top"><th scope="row">Language</th>
					<td>
						<select name="savrixplaystore[language]">
							<option <?php if ($options['language'] == "en"){ ?> selected <?php }?> value="en">English</option>
							<option <?php if ($options['language'] == "it"){ ?> selected <?php }?> value="it">Italiano</option>
							<option <?php if ($options['language'] == "es"){ ?> selected <?php }?> value="es">Espa&ntilde;ol</option>
							<option <?php if ($options['language'] == "ca"){ ?> selected <?php }?> value="ca">Catal&agrave;</option>
							<option <?php if ($options['language'] == "fr"){ ?> selected <?php }?> value="fr">Fran&ccedil;ais</option>
							<option <?php if ($options['language'] == "de"){ ?> selected <?php }?> value="de">Deutsche</option>
							<option <?php if ($options['language'] == "pt"){ ?> selected <?php }?> value="pt">Portugu&ecirc;s</option>
							<option <?php if ($options['language'] == "bg"){ ?> selected <?php }?> value="bg">Bulgarian</option>
							<option <?php if ($options['language'] == "hr"){ ?> selected <?php }?> value="hr">Hrvatski</option>
							<option <?php if ($options['language'] == "cs"){ ?> selected <?php }?> value="cs">Czech</option>
							<option <?php if ($options['language'] == "da"){ ?> selected <?php }?> value="da">Danski</option>
							<option <?php if ($options['language'] == "nl"){ ?> selected <?php }?> value="nl">Dutch</option>
							<option <?php if ($options['language'] == "et"){ ?> selected <?php }?> value="et">Estonian</option>
							<option <?php if ($options['language'] == "fi"){ ?> selected <?php }?> value="fi">Suomi</option>
							<option <?php if ($options['language'] == "el"){ ?> selected <?php }?> value="el">Greek</option>
							<option <?php if ($options['language'] == "hu"){ ?> selected <?php }?> value="hu">Magyar</option>
							<option <?php if ($options['language'] == "lv"){ ?> selected <?php }?> value="lv">Latvijas</option>
							<option <?php if ($options['language'] == "lt"){ ?> selected <?php }?> value="lt">Lietuvos</option>
							<option <?php if ($options['language'] == "no"){ ?> selected <?php }?> value="no">Norsk</option>
							<option <?php if ($options['language'] == "pl"){ ?> selected <?php }?> value="pl">Polski</option>
							<option <?php if ($options['language'] == "ro"){ ?> selected <?php }?> value="ro">Romanian</option>
							<option <?php if ($options['language'] == "ru"){ ?> selected <?php }?> value="ru">Russian</option>
							<option <?php if ($options['language'] == "sr"){ ?> selected <?php }?> value="sr">Serbian</option>
							<option <?php if ($options['language'] == "sk"){ ?> selected <?php }?> value="sk">Slovak</option>
							<option <?php if ($options['language'] == "sl"){ ?> selected <?php }?> value="sl">Slovenian</option>
							<option <?php if ($options['language'] == "sv"){ ?> selected <?php }?> value="sv">Svensk</option>
							<option <?php if ($options['language'] == "tu"){ ?> selected <?php }?> value="tu">T&uuml;rk</option>
							<option <?php if ($options['language'] == "uk"){ ?> selected <?php }?> value="uk">Ukrainian</option>
							<option <?php if ($options['language'] == "zh"){ ?> selected <?php }?> value="zh">Chinese</option>
							<option <?php if ($options['language'] == "ja"){ ?> selected <?php }?> value="ja">Japanese</option>
						</select>
					</td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
		<br/>
		<form method="post" action="" name="savrix_delete">
			Use the button below if you want to delete all files in cache.<br/>
			<input type="hidden" name="sav_del" value="savrix_delete_cache" />
			<input type="submit" class="button-secondary" value="Clear Cache" />
		</form>
		<?php
		if (isset($_POST['sav_del']))
			savrixplaystore_delete_cache();
		?>
		</div>
		<div style="float:left; margin-left:20px; margin-top:10px; border: #E1D6C6 1px solid; text-align:center;width:300px;">
		<span style="display:block;font-weight:bold;height:22px;padding:2px;background:whitesmoke;">Support the development of the plugin</span>
		<div style="background: #c9defa;padding:10px;">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="saverio.petrangelo@gmail.com">
			<input type="hidden" name="lc" value="GB">
			<input type="hidden" name="item_name" value="Donation for Savrix Play Store">
			<input type="hidden" name="item_number" value="savrixplaystore">
			<strong>Enter the amount in EUR&nbsp;</strong>
			<input name="amount" value="5.00" size="6" type="text"><br/><br/>
			<input type="hidden" name="currency_code" value="EUR">
			<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
			<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
			<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
			</form>
			<hr>
			<br/>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="saverio.petrangelo@gmail.com">
			<input type="hidden" name="lc" value="GB">
			<input type="hidden" name="item_name" value="Donation for Savrix Play Store">
			<input type="hidden" name="item_number" value="savrixplaystore">
			<strong>Enter the amount in USD&nbsp;</strong>
			<input name="amount" value="5.00" size="6" type="text"><br/><br/>
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
			<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
			<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
		</div>
	</div>
	<?php
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function savrixplaystore_validate($input) {

	$input['phpcachedays'] = ( is_numeric($input['phpcachedays']) ? $input['phpcachedays'] : 15 );
	$input['phpcachedays'] = $input['phpcachedays'] >= 0 ? $input['phpcachedays'] : 15;
	
	// Option must be safe text with no HTML tags
	$input['phpcachedays'] =  wp_filter_nohtml_kses($input['phpcachedays']);
	
	return $input;
}

function savrixplaystore_delete_cache(){
	if (is_writable(SAVRIXPLAYSTORE_PATH . "pages/")){
		$dir = SAVRIXPLAYSTORE_PATH . "pages/";
		$handle = opendir($dir);
		while ($file = readdir($handle)) {
			// If $file is NOT a directory remove it
			if(!is_dir($file)) {
				@unlink ("$dir"."$file"); // unlink() deletes the files
			}
		}
		// Close the directory
		closedir($handle);
		
		$dir = SAVRIXPLAYSTORE_PATH . "pages/icons/";
		$handle = opendir($dir);
		while ($file = readdir($handle)) {
			// If $file is NOT a directory remove it
			if(!is_dir($file)) {
				@unlink ("$dir"."$file"); // unlink() deletes the files
			}
		}
		// Close the directory
		closedir($handle);
		
		echo "Cache deleted";
	}
}
?>