<?php
/*
 * Subtitle Translator
 * Translate English subtitle to Farsi ( using targoman.ir )
 * https://github.com/itstaha/Subtitle-Translator/
*/

class subtitle {
	public function load($input) {
		$input = file_get_contents($input);
		$explode = explode("\n",$input);
		$pregmatch = preg_grep('/^(?!\d)/',$explode);
		array_shift($pregmatch);
		$array_count = count($pregmatch);
		$list = [];
		$counter = 1;
		foreach($pregmatch as $item) {
			if(strlen($item) > 1) {
				if(array_key_exists($counter,$list)) {
					$item = str_replace("\r","",$item);
					array_push($list[$counter],$item);
				}
				else {
					$item = str_replace("\r","",$item);
					$list[$counter] = [$item];
				}
			}
			else { $counter++; }
		}
		return $list;
		fclose($file);
	}
	private function request($string) {
		$string = strtolower($string);
		$ch = curl_init('https://targoman.ir/API/');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{"jsonrpc":"2.0","method":"Targoman::translate","id":1,"params":["sSTargomanWUI","'.$string.'","en2fa","127.0.0.10","NMT",true,true,true]}');
		$response = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response, true);
		if (isset($response['result']['tr']['base'][0][1])) {
			return $response['result']['tr']['base'][0][1];
		}
		else { return "something went wrong !"; }
	}
	public function translate($list) {
		$translate = [];
		foreach($list as $item) {
			foreach($item as $string) {
				$req = $this->request($string);
				$translate[$string] = $req;
			}
		}
		return $translate;
	}
}
