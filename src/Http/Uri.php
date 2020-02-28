<?php


namespace Framework\Http;


use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{

    private $scheme;
    private $user;
    private $password;
    private $host;
    private $port;
    private $path;
    private $query;
    private $fragment;

    public function __construct
    (
        string $scheme = '',
        string $user = '',
        string $password = '',
        string $host = '',
        ?int $port = null,
        string $path = '',
        string $query = '',
        string $fragment = ''
    )
    {
        $this->scheme = $scheme;
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    public static function createFromGlobals()
    {
        $scheme = $_SERVER['REQUEST_SCHEME'];
        $host = $_SERVER['HTTP_HOST'];
        $port = (int) $_SERVER['SERVER_PORT'];
        $val = explode('?', $_SERVER['REQUEST_URI']);
        $path = $val[0];
        $query = $_SERVER['QUERY_STRING'];


        return new self($scheme, '', '', $host, $port, $path, $query, '');
    }

    /**
     * @inheritDoc
     */
    public
    function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @inheritDoc
     */
    public
    function getAuthority()
    {
        return $this->getUserInfo() . '@' . $this->host . ':' . $this->port;
    }

    /**
     * @inheritDoc
     */
    public
    function getUserInfo()
    {
        return $this->user . ':' . $this->password;
    }

    /**
     * @inheritDoc
     */
    public
    function getHost()
    {
        return $this->host;
    }

    /**
     * @inheritDoc
     */
    public
    function getPort()
    {
        return $this->port;
    }

    /**
     * @inheritDoc
     */
    public
    function getPath()
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public
    function getQuery()
    {
        return $this->query;
    }

    /**
     * @inheritDoc
     */
    public
    function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @inheritDoc
     */
    public
    function withScheme($scheme)
    {
        $request = clone $this;
        $request->scheme = $scheme;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public
    function withUserInfo($user, $password = null)
    {
        $request = clone $this;
        $request->getUserInfo();
        //$request->user = $user;
        if ($password == NULL) {
            $request->password = '';
        }
        //$request->password = $password;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public
    function withHost($host)
    {
        $request = clone $this;
        $request->host = $host;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public
    function withPort($port)
    {
        $request = clone $this;
        $request->port = $port;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public
    function withPath($path)
    {
        $request = clone $this;
        $request->path = $path;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public
    function withQuery($query)
    {
        $request = clone $this;
        $request->query = $query;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public
    function withFragment($fragment)
    {
        $request = clone $this;
        $request->fragment = $fragment;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public
    function __toString()
    {
        return
            (!empty($this->scheme) ? $this->scheme . '://' : '') .
            $this->getAuthority() .
            $this->path .
            (!empty($this->query) ? '?' . $this->query : '') .
            (!empty($this->fragment) ? '#' . $this->fragment : '');
    }
}