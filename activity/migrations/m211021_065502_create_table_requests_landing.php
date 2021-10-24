<?php

use yii\db\Migration;

class m211021_065502_create_table_requests_landing extends Migration
{
    /** @var string */
    const TABLE_NAME = '{{project}}.{{%requests_landing}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME,
            [
                'id' => $this->bigPrimaryKey(11),
                'url' => $this->string(1024)->notNull()->comment('url запроса'),
                'date_request' => $this->date()->notNull()->comment('Дата запроса'),
            ]
        );

        $this->createIndex('idx_url', self::TABLE_NAME, ['url']);
        $this->createIndex('idx_date_request', self::TABLE_NAME, ['date_request']);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
