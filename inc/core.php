<?php
/*
Part of the plugin Savrix Play Store
*/
function sav_get_file($package_name) {
	global $savrix_file;
	global $savrix_options;
 
    $savrix_file = false;
    $ua = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.72 Safari/537.36';
	$headers = array(
        'Accept-language' => 'en-us,en;q=0.5', // if plugin doesn't show in the language you've selected, try to change this line
    );
    $url = 'https://play.google.com/store/apps/details?id=' . $package_name . '&hl=' . $savrix_options['language'];
 
    if (in_array('curl', get_loaded_extensions()) == true) {
        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 
        $savrix_file = curl_exec($ch);
        curl_close($ch);
    } else {
        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => "User-Agent: ".$ua."\r\n" .
                            "Accept-language: en-us,en;q=0.5\r\n" . // if plugin doesn't show in the language you've selected, try to change this line
                            "Connection: close\r\n"
            )
        );
        $sav_context = stream_context_create($opts);
        $savrix_file = @file_get_contents($url, false, $sav_context);
    }
}

function market_code ($sav_atts, $sav_content = null) {
	extract( shortcode_atts( array(
		'type' => 'market',
	), $sav_atts ) );
	
	global $savrix_file;
	global $savrix_options;

	$cache = $savrix_options['cache'];
	$daysphp = -1;
	$phpcachedays = $savrix_options['phpcachedays'];
	
	$app_name = "App Name";
	$app_developer = "Developer";
	$app_price = "ND";
	$app_icon = SAVRIXPLAYSTORE_URL . "images/default-icon.png";
	$link_market = "https://play.google.com/store/apps/";
	$link_appbrain = "http://www.appbrain.com/";
	$app_stars = "";
	$sav_content = trim(strip_tags($sav_content));

	if ($cache >= 1){
		$filename = SAVRIXPLAYSTORE_PATH . "pages/" . $sav_content . ".php";
		$filename2 = SAVRIXPLAYSTORE_PATH . "pages/icons/" . $sav_content . ".png";
	}
	
	if (($cache >= 1) && file_exists($filename)){
		/* days from the last update of the file */
		$ts1=filemtime($filename);
		$ts2=time();
		$seconds_diff = $ts2 - $ts1;
		$daysphp = floor($seconds_diff/3600/24);
	}
	
	if (($cache >= 1 && (!(file_exists($filename)) || $daysphp >= $phpcachedays)) || $cache == 0){
		if ($sav_content != "") {
			sav_get_file($sav_content);

			if ($savrix_file != false) {
				$regexp = "<span\sitemprop=\"offers\"\s[^>]*>.*itemprop=\"offerType\">\s<meta\scontent=\"(.*)\"\sitemprop=\"price\">";
				if(preg_match_all("/$regexp/siU", $savrix_file, $matches)) {
					$app_price = $matches[1][0];}
				if ($app_price == "ND") {
					$app_price = "Free";
					}

				$regexp = "<div\sclass=\"document-title\"\sitemprop=\"name\">\s<div>(.*)<\/div>";
				if(preg_match_all("/$regexp/siU", $savrix_file, $matches)) {
					$app_name = $matches[1][0];
				}
				
				$regexp = "<div\sitemprop=\"author\"\s.*itemprop=\"name\">(.*)<\/a>";
				if(preg_match_all("/$regexp/siU", $savrix_file, $matches)) {
					$app_developer = $matches[1][0];
				}
				
				$regexp = "<div\sclass=\"cover-container\">\s<img\s[^>]*\ssrc=\"([^=]*)=.*\"";
				if(preg_match_all("/$regexp/siU", $savrix_file, $matches)) {
					$app_icon = $matches[1][0];
				}
				
				$regexp = "<div\sclass=\"header-star-badge\">.*<div\sclass=\"current-rating\"\sstyle=\"width:(.*)\">";
				if(preg_match_all("/$regexp/siU", $savrix_file, $matches)) {
					$app_stars = $matches[1][0];
				}
			}
			
			$link_market = "https://play.google.com/store/apps/details?id=" . $sav_content;
			$link_appbrain = "http://www.appbrain.com/app/" . $sav_content;
			if (strcasecmp($type, "market") == 0)
				$link_qr_code = $link_market;
			else if (strcasecmp($type, "appbrain") == 0)
				$link_qr_code = $link_appbrain;
				
			if ($cache == 2 && ($app_icon != SAVRIXPLAYSTORE_URL . "images/default-icon.png")){
				if ($daysphp >= $phpcachedays || !file_exists($filename2)) {
					$savrix_type = savrix_create_icon($app_icon,$sav_content,75,75);
				}
				if ($savrix_type == 3)
					$app_icon = SAVRIXPLAYSTORE_URL . "pages/icons/" . $sav_content . ".png";
			}
			
			$badge = '<br /><div class="play-store-container">
				<div id="top-play-store"></div>
				<div class="play-store-table">
				<div id="play-store-app-icon">';
				if ($savrix_options['appbrain'] == 0){
					$badge .= '<a href="' . $link_market . '" target="_blank" rel="nofollow">';
				}
				$badge .= '<img src="' . $app_icon . '" alt="logo-app" />';
				if ($savrix_options['appbrain'] == 0){
					$badge .= '</a>';
				}
				$badge .= '</div><div id="play-store-text">';
				if ($savrix_options['appbrain'] == 0){
					$badge .= '<a href="' . $link_market . '" target="_blank" rel="nofollow">';
				}
				$badge .= '<strong><span class="play-store-app-name">' . $app_name . '</span></strong>';
				if ($savrix_options['appbrain'] == 0){
					$badge .= '</a>';
				}
				$badge .= '<br />
				<span class="play-store-developer">' . $app_developer . '</span><br /> 
				<span class="play-store-price">' . $app_price . '</span>&nbsp;&nbsp;&nbsp;<div class="stars-container">
				<div class="tiny-star">
				<div class="current-rating" style="width:' . $app_stars . '"></div>
				</div>
				</div>
				</div>';
				if ($savrix_options['appbrain'] == 1){
					$badge .= '<div id="play-store-install">
					<a href="' . $link_market . '" target="_blank" rel="nofollow"><img class="play-store-button" src="' . SAVRIXPLAYSTORE_URL . 'images/' . 'gplay-button.jpg" alt="pulsante-google-play-store" /></a><br />
					<a href="' . $link_appbrain . '" target="_blank" rel="nofollow"><img class="play-store-button" src="' . SAVRIXPLAYSTORE_URL . 'images/' . 'appbrain-button.jpg" alt="pulsante-appbrain" /></a>
					</div>';
				}
				$badge .= '<div id="play-store-qrcode"><img src="http://qrfree.kaywa.com/?l=1&amp;s=5&amp;d=' . urlencode($link_qr_code) . '" alt="qrcode-app" />
				</div>
				</div></div><br />';
		}
	}
	if ($cache >= 1){
		if (($app_name != "App Name") && (!(file_exists($filename)) || $daysphp >= $phpcachedays)){
			$handle = fopen($filename, "w");
			fwrite($handle,$badge);
			fclose($handle);
			}
		elseif (file_exists($filename)){
			$handle = fopen($filename, "r");
			$badge = fread($handle,filesize($filename));
			fclose($handle);
		}
	}
	return $badge;
}

