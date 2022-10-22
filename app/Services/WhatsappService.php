<?php

namespace App\Services;

use App\Models\Saml;
use Illuminate\Support\Facades\Config;

class WhatsappService {

	public function sendMessage($pesan) 
	{
		$ch = curl_init("https://api.callmebot.com/whatsapp.php?phone=+6281239466830&text=". urlencode($pesan) ."&apikey=323471");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow Reditect
		curl_setopt($ch, CURLOPT_USERAGENT, "test");
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt'); // Using Cookie
		return curl_exec($ch);
	}
}