<?php
namespace common\models\sys;

use Yii;

/**
 * This is the model class for table "{{%sys_auth_item_child}}".
 *
 * @property string $parent
 * @property string $child
 *
 * @property AuthItem $parent0
 * @property AuthItem $child0
 */
class AuthItemChild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sys_auth_item_child}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent', 'child'], 'unique', 'targetAttribute' => ['parent', 'child']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['child' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
        ];
    }

    /**
     * 重新写入授权
     *
     * @param string $parent 角色名称
     * @param array $auth 授权的路由数组
     * @return int
     * @throws \yii\db\Exception
     */
    public function accredit($parent, $auth)
    {
        // 删除原先所有权限
        $this::deleteAll(['parent' => $parent]);

        $data = [];
        foreach ($auth as $value)
        {
            $data[] = [$parent, $value];
        }

        if (!empty($data))
        {
            // 批量插入数据
            $field = ['parent', 'child'];
            return Yii::$app->db->createCommand()->batchInsert($this::tableName(), $field, $data)->execute();
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'child']);
    }
}
