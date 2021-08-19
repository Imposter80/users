
<?php
include_once('class.php');

// --------------------------- DISPLAYING LINKS FOR SORTING --------------------------------------

function sortLinkUsers($title, $a, $b) {
    $sort = @$_GET['sort'];     //@$_GET - исключение ошибки если ключ не существует в $_GET

    if ($sort == $a) {
        return '<a  href="?sort=' . $b . '">' . $title . ' <i>👆</i></a>';
    } elseif ($sort == $b) {
        return '<a  href="?sort=' . $a . '">' . $title . ' <i>☟</i></a>';
    } else {
        return '<a href="?sort=' . $a . '">' . $title . '</a>';
    }
}


// --------------------------- SORTING USER --------------------------------------



function sortingUsers($sort, &$users)
{
    switch ($sort) {
        case "id_asc":
            usort($users, function($a, $b) {
                return ($a->getID() == $b->getID() ? 0 : $a->getID() - $b->getID());
            });
            break;
        case "id_desc":
            usort($users, function($a, $b) {
                return  ($a->getID() == $b->getID() ? 0 : $b->getID() - $a->getID());
            });
            break;
        case "firstname_asc":
            usort($users, function($a, $b) {return strcmp($a->getFirstname(), $b->getFirstname());});
            break;
        case "firstname_desc":
            usort($users, function($a, $b) {return strcmp($b->getFirstname(), $a->getFirstname());});
            break;
        case "lastname_asc":
            usort($users, function($a, $b) {return strcmp($a->getLastname(), $b->getLastname());});
            break;
        case "lastname_desc":
            usort($users, function($a, $b) {return strcmp($b->getLastname(), $a->getLastname());});
            break;
        case "email_asc":
            usort($users, function($a, $b) {return strcmp($a->getEmail(), $b->getEmail());});
            break;
        case "email_desc":
            usort($users, function($a, $b) {return strcmp($b->getEmail(), $a->getEmail());});
            break;
    }



    /* if(isset($_GET['sorting_user_id']))
     {
         usort($users, function($a, $b) {
             (return $a->getID() == $b->getID() ? 0 : $a->getID() - $b->getID());
         });
     }

     if(isset($_GET['sorting_user_first_name'] ))
     {
         usort($users, function($a, $b) {return strcmp($a->getFirstname(), $b->getFirstname());});
     }

     if(isset($_GET['sorting_user_last_name']))
     {
         usort($users, function($a, $b) {return strcmp($a->getLastname(), $b->getLastname());});
     }

     if(isset($_GET['sorting_user_email']))
     {
         usort($users, function($a, $b) {return strcmp($a->getEmail(), $b->getEmail());});
     }*/
    return $users;
}



// --------------------------- ADD USER ---------------------------

    function createUser($users, $user_id)
    {
        if($user_id ==0)
        {

            $id = count($users) + 1;
            $tmp_user = new User($id,
                (int)($_POST['is_admin']),
                trim(htmlspecialchars($_POST['firstname'])),
                trim(htmlspecialchars($_POST['lastname'])),
                trim(htmlspecialchars($_POST['email'])),
                ($_POST['password']),
                ($_POST['birthday']));

            $users[] = $tmp_user;
            echo '<h1 style="color: #4CAF50"> Новый пользователь  ' .$tmp_user->getFirstname(). ' ' .$tmp_user->getLastname().' добавлен! </h1>';
        }
        else
        {
            foreach ($users as $user)
            {
                if( $user->getId() == $user_id)
                {
                    // camelCase
                    // snake_case

                    $user->setIs_admin( $_POST['is_admin']);
                    $user->setFirstname($_POST['firstname']);
                    $user->setLastname($_POST['lastname']);
                    $user->setEmail($_POST['email']);
                    $user->setPassword($_POST['password']);
                    $user->setBirthday($_POST['birthday']);

                    echo '<h1 style="color: #4CAF50"> Данные пользователя  ' .$user->getFirstname(). ' ' .$user->getLastname().' изменены! </h1>';
                    break;
                }
            }
        }
        return $users;
    }


// --------------------------- SEARCH USER ---------------------------

    function searchUsers($search, $users)
    {
        return array_filter($users, function($user) use($search) {

            return  (stristr($user->getLastname(), $search) || stristr($user->getFirstname(), $search) || stristr($user->getEmail(), $search ));

            /*можно использовать второй вариант*/

           /* return  (strripos($user->getFirstname(), $_GET['search']) !== false ||
                strripos($user->getLastname(), $_GET['search']) !== false ||
                strripos($user->getEmail(), $_GET['search']) !== false  );*/
        });



      /*  $tmp_users = array();

        foreach ($users as $user)
        {
            if(strripos($user->getFirstname(), $_GET['search']) !== false ||
               strripos($user->getLastname(), $_GET['search']) !== false ||
               strripos($user->getEmail(), $_GET['search']) !== false  )

                $tmp_users[] = $user;
        }
        return $tmp_users;*/

    }




