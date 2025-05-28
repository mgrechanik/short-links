<?php

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
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%short_link}}');
    }
}
