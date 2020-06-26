<?php
/**
 * Mikio CSS Engine
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */
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
}
