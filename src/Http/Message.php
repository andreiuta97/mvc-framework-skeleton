<?php


namespace Framework\Http;


use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

class Message implements MessageInterface
{
    /**
     * @var string
     */
    protected $protocolVersion;
    /**
     * @var array
     */
    protected $headers;
    /**
     * @var StreamInterface|null
     */
    protected $body;

    /**
     * Message constructor.
     * @param string $protocolVersion
     * @param StreamInterface|null $body
     */
    public function __construct
    (
        string $protocolVersion,
        ?StreamInterface $body
    )
    {
        $this->protocolVersion = $protocolVersion;
        $this->headers = [];
        $this->body = $body;
    }

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        $request = clone $this;
        $request->protocolVersion = $version;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        foreach ($this->headers as $key => $values) {
            if (strcasecmp($key, $name)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        foreach ($this->headers as $key => $values) {
            if (strcasecmp($key, $name)) {
                return $values;
            }
        }

        return [];
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        foreach ($this->headers as $key => $values) {
            if (strcasecmp($key, $name)) {
                return implode(', ', $values);
            }
        }

        return [];
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        $message = clone $this;
        if (is_array($value)) {
            $message->headers[$name] = $value;

            return $message;
        }
        $message->headers[$name] = [$value];

        return $message;

    }

    /**
     * Adds a header (key => value) to the headers
     * @param $name
     * @param $value
     * @return $this
     */
    public function addRawHeader($name, $value)
    {
        $name = ucwords(strtolower(strtr(substr($name, 5), '_', '-')), '-');
        $this->headers[$name] = explode(',', $value);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        $message = clone $this;
        $message = array_merge($message->headers[$name], $value);

        return $message;
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        $message = clone $this;
        unset($message->headers[$name]);

        return $message;
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        $message = clone $this;
        $message->body = $body;

        return $message;
    }
}
