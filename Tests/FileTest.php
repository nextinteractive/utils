<?php

namespace BackBee\Utils\Tests;

use BackBee\Utils\File\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    private $folderPath;
    private $privatePath;
    private $zipPath;

    public function setUp()
    {
        $this->folderPath = $this->getFixturesFolder() . 'foo';
        $this->privatePath = $this->getFixturesFolder() . 'bad-rights';
        $this->zipPath = $this->getFixturesFolder() . 'archive';
    }

    public function testRealpath()
    {
        $this->assertEquals(__DIR__ . DIRECTORY_SEPARATOR . 'FileTest.php', File::realpath(__DIR__.DIRECTORY_SEPARATOR."FileTest.php"));
        $this->assertEquals(false, File::realpath(DIRECTORY_SEPARATOR."FileTest.php"));

        $this->assertEquals($this->folderPath, File::realpath($this->folderPath));
    }

    public function testNormalizePath()
    {
        $this->assertEquals(realpath($this->folderPath), File::normalizePath($this->folderPath));
    }

    public function testReadableFilesize()
    {
        $this->assertEquals('1.953 kB', File::readableFilesize(2000, 3));
        $this->assertEquals('553.71094 kB', File::readableFilesize(567000, 5));
        $this->assertEquals('553.71 kB', File::readableFilesize(567000));
        $this->assertEquals('5.28 GB', File::readableFilesize(5670008902));
        $this->assertEquals('0.00 B', File::readableFilesize(0));
    }

    public function testGetExtension()
    {
        $this->assertEquals('.txt', File::getExtension('test.txt', true));
        $this->assertEquals('jpg', File::getExtension('test.jpg', false));
        $this->assertEquals('', File::getExtension('test', false));
        $this->assertEquals('', File::getExtension('test', true));
        $this->assertEquals('', File::getExtension('', true));
    }

    public function testRemoveExtension()
    {
        $this->assertEquals('test', File::removeExtension('test.txt'));
        $this->assertEquals('', File::removeExtension('.txt'));
        $this->assertEquals('', File::removeExtension(''));
        $this->assertEquals('test', File::removeExtension('test'));
    }

    public function testExistingDirMkdir()
    {
        $this->assertTrue(File::mkdir($this->folderPath));
    }

    /**
     * @expectedException \BackBee\Utils\Exception\InvalidArgumentException
     */
    public function testExistingDirMkdirWithBadRights()
    {
        File::mkdir($this->privatePath);
    }

    /**
     * @expectedException \BackBee\Utils\Exception\InvalidArgumentException
     */
    public function testUnknownDirMkdir()
    {
        File::mkdir('');
        File::mkdir(null);
    }

    /**
     * @expectedException \BackBee\Utils\Exception\InvalidArgumentException
     */
    public function testUnreadableCopy()
    {
        File::copy($this->privatePath, 'bar.txt');
    }

    /**
     * @expectedException \BackBee\Utils\Exception\InvalidArgumentException
     */
    public function testUnreadableGetFilesRecursivelyByExtension()
    {
        File::getFilesRecursivelyByExtension($this->privatePath, '.txt');
        File::getFilesRecursivelyByExtension('','');
    }

    public function testGetFilesRecursivelyByExtension()
    {
        $this->assertEquals(
            [
                $this->folderPath . DIRECTORY_SEPARATOR . 'bar.txt',
                $this->folderPath . DIRECTORY_SEPARATOR . 'foo.txt'
            ], File::getFilesRecursivelyByExtension($this->folderPath, 'txt')
        );

        $this->assertEquals([$this->folderPath . DIRECTORY_SEPARATOR . 'baz.php'], File::getFilesRecursivelyByExtension($this->folderPath, 'php'));
        $this->assertEquals([$this->folderPath . DIRECTORY_SEPARATOR . 'backbee.yml'], File::getFilesRecursivelyByExtension($this->folderPath, 'yml'));
        $this->assertEquals([$this->folderPath . DIRECTORY_SEPARATOR . 'noextension'], File::getFilesRecursivelyByExtension($this->folderPath, ''));
        $this->assertEquals([], File::getFilesRecursivelyByExtension($this->folderPath, 'aaa'));
    }

    /**
     * @expectedException \BackBee\Utils\Exception\InvalidArgumentException
     */
    public function testUnredableGetFilesByExtension()
    {
        File::getFilesByExtension($this->privatePath, '.txt');
        File::getFilesByExtension('', '');
    }

    public function testGetFilesByExtension()
    {
        /*$vfs_dir = vfsStream::setup('dircopy', 0775, array('copyfile.txt' => 'copy data', 'file2.txt' => 'copy data', 'file3.php' => 'copy data', 'file4.yml' => 'copy data'));
        $path = vfsStream::url('dircopy');

        $this->assertEquals(array('vfs://dircopy'.DIRECTORY_SEPARATOR.'copyfile.txt', 'vfs://dircopy'.DIRECTORY_SEPARATOR.'file2.txt'), File::getFilesByExtension($path, 'txt'));
        $this->assertEquals(array('vfs://dircopy'.DIRECTORY_SEPARATOR.'file3.php'), File::getFilesByExtension($path, 'php'));
        $this->assertEquals(array('vfs://dircopy'.DIRECTORY_SEPARATOR.'file4.yml'), File::getFilesByExtension($path, 'yml'));
        $this->assertEquals(array(), File::getFilesByExtension($path, ''));
        $this->assertEquals(array(), File::getFilesByExtension($path, 'aaa'));
        */
    }

    /**
     * @expectedException \BackBee\Utils\Exception\ApplicationException
     */
    public function testExtractZipArchiveNonexistentDir()
    {
        File::extractZipArchive('test', 'test');
    }

    /**
     * @expectedException \BackBee\Utils\Exception\ApplicationException
     */
    public function testExtractZipArchiveUnreadableDir()
    {
        File::extractZipArchive('test', $this->privatePath);
    }

    /**
     * @expectedException \BackBee\Utils\Exception\ApplicationException
     */
    public function testExtractZipArchiveExistingDir()
    {
        $zipFile = $this->getFixturesFolder() . 'archive.zip';
        File::extractZipArchive('test', $this->zipPath, true);
    }

    public function testResolveFilepath()
    {
        $twigFilePath = $this->getFixturesFolder() . 'file.twig';
        File::resolveFilepath($twigFilePath);
        $this->assertEquals($this->getFixturesFolder() . 'file.twig', $twigFilePath);
    }

    private function getFixturesFolder()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'Fixtures' . DIRECTORY_SEPARATOR;
    }
}
