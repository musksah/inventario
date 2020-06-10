<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubCategory extends Migration
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
			'id_category'          => [
				'type'           => 'INT',
				'constraint'     => 9,
				'unsigned'       => TRUE,
			],
			'created_at timestamp',
			'updated_at timestamp',
		]);
		$this->forge->addForeignKey('id_category','sub_category','id');
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('sub_category');
	}

	public function down()
	{
		$
}
