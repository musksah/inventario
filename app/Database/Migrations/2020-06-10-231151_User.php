<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
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
			'username'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'rol'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '150',
			],
			'password'       => [
				'type'           => 'TEXT',
			],
			'state'       => [
				'type'           => 'TINYINT',
			],
			'created_at timestamp',
			'updated_at timestamp',
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('user');
	}

	public function down()
	{
		$this->forge->dropTable('user');
	}
}
