<?php

namespace Framework\Renderer;

use Framework\Contracts\RendererInterface;
use Framework\Http\Response;
use Framework\Http\Stream;

class Renderer implements RendererInterface
{
    private $baseViewsPath;

    public function __construct(string $baseViewsPath)
    {
        $this->baseViewsPath = $baseViewsPath;
    }

    public function renderView(string $viewFile, array $arguments): Response
    {
        $fullPath = $this->baseViewsPath . $viewFile;

        ob_start();

        extract($arguments);

        require $fullPath;

        $content = ob_get_contents();

        ob_get_clean();

        $stream = Stream::createFromString($content);
        $response = new Response($stream);

        return $response;


    }

    public function renderJson(array $data): Response
    {
        $json = json_encode($data);
        $stream = Stream::createFromString($json);
        $response = new Response($stream);

        return $response;
    }
}
