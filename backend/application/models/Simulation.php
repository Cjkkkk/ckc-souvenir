<?php
/**
 * Created by PhpStorm.
 * User: liuqingyang
 * Date: 2017/3/14
 * Time: 20:56
 */
class Simulation extends CI_Model
{

    function send_post($url, $post_data)
    {

        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Cookie:JSESSIONID=B0C0A06726C49C45F0971F2E020F0E86	
Content-Type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

    function send_get($url)
    {

        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Cookie:JSESSIONID=B0C0A06726C49C45F0971F2E020F0E86	
Content-Type:application/x-www-form-urlencoded',
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }
}