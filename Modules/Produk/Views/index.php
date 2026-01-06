<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Daftar Produk</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProduk">Tambah Produk</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="table_produk">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalProduk" tabindex="-1">
    <div class="modal-dialog">
        <form id="formProduk" class="modal-content">
            
            <!-- ID UNTUK MODE EDIT -->
            <input type="hidden" name="id">

            <div class="modal-header">
                <h5 class="modal-title">Form Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" class="btn btn-success">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    var baseUrl = '<?= base_url('produk') ?>';

    $(document).ready(function () {
        showData();
    });

    // =====================
    // LOAD DATA
    // =====================
    function showData() {
        $.ajax({
            url: baseUrl + '/getData',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                let tbody = '';

                if (res.status) {
                    res.data.forEach(function (produk) {
                        tbody += `
                            <tr>
                                <td>${produk.nama}</td>
                                <td class="text-center">${produk.harga}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary btn-edit" data-id="${produk.id}">Edit</button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-id="${produk.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tbody = `<tr><td colspan="3" class="text-center">${res.message}</td></tr>`;
                }

                $('#table_produk tbody').html(tbody);
            }
        });
    }

    
    // EDIT DATA
    
    $(document).on('click', '.btn-edit', function () {
        let id = $(this).data('id');

        $.get(baseUrl + '/getById/' + id, function (res) {
            if (res.status) {
                $('input[name=id]').val(res.data.id);
                $('input[name=nama]').val(res.data.nama);
                $('input[name=harga]').val(res.data.harga);

                $('#modalProduk').modal('show');
            }
        }, 'json');
    });

    
    // SIMPAN & UPDATE
    
    $('#formProduk').submit(function (e) {
        e.preventDefault();

        let id = $('input[name=id]').val();
        let url = id ? baseUrl + '/update' : baseUrl + '/simpan';

        $.post(url, $(this).serialize(), function (res) {
            Swal.fire('Berhasil', res.message, 'success');
            $('#modalProduk').modal('hide');
            $('#formProduk')[0].reset();
            showData();
        }, 'json');
    });

    
    // DELETE DATA
    
    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Yakin hapus data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl + '/delete/' + id,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function (res) {
                        Swal.fire('Berhasil', res.message, 'success');
                        showData();
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>
