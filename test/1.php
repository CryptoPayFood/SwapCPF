<?php
$requestBody = file_get_contents('php://input');
$request = json_decode($requestBody, true);
function sendMessageMain($getQuery) {
    $ch = curl_init("https://api.telegram.org/bot/sendMessage?" . http_build_query($getQuery));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    curl_close($ch);

    return $res;
echo $res;
echo ok;
}
if ($request['message']) {д
    $message = $request['message']['text'];
    $chat_id = $request['message']['chat']['id'];
	$message1 = $message;
$message = urlencode($message);
    // Замените эту строку на свой ключ API OpenAI
    $openai_api_key = "s";
$message = htmlspecialchars($message, ENT_QUOTES);
    // Формируем запрос к OpenAI
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.openai.com/v1/engines/text-davinci-003/completions",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\"prompt\":\"You: ".$message."\",\"max_tokens\":1000,\"temperature\":0,\"n\":1,\"top_p\":1,\"stream\":false}",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".$openai_api_key,
        "Content-Type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response, true);
    $text = $response['choices'][0]['text'];
	$finish_reason = $response['choices']['finish_reason'];
	$prompt_tokens = $response['usage']['prompt_tokens'];
	$completion_tokens = $response['usage']['completion_tokens'];
	$total_tokens = $response['usage']['total_tokens'];

    // Отправляем сообщение пользователю
 //   $curl = curl_init();
if($text != ""){
$file = __DIR__."/2.txt";
$current = "Message: ".$message1."\nBot response: ".$text."\n\n";
file_put_contents($file, $current, FILE_APPEND | LOCK_EX);

if (strlen($text) > 3000) {
    $text1 = substr($text, 0, 3000);
    $text2 = substr($text, 3000, 3000);
    $text3 = substr($text, 6000, strlen($text));
} else {
		$getQueryStart45 = array(
		'chat_id' => $chat_id,
		'text'	=> "Bot: {$text}\nfinish_reason: {$finish_reason}\nprompt_token: {$prompt_tokens}\ncompletion_tokens: {$completion_tokens}\ntotal_tokens: {$total_tokens}",
		'parse_mode'	=> "html",
    		);
			sendMessageMain($getQueryStart45);

}
if($text1 != ""){
		$getQueryStart45 = array(
		'chat_id' => $chat_id,
		'text'	=> "Bot: {$text1}\nfinish_reason: {$finish_reason}\nprompt_token: {$prompt_tokens}\ncompletion_tokens: {$completion_tokens}\ntotal_tokens: {$total_tokens}",
		'parse_mode'	=> "html",
    		);
			sendMessageMain($getQueryStart45);
}
if($text2 != ""){
		$getQueryStart45 = array(
		'chat_id' => $chat_id,
		'text'	=> "Bot: {$text2}\nprompt_token: {$prompt_tokens}\ncompletion_tokens: {$completion_tokens}\ntotal_tokens: {$total_tokens}",
		'parse_mode'	=> "html",
    		);
			sendMessageMain($getQueryStart45);
}
if($text3 != ""){
		$getQueryStart45 = array(
		'chat_id' => $chat_id,
		'text'	=> "Bot: {$text3}\nprompt_token: {$prompt_tokens}\ncompletion_tokens: {$completion_tokens}\ntotal_tokens: {$total_tokens}",
		'parse_mode'	=> "html",
    		);
			sendMessageMain($getQueryStart45);
}

}
if($text == ""){
$res2 = json_encode($response);
$res1 = implode('; ', $response);
		$getQueryStart45 = array(
		'chat_id' => $chat_id,
		'text'	=> "Bot: бот ответил пустым сообщением\nfinish_reason: {$finish_reason}\nprompt_token: {$prompt_tokens}\ncompletion_tokens: {$completion_tokens}\ntotal_tokens: {$total_tokens} {$res2}\n",
		'parse_mode'	=> "html",
    		);
			sendMessageMain($getQueryStart45);

}
}

echo 'ok';
exit;
?>
