<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class BaseController
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function renderTemplate(string $template, array $params = []): Response
    {
        $templateDir = __DIR__ . '/../../templates/';

        if (!file_exists($templateDir . $template)) {
            throw new \Exception("Template '{$template}' not found");
        }

        ob_start();
        require_once $templateDir . $template;
        $content = ob_get_clean();
        return new Response($content);
    }

    public function escapeHtml(array $parameters): array
    {
        return array_map(
            function ($v) {
               return htmlspecialchars($v);
           },
            $request
        );
    }

    public function wrapErrors(array $errors): Response
    {
        return $this
            ->wrapJson($errors)
            ->setStatusCode(500);
    }

    public function wrapJson($data): Response
    {
        return (new Response())
            ->setContent($data)
            ->headers->set('Content-Type', 'application/json');
    }
}