<?php

class m250415_143102_add_timestamps_to_user extends CDbMigration
{
    public function up()
    {
        // Add timestamp columns
        $this->addColumn('user', 'created_at', 'timestamp DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('user', 'updated_at', 'timestamp DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('user', 'created_by', 'integer');
        $this->addColumn('user', 'updated_by', 'integer');

        // Add foreign keys for created_by and updated_by
        $this->addForeignKey('fk_user_created_by', 'user', 'created_by', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_user_updated_by', 'user', 'updated_by', 'user', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        // Drop foreign keys first
        $this->dropForeignKey('fk_user_created_by', 'user');
        $this->dropForeignKey('fk_user_updated_by', 'user');

        // Drop columns
        $this->dropColumn('user', 'created_at');
        $this->dropColumn('user', 'updated_at');
        $this->dropColumn('user', 'created_by');
        $this->dropColumn('user', 'updated_by');
    }
} 