<?php


namespace Framework\Http;


use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    const DEFAULT_MEMORY = 5 * 1024 * 1024;
    const DEFAULT_MODE = 'r+';

    /**
     * @var false|resource
     */
    private $stream;
    private $size;
    private $writable;
    private $readable;
    private $seekable;

    public function __construct($handler, int $size = null)
    {
        $this->stream = $handler;
        $this->size = $size;
        $this->writable = $this->readable = $this->seekable = true;
    }

    public static function createFromString(string $content): self
    {
        $stream = fopen(sprintf("php://temp/maxmemory:%s", self::DEFAULT_MEMORY), self::DEFAULT_MODE);
        fwrite($stream, $content);
        return new self($stream, strlen($content));
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        //fseek() spre pointer 0
        //fread($this->stream, )
        rewind($this->stream);
        fread($this->stream, $this->getSize());
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        $this->readable = $this->writable = $this->seekable = false;
        fclose($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        //close care verifica daca exista stream
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }

    }

    /**
     * @inheritDoc
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @inheritDoc
     */
    public function tell()
    {
        //imi zice unde e pointerul
        return ftell($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function eof()
    {
        //verifica daca poiterul nu e la sf stringului
        //feof();
        return feof($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function isSeekable()
    {
        return $this->seekable;
    }

    /**
     * @inheritDoc
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        // ii dau eu o valoare pt poiner si mi-l muta acolo
        fseek($this->stream, $offset, SEEK_CUR);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        // = fseek(0)
        // mut pointerul la inceputul stringului
        //fseek($this->stream, 0);
        rewind($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function isWritable()
    {
        return $this->writable;
    }

    /**
     * @inheritDoc
     */
    public function write($string)
    {
        fwrite($this->stream, $string);
    }

    /**
     * @inheritDoc
     */
    public function isReadable()
    {
        return $this->readable;
    }

    /**
     * @inheritDoc
     */
    public function read($length)
    {
        return fread($this->stream, $length);
    }

    /**
     * @inheritDoc
     */
    public function getContents()
    {
        $this->rewind();
        return stream_get_contents($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {
        return stream_get_meta_data($this->stream);
    }
}