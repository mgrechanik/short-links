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
