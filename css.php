<?php /** @noinspection DuplicatedCode */
/**
 * Mikio CSS/LESS Engine
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

require(dirname(__FILE__) . '/inc/polyfill-ctype.php');

if(!class_exists('lessc')) {
    require(dirname(__FILE__) . '/inc/stemmechanics/lesserphp/lessc.inc.php');
}

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
}
catch(Exception $e) {
    header('Content-Type: text/css; charset=utf-8');
    $cssFile = file_get_contents(dirname(__FILE__) . '/assets/mikio.css');
    $exceptionComment = "\n\n/** An exception occurred in the Mikio Less engine:\n\n " . $e->getMessage() . "\n\n*/";

    // Find the position of the first comment in the CSS file
    $pos = strpos($cssFile, '*/');

    // Insert the exception comment after the first comment
    $modifiedCSSFile = substr_replace($cssFile, $exceptionComment, $pos + 2, 0);

    echo $modifiedCSSFile;
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