<?php

namespace davist11\colorpalette\controllers;

use Craft;
use craft\web\Controller;

use davist11\colorpalette\models\ColorModel;
use davist11\colorpalette\services\Color;

class DefaultController extends Controller
{
    protected $allowAnonymous = false;

    public function actionEditColor(int $colorId)
    {
        $color = Color::getById($colorId);

        return $this->renderTemplate('color-palette/_edit', [
            'color' => $color,
        ]);
    }

    public function actionSaveColor()
    {
        $this->requirePostRequest();

        $color = Craft::$app->request->post('color');
        $colorId = $color['colorId'] ?? null;

        if ($colorId !== null) {
            $model = Color::getById($colorId);
        } else {
            $model = new ColorModel();
        }

        $model->name = $color['name'];
        $model->hex = $color['hex'];

        
        if (!$model->validate()) {
            Craft::$app->session->setError('There was a problem with your submission, please check the form and try again.');

            Craft::$app->urlManager->setRouteParams([
                'color' => $model,
            ]);

            return;
        }

        // Error saving record
        if (!$model = Color::save($model)) {
            Craft::$app->session->setError('There was a problem with your submission, please check the form and try again.');

            Craft::$app->urlManager->setRouteParams([
                'color' => $model,
            ]);

            return;
        }

        Craft::$app->session->setNotice('Color saved');

        return $this->redirectToPostedUrl();
    }

    public function actionDeleteColor()
    {
        $this->requireAcceptsJson();

        $id = Craft::$app->request->getRequiredParam('id');
        $result = Color::deleteById($id);

        return $this->asJson(['success' => $result]);
    }
}