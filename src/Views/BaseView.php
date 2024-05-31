<?php declare( strict_types=1 );

namespace src\Views;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class BaseView
{
    protected string $title;
    protected string $content;
    protected Environment $engine;
    
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(APP_PATH . '/web-admin/public/pages');
        $this->engine = new Environment( $loader );
    }
    
    public function setTitle( string $title ): void
    {
        $this->title = $title;
    }
    
    public function setContent( string $content ): void
    {
        $this->content = $content;
    }
    
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    protected function prepare(): string
    {
        return $this->engine->render( 'index.html', [
            'title' => $this->title,
            'content' => $this->content,
        ] );
    }
    
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function render(): void
    {
        die( $this->prepare() );
    }
}