// --------------------------- EDIT USER -------------------------

    function editUser($id, $users)
{
    foreach ($users as $user)
    {
        if( $user->getId() == $id)
        {
            $_POST['edit_user_id'] = $user->getID();
            $_POST['edit_is_admin'] = $user->getIs_admin();
            $_POST['edit_firstname'] = $user->getFirstname();
            $_POST['edit_lastname'] = $user->getLastname();
            $_POST['edit_email'] = $user->getEmail();
            $_POST['edit_password'] = $user->getPassword();
            $_POST['edit_birthday'] = $user->getBirthday();


            break;
        }
    }
}


// --------------------------- DELETE USER -------------------------

    function deleteUser($id, $users)
    {
        return array_filter($users, function($user) use($id) {
            return !($user->getID() == $id);
        });

       /* foreach ($users as $userKey => $uservalue)
        {
           if ($uservalue->getId() == $id)
           {
              echo '<h1 style="color: #4CAF50"> Пользователь  ' .$uservalue->getFirstname(). ' ' .$uservalue->getLastname().' удален! </h1>';
               unset($users[$userKey]);
               break;
           }
        }
        return $users;*/

    }

// --------------------------- CARDS USER -------------------------

    function filterUsersBySelected($users, $selectedUsers) {
        return array_filter($users, function($user) use($selectedUsers) {
            /* @var User $user */

            return in_array($user->getID(), $selectedUsers);
        });
    }


// --------------------------- TOTAL USERS AGE  -------------------------
    function totalAgeUsers($users) {
        $totalAge = 0;

        foreach($users as $user) {
            $totalAge += $user->getAge();
        }

        return $totalAge;
    }

    /**
     * [
     *     1 => 1,
     *     0 => 1,
     * ]
     *
     * @param $users
     * @return array
     */
// --------------------------- CALC USERS GROUPS  -------------------------
    function calcGroupRolesUsers($users) {
        $groupCounts = [];

        /* @var User[] $users */
        foreach($users as $user) {
            if(!isset($groupCounts[$user->getIs_admin()]))
                $groupCounts[$user->getIs_admin()] = 0;

            ++$groupCounts[$user->getIs_admin()];
        }

        return $groupCounts;
    }



// --------------------------- DELETE USERS AFTER CART -------------------------

    function deleteUsersAfterCart($card_users_id, $users)
{
    foreach ($users as $userKey => $uservalue)
    {
        if(in_array($uservalue->getId(), $card_users_id))
            unset($users[$userKey]);
    }
    return $users;
}


// --------------------------- USER LOGIN -------------------------

function logAut($autData, $users)
{
        $check_user= current( array_filter($users, function($user) use($autData) {

            return  (in_array($user->getEmail(), $autData) && in_array($user->getPassword(), $autData));

            /*можно использовать второй вариант*/

            /*return ($user->getEmail() ==$autData[0] && $user->getPassword() == $autData[1]);*/
         }));

        if (empty($check_user))
        {
            $_SESSION['message'] = 'Неверный логин или пароль!';
        }
        else
        {
            $_SESSION['user'] = [
                'id' => $check_user->getID(),
                'full_name' => $check_user->getFullName(), ];
            $_SESSION['message'] = 'Здравствуйте '. $check_user->getFullName(). '<br> <a class="nav-link" href="pages/users.php">Список пользователей</a>';
        }

}


    /*function login($email, $password, &$users)
    {

    $login = trim(htmlspecialchars($email));
    $pass = trim(htmlspecialchars($password));
    if(strlen($login) < 3 || strlen($login) > 50 || strlen($pass) < 3 || strlen($pass) > 50)
    {
        $_SESSION['message'] = 'Введите корректные данные';
    }
    else
    {
        $check_user = 0;

        foreach ($users as $userKey => $uservalue)
        {
           if ($uservalue->getEmail() == $login && $uservalue->getPassword() == $pass)

           {
               $check_user = $uservalue;
               break;
           }
        }
        if (empty($check_user))
        {
            $_SESSION['message'] = 'Неверный логин или пароль!';
        }
        else
        {
            $_SESSION['user'] = [
                'id' => $check_user->getID(),
                'full_name' => $check_user->getFirstname(). ' '. $check_user->getLastname(), ];
            $_SESSION['message'] = 'Здравствуйте '. $check_user->getFirstname(). ' '. $check_user->getLastname() . '<br> <a class="nav-link" href="pages/users.php">Список пользователей</a>';
        }
    }
}*/



?>
