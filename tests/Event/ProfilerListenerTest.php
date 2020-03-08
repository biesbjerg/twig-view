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

namespace Cake\TwigView\Test\Event;

use Cake\TwigView\Event\ConstructEvent;
use Cake\TwigView\Event\ProfilerListener;
use Cake\TwigView\Test\TestCase;
use Cake\TwigView\Twig\Extension\Profiler;
use Cake\TwigView\View\TwigView;
use Twig\Environment;

/**
 * Class ProfilerListenerTest.
 * @package Cake\TwigView\Test\Event
 */
class ProfilerListenerTest extends TestCase
{
    public function testImplementedEvents()
    {
        $eventsList = (new ProfilerListener())->implementedEvents();
        $this->assertIsArray($eventsList);
        $this->assertSame(1, count($eventsList));
    }

    public function testConstruct()
    {
        $twig = $this->prophesize(Environment::class);
        $twig->hasExtension(Profiler::class)->shouldBeCalled()->willReturn(true);

        $twigView = new TwigView();
        (new ProfilerListener())->construct(ConstructEvent::create($twigView, $twig->reveal()));
    }
}
