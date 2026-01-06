<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Daftar Produk</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProduk">Tambah Produk</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="v-data">
                </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalProduk" tabindex="-1">
    <div class="modal-dialog">
        <form id="formProduk" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Produk</h5>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        loadData();

        // Ambil Data via JSON
        function loadData() {
        $.ajax({
            url: '<?= base_url('produk/getData') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                let html = '';
                if (Array.isArray(res) && res.length > 0) {
                    res.forEach(item => {
                        html += `<tr>
                            <td>${item.nama}</td>
                            <td>${item.harga}</td>
                            <td><button class="btn btn-sm btn-danger">Hapus</button></td>
                        </tr>`;
                    });
                } else {
                    html = '<tr><td colspan="3" class="text-center">Belum ada data produk.</td></tr>';
                }
                $('#v-data').html(html);
            },
            error: function(xhr) {
                // Jika error 404 muncul lagi, pesan ini akan tampil di tabel
                $('#v-data').html('<tr><td colspan="3" class="text-center text-danger">Gagal memuat data (404 Not Found).</td></tr>');
            }
        });
    }
        // Simpan Data via AJAX
        $('#formProduk').submit(function(e) {
            e.preventDefault();
            $.post('<?= base_url('produk/simpan') ?>', $(this).serialize(), function(res) {
                Swal.fire('Berhasil', res.message, 'success');
                $('#modalProduk').modal('hide');
                $('#formProduk')[0].reset();
                loadData();
            });
        });
    });
</script>
<?= $this->endSection() ?>