<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\Path;
use kalanis\kw_paths\PathsException;
use kalanis\kw_routed_paths\RoutedPath;
use kalanis\kw_routed_paths\Sources as routeSource;
use kalanis\kw_styles\Interfaces\ILoader;
use kalanis\kw_styles\Loaders\MultiLoader;
use kalanis\kw_styles\Loaders\PhpLoader;
use kalanis\kw_styles\Styles;
use kalanis\kw_styles\StylesException;


class StylesTest extends CommonTestClass
{
    /**
     * @throws StylesException
     */
    public function testGetVirtualFile(): void
    {
        Styles::init(new XLoader());
        $this->assertEquals('abcmnodefpqrghistujklvwx%syz0123%s456', Styles::getFile('abc', 'def'));
    }

    /**
     * @throws StylesException
     */
    public function testNoLoader(): void
    {
        Styles::init(null);
        $this->expectException(StylesException::class);
        Styles::getFile('anything here', 'will die');
    }

    /**
     * @throws PathsException
     * @throws StylesException
     */
    public function testGetRealFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        $routed = new RoutedPath(new routeSource\Arrays([]));
        Styles::init(new PhpLoader($path, $routed));
        $this->assertEquals('/* dummy style file */', Styles::getFile('dummy', 'dummyStyle.css'));
    }

    /**
     * @throws PathsException
     * @throws StylesException
     */
    public function testGetNoFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        $routed = new RoutedPath(new routeSource\Arrays([]));
        Styles::init(new PhpLoader($path, $routed));
        $this->assertEquals('', Styles::getFile('dummy', '**really-not-existing'));
    }

    /**
     * @throws PathsException
     */
    public function testWant(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        $routed = new RoutedPath(new routeSource\Arrays([]));
        Styles::init(new PhpLoader($path, $routed));

        Styles::want('foo', 'abc');
        Styles::want('foo', 'def');
        Styles::want('bar', 'ghi');
        Styles::want('baz', 'jkl');
        $this->assertEquals([
            'foo' => ['abc', 'def', ],
            'bar' => ['ghi', ],
            'baz' => ['jkl', ],
        ], Styles::getAll());
    }

    /**
     * @throws StylesException
     */
    public function testMulti(): void
    {
        $lib = new MultiLoader();
        $this->assertEmpty($lib->load('dummy', '**really-not-known'));
        $lib->addLoader(new XYLoader());
        $this->assertEquals('abc%smnodefpqrghistujklvwxyz%s0123456', $lib->load('anything dummy', 'def'));
    }
}


class XLoader implements ILoader
{
    public function load(string $module, string $path = ''): ?string
    {
        return 'abcmnodefpqrghistujklvwx%syz0123%s456';
    }
}


class XYLoader implements ILoader
{
    public function load(string $module, string $path = ''): ?string
    {
        return 'abc%smnodefpqrghistujklvwxyz%s0123456';
    }
}
