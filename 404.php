<?php
if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){
$refuri = parse_url($_SERVER['HTTP_REFERER']); // use the parse_url() function to create an array containing information about the domain
if($refuri['host'] == "your-domain.com"){

//the link was on your site
}
else{
//the link was on another site. $refuri['host'] will return what that site is
}
}
else{
//the visitor typed gibberish into the address bar
}
?>