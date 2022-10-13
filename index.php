<?php 
// Work with Heroku Config Vars
$namesite = getenv('copyright');
$token = getenv('API');
$bot_url = "https://api.telegram.org/bot" . $token;

$result = json_decode(file_get_contents('php://input'), true);

// GET CALLBACK
// $data['callback_query']


// CALLBACK QUERY HANDLER
if (isset($result['callback_query'])) {
        // Reply with callback_query data
        $answer = $result['callback_query']['data'];
        $chat_id = $result['callback_query']['from']['id'];
        
        
        if($answer == "data-access"){
                $bot->sendMessage($chat_id, "Вітаю Ви надали згоду на обробку інформації. ");
        }elseif($answer == "cancel"){
                $bot->sendMessage($chat_id, "Нажаль Ви не надали згоду на обробку персональної інформації");
        }
        
        
        
        //$data = http_build_query([
        //    'text' => 'Selected language: ' . $result['callback_query']['data'],
        //    'chat_id' => $result['callback_query']['from']['id']
        //]);
        //sms($data);
        // Simple send Message
        //file_get_contents($bot_url . "/sendMessage?{$data}");
}

//$client = $result['callback_query']['from']['id'];
//$callback_query = $result['callback_query']['id'];
//$callback_data = $callback_query['data'];

// Initialisation Bot
$bot = new BOT();

if ($result['message']['text'] == '/start') {
    $bot->sendMessage($result['message']['chat']['id'], "Добро пожаловать!");
}elseif ($result['message']['text'] == '/info') {
    $bot->sendMessage($result['message']['chat']['id'], 'Даний Бот розроблено для скринінгових опитувань. Коли Ви починаєте проходити опитування Ви погоджуєтесь зі правилами надання персональної інформації.');
}elseif ($result['message']['text'] == '/chat') {
    // NEW INLINE MESSAGE    
    $bot->sendMessage($result['message']['chat']['id'], "Ви вибрали пункт Чат.");
    $bot->sendInL($result['message']['chat']['id'], "Ви надаєте згоду на обробку ПД?");    
    //$bot->sendInline($result['message']['chat']['id'], "Ви погоджуєтесь надати згоду на обробку персональних даних?");
    //$bot->sendMessage($result['message']['chat']['id'], 'Даний Бот розроблено для скринінгових опитувань. Коли Ви починаєте проходити опитування Ви погоджуєтесь зі правилами надання персональної інформації.');
}elseif ($result['message']['text'] == '/img') {
    //$img = 'https://picsum.photos/200/300?random='.mt_rand(1, 5);
    $bot->sendPhoto($result['message']['chat']['id'], 'https://nuozu.edu.ua/images/Onas/Pidrozdil/burlakova.jpg');
}elseif ($result['message']['text'] == '/doc') {
    $bot->sendDocument($result['message']['chat']['id'], 'https://nuozu.edu.ua/images/Onas/Pidrozdil/burlakova.jpg');
}elseif ($result['message']['text'] == '/msg') {
    $bot->sendMessage($result['message']['chat']['id'], "Hello World!");
}elseif ($result['message']['text'] == '/message') {
    $keyboard = [
        ['7', '8', '9'],
        ['4', '5', '6'],
        ['1', '2', '3']
       ];
    $bot->sendMessage($result['message']['chat']['id'], "Выберите чысло от 0 до 9?", $keyboard);
}elseif ($result['message']['text'] == '/qwery') {
    
    //$bot->sendMessage($result['message']['chat']['id'], "Выберите чысло от 0 до 9?", $keyboard);
    //$bot->sendMessage($result['message']['chat']['id'], "Новая клавиатура.", $keyboard);    
    $keyboard = [
        ['Yes', 'No']
       ];
    $bot->sendNewButton($result['message']['chat']['id'], "Новая клавиатура.", $keyboard);
        
        
}

elseif ($result['message']['text'] == '/debug') {
    //file_put_contents('dump.txt', var_dump($result['message']));
    //sendDocument($result['message']['chat']['id'], 'dump.txt');
    //unlink('dump.txt');
}

//// Show Home Page Site. 
else{
  $content = '<h1>BOT SYSTEM v.0.1 alfa</h1>
<div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
      <p>© 2022 '.$namesite.', Inc. All rights reserved.</p>
      <ul class="list-unstyled d-flex"></ul>
    </div>
';
  
  print $bot->boostrap($content, 'Home page');
}


/*


$options[][] = array('text' => 'Your text', 'callback_data' => 'test-data');
$replyMarkup = array('inline_keyboard' => $options);
$encodedMarkup = json_encode($replyMarkup, true);



// Create keyboard
        $data = http_build_query([
            'text' => 'Please select language;',
            'chat_id' => $update['message']['from']['id']
        ]);
        $keyboard = json_encode([
            "inline_keyboard" => [
                [
                    [
                        "text" => "english",
                        "callback_data" => "english"
                    ],
                    [
                        "text" => "russian",
                        "callback_data" => "russian"
                    ]
                ]
            ]
        ]);

        // Send keyboard
        file_get_contents($botAPI . "/sendMessage?{$data}&reply_markup={$keyboard}");

$keyboard = [
    ['7', '8', '9'],
    ['4', '5', '6'],
    ['1', '2', '3'],
         ['0']
];

$keyboard = array(
  "inline_keyboard" => array( 
    array(
      array( 
        "text" => "Button1", 
        "callback_data" => "1", 
      ), 
      array( 
        "text" => "Button2", 
        "callback_data" => "2", 
      ), 
    )
  ) 
);

*/

class BOT {
    
