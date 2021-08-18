<?php


class User {
    protected $id;
    protected $is_admin;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $password;
    protected $birthday;

   function __construct($id, $is_admin,$firstname, $lastname, $email, $password,$birthday ) {
        $this->id = $id;
        $this->is_admin = $is_admin;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->birthday = $birthday;

    }
    function Show()
    {
        echo 'User: id ('.$this->id.') '. ' admin: ('.$this->id.') name:' .$this->firstname.' '. $this->lastname.' email: '.$this->email. ' pass: '.$this->password.' birthday: '.$this->birthday.'<br/>';
    }
    public function setID($id) {
        $this->id = $id;
    }
    public function getID() {
        return $this->id;
    }

    public function setIs_admin($is_admin) {
        $this->is_admin = $is_admin;
    }
    public function getIs_admin() {
        return $this->is_admin;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }
    public function getFirstname() {
        return $this->firstname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }
    public function getLastname() {
        return $this->lastname;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
    public function getPassword() {
        return $this->password;
    }

    public function setBirthday($birthday) {
        $this->birthday = $birthday;
        return $this;
    }
    public function getBirthday() {
        return $this->birthday;
    }

    public function getFullName() {
        return ($this->firstname . ' ' . $this->lastname) ;
    }

    public function getAge() {
        $birthday_timestamp = strtotime($this->birthday);

        $age = date('Y') - date('Y', $birthday_timestamp);

        if (date('md', $birthday_timestamp) > date('md')) {
            $age--;
        }

        return (int)$age;
    }

}

$users = [
    new User(1, 1, 'Anakin', 'Skywalker', 'Anakin@mail.com', 111, '1980-01-02'),
    new User(2, 0, 'Han', 'Solo', 'Han@mail.com', 222, '1960-03-09'),
    new User(3, 0, 'Kylo', 'Ren', 'Kylo@mail.com', 333, '2001-06-08'),
    new User(4, 0, 'Obi-Wan', 'Kenobi', 'Obi-Wan@gmail.com', 444, '1997-10-01'),
    new User(5, 0, 'Leia', 'Organa', 'Leia@mail.com', 555, '2002-11-10'),
    new User(6, 1, 'Harry', 'Potter', 'Harry@mail.com', 666, '2003-06-01'),
    new User(7, 0, 'Hermione', 'Granger', 'Hermione@mail.com', 777, '2004-01-01'),
    new User(8, 0, 'Ronald', 'Weasley', 'Ronald@mail.com', 888, '2005-03-03'),
    new User(9, 1, 'Aayla', 'Secura', 'Aayla@mail.com', 999, '1515-05-05'),
];

$roles = [
    0 => 'Client',
    1 => 'Admin',
    2 => 'Manager',
];

$sort_list = array(
    'id_asc'   => '`id`',
    'id_desc'  => '`id` DESC',
    'firstname_asc'  => '`firstname`',
    'firstname_desc' => '`firstname` DESC',
    'lastname_asc'   => '`lastname`',
    'lastname_desc'  => '`lastname` DESC',
    'email_asc'   => '`email`',
    'email_desc'  => '`email` DESC',
);