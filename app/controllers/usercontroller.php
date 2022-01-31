<?php

namespace PHPMVC\Controllers;

use PHPMVC\LIB\validation;
use PHPMVC\LIB\Middleware;
use PHPMVC\Models\UserModel;
use PHPMVC\Models\QuestionModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require vendor folder
require_once '..' . DS . 'vendor' . DS . 'autoload.php';

class UserController extends AbstractController
{
    use Validation;

    public function signupAction()
    {
        Middleware::isGuest();
        // if user is already logged in, redirect to home page
        if (isset($_SESSION['loggedUser'])) {
            header('location:/index');
            exit;
        }
        $this->_data['pageTitle'] = 'Kommunity | Sign up';
        if (isset($_POST['submit'])) {
            $userAlreadyExist = UserModel::getByEmail($_POST['email']);
            if ($userAlreadyExist == true) {
                $this->_data['user_exist'] = 'Sorry, User already exist';
            } else {
                //validate the form data using trait Validation
                $username = trim($this->required($_POST['username'], "username")
                    ->minLength($_POST['username'], 3, 'username')
                    ->maxLength($_POST['username'], 40, 'username')
                    ->is_string($_POST['username'], 'username'));
                $email = $this->required($_POST['email'], "email")->is_email($_POST['email'], 'email');
                // encrypt the password using password_hash
                $password = $this->encryptPassword($this->required($_POST['password'], "password")
                    ->minLength($_POST['password'], 6, 'password')
                    ->maxLength($_POST['password'], 20, 'password')
                    ->passwordFormat($_POST['password'], 'password'));
                $confirm_password = $this->confirmPassword($_POST['confirm-password'], 'confirm-password');
                $photo = $this->validateFiles($_FILES['photo']);
                //store errors in _data array to be used in the view
                $this->_data['errors'] = $this->printError();
                $this->_data['_errors_img'] = $this->printErrorImg();
                // if there are no errors and the user uploaded a photo
                if (empty($this->printError()) && empty($this->printErrorImg()) && $photo !== null) {
                    $user = new UserModel($username, $email, $password);
                    $user->setPhoto($photo);
                    $user->save();
                    header('Location:/user/signin');
                }
                // if there are no errors and the user didn't upload a photo
                elseif (empty($this->printError()) && empty($this->printErrorImg()) && is_null($photo)) {
                    $user = new UserModel($username, $email, $password);
                    $user->setPhoto('uploads/default-user.png');
                    $user->save();
                    header('Location:/user/signin');
                }
            }
        }

        $this->_view();
    }
    public function signinAction()
    {
        Middleware::isGuest();
        $this->_data['pageTitle'] = 'Kommunity | Sign in';
        if (isset($_POST['submit'])) {
            $user = UserModel::getByEmail($_POST['email']);
            // var_dump($user);die;
            if ($user == false) {
                $this->_data['user_not_exist'] = 'Sorry, User does not exist';
            } else {
                //check if the password is correct
                if (password_verify($_POST['password'], $user->password)) {
                    $_SESSION['loggedUser'] = $user;

                    header('location:/index');
                } else {
                    $this->_data['password_error'] = 'Invalid user credentials';
                }
            }
        }

        $this->_view();
    }
    public function profileAction()
    {
        Middleware::isLoggedIn();
        $this->_data['pageTitle'] = 'Kommunity | Profile';
        $userQuestions = QuestionModel::getByQuery('SELECT * FROM question WHERE user_id = ' . $_SESSION['loggedUser']->id);
        $this->_data['userQuestions'] = $userQuestions;
        $this->_view();
    }
    public function forgetPasswordAction()
    {
        Middleware::isGuest();
        $this->_data['pageTitle'] = 'Kommunity | Forget Password';
        if (isset($_POST['submit'])) {
            $email = $this->required($_POST['email'], "email")->is_email($_POST['email'], 'email');
            $this->_data['errors'] = $this->printError();
            if (empty($this->printError())) {
                $user = UserModel::getByEmail($email);
                if ($user == false) {
                    $this->_data['user_not_exist'] = 'Sorry, User does not exist';
                } else {
                    $user->setCode();
                    $user->updateCode();
                    $this->sendEmail($user);
                    $_SESSION['valid_user'] = $user;
                    header('location:/user/verify');
                }
            }
        }
        $this->_view();
    }
    public function sendEmail($user)
    {
        ////
        ////
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'saadmohammed020@gmail.com';                     //SMTP username
            $mail->Password   = '01275003483saad';                               //SMTP password
            $mail->SMTPSecure = "ssl";         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('saadmohammed020@gmail.com', 'Stackoverflow');
            $mail->addAddress($user->email);               //Name is optional

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Verification Code';
            $mail->Body    = '  <p> Dear  ' . $user->username . ',</p>
                     <p> Your Verification Code :<b> ' . $user->code . '</b></p>
                     <p><b>Thank You</b></p>';
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    public function verifyAction()
    {
        Middleware::isGuest();
        $codeOfUser =  $_SESSION['valid_user']->code;
        if (isset($_POST['submit'])) {
            $codeOfPost = '';
            foreach ($_POST['ver'] as $key => $value) {
                $codeOfPost .= $value;
            }
            if ($codeOfPost == $codeOfUser) {
                // echo '<script>alert("Your code is correct")</script>';
                header('location:/user/changePassword');
            } else {
                $this->_data['code_error'] = 'Invalid code , please try again';
            }
        }

        $this->_view();
    }
    public function changePasswordAction()
    {
        Middleware::isGuest();
        $this->_data['pageTitle'] = 'Kommunity | Change Password';
        if (isset($_POST['submit'])) {
            $password = $this->encryptPassword($this->required($_POST['password'], "password")
                ->minLength($_POST['password'], 6, 'password')
                ->maxLength($_POST['password'], 20, 'password')
                ->passwordFormat($_POST['password'], 'password'));
                $confirm_password = $this->confirmPassword($_POST['confirm_password'], 'confirm password');
                $this->_data['errors'] = $this->printError();
                if ($this->decryptPassword($_SESSION['valid_user']->password, $password)) {
                $this->_data['old_password'] = 'Your new password must be different from your old password';
            } else {
                if (empty($this->printError())) {
                    $user = UserModel::getByEmail($_SESSION['valid_user']->email);
                    $user->setPassword($password);
                    $user->save();
                    unset($_SESSION['valid_user']);
                    header('location:/user/signin');
                }
            }
        }

        $this->_view();
    }
    public function updateProfileAction()
    {
        // check if user update his profile photo or not

        $this->_data['pageTitle'] = 'Kommunity | Update Profile';
        if (isset($_POST['submit'])) {
            // var_dump($_SESSION);die;
            $username = trim($this->required($_POST['username'], "username")
                ->minLength($_POST['username'], 3, 'username')
                ->maxLength($_POST['username'], 20, 'username')
                ->is_string($_POST['username'], 'username'));
            $filteredEmail = trim($this->required($_POST['email'], "email")->is_email($_POST['email'], 'email'));
            $usedEmail = UserModel::getByEmail($filteredEmail);

            // if user try to update with the same username

            $this->_data['errors'] = $this->printError();
            if (empty($this->printError()) && $usedEmail->username !== $username) {
                //echo '<script>alert("Your profile has been updated")</script>';die;
                $user = UserModel::getByEmail($_SESSION['loggedUser']->email);
                $user->setUsername($username);
                $user->update();
                $_SESSION['loggedUser'] = $user;
                header('location:/user/profile');
            }
            // check if user try to update his profile photo or not using validateFiles()
            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
                $photo = $this->validateFiles($_FILES['photo'], 'photo');
                $this->_data['errors'] = $this->printErrorImg();
                if (empty($this->printErrorImg())) {
                    $user = UserModel::getByEmail($_SESSION['loggedUser']->email);
                    if ($user->photo != 'uploads/default-user.png') {
                        unlink($user->photo);
                    }
                    $user->setPhoto($photo);
                    $user->update();
                    $_SESSION['loggedUser'] = $user;
                    header('location:/user/profile');
                }
            }
            // if user try to update his username only
            if (empty($this->printError()) && empty($this->printErrorImg()) && $usedEmail == false) {
                $user = UserModel::getByEmail($_SESSION['loggedUser']->email);
                $user->setUsername($username);
                $user->update();
                $_SESSION['loggedUser'] = $user;
                header('location:/user/profile');
            }
        }
        $this->_view();
    }
    public function logoutAction()
    {
        session_unset();
        setcookie(
            session_name(),
            '',
            time() - 3600,
            '/',
            '.stackoverflow.mvc',
            FALSE,
            TRUE
        );
        session_destroy();
        header('location:/user/signin');
    }
}
