<?php

namespace BitWeb\IdCard\Signing;


use BitWeb\IdCard\Authentication\AuthenticationException;
use BitWeb\IdCard\Authentication\IdCardAuthentication;
use BitWeb\IdCard\Signing\Exception\FileDoesNotExistException;

/**
 * Saves and retrieves the file containing information about signing.
 */
class File
{
    /**
     * Directory where temporary files will be saved.
     *
     * @var string
     */
    protected static $tempDir = 'data/id-sign/temp/';

    /**
     * Get current temporary directory.
     *
     * @return string
     */
    public static function getTempDir()
    {
        return self::$tempDir;
    }

    /**
     * Set current temporary directory.
     *
     * @param string $tempDir
     */
    public static function setTempDir($tempDir = 'data/id-sign/temp/')
    {
        self::$tempDir = $tempDir;
    }

    /**
     * Prepares file for saving
     *
     * @param null $fileName
     * @return string
     * @throws Exception\FileDoesNotExistException
     */
    public static function addFile($fileName = null)
    {
        if (!file_exists($fileName)) {
            throw new FileDoesNotExistException('Specified file does not exist: ' . $fileName);
        }

        return self::saveTempFile(file_get_contents($fileName), $fileName);
    }

    /**
     * Saves file to temporary directory.
     *
     * @param string $contents
     * @param string $name
     * @param string $mime
     * @return string generated file name
     * @throws \BitWeb\IdCard\Authentication\AuthenticationException
     */
    protected static function saveTempFile($contents, $name = 'data.bin', $mime = null)
    {
        if (!IdCardAuthentication::isUserLoggedIn()) {
            throw new AuthenticationException('User is not logged in.');
        }

        self::createTempDir();

        $user = IdCardAuthentication::getLoggedInUser();

        $mime = $mime === null ? self::getMimeType($name) : $mime;
        $fileId = self::generateFileId($name, $mime);

        $fileData = array(
            'fileName' => $name,
            'mimeType' => $mime,
            'contents' => $contents,
            'createdTime' => time(),
            'signatures' => array(),
            'owner' => array(
                'UserSurname' => $user->getLastName(),
                'UserGivenName' => $user->getFirstName(),
                'UserIDCode' => $user->getSocialSecurityNumber()
            )
        );

        file_put_contents(self::$tempDir . $fileId, serialize($fileData));

        return $fileId;
    }

    /**
     * Creates the temporary directory if necessary.
     */
    protected static function createTempDir()
    {
        if (!is_dir(self::$tempDir)) {
            $dirParts = explode('/', self::$tempDir);
            $createdDir = '';
            foreach ($dirParts as $dirPart) {
                if (!is_dir($createdDir . ($createdDir == '' ? '' : '/') . $dirPart)) {
                    mkdir($createdDir . ($createdDir == '' ? '' : '/') . $dirPart);
                }

                $createdDir = $createdDir . ($createdDir == '' ? '' : '/') . $dirPart;
            }
        }
    }

    /**
     * Generate file id based on current time, filename and mime type.
     *
     * @param $name
     * @param $mime
     * @return string
     */
    protected static function generateFileId($name, $mime)
    {
        return time() . md5(microtime() . $name . $mime);
    }

    /**
     * Detect mime type for file.
     *
     * @param $fileName
     * @return mixed
     */
    public static function getMimeType($fileName)
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($fileInfo, $fileName);
        finfo_close($fileInfo);

        return $mime;
    }

    /**
     * Retrieves the file from temporary directory.
     *
     * @param $fileId
     * @return array
     * @throws Exception\FileDoesNotExistException
     */
    public static function retrieveFile($fileId)
    {
        if (!file_exists(self::$tempDir . $fileId)) {
            throw new FileDoesNotExistException('Specified file does not exist ' . File::getTempDir() . $fileId);
        }

        return unserialize(file_get_contents(self::$tempDir . $fileId));
    }
}