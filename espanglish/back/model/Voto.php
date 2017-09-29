<?php
class Voto extends ActiveRecord\Model {
	static $belongs_to = array(
    	array('paise')
    );
}