<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * PHP version 5
 *
 * Copyright (c) 2009 mbarracuda <mbarracuda@gmail.com>,
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    Stagehand_DirectoryCleaner
 * @copyright  2009 mbarracuda <mbarracuda@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version    Release: @package_version@
 * @since      File available since Release 0.1.0
 */

// {{{ Stagehand_PHP_DirectoryCleanerTest

/**
 * Some tests for Stagehand_DirectoryCleaner
 *
 * @package    Stagehand_DirectoryCleaner
 * @copyright  2009 mbarracuda <mbarracuda@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_DirectoryCleanerTest extends PHPUnit_Framework_TestCase
{

    // {{{ properties

    /**#@+
     * @access public
     */

    /**#@-*/

    /**#@+
     * @access protected
     */

    protected $directory;

    /**#@-*/

    /**#@+
     * @access private
     */

    /**#@-*/

    /**#@+
     * @access public
     */

    public function setUp()
    {
        $this->directory = dirname(__FILE__) . '/../../tmp/' . get_class($this);
        mkdir($this->directory);

        touch($this->directory . '/example.txt');

        mkdir($this->directory . '/first');
        mkdir($this->directory . '/first/second');
        touch($this->directory . '/first/foo.txt');
        touch($this->directory . '/first/bar.txt');
        touch($this->directory . '/first/second/baz.txt');
    }

    public function tearDown()
    {
        $cleaner = new Stagehand_DirectoryCleaner();
        $cleaner->setRemovesRoot(true);
        $cleaner->clean($this->directory);
    }

    /**
     * @test
     */
    public function cleanADirectoryRecursively()
    {
        $this->assertFileExists($this->directory . '/example.txt');
        $this->assertFileExists($this->directory . '/first');
        $this->assertFileExists($this->directory . '/first/second');
        $this->assertFileExists($this->directory . '/first/foo.txt');
        $this->assertFileExists($this->directory . '/first/bar.txt');
        $this->assertFileExists($this->directory . '/first/second/baz.txt');

        $cleaner = new Stagehand_DirectoryCleaner();
        $cleaner->clean($this->directory);

        $this->assertFileNotExists($this->directory . '/example.txt');
        $this->assertFileNotExists($this->directory . '/first');
        $this->assertFileNotExists($this->directory . '/first/second');
        $this->assertFileNotExists($this->directory . '/first/foo.txt');
        $this->assertFileNotExists($this->directory . '/first/bar.txt');
        $this->assertFileNotExists($this->directory . '/first/second/baz.txt');
    }

    /**
     * @test
     */
    public function cleanADirectoryNotRecursively()
    {
        $this->assertFileExists($this->directory . '/example.txt');
        $this->assertFileExists($this->directory . '/first');
        $this->assertFileExists($this->directory . '/first/second');
        $this->assertFileExists($this->directory . '/first/foo.txt');
        $this->assertFileExists($this->directory . '/first/bar.txt');
        $this->assertFileExists($this->directory . '/first/second/baz.txt');

        $cleaner = new Stagehand_DirectoryCleaner();
        $cleaner->clean($this->directory, false);

        $this->assertFileNotExists($this->directory . '/example.txt');
        $this->assertFileExists($this->directory . '/first');
        $this->assertFileExists($this->directory . '/first/second');
        $this->assertFileExists($this->directory . '/first/foo.txt');
        $this->assertFileExists($this->directory . '/first/bar.txt');
        $this->assertFileExists($this->directory . '/first/second/baz.txt');
    }

    /**#@-*/

    /**#@+
     * @access protected
     */

    /**#@-*/

    /**#@+
     * @access private
     */

    /**#@-*/

    // }}}
}

// }}}

/*
 * Local Variables:
 * mode: php
 * coding: iso-8859-1
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * indent-tabs-mode: nil
 * End:
 */
