<?php /** @noinspection DuplicatedCode */
/**
 * Mikio CSS/LESS Engine (hardened)
 * @link    http://dokuwiki.org/template:mikio
 * @license GPLv2
 * @author  James Collins
 */

require(__DIR__ . '/inc/polyfill-ctype.php');

if (!class_exists('lessc')) {
    require(__DIR__ . '/inc/stemmechanics/lesserphp/lessc.inc.php');
}

function logInvalidRequest($reason, $input) {
    error_log("[mikio css.php] $reason | input: $input | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
}

function arrayDeepMerge($arr1, $arr2) {
    foreach ($arr2 as $key => $value) {
        if (isset($arr1[$key]) && is_array($arr1[$key]) && is_array($value)) {
            $arr1[$key] = arrayDeepMerge($arr1[$key], $value);
        } else {
            $arr1[$key] = $value;
        }
    }
    return $arr1;
}

try {
    if (!isset($_GET['css'])) {
        http_response_code(404);
        echo "The requested file could not be found";
        exit;
    }

    $themeRoot = realpath(__DIR__ . '/');
    if ($themeRoot === false) {
        throw new RuntimeException('Theme root resolution failed');
    }

    // Only allow CSS/LESS inside these theme subdirectories
    $allowedDirs = [
        realpath($themeRoot . '/assets'),
        realpath($themeRoot . '/styles'),
        realpath($themeRoot . '/css'),
    ];
    $allowedExtensions = ['css', 'less'];

    $css = '';
    $failed = false;

    // Support a comma-separated list like your plugin fix
    $cssFileList = explode(',', $_GET['css']);

    foreach ($cssFileList as $rawInput) {
        // Strip query/hash and basic traversal chars
        $clean = explode('?', $rawInput, 2)[0];
        $clean = trim(str_replace(['..', '\\'], '', $clean));

        if ($clean === '') {
            $failed = true;
            logInvalidRequest('Empty or invalid path', $rawInput);
            continue;
        }

        $resolved = realpath($themeRoot . '/' . ltrim($clean, '/'));
        if (!$resolved || !is_file($resolved)) {
            $failed = true;
            logInvalidRequest('Invalid file path', $rawInput);
            continue;
        }

        $ext = strtolower(pathinfo($resolved, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExtensions, true)) {
            $failed = true;
            logInvalidRequest('Disallowed extension', $rawInput);
            continue;
        }

        // Enforce allowed directories
        $inside = false;
        foreach ($allowedDirs as $dir) {
            if ($dir && strpos($resolved, $dir) === 0) {
                $inside = true;
                break;
            }
        }
        if (!$inside) {
            $failed = true;
            logInvalidRequest('File outside allowed directories', $rawInput);
            continue;
        }

        $css .= file_get_contents($resolved);
    }

    if ($failed) {
        http_response_code(404);
        echo "The requested file could not be found";
        exit;
    }

    // Load style.ini replacements from trusted locations
    $rawVars = [];
    $iniCandidates = [
        $themeRoot . '/style.ini',
        dirname($themeRoot, 3) . '/conf/tpl/mikio/style.ini' ?: null,
        (isset($_SERVER['DOCUMENT_ROOT']) ? ($_SERVER['DOCUMENT_ROOT'] . '/conf/tpl/mikio/style.ini') : null),
    ];

    foreach ($iniCandidates as $ini) {
        if ($ini && is_file($ini)) {
            $parsed = @parse_ini_file($ini, true);
            if (is_array($parsed)) {
                $rawVars = arrayDeepMerge($rawVars, $parsed);
            }
        }
    }

    header('Content-Type: text/css; charset=utf-8');

    $less = new lessc();
    $less->setPreserveComments(false);

    // Map __FOO__ => ini_FOO variables just like before
    $vars = [];
    if (isset($rawVars['replacements']) && is_array($rawVars['replacements'])) {
        foreach ($rawVars['replacements'] as $k => $v) {
            if (strpos($k, '__') === 0 && substr($k, -2) === '__') {
                $vars['ini_' . substr($k, 2, -2)] = $v;
            }
        }
    }
    if ($vars) {
        $less->setVariables($vars);
    }

    echo $less->compile($css);

} catch (Throwable $e) {
    // Log server-side; no path/stack to client
    error_log('[mikio css.php] Exception: ' . $e->getMessage());
    http_response_code(500);
    header('Content-Type: text/css; charset=utf-8');
    echo "/* An error occurred while processing the CSS. */";
}