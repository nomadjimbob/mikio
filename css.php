<?php
/**
 * Mikio CSS/LESS Engine
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

if(!function_exists('getallheaders')) {
	function getallheaders() {
		$headers = [];
		foreach($_SERVER as $name => $value) {
			if(substr($name, 0, 5) == 'HTTP_') {
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}
}

if(!function_exists('ctype_alnum')) {
    function ctype_alnum($var) {
        return preg_match('/^[a-zA-Z0-9]+$/', $var);
    }
}

if(!function_exists('ctype_alpha')) {
    function ctype_alpha($var) {
        return preg_match('/^[a-zA-Z]+$/', $var);
    }
}

if(!function_exists('ctype_cntrl')) {
    function ctype_cntrl($var) {
        return preg_match('/^[\x00-\x1F\x7F]+$/', $var);
    }
}

if(!function_exists('ctype_digit')) {
    function ctype_digit($var) {
        return preg_match('/^[0-9]+$/', $var);
    }
}

if(!function_exists('ctype_graph')) {
    function ctype_graph($var) {
        return preg_match('/^[\x20-\x7E\x80-\xFF]+$/', $var);
    }
}

if(!function_exists('ctype_lower')) {
    function ctype_lower($var) {
        return preg_match('/^[a-z]+$/', $var);
    }
}

if(!function_exists('ctype_print')) {
    function ctype_print($var) {
        return preg_match('/^[\x20-\x7E\x80-\xFF]+$/', $var);
    }
}

if(!function_exists('ctype_punct')) {
    function ctype_punct($var) {
        return preg_match('/^[^\w\s]+$/', $var);
    }
}

if(!function_exists('ctype_space')) {
    function ctype_space($var) {
        return preg_match('/^[\r\t\n]+$/', $var);
    }
}

if(!function_exists('ctype_upper')) {
    function ctype_upper($var) {
        return preg_match('/^[A-Z]+$/', $var);
    }
}

if(!function_exists('ctype_xdigit')) {
    function ctype_upper($var) {
        return preg_match('/^[0-9A-Fa-f]+$/', $var);
    }
}

try {
    if(!function_exists('ctype_digit')) {
        if(isset($_GET['css'])) {
            $baseDir = dirname(__FILE__) . '/';
            $cssFile = realpath($baseDir . $_GET['css']);
            if(strtolower(substr($cssFile, -5)) == '.less') {
                $cssFile = substr($cssFile, 0, -5) . '.css';
                if(file_exists($cssFile)) {
                    echo file_get_contents($cssFile);
                    exit;
                }
            }
        }

        throw new Exception('ctype extension not installed');
    }

    $lesscLib = '../../../vendor/marcusschwarz/lesserphp/lessc.inc.php';
    if(!file_exists($lesscLib))
        $lesscLib = '../../../../../app/dokuwiki/vendor/marcusschwarz/lesserphp/lessc.inc.php';

    if(file_exists($lesscLib)) {
        @require_once($lesscLib);

        if(isset($_GET['css'])) {
            $baseDir = dirname(__FILE__) . '/';
            $cssFile = realpath($baseDir . $_GET['css']);

            if(strpos($cssFile, $baseDir) === 0 && file_exists($cssFile)) {
                $rawVars = Array();
                $file = 'style.ini';
                if(file_exists($file)) $rawVars = array_merge($rawVars, parse_ini_file($file, TRUE));

                $file = '../../../conf/tpl/mikio/style.ini';
                if(file_exists($file)) $rawVars = array_merge($rawVars, parse_ini_file($file, TRUE));

                $css = file_get_contents($cssFile);

                header('Content-Type: text/css; charset=utf-8');

                $less = new lessc();
                $less->setPreserveComments(false);
                
                $vars = Array();
                if(isset($rawVars['replacements'])) {
                    foreach($rawVars['replacements'] as $key=>$val) {
                        if(substr($key, 0, 2) == '__' && substr($key, -2) == '__') {
                            $vars['ini_' . substr($key, 2, -2)] = $val;
                        }
                    }
                }

                if(count($vars) > 0) {
                    $less->setVariables($vars);
                }
                
                $css = $less->compile($css);
                echo $css;
            } else {
                header('HTTP/1.1 404 Not Found'); 
                echo "The requested file could not be found";              
            }
        } else {
            header('HTTP/1.1 404 Not Found'); 
            echo "The requested file could not be found";              
        }
    } else {
        throw new Exception('Lessc library not found');
    }
}
catch(Exception $e) {    
    header('HTTP/1.1 500 Internal Server Error');
    echo $e;
}
