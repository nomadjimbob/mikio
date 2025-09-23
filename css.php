<?php
/**
 * Mikio CSS/LESS Engine
 *
 * @link    http://dokuwiki.org/template:mikio
 * @license GPLv2
 * @author  James Collins
 */

require(__DIR__ . '/inc/polyfill-ctype.php');

if (!class_exists('lessc')) {
    require(__DIR__ . '/inc/stemmechanics/lesserphp/lessc.inc.php');
}

function logInvalidRequest($reason, $input) {
    error_log("[css.php] $reason | input: $input | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
}

try {
    if (!isset($_GET['css'])) {
        http_response_code(404);
        echo "The requested file could not be found";
        exit;
    }

    $cssFileList = explode(',', $_GET['css']);
    $pluginRoot = realpath(__DIR__ . '/');
    $allowedDirs = [
        realpath($pluginRoot . '/assets'),
        realpath($pluginRoot . '/styles')
    ];
    $allowedExtensions = ['css', 'less'];
    $css = '';
    $failed = false;

    foreach ($cssFileList as $rawInput) {
        // Strip query/hash
        $cleanInput = explode('?', $rawInput, 2)[0];
        $cleanInput = trim(str_replace(['..', '\\'], '', $cleanInput));
        if (empty($cleanInput)) {
            $failed = true;
            logInvalidRequest("Empty or invalid path", $rawInput);
            continue;
        }

        $resolvedPath = realpath($pluginRoot . '/' . $cleanInput);
        $ext = pathinfo($resolvedPath, PATHINFO_EXTENSION);

        if (
            !$resolvedPath ||
            !file_exists($resolvedPath) ||
            !in_array($ext, $allowedExtensions, true)
        ) {
            $failed = true;
            logInvalidRequest("Invalid file or extension", $rawInput);
            continue;
        }

        // Confirm file is within allowed directories
        $allowed = false;
        foreach ($allowedDirs as $dir) {
            if (strpos($resolvedPath, $dir) === 0) {
                $allowed = true;
                break;
            }
        }

        if (!$allowed) {
            $failed = true;
            logInvalidRequest("File outside allowed directory", $rawInput);
            continue;
        }

        $css .= file_get_contents($resolvedPath);
    }

    if ($failed) {
        http_response_code(404);
        echo "The requested file could not be found";
        exit;
    }

    header('Content-Type: text/css; charset=utf-8');

    $less = new lessc();
    $less->setPreserveComments(false);

    // Optional variables (future-proofed)
    $rawVars = [];
    $vars = [];
    if (isset($rawVars['replacements'])) {
        foreach ($rawVars['replacements'] as $key => $val) {
            if (strpos($key, '__') === 0 && substr($key, -2) === '__') {
                $vars['ini_' . substr($key, 2, -2)] = $val;
            }
        }
    }

    if (!empty($vars)) {
        $less->setVariables($vars);
    }

    echo $less->compile($css);

} catch (Exception $e) {
    error_log("[css.php] Exception: " . $e->getMessage());
    http_response_code(500);
    header('Content-Type: text/css; charset=utf-8');
    echo "/* An error occurred while processing the CSS. */";
}