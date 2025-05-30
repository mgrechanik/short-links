<?php
/**
 * This file is part of the mgrechanik/short-links project
 *
 * @copyright Copyright (c) Mikhail Grechanik <mike.grechanik@gmail.com>
 * @license https://github.com/mgrechanik/short-links/blob/main/LICENSE.md
 * @link https://github.com/mgrechanik/short-links
 */
use yii\db\Migration;

/**
 * Handles the creation of table `{{%short_link}}`.
 */
class m250528_031911_create_short_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%short_link}}', [
            'id' => $this->primaryKey(),
            'short_url' => $this->string(10)->notNull()->unique()->comment('Алиас - короткая ссылка'),
            'long_url' => $this->text()->notNull()->comment('Полный адрес ссылки'),
            'view_count' => $this->integer()->notNull()->defaultValue(0)->comment('Количество просмотров'),
            'created_at' => $this->integer()->comment('Добавлен'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ], 'CHARACTER SET utf8 COLLATE utf8_bin ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%short_link}}');
    }
}
