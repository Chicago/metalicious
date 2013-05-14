<?php
//if logout action
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'logout') {
        //kill cookies
        setcookie('user_id', '', time() - 60 * 60 * 24 * 1, '/');
        setcookie('users_user_types', '', time() - 60 * 60 * 24 * 1, '/');
        
        header("Location: login.php");
    }
}

include_once 'classes/user.php';

//user login
$user_info = User::validate_login($_POST['username'], $_POST['password']);

//if valid login
if ($user_info->num_rows > 0) {
    //retrieve info
    $user_info = mysqli_fetch_assoc($user_info);
    
    //set user_id cookie
    setcookie('user_id', $user_info['User_ID'], time() + 60 * 60 * 24 * 1, '/');
    
    //set permissions
    setcookie('users_user_types', base64_encode(serialize(User::get_users_user_types($user_info['User_ID']))), time() + 60 * 60 * 24 * 1, '/');
    
    //forward to main page
    header("Location: index.php");
}

include 'include/header.php';
?>
<br />

<script>
    $(document).ready(function() {
        $('#username').focus();
    });
</script>

<div class="span5">
    <form class="well form-horizontal" action="login.php" method="post">
        <h4>Log In:</h4>
        <div class="control-group">
            <label class="control-label" style="margin-left: 0px;" for="username">Username:</label>
            <div class="controls">
                <input type="text" class="span2" style="margin-bottom: 0px;" name="username" id="username" placeholder="Your Username" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="password">Password:</label>
            <div class="controls">
                <input type="password" class="span2" style="margin-bottom: 0px;" name="password" id="password" placeholder="Your Password" />
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <input type="submit" class="btn btn-primary" value="Log In" />
            </div>
        </div>
    </form>
</div>
