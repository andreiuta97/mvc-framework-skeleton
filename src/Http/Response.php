<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response extends Message
{
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var string
     */
    private $reasonPhrase;

    /**
     * Response constructor.
     * @param StreamInterface $body
     * @param string $protocolVersion
     * @param int $statusCode
     * @param string $reasonPhrase
     */
    public function __construct(StreamInterface $body, string $protocolVersion = '1.1', int $statusCode = 200, string $reasonPhrase = '')
    {
        parent::__construct($protocolVersion, $body);
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
    }

    /**
     * Sends the content of a Response
     */
    public function send(): void
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    /**
     * Sends the headers of a Response
     */
    private function sendHeaders(): void
    {
        foreach ($this->headers as $key => $value) {
            header($key, implode(', ', $value));
        }
    }

    /**
     * Sends the body of a Response
     */
    private function sendBody(): void
    {
        echo $this->getBody()->getContents();
    }


    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @inheritDoc
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $response = clone $this;
        $response->statusCode = $code;
        $response->reasonPhrase = $reasonPhrase;

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }
}
