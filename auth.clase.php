<?php

require __DIR__ . '\vendor\autoload.php';
use Firebase\JWT\JWT;


class Auth
{
    private static $secret_key = 'Sdw1s9x8@';
    private static $encrypt = ['HS256'];
    private static $aud = null;
    public  static $leeway = 0 ;
    public  static  $timestamp = null ;
    
    public static function SignIn($data)
    {
        $time = time();
        $timestamp = is_null(static::$timestamp) ? time() : static::$timestamp;

        $token = array(
            'exp' => $time + (60*180),
            'aud' => self::Aud(),
            'data' => $data
        );

        return JWT::encode($token, self::$secret_key);
    }
    
    public static function Check($token)
    {
        if(empty($token))
        {
            throw new Exception("Invalid token supplied.");
        }
        
        $decode = JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        );
        
        if($decode->aud !== self::Aud())
        {
            throw new Exception("Invalid user logged in.");
        }

        if (isset($token->exp) && ($token->timestamp - static::$leeway) >= $token->exp) {
            throw new Exception('Expired token');   
        }

        return $decode;
    }
    
    public static function GetData($token)
    {
        return JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        )->data;
    }
    
    private static function Aud()
    {
        $aud = 'weje';
        
       
        
        return sha1($aud);
    }
}
