<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Product extends Migration
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
				'constraint'     => '150',
			],
			'created_at timestamp',
			'updated_at timestamp',
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('product');
	}

	public function down()
	{
		$this->forge->dropTable('product');
	}
}
