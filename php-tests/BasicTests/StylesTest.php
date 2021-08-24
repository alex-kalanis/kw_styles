<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\Path;
use kalanis\kw_styles\Interfaces\ILoader;
use kalanis\kw_styles\Loaders\PhpLoader;
use kalanis\kw_styles\Styles;
use kalanis\kw_styles\StylesException;


class StylesTest extends CommonTestClass
{
    public function testLoaderException(): void
    {
        $loader = new PhpLoader();
        $this->expectException(StylesException::class);
        $loader->load('dummy', 'file');
    }

    public function testGetVirtualFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot('/tmp/none');
        Styles::init($path);
        Styles::reset($path, new XLoader());
        $this->assertEquals('abcmnodefpqrghistujklvwx%syz0123%s456', Styles::getFile('abc', 'def'));
    }

    public function testGetRealFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        Styles::reset($path);
        $this->assertEquals('/* dummy style file */', Styles::getFile('dummy', 'dummyStyle.css'));
    }

    public function testGetNoFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        Styles::reset($path);
        $this->assertEquals('', Styles::getFile('dummy', '**really-not-existing'));
    }

    public function testWant(): void
    {
        $path = new Path();
        $path->setDocumentRoot('/tmp/none');
        Styles::init($path);

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
}


class XLoader implements ILoader
{
    public function load(string $module, string $path = ''): string
    {
        return 'abcmnodefpqrghistujklvwx%syz0123%s456';
    }
}
