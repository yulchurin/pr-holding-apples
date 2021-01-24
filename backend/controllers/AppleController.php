<?php

namespace backend\controllers;

use Yii;
use app\models\Apple;
use yii\db\Query;
use yii\web\Controller;
use yii\web\Request;

class AppleController extends Controller
{

    public function actionApples()
    {
        
        $apples = new Apple();
        if (isset(Yii::$app->request->post()['generate']) {
            $apples->generateApples(Yii::$app->request->post()['apples_quantity']);
            $rows = (new Query())->select(['id', 'color', 'piece'])->from('apples')->all();
            foreach ($rows as $row) {
                $this->generateImages($row['id'], $row['color'], $row['piece']);
            }
        }
        if (isset(Yii::$app->request->post()['eat']) && isset(Yii::$app->request->post()['percent'])) {
            $id = Yii::$app->request->post()['id'];
            $piece = Yii::$app->request->post()['piece'];
            $percent = Yii::$app->request->post()['percent'];
            $color = Yii::$app->request->post()['color'];
            $new_piece = $piece - $percent;

            if ($new_piece <= 0) {
                $apples->deleteApple($id);
            } else {
                $apples->eatApple($id, $new_piece);
                $this->generateImages($id,$color,$new_piece);
            }

        }

        if (isset(Yii::$app->request->post()['delete'])) {
            $apples->deleteApple(Yii::$app->request->post()['id']);
        }

        if (isset(Yii::$app->request->post()['fall'])) {
            $apples->fallDown(Yii::$app->request->post()['id']);
        }

        $allApples = $apples->viewApples();

        foreach ($allApples as $apple) {
            if (isset($apple['fell_at']) &&  ((time() - strtotime($apple['fell_at'])) > 18000)) {
                $apples->turnToTurd($apple['id']);
            }
        }

        return $this->render('apples', ['tree'=>$allApples]);
    }

    private function generateImages($id, $color, $piece)
    {
        $imgphp = fopen('img/'.$id.'.php', 'w+');
        $data = '<?php
        $image_width = 100;
        $image_height = 100;
        $image = imageCreate($image_width, $image_height);
        $bg_color = ImageColorAllocate($image, 255, 255, 255);
        $hex = "'.$color.'";
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        $color = ImageColorAllocate($image, $r, $g, $b);
        $end = '.$piece.' * 360 / 100; 
        ImageFilledArc($image, 50, 50, 50, 50, 0, $end, $color, IMG_ARC_PIE);
        ob_clean();
        header ("Content-type: image/png");
        ImagePng($image);
        ImageDestroy($image);
        ';
        fwrite($imgphp, $data);
        fclose($imgphp);

    }




}
