<?php

namespace SilexMemcache\Tests\Extension;

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

use SilexMemcache\MemcacheExtension;

class MemcacheExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('Memcache')) {
            $this->markTestSkipped('Memcache is not loaded.');
        }
        if (!class_exists('Memcached')) {
            $this->markTestSkipped('Memcached is not loaded.');
        }
    }

    public function testRegisterMemcached()
    {
        $app = new Application();
        $app->register(new MemcacheExtension(), array(
            'memcache.library'    => 'memcached',
            'memcache.server' => array(
                array('localhost', 11211)
            )
        ));

        $app->get('/', function() use($app) {
            $app['memcache'];
        });
        $request = Request::create('/');
        $app->handle($request);

        $this->assertInstanceOf('Memcached', $app['memcache']);
    }

    public function testRegisterMemcache()
    {
        $app = new Application();
        $app->register(new MemcacheExtension(), array(
            'memcache.library'    => 'memcache',
            'memcache.server' => array(
                array('localhost', 11211)
            )
        ));

        $app->get('/', function() use($app) {
            $app['memcache'];
        });
        $request = Request::create('/');
        $app->handle($request);

        $this->assertInstanceOf('Memcache', $app['memcache']);
    }

    public function testSetAndGetMemcache()
    {
        $app = new Application();
        $app->register(new MemcacheExtension(), array(
            'memcache.library'    => 'memcache',
            'memcache.server' => array(
                array('localhost', 11211)
            )
        ));

        $app->get('/', function() use($app) {
            $app['memcache'];
        });
        $request = Request::create('/');
        $app->handle($request);

        $testvalue = 'my_test_value';
        $app['memcache']->set('my_test_key', $testvalue);

        $this->assertSame($testvalue, $app['memcache']->get('my_test_key'));
    }

    public function testSetAndGetMemcached()
    {
        $app = new Application();
        $app->register(new MemcacheExtension(), array(
            'memcache.library'    => 'memcached',
            'memcache.server' => array(
                array('localhost', 11211)
            )
        ));

        $app->get('/', function() use($app) {
            $app['memcache'];
        });
        $request = Request::create('/');
        $app->handle($request);

        $testvalue = 'my_test_value';
        $app['memcache']->set('my_test_key', $testvalue);

        $this->assertSame($testvalue, $app['memcache']->get('my_test_key'));
    }


}
