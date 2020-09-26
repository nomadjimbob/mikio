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


try {
    $lesscLib = '../../../vendor/marcusschwarz/lesserphp/lessc.inc.php';
    if(file_exists($lesscLib)) {
        require_once($lesscLib);

        if(isset($_GET['css'])) {
            $baseDir = dirname(__FILE__) . '/';
            $cssFile = realpath($baseDir . $_GET['css']);

            if(strpos($cssFile, $baseDir) === 0 && file_exists($cssFile)) {
                $lastModified = filemtime($cssFile);
                $eTagFile = md5_file($cssFile);
                $eTagHeader = (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : FALSE);

                header('Content-Type: text/css; charset=utf-8');
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');
                header('Etag: ' . $eTagFile);
                header('Cache-Control: public, max-age=604800, immutable');

                if(@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $lastModified || $eTagHeader == $eTagFile) {
                    header('HTTP/1.1 304 Not Modified');
                    exit;
                }
                
                $css = file_get_contents($cssFile);

                $less = new lessc();
                $less->setPreserveComments(false);
                
                if(file_exists('style.ini')) {
                    $overrideStyle = '../../../conf/tpl/mikio/style.ini';

                    $vars = Array();
                    $rawVars = parse_ini_file('style.ini', TRUE);
                    
                    if(file_exists($overrideStyle)) {
                        $userVars = parse_ini_file($overrideStyle, TRUE);
                        $rawVars = associativeMerge($rawVars, $userVars);
                    }
                  
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
                }
                
                $css = $less->compile($css);

				$accept_encoding = @getallheaders()['Accept-Encoding'];
     	        if($accept_encoding && preg_match('/ *gzip *,?/', $accept_encoding)) {
               	    header('Content-Encoding: gzip');
                		echo gzencode($css);
            	} else {
                		echo $css;
                }
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
    header('HTTP/1.500 Internal Server Error');
    echo $e;
}

function associativeMerge($base, $addition)
{
    $result = $base;

    // if(is_array($base) && is_array($addition)) {
    //     foreach($addition as $key=>$value) {
    //         if(is_array($value)) {
    //             $result[$key] = associativeMerge($result[$key], $value);
	// 		} else {
	// 			$result[$key] = $value;
	// 		}
    //     }
    // }

    return $result;
}

