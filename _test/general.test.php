<?php

namespace dokuwiki\tpl\mikio\test;

use dokuwiki\template\mikio\mikio;
use DokuWikiTest;

/**
 * General tests for the mikio template
 *
 * @group tpl_mikio
 * @group plugins
 */
class general_tpl_mikio_test extends DokuWikiTest
{

    /**
     * Simple test to make sure the template.info.txt is in correct format
     */
    public function test_templateinfo()
    {
        $file = __DIR__ . '/../template.info.txt';
        $this->assertFileExists($file);

        $info = confToHash($file);

        $this->assertArrayHasKey('base', $info);
        $this->assertArrayHasKey('author', $info);
        $this->assertArrayHasKey('email', $info);
        $this->assertArrayHasKey('date', $info);
        $this->assertArrayHasKey('name', $info);
        $this->assertArrayHasKey('desc', $info);
        $this->assertArrayHasKey('url', $info);

        $this->assertEquals('mikio', $info['base']);
        $this->assertRegExp('/^https?:\/\//', $info['url']);
        $this->assertTrue(mail_isvalid($info['email']));
        $this->assertRegExp('/^\d\d\d\d-\d\d-\d\d$/', $info['date']);
        $this->assertTrue(false !== strtotime($info['date']));
    }

    /**
     * Test to ensure that every conf['...'] entry in conf/default.php has a corresponding meta['...'] entry in
     * conf/metadata.php.
     */
    public function test_tpl_conf_and_meta_exists(): void
    {
        global $conf, $meta;

        $conf_existing_keys = [];
        if(!is_null($conf)) {
            $conf_existing_keys = array_keys($conf);
        }

        $conf_file = __DIR__ . '/../conf/default.php';

        if (file_exists($conf_file)) {
            include $conf_file;
        }

        $meta_existing_keys = [];
        if(!is_null($meta)) {
            $meta_existing_keys = array_keys($meta);
        }

        $meta_file = __DIR__ . '/../conf/metadata.php';

        if (file_exists($meta_file)) {
            include $meta_file;
        }

        $this->assertEquals(
            gettype($conf),
            gettype($meta),
            'Both conf/default.php and conf/metadata.php have to exist and contain the same keys.'
        );

        if (!is_null($conf) && !is_null($meta)) {
            foreach ($conf as $key => $value) {
                if(in_array($key, $conf_existing_keys, true)) {
                    continue;
                }

                $this->assertArrayHasKey(
                    $key,
                    $meta,
                    'Key $meta[\'' . $key . '\'] missing in conf/metadata.php'
                );
            }

            foreach ($meta as $key => $value) {
                if(in_array($key, $meta_existing_keys, true)) {
                    continue;
                }

                $this->assertArrayHasKey(
                    $key,
                    $conf,
                    'Key $conf[\'' . $key . '\'] missing in conf/default.php'
                );
            }
        }
    }

    /**
     * Test to ensure that every conf['...'] entry in conf/default.php has a corresponding lang['...'] entry in
     * lang/../setting.php.
     */
    public function test_tpl_lang_settings_conf_exists(): void
    {
        global $conf, $lang;

        $conf_existing_keys = [];
        if(!is_null($conf)) {
            $conf_existing_keys = array_keys($conf);
        }

        $conf_file = __DIR__ . '/../conf/default.php';

        $this->assertFileExists(
            $conf_file,
            'conf/default.php has to exist.'
        );

        include $conf_file;

        if (!is_null($conf)) {
            $lang_dir = __DIR__ . '/../lang/';
            $lang_dir_codes = scandir($lang_dir);

            $lang_orig_keys = array_keys($lang);

            foreach ($lang_dir_codes as $lang_code) {
                if($lang_code !== '.' && $lang_code !== '..' && is_dir($lang_dir . $lang_code)) {
                    $lang_file_path = $lang_dir . $lang_code . '/settings.php';
                    $this->assertFileExists(
                        $lang_file_path,
                        'lang/' . $lang_code . '/lang.php has to exist.'
                    );

                    include $lang_file_path;

                    foreach ($conf as $key => $value) {
                        if(in_array($key, $conf_existing_keys, true)) {
                            continue;
                        }

                        $this->assertArrayHasKey(
                            $key,
                            $lang,
                            'Key $lang[\'' . $key . '\'] missing in lang/' . $lang_code . '/lang.php'
                        );
                    }

                    foreach(array_keys($lang) as $lang_key) {
                        if(in_array($lang_key, $lang_orig_keys, true)) {
                            continue;
                        }

                        unset($lang[$lang_key]);
                    }
                }
            }
        }
    }

    /**
     * Test to ensure that every lang['...'] entry in lang/../lang.php has a corresponding lang['...'] entry in
     * lang/en/lang.php.
     */
    public function test_tpl_lang_exists_in_non_en_lang(): void
    {
        global $lang;

        $lang_dir = __DIR__ . '/../lang/';

        $lang_existing_keys = [];
        if(!is_null($lang)) {
            $lang_existing_keys = array_keys($lang);
        }

        $lang_en_file = $lang_dir . 'en/lang.php';

        $this->assertFileExists(
            $lang_en_file,
            'lang/en/lang.php has to exist.'
        );

        include $lang_en_file;

        $lang_en_keys = array_diff(array_keys($lang), $lang_existing_keys);
        foreach($lang_en_keys as $lang_key) {
            unset($lang[$lang_key]);
        }

        $lang_dir_codes = scandir($lang_dir);

        foreach ($lang_dir_codes as $lang_code) {
            if($lang_code !== '.' && $lang_code !== '..' && $lang_code !== 'en' && is_dir($lang_dir . $lang_code)) {
                $lang_file_path = $lang_dir . $lang_code . '/lang.php';
                $this->assertFileExists(
                    $lang_file_path,
                    'lang/' . $lang_code . '/lang.php has to exist.'
                );

                include $lang_file_path;

                foreach ($lang_en_keys as $key) {
                    $this->assertArrayHasKey(
                        $key,
                        $lang,
                        'Key $lang[\'' . $key . '\'] missing in lang/' . $lang_code . '/lang.php'
                    );

                    unset($lang[$key]);
                }
            }
        }
    }

    /**
     * Test to ensure that the mikio class is a singleton
     */
    public function test_singleton_pattern()
    {
        $instance1 = mikio::getInstance();
        $instance2 = mikio::getInstance();
        $this->assertSame($instance1, $instance2);
    }
}
