<?php

namespace BitWeb\IdCard\Signing;

class FileTest extends \PHPUnit_Framework_TestCase
{
    public $testFileName = 'test/BitWeb/IdCard/TestAsset/file.txt';

    public function testGetMimeType()
    {
        $this->assertEquals('text/plain', File::getMimeType($this->testFileName));
    }

    public function testGetTempDir()
    {
        $this->assertEquals('data/id-sign/temp/', File::getTempDir());
    }

    public function testSetTempDir()
    {
        $tempDir = 'temp/id-card/';
        File::setTempDir($tempDir);
        $this->assertEquals($tempDir, File::getTempDir());

        File::setTempDir();
        $this->assertEquals('data/id-sign/temp/', File::getTempDir());
    }

    public function testAddFileFromFile()
    {
        $tempFile = File::addFileFromFile($this->testFileName);
        $this->assertTrue(is_string($tempFile));
        $this->assertTrue(file_exists(File::getTempDir() . $tempFile));
    }

    /**
     * @expectedException \BitWeb\IdCard\Signing\Exception\FileDoesNotExistException
     */
    public function testAddFileFromFileThrowsWhenFileDoesNotExist()
    {
        $this->assertFalse(File::addFileFromFile());
    }

    public function testRetrieveFileReturnsArray()
    {
        $tempFile = File::addFileFromFile($this->testFileName);
        $this->assertTrue(is_array(File::retrieveFile($tempFile)));
    }

    /**
     * @expectedException \BitWeb\IdCard\Signing\Exception\FileDoesNotExistException
     */
    public function testRetrieveFileReturnsFalseWhenFileDoesNotExist()
    {
        $tempFile = File::addFileFromFile($this->testFileName);
        self::removeTempFiles();
        $this->assertFalse(File::retrieveFile($tempFile));
    }

    public static function tearDownAfterClass()
    {
        self::removeTempFiles();
    }

    public static function removeTempFiles()
    {
        if (is_dir(File::getTempDir())) {
            foreach (scandir(File::getTempDir()) as $file) {
                if (file_exists(File::getTempDir() . $file) && !in_array($file, ['.', '..'])) {
                    unlink(File::getTempDir() . $file);
                }
            }

            $dir = File::getTempDir();
            while (true) {
                rmdir($dir);
                if (substr_count($dir, '/') === 1) {
                    break;
                }
                $dir = str_replace('/' . explode('/', $dir)[count(explode('/', $dir)) - 2], '', $dir);
            }
        }
    }
}