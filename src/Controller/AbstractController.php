<?php
declare(strict_types=1);

namespace Framework\Controller;

use Framework\Contracts\RendererInterface;

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
}
