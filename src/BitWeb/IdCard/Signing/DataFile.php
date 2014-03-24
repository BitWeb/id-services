<?php

namespace BitWeb\IdCard\Signing;


class DataFile
{
    const CONTENT_TYPE_HASH_CODE = 'HASHCODE';
    const CONTENT_TYPE_EMBEDDED_BASE64 = 'EMBEDDED_BASE64';

    const DIGEST_TYPE_SHA1 = 'sha1';
    const DIGEST_TYPE_SHA256 = 'sha256';

    public static $xmlNamespace = 'http://www.sk.ee/DigiDoc/v1.3.0#';

    public static $contentTypes = array(
        self::CONTENT_TYPE_EMBEDDED_BASE64,
        self::CONTENT_TYPE_HASH_CODE
    );

    public static $digestTypes = array(
        self::DIGEST_TYPE_SHA1,
        self::DIGEST_TYPE_SHA256
    );

    protected $Id;

    protected $Filename;

    protected $ContentType;

    protected $MimeType;

    protected $Size;

    protected $DigestType;

    protected $DigestValue;

    protected $DfData;

    /**
     * @param $contentType
     * @throws \InvalidArgumentException
     */
    public function setContentType($contentType)
    {
        if (!in_array($contentType, self::$contentTypes)) {
            throw new \InvalidArgumentException();
        }

        $this->ContentType = $contentType;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->ContentType;
    }

    /**
     * @param mixed $dfData
     */
    public function setDfData($dfData)
    {
        $this->DfData = $dfData;
    }

    /**
     * @return mixed
     */
    public function getDfData()
    {
        return $this->DfData;
    }

    /**
     * @param $digestType
     * @throws \InvalidArgumentException
     */
    public function setDigestType($digestType)
    {
        if (!in_array($digestType, self::$digestTypes)) {
            throw new \InvalidArgumentException();
        }
        $this->DigestType = $digestType;
    }

    /**
     * @return mixed
     */
    public function getDigestType()
    {
        return $this->DigestType;
    }

    /**
     * @param mixed $digestValue
     */
    public function setDigestValue($digestValue)
    {
        $this->DigestValue = $digestValue;
    }

    /**
     * @return mixed
     */
    public function getDigestValue()
    {
        return $this->DigestValue;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->Filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->Filename;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->Id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->MimeType = $mimeType;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->MimeType;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->Size = $size;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->Size;
    }

    /**
     * Detect mime type for file.
     *
     * @param $fileName
     * @return mixed
     */
    public static function detectMimeType($fileName)
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($fileInfo, $fileName);
        finfo_close($fileInfo);

        return $mime;
    }

    /**
     * Detect file size
     *
     * @param $fileName
     * @return int
     */
    public static function detectFileSize($fileName)
    {
        return filesize($fileName);
    }

    public function fillData($fileName)
    {
        $this->setFilename(basename($fileName));
        $this->setContentType(self::CONTENT_TYPE_HASH_CODE);
        $this->setMimeType(DataFile::detectMimeType($fileName));
        $this->setSize(DataFile::detectFileSize($fileName));
        $this->generateDigestValue($fileName, self::DIGEST_TYPE_SHA1);
    }

    protected function generateDigestValue($fileName, $digestType = self::DIGEST_TYPE_SHA1)
    {
        $this->setDigestType($digestType);

        $encoded = hash($digestType, $this->generateXml($fileName));

        $this->setDigestValue(base64_encode(pack('H*', $encoded)));
    }

    protected function generateXml($fileName)
    {
        $doc = new \DOMDocument(null, 'UTF-8');
        $dom = new \DOMElement('DataFile', base64_encode(file_get_contents($fileName)) . "\n", self::$xmlNamespace);
        $doc->appendChild($dom);
        $dom->setAttribute('ContentType', self::CONTENT_TYPE_EMBEDDED_BASE64);
        $dom->setAttribute('Filename', basename($fileName));
        $dom->setAttribute('Id', 'D0');
        $dom->setAttribute('MimeType', $this->getMimeType());
        $dom->setAttribute('Size', filesize($fileName));

        return $dom->C14N(false, false);
    }

    public function toArray()
    {
        return [
            'Filename' => $this->Filename,
            'MimeType' => $this->MimeType,
            'ContentType' => $this->ContentType,
            'Size' => $this->Size,
            'DigestType' => $this->DigestType,
            'DigestValue' => $this->DigestValue
        ];
    }
}