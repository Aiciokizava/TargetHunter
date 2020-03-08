<?php
// Insert token
$token = "...";
$output = fopen(__DIR__."/output", 'w+');
$user_id = htmlentities(file_get_contents(__DIR__."/input"));
$i = 0;

$info_get_friends_json = json_decode(file_get_contents("https://api.vk.com/method/friends.get?user_id=$user_id&access_token=$token&v=5.103"));
$write = $info_get_friends_json->response->items[$i];
while ($info_get_friends_json->response->items[$i])
{
    ++$i;
    $write = $write . ", " . $info_get_friends_json->response->items[$i];
}

$i = 0;
$info_get_followers_json = json_decode(file_get_contents("https://api.vk.com/method/users.getFollowers?user_id=$user_id&access_token=$token&v=5.103"));
$write = $write . " " . $info_get_followers_json->response->items[$i];
while ($info_get_followers_json->response->items[$i])
{
    ++$i;
    if($info_get_followers_json->response->items[$i])
    {
        $write = $write . ", " . $info_get_followers_json->response->items[$i];
    }
    else
    {
        $write = $write . " " . $info_get_followers_json->response->items[$i];
    }
}

fwrite($output, $write);
fclose($output);