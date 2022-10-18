# Telegram Bot Class
Simple Class to crete Telegram chat bot.  

This class include simples for fast start work with Telegram Bot.
All function tested on Heroku WebApp. 

- PHP Class 
- Bootsrap Included
- Telegram API
- Heroku WebApp

### Heroku deploy
<a href="https://heroku.com/deploy?template=https://github.com/intern-tester/cathedra-test-system/main">
  <img src="https://www.herokucdn.com/deploy/button.svg" alt="Deploy">
</a>


## Features

- Create simple chat bot. 
- Tested on Heroku WebApp
- Include function to work with Inline keyboard
- Bootstrap cdn (web page)

This class cretaed to simple work for personal usege. 
Created by [Bohdan Pukhovskyi](https://www.facebook.com/bohdan.pukhovskyi).

## Tech
Class uses a number of open source projects:
- [TelegramAPI] - a powerful, feature-packed frontend toolkit.
- [BootrapCDN](https://getbootstrap.com) - a powerful, feature-packed frontend toolkit.
- [jQuery](https://jquery.com) - is a fast, small, and feature-rich JavaScript library. 

And of course Telegram Bot Class created for itself, is open source with a [public repository][gitproject] 
on GitHub.

## Installation
Telegram requires [PHP](https://www.php.net) v7.0+ to run.
> Note: `PHP` is required on Heroku WebApp. You don`t need to install it. 

If you use Heroku WebApp: Set in Heroku settings `ConfigVars`: 
`API` : `1234:000000` - Telegram bot token.
> Note: `API` is need to set on Heroku WebApp Settings. It needed to create Webhook for properly work bot. To get this Token, you need to go on `@BotFather` and select `API Token`.

## Usage
To preperly work bot, need to get _$token_ from _Heroku ConfigVars_:
```php
index.php
$token = getenv('API');
```

Then we gen _handler_ for answer from _telegram_. And then create _Bot_ class object.
```php
index.php
$result = json_decode(file_get_contents('php://input'), true);
$bot = new BOT();
```

To send message to user:
```php
$bot->sendMessage($result['message']['chat']['id'], "Welcome!");
```
> Note: function sendMessage($chat_id, $message);



## License

MIT

**Opensources software.**

[gitproject]: <https://github.com/intern-tester/cathedra-test-system>
[git-repo-url]: <https://github.com/intern-tester/cathedra-test-system.git>
[TelegramAPI]: <https://github.com/intern-tester/cathedra-test-system.git>
