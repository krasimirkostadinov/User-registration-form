<?php
/**
 * Created by PhpStorm.
 * User: krasimir
 * Date: 15-9-5
 * Time: 12:56
 */

namespace models;


class Helper
{

    /**
     * Validate is empty given data
     * @param string $data
     * @return bool
     */
    public static function isEmpty($data){
        return (empty(trim($data))) ? true : false;
    }

    /**
     * Validate is string given $data
     * @param string $data
     * @return bool
     */
    public static function isString($data){
        return (is_string($data)) ? true : false;
    }

    /**
     * @param $data
     * @return bool
     */
    public static function isInt($data){
        return (is_int($data)) ? true : false;
    }

    /**
     *
     * Validate is valid email given data
     * @param string $email
     * @return bool
     */
    public static function isValidEmail($email){
        return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
    }


    /**
     * Validate field size are in range
     * @param string $data
     * @param int $min
     * @param int $max
     * @return bool
     */
    public static function validateSize($data, $min = 0, $max){
        $string_count = strlen($data);
        return ($string_count > $min && $string_count <= $max);
    }

    /**
     *
     * @param string $data
     * @param string $types int|string|trim|strip_tags|specialchars
     * @return string
     */
    public static function validateData($data, $types) {
        $types = explode('|', $types);
        if (is_array($types)) {
            foreach ($types as $v) {
                if ($v === 'int') {
                    $data = (int) $data;
                }
                if ($v === 'string') {
                    $data = (string) $data;
                }
                if ($v === 'trim') {
                    $data = trim($data);
                }
                if ($v === 'strip_tags') {
                    $data = strip_tags($data);
                }
                if ($v === 'specialchars') {
                    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
                }
                if ($v === 'filter_special_chars') {
                    $data = str_replace(str_split('<>"&*~|<>#@$%^()!?+-=/\\`.,:;_' . "'" . ''), ' ', $data);
                }
            }
        }
        return $data;
    }

}