<?php
session_start();
?>

<?php
if(!isset($_SESSION['user']))
{
    header('Location: http://library/index.php');
    exit;
}

include_once('functions.php');
include_once('class.php');


if (isset($_GET['sort'] ))
{
    $users =  sortingUsers($_GET['sort'] , $users);
}

if ( isset($_GET['search']) )
{
    $users = searchUsers($_GET['search'], $users);
}


if ( isset($_GET['edit_user']) )
{
    editUser($_GET['edit_user'], $users);

}


if ( isset($_POST['is_admin'],$_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['password'],$_POST['birthday']))
{
   $users= createUser($users, $_POST['user_id'] );
}

if ( isset($_GET['delete_user']) )
{
    $users = deleteUser($_GET['delete_user'], $users);
}

if ( isset($_GET['delete_card_users']) )
{
    $users = deleteUsersAfterCart($_GET['delete_card_users'], $users);
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

                    <li class="nav-item">
                        <form action="../index.php" method="post">
                            <button   name="exit_user" >Выход</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </nav>
</div>

<div class="container">
    <div class="card mt-5">

        <div class="card-header">
            <h2>Все пользователи</h2>
        </div>

        <div class="card-body">

            <form action="users.php" method="get">
                <input type="text"  placeholder="Поиск......" name="search" id="search" required>
            </form>


            <form action="users-cards.php"  method="get">

                <input type="submit" class="loginrbtn">

                <table  class="table table-success">
                    <thead>
                    <tr>
                        <th>Choose</th>

                        <th>
                            <?php echo sortLinkUsers('ID', 'id_asc', 'id_desc'); ?>
                        </th>

                        <th>Admin</th>

                        <th>
                            <?php echo sortLinkUsers('First Name', 'firstname_asc', 'firstname_desc'); ?>
                        </th>

                        <th>
                            <?php echo sortLinkUsers('Last Name', 'lastname_asc', 'lastname_desc'); ?>
                        </th>

                        <th>
                            <?php echo sortLinkUsers('Email', 'email_asc', 'email_desc'); ?>
                        </th>


                        <th>Birthday</th>
                        <th>Operations</th>
                        <th></th>
                    </tr>



                    </thead>
                    <tbody>


                    <?php
                    foreach($users as $user): ?>
                        <tr>

                            <td>
                                <input type="checkbox"  name="choose_user[]" value="<?php echo $user->getId();?>">
                            </td>

                            <td><?= $user->getId(); ?></td>
                            <td><?= $user->getIs_admin(); ?></td>
                            <td><?= $user->getFirstname(). ' ' . ($user->getID() == $_SESSION['user']['id']? '🤪' : ''); ?></td>
                            <td><?= $user->getLastname(); ?></td>
                            <td><?= $user->getEmail(); ?></td>
                            <td><?= $user->getBirthday(); ?></td>

                            <td>
                                <a href='users.php?edit_user=<?php echo $user->getId(); ?>'>EDIT</a>
                            </td>

                            <td >
                                <a href='users.php?delete_user=<?php echo $user->getId(); ?>'>DELETE</a>
                            </td>

                            <!--<td>
                            <form action="" method="get">
                                <input type="hidden" name="page" value="2"/>
                                <button class="btn btn-danger" type="submit" name="delete_user" value="<?php /*echo $user->getId(); */?>">Delete</button>
                            </form>
                        </td>-->

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

            </form>

            <!--<td><?/*= print_r($_POST); */?></td>-->
            <!--<td><?/*= print_r($_GET); */?></td>-->
            <!--<td><?/*= print_r($_POST['choose_user_id']); */?></td>-->
        </div>

    </div>


    <form action="users.php" method="post">
        <div class="container">

            <h3>Добавить пользователя</h3>
            <hr>
            <input type="hidden"  name="user_id" value="<?php echo (isset($_POST['edit_user_id']) ? $_POST['edit_user_id']: 0 ) ?>">

            <input type="text" placeholder="Тип пользователя" name="is_admin" value="<?php echo (isset($_POST['edit_is_admin']) ? $_POST['edit_is_admin']: '') ?>" required>
            <input type="text" placeholder="Имя" name="firstname" value="<?php echo (isset($_POST['edit_firstname']) ? $_POST['edit_firstname']: '') ?>"  required>
            <input type="text" placeholder="Фамилия" name="lastname"  value="<?php echo (isset($_POST['edit_lastname']) ? $_POST['edit_lastname']: '') ?>" required>
            <input type="text" placeholder="Почта" name="email"  value="<?php echo (isset($_POST['edit_email']) ? $_POST['edit_email']: '') ?>" required>
            <input type="password" placeholder="Пароль" name="password"  value="<?php echo (isset($_POST['edit_password']) ? $_POST['edit_password']: '') ?>" required>
            <input type="text" placeholder="Дата рождения" name="birthday"  value="<?php echo (isset($_POST['edit_birthday']) ? $_POST['edit_birthday']: '') ?>" required>
            <hr>
            <button type="submit" class="loginrbtn" ><?php echo (isset($_POST['edit_user_id']) ? 'РЕДАКТИРОВАТЬ': 'СОЗДАТЬ') ?></button>
        </div>

    </form>
</div>



</div>
</body>
</html>





