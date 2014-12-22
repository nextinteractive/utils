<?php

namespace BackBee\Utils\Tests;

use BackBee\Utils\File\Dir;

class DirTest extends \PHPUnit_Framework_TestCase
{
    private $copyFolder;
    private $privateFolder;

    public function setUp()
    {
        $this->copyFolder = $this->getFixturesFolder().'archive';
        $this->privatePath = $this->getFixturesFolder().'bad-rights';
        @chmod($this->privatePath, 0000);
    }

    public function testCopy()
    {
        $copyPath = $this->getFixturesFolder() . 'archive2';
        $directoryPath = Dir::copy($this->copyFolder, $copyPath);

        $this->assertEquals(true, $directoryPath);
        $this->assertEquals(array_values(Dir::getContent($copyPath)), array_values(Dir::getContent($this->copyFolder)));

        Dir::delete($copyPath);
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testUnreadableCopy()
    {
        $this->assertFalse(Dir::copy($this->copyFolder, $this->privateFolder));
    }

    /**
     * @expectedException \Exception
     */
    public function testUnknownGetContent()
    {
        Dir::getContent('unknow');
    }

    /**
     * @expectedException \Exception
     */
    public function testGetContentFails()
    {
        Dir::getContent('/DirTest.php');
    }

    public function testGetContent()
    {
        /*$test_dir = vfsStream::setup('test_dir');
        $path_dir = vfsStream::url('test_dir');

        $arr1 = array_diff(scandir($path_dir), array('.', '..'));
        $arr2 = Dir::getContent($path_dir);

        $this->assertTrue(is_array($arr2));
        $this->assertEquals($arr2, $arr1);
        */
    }

    /**
     * @expectedException \Exception
     */
    public function testModeFilesGetContent()
    {
        $res = Dir::getContent($this->privateFolder);
    }

    public function testIsArrayGetContent()
    {
        /*$test_dir = vfsStream::setup('test_dir', 0777, array('file1' => 'file1 data', 'file2' => 'file2 data'));
        $path_dir = vfsStream::url('test_dir');

        $res = Dir::getContent($path_dir);
        $this->assertTrue(is_array($res));
        */
    }

    public function testDelete()
    {
        /*vfsStream::setup('test_dir');
        $path_dir = vfsStream::url('test_dir');

        $res = Dir::delete($path_dir);

        $this->assertEquals(true, $res);
        $this->assertFileNotExists($path_dir);
        */
    }

    public function testMove()
    {
        /*$dir_mode = 0777;
        $vfs_dir = vfsStream::setup('dirstart', $dir_mode, array('startfile' => 'start data'));
        $start_path = vfsStream::url('dirstart');

        $copy_path = $this->copy_path;

        $dir_path = Dir::move($start_path, $copy_path, $dir_mode);

        $this->assertEquals(true, $dir_path);*/
    }

    public function testCallback2ParamsMove()
    {
        /*$dir_mode = 0777;
        $vfs_dir = vfsStream::setup('dircopy', $dir_mode, array('copyfile' => 'copy data'));

        $start_path = vfsStream::url('dircopy');
        $copy_path = $this->copy_path;

        $dir_path = Dir::move($start_path, $copy_path, $dir_mode, array('self', 'getContent', $start_path));
        $this->assertEquals(true, $dir_path);*/
    }

    public function testCallback3ParamsMove()
    {
        /*$dir_mode = 0777;
        $vfs_dir = vfsStream::setup('dircopy', $dir_mode, array('copyfile' => 'copy data'));

        $start_path = vfsStream::url('dircopy');
        $copy_path = $this->copy_path;

        $dir_path = Dir::move($start_path, $copy_path, $dir_mode, array('getContent', $start_path, $copy_path, $dir_mode));
        $this->assertEquals(true, $dir_path);
        */
    }

    private function getFixturesFolder()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR;
    }

    public function tearDown()
    {
        @chmod($this->privatePath, 0755);
        $this->privatePath = null;
    }
}
