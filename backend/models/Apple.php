<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string $born_at
 * @property string $fell_at
 * @property string $color
 * @property string $status
 * @property int $piece
 */
class AppleTree extends ActiveRecord
{

    public static function tableName()
    {
        return '{{apples}}';
    }
}

class Apple extends Model
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'born_at', 'color', 'status', 'piece'], 'required'],
            [['id', 'piece'], 'integer'],
            [['born_at', 'fell_at'], 'safe'],
            [['color', 'status'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'born_at' => 'Born At',
            'fell_at' => 'Fell At',
            'color' => 'Color',
            'status' => 'Status',
            'piece' => 'Piece',
        ];
    }
    public function createApple()
    {
        $r = rand(0,255);
        $g = rand(0,255);
        $b = rand(0,255);
        $hexColor = '#' . dechex($r) . dechex($g) . dechex($b);
        $born = rand(1577836800, 1611568800);

        $apple = new AppleTree();
        $apple->born_at = date('Y-m-d H:i:s', $born);
        $apple->color = $hexColor;
        $apple->status = 'on tree';
        $apple->piece = 100;
        $apple->save();

    }

    public function generateApples($quantity = 1)
    {
        $i = 0;
        while ($i < $quantity) {
            $this->createApple();
            $i++;
        }
    }

    public function viewApples()
    {
        $appleTree = (new \yii\db\Query())->select('*')->from('apples')->all();
        return $appleTree;
    }

    public function deleteApple($id)
    {
        $apple = AppleTree::findOne($id);
        $apple->delete();
    }

    public function fallDown($id)
    {
        $apple = AppleTree::findOne($id);
        $apple->fell_at = date('Y-m-d H:i:s', time());
        $apple->status = 'felt';
        $apple->save();
    }

    public function eatApple($id, $percent)
    {
        $apple = AppleTree::findOne($id);
        if ($apple->status != 'turd') {
            $apple->piece = $percent;
            $apple->save();
        } else {
            return false;
        }
    }

    public function size($id)
    {
        return AppleTree::findOne($id)->piece;
    }

    public function color($id)
    {
        return AppleTree::findOne($id)->color;
    }

    public function turnToTurd($id)
    {
        $apple = AppleTree::findOne($id);
        $apple->color = '#7a5901';
        $apple->status = 'turd';
        $apple->save();
    }

}


