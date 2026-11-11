<?php
namespace App\Models;
use CodeIgniter\Model;
class ProductoModel extends Model
{
    protected $table='productos';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['nombre','descripcion','precio','cantidad'];
    protected $useTimestamps=false;
}
