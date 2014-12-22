<?php

namespace BackBee\Utils\Tests;

use BackBee\Utils\File\Dir;

class DirTest extends \PHPUnit_Framework_TestCase
{
    private $copy_path;
    private $privateFolder;

    public function setUp()
    {
        $this->copyPath = 'file.txt';
        $this->privatePath = $this->getFixturesFolder().'bad-rights';
        @chmod($this->privatePath, 0000);
    }

    public function testCopy()
    {
        /*$dir_mode = 0777;
        $vfs_dir = vfsStream::setup('startpath', $dir_mode, array('startfile' => 'start data'));
        $start_path = vfsStream::url('startpath');

        $copy_path = $this->copy_path;

        $dir_path = Dir::copy($start_path, $copy_path);

        $this->assertEquals(true, $dir_path);

        $this->assertEquals(array_values(Dir::getContent($copy_path)), array_values(Dir::getContent($start_path)));
        */
    }

    public function testUnreadbleCopy()
    {
        /*$dir_mode = 0000;
        $vfs_dir = vfsStream::setup('dircopy', $dir_mode, array('copyfile' => 'copy data'));

        $start_path = vfsStream::url('dircopy');

        $unreadable = vfsStream::setup('copydir', 0000);
        $dir_path1 = Dir::copy($start_path, $unreadable);

        $this->assertEquals(false, $dir_path1);
        */
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
        if (is_dir($this->copy_path)) {
            $allfiles = scandir($this->copy_path);
            foreach ($allfiles as $file) {
                if (!is_dir($file)) {
                    unlink($this->copy_path.DIRECTORY_SEPARATOR.$file);
                }
            }

            rmdir($this->copy_path);
        }
    }
}
