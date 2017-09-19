<?php
class Jurado extends ActiveRecord\Model {
	static $has_many = array(
    	array('palcos'),
    	array('barracas')
    );
}