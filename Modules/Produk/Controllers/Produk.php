<?php

namespace Modules\Produk\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use Modules\Produk\Models\ProdukModel;
class Produk extends BaseController
{
    protected $produkModel;
    use ResponseTrait;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        return view('Modules\Produk\Views\index');
    }

    public function getData()
    {
        $data = $this->produkModel->findAll();

        if (empty($data)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        return $this->response->setJSON(['status' => true, 'data' => $data]);
    }

    public function simpan()
    {
        $model = new ProdukModel();
        $data = [
            'nama'  => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
        ];
        $model->save($data);
        return $this->respondCreated(['status' => true, 'message' => 'Data berhasil disimpan']);
    }

    public function getById($id)
    {
        $data = $this->produkModel->find($id);

        if (!$data) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $data
        ]);
    }

    public function update()
    {
        $id = $this->request->getPost('id');

        $data = [
            'nama'  => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
        ];

        $this->produkModel->update($id, $data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil diupdate'
        ]);
    }
    public function delete($id)
    {
        $this->produkModel->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}