<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubCategoryProduct extends Migration
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
			'date'       => [
				'type'           => 'DATE',
			],
			'id_sub_category'          => [
				'type'           => 'INT',
				'constraint'     => 9,
				'unsigned'       => TRUE,
			],
			'id_product'          => [
				'type'           => 'INT',
				'constraint'     => 9,
				'unsigned'       => TRUE,
			],
			'created_at timestamp',
			'updated_at timestamp',
		]);
		$this->forge->addForeignKey('id_sub_category', 'sub_category', 'id');
		$this->forge->addForeignKey('id_product', 'product', 'id');
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('subcategory_product');
	}

	public function down()
	{
		$this->forge->dropTable('subcategory_product');
	}
}
