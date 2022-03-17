<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use App\Pdo\ScreenshotPdo;
use App\Validation\BaseValidator;
use App\Validation\FileValidator;

class ScreenshotController extends BaseController
{
    protected const UPLOAD_DIR = '/user/img/';

    public function showAll(array $parameters): Response
    {
        return $this->renderTemplate(
            'start.php', 
            ['session' => $this->request->getSession()]
        );
    }

    public function getScreenshots(array $parameters): Response
    {
        $lastId = $parameters['lastid'];
        if ($lastId != 0 && !BaseValidator::isIdCorrect($lastId)) {
            return new Response('', 404);
        }

        $screenshotPdo = new ScreenshotPdo();
        $screenshots = $screenshotPdo->getScreenshots($lastId, 10);

        if ($screenshots->rowCount() !== 0) {
            return $this->renderTemplate(
                'screenshots.php', 
                ['screenshots' => $screenshots]
            );
        } else {
            return new Response('', 200);
        }        
    }

    public function showDetail(array $parameters): Response
    {
        $lastId = $parameters['lastid'];
        if (!BaseValidator::isIdCorrect($lastId)) {
            return new Response('', 404);
        }

        $screenshotPdo = new ScreenshotPdo();
        $screenshot = $screenshotPdo->getScreenshot($screenshotId);

        return $this->renderTemplate(
            'detail.php', 
            [
                'screenshot' => $screenshot,
                'session' => $this->request->getSession()
            ]
        );
    }

    public function showFileLoadForm(array $parameters): Response
    {
        return $this->renderTemplate(
            'file_form.php', 
            ['session' => $this->request->getSession()]
        );
    }

    public function loadFile(array $parameters): Response
    {
        if (!$this->request->getSession()->has('userName')) {
            $response = new Response();
            $response->headers->set('Location', '/');
            return new Response('', 300);
        }

        $file = $this->getRequest()->files->get('file');

        if ($file['error'] != UPLOAD_ERR_OK) {
            return $this->wrapErrors(
                ["Ошибка загрузки файла: ".$file['error']]);
        }

        $errors = FileValidator::validateFile($file);
        if (!empty($errors)) {
            return $this->wrapErrors($errors);
        }

        $screenshotPdo = new ScreenshotPdo();

        $tmpName = $file["tmp_name"];
        $extension = pathinfo($file['name'])['extension'] ?? "";
        $newRelativePath = self::UPLOAD_DIR.uniqid().'.'.$extension;

        if (!move_uploaded_file($tmpName, $_SERVER['DOCUMENT_ROOT'].$newRelativePath)) {
            return $this->wrapErrors(["Ошибка перемещения файла"]);
        }

        return $this->wrapJson([
            'success' => true,
            'id' => $screenshotPdo->save($newRelativePath, $isPrivate)
        ]);
    }
}