    //private $bot_url = "https://api.telegram.org/bot".getenv('API');
        
    function sms($data){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        file_get_contents($bot_url . "/sendMessage?{$data}");
    }    

    function sendMessage($chat_id, $msg, $keyboard = array()){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ;

        $replyMarkup = array(
            'keyboard' => $keyboard
        );
        
        $encodedMarkup = json_encode($replyMarkup);    

        $post_fields = array(
            'chat_id'   => $chat_id,
            'resize_keyboard' => true, 
            'reply_markup' => $encodedMarkup,
            'text'     => $msg 
        ); 

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
        $output = curl_exec($ch);
    }
        
    function sendInL($chat_id, $msg){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ;
            
        $keyboard = [
            "inline_keyboard" => [
                [
                    [
                        "text" => "Так",
                        "callback_data" => "access"
                    ],
                    [
                        "text" => "Ні",
                        "callback_data" => "cancel"
                    ]
                ]
            ]
        ];
            
       

        $replyMarkup = array(
            'keyboard' => $keyboard
        );
        
        $encodedMarkup = json_encode($replyMarkup);    

        $post_fields = array(
            'chat_id'   => $chat_id,
            'resize_keyboard' => true, 
            'reply_markup' => $encodedMarkup,
            'text'     => $msg 
        ); 

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
        $output = curl_exec($ch);    

        // Send keyboard
        //file_get_contents($botAPI . "/sendMessage?{$data}&reply_markup={$keyboard}");
    }    
        
    function sendInline($chat_id, $msg = ""){
    $data = http_build_query([
            'text' => $msg,
            'chat_id' => $chat_id
        ]);
        $keyboard = json_encode([
            "inline_keyboard" => [
                [
                    [ "text" => "Так","callback_data" => "access" ],
                    [ "text" => "Ні", "callback_data" => "cancel" ]
                ]
            ]
        ]);
                

        // Send keyboard
        file_get_contents($botAPI . "/sendMessage?{$data}&reply_markup={$keyboard}");
    }    
        
    function sendNewButton($chat_id, $msg, $keyboard = array()){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ;
            
        

        $replyMarkup = array(
            'keyboard' => $keyboard
        );
        
        $encodedMarkup = json_encode($replyMarkup);    
            
        
        //////////////////////////
        $options[][] = array('text' => 'Так', 'callback_data' => 'data-access');
        $replyMarkup = array('inline_keyboard' => $options);
        $encodedMarkup = json_encode($replyMarkup, true);    
        /////////////////////////    
            
            

        $post_fields = array(
            'chat_id'   => $chat_id,
            //'resize_keyboard' => true, 
            'reply_markup' => $encodedMarkup,
            'text'     => $msg 
        ); 

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
        $output = curl_exec($ch);
    }   
    
    function sendCallbackQuery($chat_id, $reply, $keyboard = array()){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ;
        
        $keyboard = array(
          "inline_keyboard" => array( // inline_keyboard not keyboard
            array(
              array( 
                "text" => "Button1", 
                "callback_data" => "1", 
              ), 
              array( 
                "text" => "Button2", 
                "callback_data" => "2", 
              ), 
            )
          ) //Removed onetimekeyboard etc.
        );
        
        $postfields = array( 
          'chat_id' => $chat_id,
          'text' => $reply, 
          'reply_markup' => json_encode($keyboard) 
        );

        $replyMarkup = array(
            'keyboard' => $keyboard
        );
        
        $encodedMarkup = json_encode($replyMarkup);    

        $post_fields = array(
            'chat_id'   => $chat_id,
            //'resize_keyboard' => true, 
            'reply_markup' => $encodedMarkup,
            'text'     => $msg 
        ); 

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
        $output = curl_exec($ch);
    }
    
    function sendDocument($chat_id, $doc){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendDocument?chat_id=" . $chat_id ;

        $post_fields = array('chat_id'   => $chat_id,
            'document'     => new CURLFile($doc) 
        ); 
        // realpath("/path/to/image.png")
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
        $output = curl_exec($ch);
    }
    
    function sendPhoto($chat_id, $photo){
        $bot_url    = "https://api.telegram.org/bot".getenv('API');
        $url        = $bot_url . "/sendPhoto?chat_id=" . $chat_id ;

        $post_fields = array('chat_id'   => $chat_id,
            'photo'     => new CURLFile($photo) 
        ); 
        // realpath("/path/to/image.png")
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
        $output = curl_exec($ch);
    }
    
    function boostrap($content, $title = "Home"){
    return '
        <!doctype html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>'.$title.'</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
          </head>
          <body>
            '.$content.'
          </body>
        </html>
    ';
}
}

/*
// Worked sendMessage with keyboard
function sendMessage($chat_id, $msg){
$bot_url    = "https://api.telegram.org/bot".getenv('API');
$url        = $bot_url . "/sendMessage?chat_id=" . $chat_id ;
    
$replyMarkup = array(
    'keyboard' => array(
        array("A", "B")
    )
);
$encodedMarkup = json_encode($replyMarkup);    

$post_fields = array(
    'chat_id'   => $chat_id,
    'reply_markup' => $encodedMarkup,
    'text'     => $msg 
); 
    
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type:multipart/form-data"
));
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
$output = curl_exec($ch);
}


*/



// Simple Send Messsage file_get_contents("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $result['message']['chat']['id'] . "&text=" . urlencode('Welcom on ONSET'));
// //file_get_contents("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $result['message']['chat']['id'] . "&text=" . urlencode('Даний Бот розроблено для скринінгових опитувань. Коли Ви починаєте проходити опитування Ви погоджуєтесь зі правилами надання персональної інформації. '));
?>
