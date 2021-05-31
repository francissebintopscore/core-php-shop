<?php
require_once 'templates/header.php';
use Includes\Helpers\Security;
?>

<div class="container" style="margin-top:30px">
    <div class="row">
        <div class="col-sm-12">
            <div class="au-heading">
                <h2>Login</h2>
            </div>
            <div class="login-form-container mg-bot-30">
                <form action="actions/login.php" method="POST">
                    <input type="hidden" name="csrf" value="<?php echo Security::generateCSRF('csrf');?>">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
                    </div>
                    <div class="form-group form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="remember"> Remember me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-success" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'templates/footer.php';
?>