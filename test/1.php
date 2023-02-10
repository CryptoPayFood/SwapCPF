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
$message_history = array();

if (array_key_exists($chat_id, $message_history)) {
    $prev_message = end($message_history[$chat_id]);
    if (count($message_history[$chat_id]) >= 5) {
        array_shift($message_history[$chat_id]);
    }
} else {
    $prev_message = "";
}

if ($request['message']) {
    $message = $request['message']['text'];
    $chat_id = $request['message']['chat']['id'];
	$message1 = $message;
$message = urlencode($message);
    // Замените эту строку на свой ключ API OpenAI
    $openai_api_key = "";
$message = htmlspecialchars($message, ENT_QUOTES);
$history = array();

// Получить историю сообщений для текущего пользователя
if (isset($history[$chat_id])) {
  $prev_messages = $history[$chat_id];
} else {
  $prev_messages = array();
}

// Добавление нового сообщения к истории
array_unshift($prev_messages, $message);
$prev_messages = array_slice($prev_messages, 0, 5);
$history[$chat_id] = $prev_messages;
$history_string1 = "";
// Отправка истории предыдущих сообщений в API
$history_string = implode(", ", $prev_messages);
$post_data = array(
"prompt" => "You: " . $message + "Тут находятся предыдущие сообщения пользователя и openai api используй их для ответов: " . $history_string,
//"context" => "Previous messages: " . $history_string,
"max_tokens" => 1000,
"temperature" => 0.5,
"n" => 1,
"top_p" => 1,
"frequency_penalty" => 0.0,
"presence_penalty" => 0.0,
"stream" => false,
"user" => "$chat_id"
);
$post_data = json_encode($post_data);


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
      CURLOPT_POSTFIELDS => $post_data,
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
	$text = rawurldecode($text);
    // Отправляем сообщение пользователю
if($text != ""){
$file = __DIR__."/2.txt";
$current = "Message: ".$message1."\nPrevious messages: ".$history_string."\nBot response: ".$text."\n\n";
file_put_contents($file, $current, FILE_APPEND | LOCK_EX);

if (strlen($text) > 3000) {
    $text1 = substr($text, 0, 3000);

    $text2 = substr($text, 3000, 3000);

    $text3 = substr($text, 6000, strlen($text));

} else {
		$getQueryStart45 = array(
		'chat_id' => $chat_id,
		'text'	=> "Bot:{$text}\nfinish_reason: {$finish_reason}\nprompt_token: {$prompt_tokens}\ncompletion_tokens: {$completion_tokens}\ntotal_tokens: {$total_tokens}",
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
