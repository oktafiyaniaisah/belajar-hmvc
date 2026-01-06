<?php
namespace Modules\Produk\Controllers;
use App\Controllers\BaseController;
use Modules\Produk\Models\ProdukModel;
use CodeIgniter\API\ResponseTrait;

class Produk extends BaseController {
    use ResponseTrait;

    public function index() {
        return view('Modules\Produk\Views\index');
    }

    public function getData() {
    $model = new ProdukModel();
    $data = $model->findAll();
    return $this->response->setJSON($data); // Cara eksplisit mengirim JSON
    }

    public function simpan() {
        $model = new ProdukModel();
        $data = [
            'nama'  => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
        ];
        $model->save($data);
        return $this->respondCreated(['status' => true, 'message' => 'Data berhasil disimpan']);
    }
    
    // Fungsi delete, edit, dll bisa ditambahkan di sini
}