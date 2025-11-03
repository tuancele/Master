<?php 

$str1 = $_GET["hoten"];
$ten = preg_replace('/\s+/', '', $str1);

$var = 'hoten='.$ten;
$var .= '&isDuong='.$_GET["isDuong"];

$var .= '&isNam='.$_GET["isNam"];

$var .= '&gio='.$_GET["gio"];

$var .= '&ngay='.$_GET["ngay"];

$var .= '&thang='.$_GET["thang"];

$var .= '&nam='.$_GET["nam"];

$var .= '&mau='.$_GET["mau"];

$var .= '&luuthaitue='.$_GET["luuthaitue"];

$var .= '&gioDH='.$_GET["gioDH"];

$var .= '&gioDM='.$_GET["gioDM"];

$var .= '&namHan='.$_GET["namHan"];

$var .= '&anTuHoa='.$_GET["anTuHoa"];



if (isset($_GET['checkDaiVan'])) {
$var .= '&checkDaiVan='.$_GET["checkDaiVan"];
}
if (isset($_GET['check4Hoa'])) {
$var .= '&check4Hoa='.$_GET["check4Hoa"];
}
if (isset($_GET['check4Duc'])) {
$var .= '&check4Duc='.$_GET["check4Duc"];
}
if (isset($_GET['checkLuuKhac'])) {
$var .= '&checkLuuKhac='.$_GET["checkLuuKhac"];
}
if (isset($_GET['checkLocNhap'])) {
$var .= '&checkLocNhap='.$_GET["checkLocNhap"];
}

if (isset($_GET['checkLuuTuanTriet'])) {
$var .= '&checkLuuTuanTriet='.$_GET["checkLuuTuanTriet"];
}





//gettoken($linktoken);
tuvi($var);

function tuvi($var) {
	$linktoken = 'http://www.tuvichanco.com/';
	$token = gettoken($linktoken);
	$link = 'http://www.tuvichanco.com/tuvi_ls/core/core.php?'.$var.'&tokenkey='.$token;
	$nd = grab_link($link);
	echo $nd;
//    echo $token;
}



function gettoken($link) {
	$nd=grab_link($link);
	$text=trim(laynoidung($nd,'g_token_key = "','";'));
	$text = str_replace( 'g_token_key = "', '', $text );
	return $text;
//	return $nd;
}







function userAgent() {
$userAgent =array('Mozilla/5.0 (Linux; U; Android 4.2.2; en-US; iPhone Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.6.2.599 U3/0.8.0 Mobile Safari/534.30');
return $userAgent[0];
}
function grab_link($url,$cookie='PHPSESSID=7ivi011u1srvf08dqpogifo287',$user_agent='',$header='') {
if(function_exists('curl_init')){
$ch = curl_init();
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
$headers[] = 'Accept-Language: en-us,en;q=0.5';
$headers[] = 'Accept-Encoding: gzip,deflate';
$headers[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
$headers[] = 'Keep-Alive: 300';
$headers[] = 'Connection: Keep-Alive';
$headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
curl_setopt($ch, CURLOPT_URL, $url);
if($user_agent)	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
else curl_setopt($ch, CURLOPT_USERAGENT, userAgent());
if($header)
curl_setopt($ch, CURLOPT_HEADER, 1);
else
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com.vn/search?hl=vi&client=firefox-a&rls=org.mozilla:en-US:official&hs=hKS&q=video+clip&start=20&sa=N');
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
if(strncmp($url, 'https', 6)) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
if($cookie)	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
curl_setopt($ch, CURLOPT_TIMEOUT, 100);
$html = curl_exec($ch);
$mess_error = curl_error($ch);
curl_close($ch);
}
else {
$matches = parse_url($url);
$host = $matches['host'];
$link = (isset($matches['path'])?$matches['path']:'/').(isset($matches['query'])?'?'.$matches['query']:'').(isset($matches['fragment'])?'#'.$matches['fragment']:'');
$port = !empty($matches['port']) ? $matches['port'] : 80;
$fp=@fsockopen($host,$port,$errno,$errval,30);
if (!$fp) {
$html = "$errval ($errno)<br />\n";
} else {
$rand_ip = rand(1,254).".".rand(1,254).".".rand(1,254).".".rand(1,254);
$out  = "GET $link HTTP/1.1\r\n".
"Host: $host\r\n".
"Referer: http://www.google.com.vn/search?hl=vi&client=firefox-a&rls=org.mozilla:en-US:official&hs=hKS&q=video+clip&start=20&sa=N\r\n".
"Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5\r\n";
if($cookie) $out .= "Cookie: $cookie\r\n";
if($user_agent) $out .= "User-Agent: ".$user_agent."\r\n";
else $out .= "User-Agent: ".userAgent()."\r\n";
$out .= "X-Forwarded-For: $rand_ip\r\n".
"Via: CB-Prx\r\n".
"Connection: Close\r\n\r\n";
fwrite($fp,$out);
while (!feof($fp)) {
$html .= fgets($fp,4096);
}
fclose($fp);
}
}
return $html;
}

function laynoidung($noidung, $start, $stop) {
$bd = strpos($noidung, $start);
$kt = strpos(substr($noidung, $bd), $stop) + $bd;
$content = substr($noidung, $bd, $kt - $bd);
return $content;
}


