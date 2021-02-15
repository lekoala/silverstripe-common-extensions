<?php

namespace LeKoala\CommonExtensions\Test;

use SilverStripe\Dev\SapphireTest;
use LeKoala\CommonExtensions\IPExtension;

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
        $model = new Test_CommonExtensions();
        $model->write();
        $this->assertNotEmpty($model->Ip);

        $ip = '127.0.0.1';
        $model->Ip = $ip;
        $this->assertEquals($ip, $model->Ip);
    }
}
