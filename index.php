<?php
$pid = $_GET["pid"];
//获取想要搜寻的pid，只允许存在全整数型pid，如果有 _p0 等，需要去掉，否则程序错误。
$om = $_GET["master"];
//传入是否使用master1200的缩略图，加快访问速度（降低带宽开销）。


if($pid == ""){
    echo "<!DOCTYPE html><meta name=\"viewport\" content=\"width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no\"/><html><head><title>Pixiv Img Download Tool</title></head><body>";
    echo "<h3>from: <a href=\"https://github.com/Artificialheaven/pixiv_pid.git\">pixiv_pid.git</a> ( by <a href=\"https://github.com/Artificialheaven/\">Artificialheaven</a>  )</h3><h1>pixiv_pid</h1><p>Use php to implement get pid to get pixiv images.</p><h1>Get started</h1><p>Visit http(s)://[your URL]/index.php?master=0&amp;pid=[your PID] to get the original image. (If you modify the Master entry to 1, you can get some degree of thumbnail for higher speeds. )</p><h1>Disposition</h1><p>PHP 56 or above is required. Deploy index.php on your web server and access it directly.</p><h1>Test</h1><p><a href=\"index.php?master=0&pid=97102324\">pid=97102324&master=0</a></p><p><a href=\"index.php?master=1&pid=97102324&master=1\">pid=97102324&master=1</a></p></br></br><h2><a href=\"LICENSE.txt\">LICENSE &nbsp;&nbsp;|&nbsp;&nbsp; GUN GPL v2</a></h2></body></html>";
	//没有获取到pid。
    exit;
};


$pixiv = file_get_contents("https://www.pixiv.net/artworks/".$pid);
//获取全部页面数据


if ($om == 1){
// regular
$url = getSubstr($pixiv,"regular\":\"","\",\"");
}   else   {
$url = getSubstr($pixiv,"original\":\"","\"},");
//original
};

    $ch = curl_init();//curl初始化
	curl_setopt($ch,CURLOPT_URL, $url);//置访问地址
	curl_setopt($ch,CURLOPT_REFERER,"http://www.pixiv.net/"); //置referer ， 破解防盗链
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	$res = curl_exec($ch);//获取图片数据
	header("Content-Type: ".curl_getinfo($ch, CURLINFO_CONTENT_TYPE));//获取图片类型，添加header头文件告诉浏览器这是个什么文件
	echo($res);//输出图片
	curl_close($ch);//释放curl
	exit; //退出，实际上无意义。

function getSubstr($str, $leftStr, $rightStr)
{
    $left = strpos($str, $leftStr);
    $right = strpos($str, $rightStr,$left);
    if($left < 0 or $right < $left){
         return "";
    };
    return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
};

?>
