import telebot
import openai

# Устанавливаем секретный ключ API
openai.api_key = ""
#
# Создаем экземпляр бота с указанием токена доступа
bot = telebot.TeleBot("")

# Определяем функцию, которая будет вызываться при получении сообщения
@bot.message_handler(content_types=["text"])
def respond_to_message(message):
    # Запрашиваем ответ от API OpenAI
    response = openai.Completion.create(
        engine="text-davinci-003",
        prompt="You: " + message.text,
        max_tokens=4000,
        n=1,
        stop=None,
        temperature=0.5,
    )

    # Отправляем ответ в Telegram
    bot.send_message(
        chat_id=message.chat.id,
        text="Bot: " + response.choices[0].text
    )

# Запускаем бесконечный цикл прослушивания
bot.polling(none_stop=True)
