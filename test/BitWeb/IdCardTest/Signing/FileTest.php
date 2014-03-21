<?php

namespace BitWeb\IdCardTest\Signing;

use BitWeb\IdCard\Authentication\IdCardAuthentication;
use BitWeb\IdCard\Signing\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    public $testFileName = 'test/BitWeb/IdCardTest/TestAsset/file.txt';

    protected function login()
    {
        $_SERVER[IdCardAuthentication::SSL_CLIENT_VERIFY] = IdCardAuthentication::SSL_CLIENT_VERIFY_SUCCESSFUL;
        $_SERVER['SSL_CLIENT_S_DN'] = 'GN=Mari-Liis/SN=Männik/serialNumber=47101010033/C=EST';

        IdCardAuthentication::login();
    }

    protected function logout()
    {
        IdCardAuthentication::logout();
    }

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
        $this->login();

        $tempFile = File::addFile($this->testFileName);
        $this->assertTrue(is_string($tempFile));
        $this->assertTrue(file_exists(File::getTempDir() . $tempFile));
    }

    /**
     * @expectedException \BitWeb\IdCard\Signing\Exception\FileDoesNotExistException
     */
    public function testAddFileFromFileThrowsWhenFileDoesNotExist()
    {
        $this->login();
        File::addFile();
    }

    /**
     * @expectedException \BitWeb\IdCard\Authentication\AuthenticationException
     */
    public function testAddFileThrowsWhenNotLoggedIn()
    {
        $this->logout();
        File::addFile($this->testFileName);
    }

    public function testRetrieveFileReturnsArray()
    {
        $this->login();

        $tempFile = File::addFile($this->testFileName);
        $this->assertTrue(is_array(File::retrieveFile($tempFile)));
    }

    /**
     * @expectedException \BitWeb\IdCard\Signing\Exception\FileDoesNotExistException
     */
    public function testRetrieveFileReturnsFalseWhenFileDoesNotExist()
    {
        $this->login();
        $tempFile = File::addFile($this->testFileName);
        self::removeTempFiles();
        File::retrieveFile($tempFile);
    }

    public static function tearDownAfterClass()
    {
        self::removeTempFiles();
    }

    protected static function removeTempFiles()
    {
        $dir = File::getTempDir();
        if (is_dir($dir)) {
            foreach (scandir($dir) as $file) {
                if (file_exists($dir . $file) && !in_array($file, ['.', '..'])) {
                    unlink($dir . $file);
                }
            }

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