<?php

define('PASSWORD', true);
define('NO_PASSWORD', false);
define('CHECKED', true);

class BayonetForm
{
	static public $request;
	
	public function __construct($action, $method)
	{
		$this->request = $_POST;
		echo "<form action=\"$action\" method=\"$method\">\n";
	}
	
	public function __destruct()
	{
		echo "</form>\n";
	}
	
	function getKeyStates($keys)
	{
		$good = array();
		$bad = array();
		
		if(!is_array($keys))
			return array();
			
		foreach($keys as $key => $value)
		{
			if(!empty($value))
				$good[$key] = $value;
			else
				$bad[$key] = $value;
		}
		
		$data = array(
			'set' => $good,
			'unset' => $bad
		);
		
		return $data;
	}
	
	function verify($submit_key)
	{
		return $this->verifySubmit($submit_key);
	}
	
	function verifySubmit($submit_key)
	{
		return isset($this->request[$submit_key]) ? true : false;
	}
	
	function button($extern_name, $value, $text = "Button")
	{
		echo "<button name=\"{$extern_name}\" value=\"{$value}\">{$text}</button>\n";
	}
	
	function submitButton($extern_name, $value = "Submit")
	{
		echo "<input type=\"submit\" name=\"{$extern_name}\" value=\"{$value}\" />\n";	
	}
	
	function reset($value = "Reset")
	{
		echo "<input type=\"reset\" value=\"{$value}\" />\n";
	}
	
	function textField($extern_name, $value = NULL, $isPassword = false)
	{
		$type = 'text';
		if($isPassword) $type = 'password';
		
		$value = filter_var($value, FILTER_SANITIZE_STRING);
		echo "<input type=\"{$type}\" name=\"{$extern_name}\" value=\"$value\" />\n";	
	}
	
	function radioButton($extern_name, $value, $isChecked = false)
	{
		if($isChecked)
		{
			echo "<input type=\"radio\" name=\"{$extern_name}\" value=\"$value\" checked=\"checked\"/>\n";
		}
		else
		{
			echo "<input type=\"radio\" name=\"{$extern_name}\" value=\"$value\" />\n";
		}
	}
	
	function checkBox($extern_name, $value, $isChecked = false)
	{
		if($isChecked)
		{
			echo "<input type=\"checkbox\" name=\"{$extern_name}\" value=\"$value\" checked=\"checked\"/>\n";
		}
		else
		{
			echo "<input type=\"checkbox\" name=\"{$extern_name}\" value=\"$value\" />\n";
		}
	}
	
	function dropDown($extern_name, $values = array('None'), $select = NULL)
	{
		$selectIterator = 1;
		
		echo "<select name=\"{$extern_name}\">\n";
		foreach($values as $option => $text)
		{
			if(!is_null($select) && $selectIterator !== (int)$select)
			{
				echo "<option value=\"{$option}\">{$text}</option>\n";
			}
			else
			{
				echo "<option value=\"{$option}\" selected=\"selected\">{$text}</option>\n";
			}
			$selectIterator++;
		}	
		echo "</select>\n";
	}
	
	function textArea($extern_name, $rows = 10, $cols = 30, $value = NULL)
	{
		$value = filter_var($value, FILTER_SANITIZE_STRING);
		echo "<textarea name=\"{$extern_name}\" rows=\"$rows\" cols=\"$cols\">{$value}</textarea>\n";
	}
}

?>