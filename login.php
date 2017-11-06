<?php
$title = 'Tuffy Bay';
$css_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_header.php';
?>

<div class="login_sec">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="index.html">Home</a></li>
      <li class="active">Login</li>
    </ol>
    <h2>Login</h2>
    <div class="col-md-6 log">
      <p>Welcome, please enter the following to continue.</p>
        <form>
          <h5>Username:</h5>
          <input type="text" value="">
          <h5>Password:</h5>
          <input type="password" value="">
          <input type="submit" value="Login">
          <a class="acount-btn" href="account.html">Create an Account</a>
      </form>
    </div>
    <div class="clearfix"></div>
  </div>
</div>

<?php
$js_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_footer.php';
?>