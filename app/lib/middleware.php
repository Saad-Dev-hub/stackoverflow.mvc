<?php
 namespace PHPMVC\LIB;
 class Middleware{
        public static function isLoggedIn(){
            if(!isset($_SESSION['loggedUser'])){
                header('Location: /user/signin');
                exit();
            }
        }
        public static function isGuest(){
            if(isset($_SESSION['loggedUser'])){
                header('Location: /index');
                exit();
            }
        }
     
         
 }