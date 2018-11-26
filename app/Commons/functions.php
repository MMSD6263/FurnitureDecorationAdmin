<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2017/5/25 0025
 * Time: 下午 9:20
 */

function curl_get($url)
{
    //初始化curl
    $ch = curl_init();
    //设置curl选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    //执行
    $output = curl_exec($ch);
    //关闭
    curl_close($ch);
    return $output;
}

function http_request($url, $data = null)
{

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

function message($success = '', $message = '')
{
    return json_encode(['success' => $success, 'message' => $message]);
}

function aa($request)
{
    echo '<pre/>';
    print_r($request);
    die();
}

function getTime()
{
    echo date('Y-m-d', strtotime('today'));
}

//最近7天
function getRecentSevenDays()
{
    $time = strtotime('today') - 7 * 86400;
    echo date('Y-m-d', $time);
}

//最近30天
function getRecentThirtyDays()
{
    $time = strtotime('today') - 30 * 86400;
    echo date('Y-m-d', $time);
}

//当月
function getCurrentMonth()
{
    $date = date('Y-m-01', strtotime(date("Y-m-d")));
    echo $date;
}

//上月
function getLastMonth()
{
    $start = date('Y-m-01', strtotime('-1 month'));
    $end   = date('Y-m-t', strtotime('-1 month'));
    $res   = array($start, $end);
    return ($res);
}


function mkdirs($dir, $mode = 0777)
{
    if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
    if (!mkdirs(dirname($dir), $mode)) return FALSE;
    return @mkdir($dir, $mode);
}

//获取用户信息
function getUserInfo()
{
    $username = session('admin.username');
    $uid      = session('admin.id');

    return [
        'uid'      => $uid,
        'username' => $username,
    ];
}


function generate_rand_char($length = 8)
{
// 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str   = '';
    for ($i = 0; $i < $length; $i++) {

        $str .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $str;
}


function getPermission()
{
    $permission = config('power.powers');
    return $permission;
}

function mSecTime()
{
    return intval(microtime(true) * 1000);
}

function getLogger()
{
    return session('admin');
}


//过滤特殊字符
function replaceSpecialChar($strParam)
{
    $regex = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\s|\.|\/|\;|\'|\`|\=|\\\|\|/";
    return preg_replace($regex, "", $strParam);
}


function super_authority()
{
    if (session('admin.rid') == 1) {
        return 1;
    } else {
        return 0;
    }
}


function msctime() {
    list($msec, $sec) = explode(' ', microtime());
    $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return $msectime;
}


