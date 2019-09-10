<?php

/*!
 *  Elberos Telegram
 *
 *  (c) Copyright 2019 "Ildar Bikmamatov" <support@bayrell.org>
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      https://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

namespace \Elberos\Telegram;


class Provider extends \Elberos\Core\Struct
{
	protected $__enable = false;
	protected $__bot_token = "";
	protected $__chat_id = "";
	
	
	/**
	 * Telegram send
	 */
	static function sendMessage($telegram, $text)
	{
		if ($telegram->enable == 0) return [$telegram, -1, "Disabled"];
		if ($telegram->bot_token == "") return [$telegram, -1, "bot_token is null"];
		if ($telegram->chat_id == "") return [$telegram, -1, "chat_id is null"];
		
		$url = "https://api.telegram.org/bot" . $telegram->bot_token . 
			"/sendMessage?chat_id=" . $telegram->chat_id;
		$url = $url . "&text=" . urlencode($text);
		
		/* Send message */
		$curl = curl_init();
		$otp = [
			CURLOPT_URL => $url,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_RETURNTRANSFER => true,
		];
		curl_setopt_array($curl, $otp);
		$res = curl_exec($curl);
		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		
		if ($code == 200) return [1, ""];
		return [$telegram, -$code, "Error code " . $code];
	}
	
}
