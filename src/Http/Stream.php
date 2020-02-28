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
    /**
     * @var int|null
     */
    private $size;
    /**
     * @var bool
     */
    private $writable;
    /**
     * @var bool
     */
    private $readable;
    /**
     * @var bool
     */
    private $seekable;

    /**
     * Stream constructor.
     * @param $handler
     * @param int|null $size
     */
    public function __construct($handler, ?int $size = null)
    {
        $this->stream = $handler;
        $this->size = $size;
        $this->writable = $this->readable = $this->seekable = true;
    }

    /**
     * Creates a temporary Stream
     * @param string $content
     * @return static
     */
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
        return ftell($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function eof()
    {
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
        fseek($this->stream, $offset, SEEK_CUR);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
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