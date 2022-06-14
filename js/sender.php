<?

function message_to_telegram($text)
{
	$arr_chat = "381762556, 845697964";
	if($arr_chat) {

		$arr_chat = explode(",",$arr_chat);
	    $ch = curl_init();
		
		for ($i = 0; $i<count($arr_chat); $i++) {
		    curl_setopt_array(
		        $ch,
		        array(
		            CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
		            CURLOPT_POST => TRUE,
		            CURLOPT_RETURNTRANSFER => TRUE,
		            CURLOPT_TIMEOUT => 10,
		            CURLOPT_POSTFIELDS => array(
		                'chat_id' => trim($arr_chat[$i]),
		                'text' => $text,
		            ),
		        )
		    );
		    $output = curl_exec($ch);
		}
	}
	
}

// Универсальный отправщик
add_action('wp_ajax_newsendr', 'newsendr');
add_action('wp_ajax_nopriv_newsendr', 'newsendr');

function newsendr()
{
	if (empty($_REQUEST['nonce'])) {
		wp_die('0');
	}

	if (check_ajax_referer('NEHERTUTLAZIT', 'nonce', false)) {
       
		$send_adr = carbon_get_theme_option('email_send');
	
		

		$subj = "Сообщение с сайта";
		$content = "<h2>Новое сообщение с сайта</h2>";
		$content_tg = "Новое сообщение с сайта\n\r";

		for ($i =0; $i < count($_REQUEST["fildname"]); $i++) {
			$content .= $_REQUEST["fildval"][$i].": <strong>".$_REQUEST[$_REQUEST["fildname"][$i]]."</strong><br/>";
			$content_tg .= $_REQUEST["fildval"][$i].": ".$_REQUEST[$_REQUEST["fildname"][$i]]."\n\r";
		}

		message_to_telegram($content_tg);

		$headers = array(
			'From: Сайт Мир Туризма 46 <noreply@mirturizma46.ru>',
			'content-type: text/html',
		);

		add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
		if (wp_mail($send_adr, $subj, $content, $headers))
		{
			wp_die(true);
		} else {
			wp_die("NO ОК", '', 403 );
		}

	} else {
		wp_die('НО-НО-НО!', '', 403);
	}
}

?>