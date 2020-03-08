<?php
declare(strict_types=1);

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cake\TwigView\Test\TestCase\Twig;

use Cake\TestSuite\TestCase;
use Cake\TwigView\Twig\Loader;
use Twig\Error\LoaderError;

/**
 * Class LoaderTest.
 */
class LoaderTest extends TestCase
{
    /**
     * @var Loader
     */
    protected $Loader;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadPlugins(['TestTwigView']);

        $this->Loader = new Loader();
    }

    public function tearDown(): void
    {
        unset($this->Loader);

        $this->removePlugins(['TestTwigView']);

        parent::tearDown();
    }

    public function testGetSource()
    {
        $this->assertSame('TwigView', $this->Loader->getSource('TestTwigView.twig'));
        $this->assertSame('TwigView', $this->Loader->getSource('TestTwigView.twig.twig'));
    }

    public function testGetSourceNonExistingFile()
    {
        $this->expectException(LoaderError::class);

        $this->Loader->getSource('TestTwigView.no_twig');
    }

    public function testGetCacheKeyNoPlugin()
    {
        $this->assertSame(
            TEST_APP . 'templates/layout.twig',
            $this->Loader->getCacheKey('layout')
        );
    }

    public function testGetCacheKeyPlugin()
    {
        $this->assertSame(
            TEST_APP . 'plugins/TestTwigView/templates/twig.twig',
            $this->Loader->getCacheKey('TestTwigView.twig')
        );
        $this->assertSame(
            TEST_APP . 'plugins/TestTwigView/templates/twig.twig',
            $this->Loader->getCacheKey('TestTwigView.twig.twig')
        );
    }

    public function testGetCacheKeyPluginNonExistingFile()
    {
        $this->expectException(LoaderError::class);

        $this->Loader->getCacheKey('TestTwigView.twog');
    }

    public function testIsFresh()
    {
        file_put_contents(TMP . 'TwigViewIsFreshTest', 'TwigViewIsFreshTest');
        $time = filemtime(TMP . 'TwigViewIsFreshTest');

        $this->assertTrue($this->Loader->isFresh(TMP . 'TwigViewIsFreshTest', $time + 5));
        $this->assertTrue(!$this->Loader->isFresh(TMP . 'TwigViewIsFreshTest', $time - 5));

        unlink(TMP . 'TwigViewIsFreshTest');
    }

    public function testIsFreshNonExistingFile()
    {
        $this->expectException(LoaderError::class);

        $this->Loader->isFresh(TMP . 'foobar' . time(), time());
    }
}
