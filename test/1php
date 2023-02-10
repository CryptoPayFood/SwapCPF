<?php
$requestBody = file_get_contents('php://input');
$request = json_decode($requestBody, true);

if ($request['message']) {
    $message = $request['message']['text'];
    $chat_id = $request['message']['chat']['id'];

    // Замените эту строку на свой ключ API OpenAI
    $openai_api_key = "";

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
      CURLOPT_POSTFIELDS => "{\"prompt\":\"You: ".$message."\",\"max_tokens\":1024,\"temperature\":0.5}",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".$openai_api_key,
        "Content-Type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response, true);
    $response = $response['choices'][0]['text'];

    // Отправляем сообщение пользователю
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.telegram.org/botI/sendMessage",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "chat_id=".$chat_id."&text=ChatGPT: ".$response,
    CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded"
    ),
  ));
$response = curl_exec($curl);
curl_close($curl);
}

echo 'ok';
exit;
?>
