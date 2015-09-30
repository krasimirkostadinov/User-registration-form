<?php
//Autoload all classes by PSR-4 specification
require_once(__DIR__ . '/../vendor/autoload.php');

if(!empty($_POST) && !empty($_POST['form_data'])){
    $form_params = [];
    parse_str($_POST['form_data'], $form_params);

    $username = (!empty($form_params['username'])) ? \models\Helper::validateData($form_params['username'], 'string|specialchars') : null;
    $email = (!empty($form_params['email'])) ? \models\Helper::validateData($form_params['email'], 'string|specialchars') : null;
    $first_name = (!empty($form_params['first-name'])) ? \models\Helper::validateData($form_params['first-name'], 'string|specialchars') : null;
    $last_name = (!empty($form_params['last-name'])) ? \models\Helper::validateData($form_params['last-name'], 'string|specialchars') : null;
    $password1 = (!empty($form_params['password1'])) ? $form_params['password1'] : null;
    $password2 = (!empty($form_params['password2'])) ? $form_params['password2'] : null;

    $password = null;
    if($password1 === $password2){
        $password = $password1;
    }

    $user = new \models\User();
    $user->setUsername($username);
    $user->setEmail($email);
    $user->setFirstName($first_name);
    $user->setLastName($last_name);
    $user->setPassword($password);
    $user_result = $user->save();

    echo json_encode($user_result);
}else{
    throw new Exception('No POST data during save user');
}