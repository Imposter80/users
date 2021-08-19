<?php
session_start();
?>

<?php
include_once('pages/functions.php');

if (isset($_POST['log_email']) && isset($_POST['log_password'] ) )
{

    logAut( array( $_POST['log_email'], $_POST['log_password']), $users);


}

if ( isset($_POST['exit_user']) )
{
    unset($_SESSION['user']);
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />


    <title>My_Library</title>
</head>
<body style="margin-left: 25px;">
<div class="conteiner">
    <div class="row">
        <nav class="col-sm-12 col-md-12 col-lg-12">
            <?php
            include_once('pages/functions.php');
            ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Вход</a>
                        </li>
                        <?php
                           if (isset($_SESSION['user']))
                              {
                                ?>
                                 <li class="nav-item">
                                      <a class="nav-link" href="pages/users.php">Список пользователей</a>
                                 </li>

                                  <li class="nav-item">
                                      <form action="../index.php" method="post">
                                          <button   name="exit_user" >Выход</button>
                                      </form>
                                  </li>
                                <?php
                              }
                        ?>

                    </ul>
                </div>
            </nav>
        </nav>
    </div>


    <?php

    if (isset($_SESSION['user']))
    {
        ?>
        <div class="container">
            <?php
            if(isset($_SESSION['message']) )
            {
                echo '<p style="padding: 10px; font-weight: bold; text-align: center; " >'. $_SESSION['message']. '</p>';
            }
            unset($_SESSION['message']);
            ?>
        </div>

        <?php

    }
    else
    {
        ?>
        <form action="" method="post">
            <div class="container">
                <h1>Вход</h1>
                <h3>Пожалуйста заполните поля</h3>
                <hr>
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="📬 - Enter Email" name="log_email" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="🔏 - Enter Password" name="log_password" required>
                <hr>


                <button type="submit" class="loginrbtn">ВОЙТИ</button>
                <div class="container">
                    <?php
                    if(isset($_SESSION['message']) )
                    {
                        echo '<p style="padding: 10px; font-weight: bold; text-align: center; " >'. $_SESSION['message']. '</p>';
                    }
                    unset($_SESSION['message']);

                    ?>
                </div>
            </div>

        </form>
<?php
    }
     ?>





</div>
</body>
</html>

