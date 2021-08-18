<?php
session_start();
?>
<!doctype html>
<html lang="en">
<?php

include_once('functions.php');

require_once 'class.php';

if ( isset($_GET['choose_user']) )
    $users = filterUsersBySelected($users, $_GET['choose_user']);

$groupUsers = calcGroupRolesUsers($users);

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />


    <title>My_Library</title>



</head>
<body style="margin-left: 25px;">

<div class="row">
    <nav class="col-sm-12 col-md-12 col-lg-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Список пользователей</a>
                    </li>
                    <li class="nav-item" >
                        <form action="../index.php" method="post">
                            <button   name="exit_user" >Выход</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </nav>
</div>
<div class="container" >
    <div class="card mt-5">
        <div class="card-header">
            <h2>Карточки пользователей</h2>
        </div>
        <div class="card-group">
            <?php foreach($users as $user): ?>

                <div class="card border-secondary mb-3" style="max-width: 18rem;">
                    <div class="card-header"><?= $user->getIs_admin() == 1 ? 'Admmin': 'Client';?></div>
                    <div class="card-body text-secondary">
                        <h5 class="card-title">ID: <?= $user->getId(); ?></h5>
                        <p class="card-text">Name: <?= $user->getFirstname() . ' - '. $user->getLastname(); ?></p>
                        <p class="card-text">E-Mail: <?= $user->getEmail(); ?></p>
                        <p class="card-text">Age: <?= $user->getAge(); ?></p>
                    </div>
                </div>

            <?php endforeach; ?>

            <div class="container">

                <h5>Количество выбранных пользователей - <?php echo count($users) ?> </h5><br>
                <h5>Общая сумма возрастов выбранных пользователей - <?php echo totalAgeUsers($users) ?> </h5><br>

                <?php foreach ($groupUsers as $group => $count) { ?>
                    <h5><?= isset($roles[$group]) ? $roles[$group] : 'Other' ?> - <?= $count ?> </h5><br>
                <?php } ?>

                <form action="users.php" method="get">
                    <?php foreach($users as $user): ?>
                        <input type="hidden"  name="delete_card_users[]" value="<?= $user->getId(); ?>"/>
                    <?php endforeach; ?>

                    <button type="submit" class="loginrbtn">Delete users</button>
                </form>

            </div>


        </div>
    </div>




</div>
</body>
</html>









