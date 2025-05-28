<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%visit}}`.
 */
class m250528_032759_create_visit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%visit}}', [
            'id' => $this->primaryKey(),
            'id_slink' => $this->integer()->notNull()->comment('Внешний ключ на короткую ссылку'),
            'ip' => $this->integer()->notNull()->comment('ip адресс'),
            'created_at' => $this->integer()->comment('Добавлен'),
        ]);

        $this->addForeignKey('visit_id_slink_fk', 'visit', 'id_slink', 'short_link', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%visit}}');
    }
}
