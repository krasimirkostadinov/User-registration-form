<?php
/**
 * Created by PhpStorm.
 * User: krasimir
 * Date: 15-9-5
 * Time: 11:17
 */

namespace models;

/**
 * Class User containing all related to User object properties and methods
 * @package models
 */
class User implements IEntity
{

    private $id = null,
        $_email = '',
        $_username = '',
        $_first_name = '',
        $_last_name = '',
        $_password = '',
        $_entity_class = 'User',
        $errors = [],
        $_date_created = null;

    /**
     * Array with all requirements for every
     * @var array
     */
    private $fields_requirements = [
        '_email' => [
            'max_value_size' => 50,
            'min_value_size' => 1,
            'required' => true
        ],
        '_username' => [
            'max_value_size' => 50,
            'min_value_size' => 1,
            'required' => true
        ],
        '_first_name' => [
            'max_value_size' => 50,
            'min_value_size' => 1,
            'required' => true
        ],
        '_last_name' => [
            'max_value_size' => 50,
            'min_value_size' => 1,
            'required' => true
        ]
    ];


    protected static $db;

    public function __construct($id = null) {

        self::$db = new Database();

        $id = (int)$id;
        if (!empty($id)) {
            $this->init($id);
        }
    }

    /**
     * * Method for object initialisation
     * @param int $id
     * @throws \Exception
     */
    public function init($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $sql = '
                SELECT u.* FROM users AS u
                WHERE u.id = :id
            ';
            $params = ['id' => $this->id];

            $num_rows = self::$db->prepare($sql, $params)->execute()->getAffectedRows();
            if ($num_rows === 1) {
                $rows = self::$db->fetchAllAssoc();
                $user = self::createUsersObjects($rows);
                if (count($user) === 1) {
                    $k = key($user);
                    if ($user[$k] instanceof \models\User) {
                        $this->id = $user[$k]->id;
                        $this->_email = $user[$k]->_email;
                        $this->_first_name = $user[$k]->_first_name;
                        $this->_last_name= $user[$k]->_last_name;
                        $this->_username = $user[$k]->_username;
                        $this->_password = $user[$k]->_password;
                        $this->_date_created = $user[$k]->_date_created;
                    }
                }
            }
            else {
                throw new \Exception('User with ID [' . $id . '] not exist!');
            }
        }
    }

    /**
     * Create \models\User object from assoc array
     * @param array $rows assoc with keys name of fields
     * @return \models\User|null
     */
    public static function createUsersObjects($rows) {
        if (!empty($rows) && is_array($rows)) {
            foreach ($rows as $row) {
                $key = $row['id'];
                $user[$key] = new User();
                $user[$key]->id = $row['id'];
                $user[$key]->_username = $row['username'];
                $user[$key]->_first_name = $row['first_name'];
                $user[$key]->_last_name = $row['last_name'];
                $user[$key]->_email = $row['email'];
                $user[$key]->_password = $row['password'];
                $user[$key]->_date_created = $row['date_created'];
            }
            return !empty($user) ? $user : null;
        }
        return null;
    }

    /**
     * Save or update users data
     */
    public function save() {
        $result = [];
        $result['state'] = false;

        if($this->is_valid()){
            //check form is valid and save User to DB

            if (!empty($this->id)) {
                // TODO update case
            }
            else {
                //Insert case
                if ($this->_insert()) {
                    $result['state'] = true;
                    $result['user_email'] = $this->getEmail();
                    return $result;
                }
            }
        }else{
            $result['errors'] = $this->errors;
            return $result;
        }
    }

    private function _insert() {
        $dateNow = date('Y-m-d H:i:s', time());
        $sql = '
                INSERT INTO users (username, email, first_name, last_name, password, date_created)
                VALUES (:username, :email, :first_name, :last_name, :password, :date_created) ';
        $params = [
            'username' => $this->_username,
            'email' => $this->_email,
            'first_name' => $this->_first_name,
            'last_name' => $this->_last_name,
            'password' => $this->_password,
            'date_created' => $dateNow
        ];
        self::$db->prepare($sql, $params)->execute();
        if (self::$db->getAffectedRows() > 0) {
            return true;
        }
    }

    /**
     * Check for already registered email (unique constraint)
     */
    private function _checkAlreadyRegisteredEmail(){
        // TODO - check for already registered email
    }

    private function _update() {
        // TODO implement update method
    }

    private function _validateUserName(){
        if (Helper::isEmpty($this->_username)){
            $this->errors['username'] = 'Username can not be empty.';
        }elseif(!Helper::isString($this->_username)){
            $this->errors['username'] = 'Username must be a string value.';
        }
    }

    private function _validateFirstName(){
        if (Helper::isEmpty($this->_first_name)){
            $this->errors['first_name'] = 'First name can not be empty.';
        }elseif(!Helper::isString($this->_first_name)){
            $this->errors['first_name'] = 'First name must be a string value.';
        }
//        elseif(Helper::validateSize($this->_first_name, 1, $this->fields_requirements['_first_name']['max_value_size'])){
//            $this->errors['first_name'] = 'First name must be between 1 and 50 characters';
//        }
    }

    private function _validateLastName(){
        if (Helper::isEmpty($this->_last_name)){
            $this->errors['last_name'] = 'Last name can not be empty.';
        }elseif(!Helper::isString($this->_last_name)){
            $this->errors['last_name'] = 'Last name must be a string value.';
        }
    }

    private function _validateEmail(){
        if(!Helper::isValidEmail($this->_email)){
            $this->errors['email'] = 'Enter valid email address.';
        }
    }

    private function _validatePassword(){
        if (Helper::isEmpty($this->_password)){
            $this->errors['password'] = 'Password can not be empty.';
        }elseif(!Helper::isString($this->_password)){
            $this->errors['password'] = 'Password must be a string value.';
        }
    }

    /**
     * Override parent is_valid method and check validation for current instance
     * @return bool
     */
    public function is_valid()
    {
        $this->_validateFirstName();
        $this->_validateLastName();
        $this->_validateUserName();
        $this->_validateEmail();
        $this->_validatePassword();

        return count($this->errors) === 0;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param mixed $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->_username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->_first_name;
    }

    /**
     * @param mixed $first_name
     * @return User
     */
    public function setFirstName($first_name)
    {
        $this->_first_name = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->_last_name;
    }

    /**
     * @param mixed $last_name
     * @return User
     */
    public function setLastName($last_name)
    {
        $this->_last_name = $last_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Set password. ! USED password_hash - requires PHP 5.5
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        if(!empty($password)){
            $this->_password = password_hash($password, PASSWORD_DEFAULT);
        }else{
            $this->_password = null;
        }

        return $this;


    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->_date_created;
    }

    /**
     * @param mixed $date_created
     * @return User
     */
    public function setDateCreated($date_created)
    {
        $this->_date_created = $date_created;
        return $this;
    }


}