function sav_qr_code ($qr_atts, $qr_content = null) {
	extract( shortcode_atts( array(
		'size' => '125',
		'type' => 'market',
		'class' => '',
	), $qr_atts ) );
	
	if (strcasecmp($type, "market") == 0)
		$qr_link_market = "https://play.google.com/store/apps/details?id=" . $qr_content;
	else if (strcasecmp($type, "appbrain") == 0)
		$qr_link_market = "http://www.appbrain.com/app/" . $qr_content;
	
	if ($class != "")
		return '<img class="' . $class . '" title="QR Code" src="http://qrfree.kaywa.com/?l=1&amp;s=5&amp;d=' . urlencode($qr_link_market) . '" alt="qrcode-app" />';
	else
		return '<img width="'. $size. '" height="' . $size . '" title="QR Code" src="http://qrfree.kaywa.com/?l=1&amp;s=5&amp;d=' . urlencode($qr_link_market) . '" alt="qrcode-app" />';
}

function sav_icon_code ($icon_atts, $icon_content = null) {
	extract( shortcode_atts( array(
		'size' => '125',
		'class' => '',
	), $icon_atts ) );
	
	$sav_icon = "";
	global $savrix_options;
	global $savrix_file;
	
	$cache = $savrix_options['cache'];
	$daysphp = -1;
	$phpcachedays = $savrix_options['phpcachedays'];
	
	if ($cache == 2)
		$filename2 = SAVRIXPLAYSTORE_PATH . "pages/icons/" . $icon_content . ".png";

	if (($cache == 2) && file_exists($filename2)){
		/* days from the last update of the file */
		$ts1=filemtime($filename2);
		$ts2=time();
		$seconds_diff = $ts2 - $ts1;
		$daysphp = floor($seconds_diff/3600/24);
	}
	if (($cache == 2 && (!(file_exists($filename2)) || $daysphp >= $phpcachedays)) || $cache == 0){
		if ($savrix_file == false){
			sav_get_file($icon_content);
			}
		else {
			if (!stristr($savrix_file, $icon_content)){
				sav_get_file($icon_content);
				}
			}
		
		if ($savrix_file != false) {
			$regexp = "<div\sclass=\"cover-container\">\s<img\s[^>]*\ssrc=\"([^=]*)=.*\"";
				if(preg_match_all("/$regexp/siU", $savrix_file, $matches)) {
					$sav_icon = $matches[1][0];
				}
			}
		if ($cache == 2 && $sav_icon != ""){
			$savrix_type = savrix_create_icon($sav_icon,$icon_content,$size,$size);
			if ($savrix_type == 3)
				$sav_icon = SAVRIXPLAYSTORE_URL . "pages/icons/" . $icon_content . ".png";
		}
	}
	elseif ($cache == 2 && file_exists($filename2)){
		$sav_icon = SAVRIXPLAYSTORE_URL . "pages/icons/" . $icon_content . ".png";
	}
	
	$icontext = '<img src="' . $sav_icon . '" alt="logo-app" ';
	if ($class != "") {
		$icontext = $icontext . 'class="' . $class . '" ';
		}
	else {
		$icontext = $icontext . 'width="' . $size . '" height="' . $size .'" ';
		}
	$icontext = $icontext . '/>';
	return $icontext;
}

function savrix_create_icon($app_icon,$sav_content,$w,$h){
	list($width, $height, $type) = getimagesize($app_icon);
	if ($type == 3){
		$newwidth = $w; // pixel width of the image to be saved
		$newheight = $h; // pixel height of the image to be saved
		// Load
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		imagealphablending($thumb, false);
		imagesavealpha($thumb, true);  
		$source = imagecreatefrompng($app_icon);
		imagealphablending($source, true);
		// Resize
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		// Output
		imagepng($thumb,SAVRIXPLAYSTORE_PATH . "pages/icons/" . $sav_content . ".png");
	}
	return $type;
}

function savrixplaystore_load_options() {
	$savrixdefault = array(
		'cache' => 0,
		'appbrain' => 1,
		'phpcachedays' => 15,
		'language' => 'en',
		);
	$options = get_option('savrixplaystore', $savrixdefault);
	
	return $options;
}