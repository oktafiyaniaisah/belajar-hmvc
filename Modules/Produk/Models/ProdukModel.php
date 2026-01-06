<?php
namespace Modules\Produk\Models;
use CodeIgniter\Model;

class ProdukModel extends Model {
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'harga'];
}