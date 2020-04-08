<?php
declare(strict_types=1);

namespace Framework\Controller;

use Framework\Contracts\RendererInterface;
use Framework\Http\Response;
use Framework\Http\Stream;

/**
 * Base abstract class for application controllers.
 * All application controllers must extend this class.
 */
abstract class AbstractController
{
    /**
     * @var RendererInterface
     */
    protected $renderer;

    public function __construct(RendererInterface $renderer)
    {
        // Rendered gets constructor injected
        $this->renderer = $renderer;
    }

    public function createRedirectResponse(string $location): Response
    {
        $body = Stream::createFromString('');
        /** @var $response Response */
        $response = new Response($body, '1.1', 301, '');
        $response = $response->withHeader('Location', $location);

        return $response;
    }
}
