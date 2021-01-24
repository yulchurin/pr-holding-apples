<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\controllers\AppleController;
use app\models\Apple;

$this->title = 'APPLES';
if (Yii::$app->user->isGuest) {
    header('Location: index.php');
}

?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'apple-generator-form']); ?>
        <label for="apples-quantity">how much apples should i generate? (10 max)</label>
        <div class="input-group mb-3">
            <input requuired name="apples_quantity" id="apples-quantity" type="number" min="1" max="10" class="form-control" placeholder="how much apples should i generate? (10 max)">
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="submit" name="generate">Generate!</button>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

    <?php
    foreach ($tree as $apple) {
        $form = ActiveForm::begin(['id' => $apple['id'].'apple']);
    ?>
    <br>
    <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="submit" class="btn btn-secondary" name="fall">Упасть</button>
            <button type="submit" class="btn btn-secondary" name="eat">Съесть</button>
            <button type="submit" class="btn btn-secondary" name="delete">Удалить</button>
        </div>
        <div class="input-group">
            <input type="hidden" id="<?= $apple['id'] ?>" name="id" value="<?= $apple['id'] ?>">
            <input type="hidden" name="piece" value="<?= $apple['piece'] ?>">
            <input type="hidden" name="color" value="<?= $apple['color'] ?>">
            <input type="text" class="form-control" placeholder="How much to bite?" name="percent">
        </div>
        <img src="img/<?= $apple['id'] ?>.php">
    </div>
    <?php
        ActiveForm::end();
    }



    ?>

</div>
