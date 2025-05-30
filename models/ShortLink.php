<?php
/**
 * This file is part of the mgrechanik/short-links project
 *
 * @copyright Copyright (c) Mikhail Grechanik <mike.grechanik@gmail.com>
 * @license https://github.com/mgrechanik/short-links/blob/main/LICENSE.md
 * @link https://github.com/mgrechanik/short-links
 */
declare(strict_types=1);

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\service\UrlCheckService;

/**
 * This is the model class for table "short_link".
 *
 * @property int $id
 * @property string $short_url Алиас - короткая ссылка
 * @property string $long_url Полный адрес ссылки
 * @property int $view_count Количество просмотров
 * @property int|null $created_at Добавлен
 * @property int|null $updated_at Изменен
 *
 * @property Visit[] $visits
 */
class ShortLink extends \yii\db\ActiveRecord
{
    public const SCENARIO_CREATE = 'create';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'short_link';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['view_count'], 'default', 'value' => 0],
            [['short_url', 'long_url'], 'required'],
            [['long_url'], 'string'],
            [['long_url'], 'checkLoop'],
            [['long_url'], 'checkLink'],
            [['view_count', 'created_at', 'updated_at'], 'integer'],
            [['short_url'], 'string', 'max' => 10],
            [['short_url'], 'unique'],
        ];
    }

    public function checkLink($attribute, $params, $validator)
    {
        $url = $this->$attribute;
        $service = new UrlCheckService();
        if (!$service->isValidUrlWithIDN($url)) {
            $this->addError($attribute, 'Не корректная ссылка');
        }

        if (!$service->isAccessible($url)) {
            $this->addError($attribute, 'Не доступная ссылка');
        }
    }

    public function checkLoop($attribute, $params, $validator)
    {
        $url = $this->$attribute;
        if (str_starts_with($url, Yii::$app->params['shortLinkPrefix'])) {
            $this->addError($attribute, 'Не разрешено создавать ссылку на короткую ссылку');
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['long_url'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'short_url' => 'Алиас - короткая ссылка',
            'long_url' => 'Полный адрес ссылки',
            'view_count' => 'Кол-во просмотров',
            'created_at' => 'Добавлен',
            'updated_at' => 'Изменен',
        ];
    }

    /**
     * Gets query for [[Visits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisits()
    {
        return $this->hasMany(Visit::class, ['id_slink' => 'id']);
    }

    /**
     * @return string Короткая ссылка
     */
    public function getShortUrl()
    {
        $prefix = Yii::$app->params['shortLinkPrefix'];
        return $prefix . 'sl/' . $this->short_url;
    }

}
