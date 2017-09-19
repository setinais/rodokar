<?php
class Paise extends ActiveRecord\Model {
	static $has_many = array(
	    array('palcos'),
	    array('barracas')
   );
}