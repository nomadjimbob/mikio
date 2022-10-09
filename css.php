<?php
/**
 * Mikio CSS/LESS Engine
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

require(dirname(__FILE__) . '/inc/polyfill-ctype.php');

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

if(!function_exists('platformSlashes')) {
	function platformSlashes($path) {
		return str_replace('/', DIRECTORY_SEPARATOR, $path);
	}
}

try {
    $lesscLib = platformSlashes('../../../vendor/marcusschwarz/lesserphp/lessc.inc.php');
    if(!file_exists($lesscLib))
        $lesscLib = platformSlashes($_SERVER['DOCUMENT_ROOT'] . '/vendor/marcusschwarz/lesserphp/lessc.inc.php');
    if(!file_exists($lesscLib))
        $lesscLib = platformSlashes('../../../../../app/dokuwiki/vendor/marcusschwarz/lesserphp/lessc.inc.php');
    if(!file_exists($lesscLib))
        $lesscLib = platformSlashes($_SERVER['DOCUMENT_ROOT'] . '/app/dokuwiki/vendor/marcusschwarz/lesserphp/lessc.inc.php');

    if(file_exists($lesscLib)) {
        @require_once($lesscLib);

        if(isset($_GET['css'])) {
            $baseDir = platformSlashes(dirname(__FILE__) . '/');
            $cssFile = platformSlashes(realpath($baseDir . $_GET['css']));

            if(strpos($cssFile, $baseDir) === 0 && file_exists($cssFile)) {
                $rawVars = Array();
                $file = 'style.ini';
                if(file_exists($file)) {
                    $rawVars = arrayDeepMerge($rawVars, parse_ini_file($file, TRUE));
                }

                $file = platformSlashes('../../../conf/tpl/mikio/style.ini');
                if(file_exists($file)) {
                    $rawVars = arrayDeepMerge($rawVars, parse_ini_file($file, TRUE));
                }

                $file = ($_SERVER['DOCUMENT_ROOT'] . '/conf/tpl/mikio/style.ini');
                if(file_exists($file)) {
                    $rawVars = arrayDeepMerge($rawVars, parse_ini_file($file, TRUE));
                }

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
        throw new Exception('Mikio could not find the LESSC engine in DokuWiki');
    }
}
catch(Exception $e) {
    // echo $e;
    header('Content-Type: text/css; charset=utf-8');
    include(dirname(__FILE__) . '/assets/mikio.css');
}

function arrayDeepMerge($arr1, $arr2) {
    foreach ($arr2 as $key => $value){
        if(array_key_exists($key, $arr1)) {
            $arr1[$key] = array_merge($arr1[$key], $value);
        } else {
            $arr1[$key] = $value;
        }
    }
    return $arr1;
}