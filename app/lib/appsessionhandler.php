<?php
namespace PHPMVC\LIB;
define('SESSION_SAVE_PATH', dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR . 'session');
class AppSessionHandler extends \SessionHandler
{
    private $session_name = 'MYAPPSESSION';
    private $sessionMaxLifeTime = 0;
    private $sessionSSL = FALSE;
    private $sessionHTTPOnly = TRUE;
    private $sessionPath = '/';
    private $sessionDomain = '.stackoverflow.mvc';
    private $sessionCypherAlgo = 'AES-256-CBC';
    private $sessionCypherKey = 'W@7$_$PQ#';
    private $iv = 'WE1C0METOMVC234Q';
    private $ttl = 1;
    private $sessionSavePath = SESSION_SAVE_PATH;

    public function __construct()
    {
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_trans_sid', 0);
        ini_set('session.save_handler', 'files');
        session_name($this->session_name);
        session_save_path($this->sessionSavePath);
        session_set_cookie_params(
            $this->sessionMaxLifeTime,
            $this->sessionPath,
            $this->sessionDomain,
            $this->sessionSSL,
            $this->sessionHTTPOnly
        );
        session_set_save_handler($this, TRUE);
    }
    public function __set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public function __get($key)
    {
        return (false !== $_SESSION[$key]) ? $_SESSION[$key] : FALSE;
    }
    public function __isset($key)
    {
        return (isset($_SESSION[$key]) ? TRUE : FALSE);
    }
    public function start()
    {
        if (session_id() === '') {
            if (session_start()) {
                $this->setSessionStartTime();
                $this->checkSessionValidity();
            }
        }
    }
    public function write($id,  $data): bool
    {
        // encrypt the session data using ssl and base64 encoding
        $data = base64_encode(openssl_encrypt($data, $this->sessionCypherAlgo, $this->sessionCypherKey, 0, $this->iv));
        return  parent::write($id, $data);
    }
    public function read($id): string
    {
        $data = parent::read($id);
        if ($data) {
            // decrypt the session data using ssl and base64 encoding
            $data = openssl_decrypt(base64_decode($data), $this->sessionCypherAlgo, $this->sessionCypherKey, 0, $this->iv);
        }
        return $data;
    }
    private function setSessionStartTime()
    {
        if (!isset($this->sessionStartTime)) {
            $this->sessionStartTime = time();
        }
        return true;
    }
    private function checkSessionValidity()
    {
        if ((time() - $this->sessionStartTime) > ($this->ttl * 60)) {
              $this->renewSession();
              $this->generateFingerPrint();
        }
        return true;
    }
    private function renewSession()
    {
        $this->sessionStartTime = time();
        return session_regenerate_id(true);
    }
    public function kill()
    {
        session_unset();
        setcookie(
            $this->session_name,
            '',
            time() - 3600,
            $this->sessionPath,
            $this->sessionDomain,
            $this->sessionSSL,
            $this->sessionHTTPOnly
        );
        session_destroy();
    }
    private function generateFingerPrint(){
        $userAgentId = $_SERVER['HTTP_USER_AGENT'];
        $this->cypherKey=random_bytes(32);
        $sessionId = session_id();
       $this->fingerPrint = md5($userAgentId . $sessionId . $this->cypherKey);
    }
    public function isValidFingerPrint(){
        // generate random key  
        if(!isset($this->fingerPrint)){
           $this->generateFingerPrint();
        }
        $fingerPrint=md5($_SERVER['HTTP_USER_AGENT'] . session_id() . $this->cypherKey);
        if($fingerPrint=== $this->fingerPrint){
            return true;
        }
        return false;
    }
}
