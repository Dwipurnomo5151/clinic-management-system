<?php

class m250415_105155_add_status_to_wilayah extends CDbMigration
{
	public function up()
	{
		$this->addColumn('wilayah', 'status', "string NOT NULL DEFAULT 'aktif'");
	}

	public function down()
	{
		$this->dropColumn('wilayah', 'status');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}