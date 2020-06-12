<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Category extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 9,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'name'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'state'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'created_at timestamp',
			'updated_at timestamp',
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('category');
	}

	public function down()
	{
		$this->forge->dropTable('category');
	}
}
