<?php

///////////////////////////
// WHICH TEMPLATE TO USE //
///////////////////////////

//Template 1 = Standard Template
//Template 2 = Inteli-Login Template
// Templates can also be edited to change the look and feel

$template = 1;



//////////////////////////
///YOUR EMAIL SETTINGS //
//////////////////////////

$html_format = "no";                                         //Change this to "yes" if you are sending html format email

$subject = "Join me at this amazing site!";                  // Subect of the emails sent out

$from = "sales@getmycontacts.com";                           //This is your email address

$redirect = "http://www.getmycontacts.com/thankyou.html";    //change this to your own thank you type page



///////////////////////////
// EMAIL MESSAGE TO SEND //
///////////////////////////

//IMPORTANT -- DO NOT DELETE  <<<EOF  and EOF;

$message = <<<EOF


Hi $name

Come and join me at this great site that I found

www.getmycontacts.com (This is just an example email)

From ($sendersemail)



EOF;



///////////////////////
//FOR GODADDY.COM USERS
///////////////////////
$hosted_by_godaddy  = 'no';  //change this to 'yes' if you web host is Godaddy.com













/// ******************************************************* DO NOT  EDIT BELOW THIS LINE********************************************** \\

//template loader//
if($template ==1){
$template_selected = 'template.html';	
	}
if($template ==2){
$template_selected = 'template2.html';		
	}
if($template ==3){
$template_selected = 'template3.html';		
	}


		
function curl_get($url,$follow, $debug){
global $path_to_cookie, $browser_agent;
$ch=curl_init();
if ($hosted_by_godaddy =='yes'){
curl_setopt ($ch, CURLOPT_PROXYTYPE,CURLPROXY_HTTP);
curl_setopt ($ch, CURLOPT_PROXY,"http://proxy.shr.secureserver.net:3128");
}
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);              
curl_setopt($ch,CURLOPT_COOKIEJAR,$path_to_cookie);
curl_setopt($ch,CURLOPT_COOKIEFILE,$path_to_cookie);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,$follow);
curl_setopt($ch,CURLOPT_USERAGENT, $browser_agent);
$result=curl_exec($ch);
curl_close($ch);

if($debug==1){
echo "<textarea rows=30 cols=120>".$result."</textarea>";       
}
if($debug==2){
echo "<textarea rows=30 cols=120>".$result."</textarea>";       
echo $result;
}
return $result;
}

function curl_post($url,$postal_data,$follow, $debug){
global $path_to_cookie, $browser_agent;
$ch=curl_init();
if ($hosted_by_godaddy =='yes'){
curl_setopt ($ch, CURLOPT_PROXYTYPE,CURLPROXY_HTTP);
curl_setopt ($ch, CURLOPT_PROXY,"http://proxy.shr.secureserver.net:3128");
}
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS,$postal_data);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);              
curl_setopt($ch,CURLOPT_COOKIEJAR,$path_to_cookie);
curl_setopt($ch,CURLOPT_COOKIEFILE,$path_to_cookie);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,$follow);
curl_setopt($ch,CURLOPT_USERAGENT, $browser_agent);
$result=curl_exec($ch);
curl_close($ch);

if($debug==1){
echo "<textarea rows=30 cols=120>".$result."</textarea>";       
}
if($debug==2){
echo "<textarea rows=30 cols=120>".$result."</textarea>";       
echo $result;
}
return $result;
}


$footer = 
'<table border="0" width="12%">
		<tr>
			<td bgcolor="#CCCCCC" width="61">
			<font face="Arial" size="1" color="#333333">Powered 
			by</font></td>
			<td bgcolor="#EBEBEB"><font face="Arial" size="1">
			<a href="http://www.getmycontacts.com/"><font color="#333333">GetmyContacts</font></a></font></td>
		</tr>
</table>';


$username = $_POST["username"];

$password = $_POST["password"];

$sendersemail = $username;
?>