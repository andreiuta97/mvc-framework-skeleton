<?php

namespace Framework\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message
{
    /**
     * @var string
     */
    private $httpMethod;
    /**
     * @var UriInterface
     */
    private $uri;
    private $requestTarget;

    /**
     * Request constructor.
     * @param string $protocolVersion
     * @param string $httpMethod
     * @param UriInterface $uri
     * @param StreamInterface $body
     */
    public function __construct
    (
        string $protocolVersion,
        string $httpMethod,
        UriInterface $uri,
        StreamInterface $body
    )
    {
        parent::__construct($protocolVersion, $body);
        $this->httpMethod = $httpMethod;
        $this->uri = $uri;
    }

    /**
     * Creates a Request using the global variables
     * @return static
     */
    public static function createFromGlobals(): self
    {
        $protocolVersion = $_SERVER['SERVER_PROTOCOL'];
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = Uri::createFromGlobals();
        $body = new Stream(fopen('php://input', 'r'));

        $request = new self($protocolVersion, $httpMethod, $uri, $body);
        foreach ($_SERVER as $variableName => $variableValue) {
            if (strpos($variableName, 'HTTP_') !== 0) {
                continue;
            }
            $request->addRawHeader($variableName, $variableValue);
        }

        return $request;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getParameter(string $name)
    {
        return $_GET[$name];
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getCookie(string $name)
    {
        return $_COOKIE[$name];
    }

    /**
     * @param string $path
     */
    public function moveUploadedFile(string $path)
    {
        //TODO
        move_uploaded_file($_FILES, $path);
    }

    /**
     * @inheritDoc
     */
    public function getRequestTarget()
    {
        if ($this->requestTarget) {
            return $this->requestTarget;
        }
        if ($this->uri) {
            return $this->uri->__toString();
        }
        return '/';
    }

    /**
     * @inheritDoc
     */
    public function withRequestTarget($requestTarget)
    {
        $request = clone $this;
        $request->requestTarget = $requestTarget;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @inheritDoc
     */
    public function withMethod($method)
    {
        $request = clone $this;
        $request->httpMethod = $method;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @inheritDoc
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $request = clone $this;
        $request->uri = $uri;

        return $request;
    }
}
