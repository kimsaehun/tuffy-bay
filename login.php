<?php
$title = 'Login/Register';
$css_files = array(
  'loginpage.css'
);

include 'functions.php';

if ($tuffy_user->is_loggedin()){
    header("Location: http://" .$_SERVER['SERVER_NAME']);
            /* Make sure that code below does not get executed when we redirect. */
            exit;
}
$tuffy_inventory = new tuffy_inventory($DB_connection);

//TODO: we should do authentication restrictions on javascript, doing it on php in the meantime
$msg = "";
if ( isset($_POST['login_user']) )
{
    if ( !empty($_POST['login-username']) )
    {
        if( !empty($_POST['login-password']) )
        {
            $tuffy_user->login_user($_POST['login-username'], $_POST['login-password']);
            if (!$tuffy_user->login_usernameFound){$msg="username not valid";}
            else if (!$tuffy_user->login_correctPassword){$msg="wrong password";}
        }
        else{$msg="need password...";}
    }
    else{$msg="need username...";}
}
else if(isset($_POST['register_user']))
{

    $tuffy_user->register_user($_POST['register-username'], $_POST['register-password'], $_POST['register-email']);

    if ($tuffy_user->register_usernameTaken){$msg = "username already taken";}
}
echo $msg;


include $_SERVER['DOCUMENT_ROOT'] . '/php/phtml/html_header.phtml';
?>
<div class="login-wrap">
    <div class="login-html">
    <div align="center" color="white">Login<br></div>
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
        <div class="login-form">
            <form class="sign-in-htm" method="post">
                <div class="group">
                    <label for="user" class="label">Username</label>
                    <input id="user" type="text" class="input" name="login-username">
                </div>
                <div class="group">
                    <label for="pass" class="label">Password</label>
                    <input id="pass" type="password" class="input" data-type="password" name="login-password">
                </div>
                <div class="group">
                    <input id="check" type="checkbox" class="check" checked>
                    <label for="check"><span class="icon"></span> Keep me Signed in</label><!--this doesnt do anything yet-->
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Sign In" name="login_user">
                </div>
                <div class="hr"></div>
                <div class="foot-lnk">
                    <a href="#forgot">Forgot Password?</a><!--this doesnt do anything yet-->
                </div>
            </form>
            <form class="sign-up-htm" method="post">
                <div class="group">
                    <label for="user" class="label">Username</label>
                    <input id="user" type="text" class="input" name="register-username">
                </div>
                <div class="group">
                    <label for="pass" class="label">Password</label>
                    <input id="pass" type="password" class="input" data-type="password" name="register-password">
                </div>
                <div class="group">
                    <label for="pass" class="label">Repeat Password</label>
                    <input id="pass" type="password" class="input" data-type="password"><!--TO DO: do this repeat pass thing-->
                </div>
                <div class="group">
                    <label for="pass" class="label">Email Address</label>
                    <input id="pass" type="text" class="input" name="register-email">
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Sign Up" name="register_user">
                </div>
                <div class="hr"></div>
                <div class="foot-lnk">
                    <label for="tab-1">Already Member?</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$js_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/php/phtml/html_footer.phtml';
?>