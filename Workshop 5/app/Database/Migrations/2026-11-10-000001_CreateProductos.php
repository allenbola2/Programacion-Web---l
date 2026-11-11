<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateProductos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'nombre'=>['type'=>'VARCHAR','constraint'=>120],
            'descripcion'=>['type'=>'TEXT','null'=>true],
            'precio'=>['type'=>'DECIMAL','constraint'=>'10,2','default'=>0],
            'cantidad'=>['type'=>'INT','default'=>0],
        ]);
        $this->forge->addKey('id',true);
        $this->forge->createTable('productos');
    }
    public function down(){ $this->forge->dropTable('productos'); }
}
