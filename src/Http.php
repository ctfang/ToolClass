<?php
namespace ToolClass;

/**
* HTTP 工具
*/
class Http
{
    /**
     * 当前完整url
     * @return string
     */
    static public function url(){
        $pageURL = 'http';

        if ($_SERVER["HTTPS"] == "on"){
            $pageURL .= "s";
        }
        $pageURL .= "://";

        if ($_SERVER["SERVER_PORT"] != "80"){
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        }else{
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
    static public function toParam($array){
        foreach ($array as $key=>$value){
            $arr[] = $key.'='.$value;
        }
        return implode('&',$arr);
    }
    /**
     * 发送post请求
     * @param  string $url  请求地址
     * @param  array $data  发送数据
     * @return string       
     */
    static public function post($url,$data)
    {
        $header [] = "content-type: application/x-www-form-urlencoded; charset=UTF-8";
        if(is_array($data)) $data = http_build_query($data);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        $res = curl_exec ( $ch );
        curl_close ( $ch );
        return $res;
    }
   /**
    * 模拟post请求
    * @access public
    * @param string $url 远程URL
    * @param array $conf 其他配置信息
    *        int   limit 分段读取字符个数
    *        string post  post的内容,字符串或数组,key=value&形式
    *        string cookie 携带cookie访问,该参数是cookie内容
    *        string ip    如果该参数传入,$url将不被使用,ip访问优先
    *        int    timeout 采集超时时间
    *        bool   0 只请求 1 返回状态吗 2 返回http数据
    * @return mixed
    */
    public function fsockurl($strUrl,$conf )
    {
        session_write_close();// 文件锁
        $url        = parse_url( $strUrl );
        $conf_arr = array(
            'limit'     =>  0,
            'post'      =>  '',
            'cookie'    =>  session_id(),
            'ip'        =>  '',
            'timeout'   =>  80,
            'block'     =>  0,
            );
        extract( array_merge($conf_arr, $conf) );
        if( is_array($post) ){
            $post = http_build_query($post);
        }
        $fp     = fsockopen($url['host'], 80, $errno, $errstr, $timeout);
        if (!$fp) die( "打开fsockopen失败".$errno.$errstr );
        fputs($fp, sprintf("POST %s%s%s HTTP/1.0\n", $url['path'], "",""));
        fputs($fp, "Host: $url[host]\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
        fputs($fp, 'Cookie:'.session_name().'='.$cookie. "\n");
        fputs($fp, "Content-length: " . strlen($post) . "\n");
        fputs($fp, "Connection: close\n\n");   
        fputs($fp, "{$post}\n");
        fclose($fp);
    }
    /**
     * 显示HTTP Header 信息
     * @return string
     */
    static function getHeaderInfo($header='',$echo=true) 
    {
        ob_start();
        $headers    = getallheaders();
        if(!empty($header)) {
            $info   = $headers[$header];
            echo($header.':'.$info."\n"); ;
        }else {
            foreach($headers as $key=>$val) {
                echo("$key:$val\n");
            }
        }
        $output     = ob_get_clean();
        if ($echo) {
            echo (nl2br($output));
        }else {
            return $output;
        }

    }

    /**
     * HTTP Protocol defined status codes
     * @param int $num
     */
    static function sendHttpStatus($code) 
    {
        static $_status = array(
            // Informational 1xx
            100 => 'Continue',
            101 => 'Switching Protocols',

            // Success 2xx
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',

            // Redirection 3xx
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',  // 1.1
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            // 306 is deprecated but reserved
            307 => 'Temporary Redirect',

            // Client Error 4xx
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',

            // Server Error 5xx
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            509 => 'Bandwidth Limit Exceeded'
        );
        if(isset($_status[$code])) {
            header('HTTP/1.1 '.$code.' '.$_status[$code]);
        }
    }
}