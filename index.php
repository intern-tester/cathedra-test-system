<?php 
$namesite = getenv('copyright');
$token = getenv('API');
$bot_url = "https://api.telegram.org/bot" . $token;

$result = json_decode(file_get_contents('php://input'), true);

$bot = new BOT();

if ($result['message']['text'] == '/start') {
    file_get_contents("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $result['message']['chat']['id'] . "&text=" . urlencode('Welcom on ONSET'));
}elseif ($result['message']['text'] == '/info') {
    file_get_contents("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $result['message']['chat']['id'] . "&text=" . urlencode('Даний Бот розроблено для скринінгових опитувань. Коли Ви починаєте проходити опитування Ви погоджуєтесь зі правилами надання персональної інформації. '));
}elseif ($result['message']['text'] == '/url') {
    file_get_contents("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $result['message']['chat']['id'] . "&text=" . urlencode('https://nuozu.edu.ua/zagruzka2/14_02_22-11.doc'));
}elseif ($result['message']['text'] == '/img') {
    sendPhoto($result['message']['chat']['id'], 'https://www.nuozu.edu.ua/images/Onas/Pidrozdil/burlakova.jpg');
}elseif ($result['message']['text'] == '/doc') {
    sendDocument($result['message']['chat']['id'], 'https://www.nuozu.edu.ua/images/Onas/Pidrozdil/burlakova.jpg');
}elseif ($result['message']['text'] == '/msg') {
    sendMessage($result['message']['chat']['id'], "Hello World!");
}elseif ($result['message']['text'] == '/message') {
    $bot->sendMessage($result['message']['chat']['id'], "Привет");
}

elseif ($result['message']['text'] == '/debug') {
    //file_put_contents('dump.txt', var_dump($result['message']));
    //sendDocument($result['message']['chat']['id'], 'dump.txt');
    //unlink('dump.txt');
}

//// Show Home Page Site. 
else{
  $content = '<h1>Cathedra</h1>
<div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
      <p>© 2022 '.$namesite.', Inc. All rights reserved.</p>
      <ul class="list-unstyled d-flex"></ul>
    </div>
';
  
  print boostrap($content, 'Home page');
}

function boostrap($content, $title = "Page"){
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


//Base Bot Functions



// Send Image File 
    // img, jpg, png. 
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

// Send Document File
    // doc, docx, txt, json, md5, sql 
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





// TESTED SendMessage

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


//print 'Test Cathedra VAR % ' . $namesite; curl -F document=@"path/to/some.file" https://api.telegram.org/bot<token>/sendDocument?chat_id=<chat_id>

/*

$keyboard = [
    ['7', '8', '9'],
    ['4', '5', '6'],
    ['1', '2', '3'],
         ['0']
];

*/

class BOT {
    
    //private $bot_url = "https://api.telegram.org/bot".getenv('API');

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
}







?>
