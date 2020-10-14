<?php

use yii\db\Migration;

/**
 * Class m201013_082538_init
 */
class m201013_082538_init extends Migration
{
    public function safeUp()
    {
        $this->createTable('domain_files', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string()->notNull(),
            'file_name' => $this->string()->notNull(),
            'status' => $this->integer()->notNull()->unsigned(),
        ]);

        $this->createTable('domains', [
            'id' => $this->primaryKey()->unsigned(),
            'file_id' => $this->integer()->unsigned(),
            'domain' => $this->string()->notNull(),
            'valid' => $this->boolean(),
            'expires' => $this->date()->null(),
            'status' => $this->integer()->unsigned(),
        ]);

        $this->addForeignKey('domain_2_file', 'domains', 'file_id', 'domain_files', 'id', 'SET NULL', 'CASCADE');

        $this->createTable('servers', [
            'id' => $this->primaryKey()->unsigned(),
            'tld' => $this->string(),
            'whois' => $this->string(),
            'is_http' => $this->boolean()->defaultValue(0),
            'domain_only' => $this->boolean()->defaultValue(0),
            'available_string' => $this->string(),
            'expire_string' => $this->string(),
            'server_response' => $this->text(),
            'status' => $this->integer()->unsigned(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('servers');
        $this->dropForeignKey('domain_2_file', 'domains');
        $this->dropTable('domains');
        $this->dropTable('domain_files');
    }
}
