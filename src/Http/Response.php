<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface
{
    public function send(): void
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    private function sendHeaders(): void
    {
        // TODO: use header() PHP function here to send the response headers added to this response
    }

    private function sendBody(): void
    {
        // TODO: just print the content of the response
    }

    // TODO: implement methods declared by ResponseInterface

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        // TODO: Implement getStatusCode() method.
    }

    /**
     * @inheritDoc
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        // TODO: Implement withStatus() method.
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        // TODO: Implement getReasonPhrase() method.
    }
}
