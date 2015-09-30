<?php

namespace models;

/**
 * Interface IEntity which every entity must implement mehotds
 * @package models
 */
interface IEntity{

    /**
     * Declare implementation of init method for new object instance
     * @return mixed
     */
    public function init($id);

    /**
     * is_valid() method which validate properties with logic inside from children
     * @return mixed
     */
    public function is_valid();

    /**
     * Save method with logic inside from children
     * @return mixed
     */
    public function save();
}