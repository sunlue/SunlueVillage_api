<?php

namespace app\village_api\controller\plugin\access;

use app\village_api\common\controller\eVillageApi;
use think\facade\Db;
use think\facade\Request;

class Index extends eVillageApi {

    public function initialize() {
        parent::_init();
    }

    public function index() {
        $cookie = cookie('SunlueAccessTotal');
        if (!$cookie) {
            $cookie = cookie('SunlueAccessTotal', time() . rand(1000, 9999));
        }
        $host = "";
        $referer = "";
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
            if (!empty($referer)) {
                $domain = parse_url($referer);
                $host = $domain['host'];
            }
        }
        $engine = $this->getAccessFrom();
        $array = array(
            'uniqid' => uniqid('access_'),
            'type' => !is_mobile() ? 'pc' : 'wap',
            'ip' => $this->getAccessIp(),
            'referer' => !empty($referer) ? $referer : '',
            'domain' => !empty($referer) ? $host : '',
            'date' => date('Y-m-d', time()),
            'time' => date('H:i:s', time()),
            'cookie' => $cookie,
            'engine' => $engine['engine'],
            'keyword' => $engine['keyword']
        );
        Db::name('plugin_access')->insert($array);
    }

    protected function getAccessIp($ip = false) {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++) {
                if (!eregi("^(10│172.16│192.168).", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

    protected function getAccessFrom() {
        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';//获取入站url。
        $search_1 = "google.com"; //q= utf8
        $search_2 = "baidu.com"; //wd= gbk
        $search_3 = "yahoo.cn"; //q= utf8
        $search_4 = "sogou.com"; //query= gbk
        $search_5 = "soso.com"; //w= gbk
        $search_6 = "bing.com"; //q= utf8
        $search_7 = "youdao.com"; //q= utf8

        $google = preg_match("/\b{$search_1}\b/", $url);//记录匹配情况，用于入站判断。
        $baidu = preg_match("/\b{$search_2}\b/", $url);
        $yahoo = preg_match("/\b{$search_3}\b/", $url);
        $sogou = preg_match("/\b{$search_4}\b/", $url);
        $soso = preg_match("/\b{$search_5}\b/", $url);
        $bing = preg_match("/\b{$search_6}\b/", $url);
        $youdao = preg_match("/\b{$search_7}\b/", $url);

        //获取没参数域名
        $domain = parse_url($url);
        $burl = empty($domain['host'])?'':$domain['host'];
        //匹配域名设置
        $curl = parse_url(Request::domain());
        $engine = '';
        $keyword = '';
        if ($burl != $curl['host']) {
            if ($google) {//来自google
                $keyword = $this->getAccessKeyword($url, 'q=');//关键词前的字符为"q="。
                $keyword = urldecode($keyword);
                $engine = "谷歌";
            } else if ($baidu) {//来自百度
                $keyword = $this->getAccessKeyword($url, 'wd=');//关键词前的字符为"wd="。
                $keyword = urldecode($keyword);
                $engine = "百度";
            } else if ($yahoo) {//来自雅虎
                $keyword = $this->getAccessKeyword($url, 'q=');//关键词前的字符为"q="。
                $keyword = urldecode($keyword);
                $engine = "雅虎";
            } else if ($sogou) {//来自搜狗
                $keyword = $this->getAccessKeyword($url, 'query=');//关键词前的字符为"query="。
                $keyword = urldecode($keyword);
                $keyword = iconv("GBK", "UTF-8", $keyword);//引擎为gbk
                $engine = "搜狗";
            } else if ($soso) {//来自搜搜
                $keyword = $this->getAccessKeyword($url, 'w=');//关键词前的字符为"w="。
                $keyword = urldecode($keyword);
                $keyword = iconv("GBK", "UTF-8", $keyword);//引擎为gbk
                $engine = "搜搜";
            } else if ($bing) {//来自必应
                $keyword = $this->getAccessKeyword($url, 'q=');//关键词前的字符为"q="。
                $keyword = urldecode($keyword);
                $engine = "必应";
            } else if ($youdao) {//来自有道
                $keyword = $this->getAccessKeyword($url, 'q=');//关键词前的字符为"q="。
                $keyword = urldecode($keyword);
                $engine = "有道";
            } else {
                $engine = parse_url($url);
                $engine = empty($engine['host'])?'':$engine['host'];
            }
        }
        return array(
            'keyword' => $keyword,
            'engine' => $engine
        );
    }

    /**
     * 获取来自搜索引擎入站时的关键词
     * @param $url
     * @param $kw_start
     * @return bool|string
     */
    protected function getAccessKeyword($url, $kw_start) {
        $start = stripos($url, $kw_start);
        $url = substr($url, $start + strlen($kw_start));
        $start = stripos($url, '&');
        if ($start > 0) {
            $start = stripos($url, '&');
            $keyword = substr($url, 0, $start);
        } else {
            $keyword = substr($url, 0);
        }
        return $keyword;
    }


}