<?php

namespace Framework\Renderer;

use Framework\Contracts\RendererInterface;
use Framework\Http\Response;
use Framework\Http\Stream;

class Renderer implements RendererInterface
{
    const CONFIG_KEY_BASE_VIEW_PATH = 'base_view_path';

    /**
     * @var string
     */
    private $baseViewsPath;

    /**
     * Renderer constructor.
     * @param string $baseViewsPath
     */
    public function __construct(string $baseViewsPath)
    {
        $this->baseViewsPath = $baseViewsPath;
    }

    /**
     * Renderer for HTML
     * @param string $viewFile
     * @param array $arguments
     * @return Response
     */
    public function renderView(string $viewFile, array $arguments): Response
    {
        $fullPath = $this->baseViewsPath . $viewFile;

        ob_start();
        extract($arguments);
        require $fullPath;
        $content = ob_get_contents();
        ob_get_clean();

        $stream = Stream::createFromString($content);

        return new Response($stream);


    }

    /**
     * Renderer for JSON
     * @param array $data
     * @return Response
     */
    public function renderJson(array $data): Response
    {
        $json = json_encode($data);
        $stream = Stream::createFromString($json);

        return new Response($stream);

    }
}
