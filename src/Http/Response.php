<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response extends Message
{
    private $statusCode;
    private $reasonPhrase;

    public function __construct(StreamInterface $body, string $protocolVersion= '1.1', int $statusCode=200, string $reasonPhrase = '')
    {
        parent::__construct($protocolVersion, $body);
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    private function sendHeaders(): void
    {
        foreach ($this->headers as $key => $value) {
            header($key, implode(', ', $value));
        }
    }

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
