<?php

declare(strict_types=1);

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property int $id_slink Внешний ключ на короткую ссылку
 * @property int $ip ip адресс
 * @property int|null $created_at Добавлен
 *
 * @property ShortLink $slink
 */
class Visit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visit';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'default', 'value' => null],
            [['id_slink', 'ip'], 'required'],
            [['id_slink', 'ip', 'created_at'], 'integer'],
            [['id_slink'], 'exist', 'skipOnError' => true, 'targetClass' => ShortLink::class, 'targetAttribute' => ['id_slink' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_slink' => 'Внешний ключ на короткую ссылку',
            'ip' => 'ip адресс',
            'created_at' => 'Добавлен',
        ];
    }

    /**
     * Gets query for [[Slink]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSlink()
    {
        return $this->hasOne(ShortLink::class, ['id' => 'id_slink']);
    }

    public function setIpFromString($ip)
    {
        $this->ip = ip2long($ip);
    }
}
