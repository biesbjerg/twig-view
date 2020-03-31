<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * Copyright (c) 2014 Cees-Jan Kiewiet
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

namespace Cake\TwigView\Test\TestCase;

use Cake\TestSuite\TestCase;
use TestApp\View\AppView;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class TwigViewTest.
 */
class TwigViewTest extends TestCase
{
    /**
     * Test rendering simple twig template.
     *
     * @return void
     */
    public function testRenderSimpleTemplate()
    {
        $view = new AppView();
        $output = $view->render('simple', false);

        $this->assertSame('underscore_me', $output);
    }

    /**
     * Test rendering simple twig template with layout.
     *
     * @return void
     */
    public function testRenderSimpleTemplateWithLayout()
    {
        $view = new AppView();
        $output = $view->render('simple');

        $this->assertSame('underscore_me', $output);
    }

    /**
     * Test rendering template with layout.
     *
     * @return void
     */
    public function testRenderLayoutWithElements()
    {
        $view = new AppView();
        $output = $view->render('Blog/index');

        $this->assertSame('blog_entry', $output);
    }

    /**
     * Tests a twig file that throws internal exception throw a Twig exception with message.
     *
     * @return void
     */
    public function testThrowWrappedException()
    {
        $this->expectException(RuntimeError::class);
        $this->expectExceptionMessage('Something is missing');

        $view = new AppView();
        $view->render('exception', false);
    }

    /**
     * Tests invalid twig template throws exception.
     *
     * @return void
     */
    public function testThrowSyntaxError()
    {
        $this->expectException(SyntaxError::class);

        $view = new AppView();
        $view->render('syntaxerror', false);
    }
}