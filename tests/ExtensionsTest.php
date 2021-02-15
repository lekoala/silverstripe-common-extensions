<?php

namespace LeKoala\CommonExtensions\Test;

use SilverStripe\Dev\SapphireTest;
use LeKoala\CommonExtensions\IPExtension;
use SilverStripe\Control\Controller;

class ExtensionsTest extends SapphireTest
{
    /**
     * Defines the fixture file to use for this test class
     * @var string
     */
    protected static $fixture_file = 'Test_CommonExtensions.yml';

    protected static $extra_dataobjects = array(
        Test_CommonExtensions::class,
    );

    public function testHasExtensions()
    {
        $model = new Test_CommonExtensions();

        $this->assertTrue($model->hasExtension(IPExtension::class));
    }

    public function testIPExtension()
    {
        $controller = Controller::curr();

        $model = new Test_CommonExtensions();
        $model->write();
        if ($controller) {
            $this->assertNotEmpty($model->IP);
        }

        $ip = '127.0.0.1';
        $model->IP = $ip;
        $this->assertEquals($ip, $model->IP);
    }
}
