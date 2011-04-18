<?php

abstract class Bayonet_Layout
{
    function OpenContent()
    {
        echo "<div class=\"contentBorder1\">";
        echo "<div class=\"contentBorder2\">";
    }

    function CloseContent()
    {
        echo "</div>";
        echo "</div>";
    }
}

class Bayonet_Theme extends Bayonet_Layout
{
    static public $index;
    static public $header;
    static public $footer;

    static public $name;
    static public $root_path;
    static public $include_path;
    static public $image_path;
    static public $config_path;
    static public $config;
    static public $primary_css;

    static function init()
    {
        if (!isset($_GET['theme']))
        {
            self::$name = Bayonet_Config::$ini['site']['theme'];
        }
        else
        {
            self::$name = $_GET['theme'];
        }

        decho('Initializing theme variables for \'' . self::$name . '\'');
        self::$root_path = dirname(BAYONET_ROOT) . '/themes/' . self::$name;
        self::$include_path = self::$root_path . '/include';
        self::$image_path = self::$root_path . '/images';
        self::$primary_css = self::$include_path . '/primary.css';
        self::$config_path = self::$include_path . '/theme.ini';

        if (!self::is_valid())
        {
            die('Theme failed during initialization.');
        }
        self::$config = parse_ini_file(self::$config_path, true);

        self::$index = self::$root_path . '/index.php';
        self::$header = self::$root_path . '/header.php';
        self::$footer = self::$root_path . '/footer.php';

        //decho(get_class_vars(Bayonet_Theme)); //do not re-enable this
        self::load();
    }

    static private function is_valid()
    {
        if (file_exists(self::$root_path) && file_exists(self::$include_path) &&
            file_exists(self::$config_path)) return true;
        else  return false;
    }

    static function load()
    {
        global $db, $config;
        decho("Loading theme: '" . self::$name . "'");
        require self::$index;
    }
}

class Bayonet_Config
{
    static $ini;
    static function init()
    {
        decho('Parsing configuration data');
        if (file_exists(BAYONET_CONFIG))
        {
            self::$ini = parse_ini_file(BAYONET_CONFIG, true);
            decho(self::$ini);
        }
        else  die(BAYONET_CONFIG . ' not found');
    }
}

class Bayonet
{
    static function init()
    {
        global $db, $config;
        Bayonet_Config::init();

        // Set globally referenced configuration and database variables
        $config = Bayonet_Config::$ini;
        $db = new Bayonet_SQL();

        //Connect to the MySQL server
        $db->Connect($config['sql']['hostname'], $config['sql']['username'], $config['sql']['password']);
        $db->Select_db($config['sql']['database']);

        decho('Initializing Bayonet');
        Bayonet_Theme::init();
    }
}


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

        if (!is_array($keys)) return array();

        foreach ($keys as $key => $value)
        {
            if (!empty($value)) $good[$key] = $value;
            else  $bad[$key] = $value;
        }

        $data = array('set' => $good, 'unset' => $bad);

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

    function textField($extern_name, $value = null, $isPassword = false, $size = null,
        $max = null)
    {
        $type = 'text';
        if ($isPassword) $type = 'password';

        $value = filter_var($value, FILTER_SANITIZE_STRING);
        echo "<input type=\"{$type}\" name=\"{$extern_name}\" value=\"$value\" size=\"{$size}\" maxLength=\"{$max}\" />\n";
    }

    function radioButton($extern_name, $value, $isChecked = false)
    {
        if ($isChecked)
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
        if ($isChecked)
        {
            echo "<input type=\"checkbox\" name=\"{$extern_name}\" value=\"$value\" checked=\"checked\"/>\n";
        }
        else
        {
            echo "<input type=\"checkbox\" name=\"{$extern_name}\" value=\"$value\" />\n";
        }
    }

    function dropDown($extern_name, $values = array('None'), $select = null)
    {
        $selectIterator = 1;

        echo "<select name=\"{$extern_name}\">\n";
        foreach ($values as $option => $text)
        {
            if (!is_null($select) && $selectIterator !== (int)$select)
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

    function textArea($extern_name, $rows = 10, $cols = 30, $value = null)
    {
        $value = filter_var($value, FILTER_SANITIZE_STRING);
        echo "<textarea name=\"{$extern_name}\" rows=\"$rows\" cols=\"$cols\">{$value}</textarea>\n";
    }
}

?>