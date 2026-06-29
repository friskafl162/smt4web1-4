<?= $this->include('template/admin_header'); ?> <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Data Artikel (AJAX CRUD)</h1>
        <button type="button" class="btn btn-success" id="btnTambah">
            Tambah Artikel
        </button>
    </div>

    <table class="table table-bordered table-striped" id="artikelTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade" id="artikelModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Form Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="artikelForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="artikel_id">
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi</label>
                        <textarea name="isi" id="isi" rows="5" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1">Publish</option>
                            <option value="0">Draft</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/jquery-4.0.0.min.js') ?>"></script>

<script>
$(document).ready(function () {

    function showLoadingMessage() {
        $('#artikelTable tbody').html('<tr><td colspan="4" class="text-center">Loading data...</td></tr>');
    }

    // 1. LOAD DATA (READ)
    function loadData() {
        showLoadingMessage();
        $.ajax({
            url: "<?= base_url('ajax/getData') ?>",
            method: "GET",
            dataType: "json",
            success: function (data) {
                let tableBody = '';
                if(data.length === 0) {
                    tableBody = '<tr><td colspan="4" class="text-center">Tidak ada data.</td></tr>';
                } else {
                    for (let i = 0; i < data.length; i++) {
                        let row = data[i];
                        
                        // Menampilkan Badge Status Asli dari DB
                        let statusBadge = row.status == 1 
                            ? '<span class="badge bg-success">Publish</span>' 
                            : '<span class="badge bg-secondary">Draft</span>';

                        tableBody += '<tr>';
                        tableBody += '<td>' + row.id + '</td>';
                        tableBody += '<td>' + row.judul + '</td>';
                        tableBody += '<td>' + statusBadge + '</td>';
                        tableBody += '<td>';
                        tableBody += '<button class="btn btn-sm btn-info btn-edit me-1" data-id="' + row.id + '">Edit</button>';
                        tableBody += '<button class="btn btn-sm btn-danger btn-delete" data-id="' + row.id + '">Delete</button>';
                        tableBody += '</td>';
                        tableBody += '</tr>';
                    }
                }
                $('#artikelTable tbody').html(tableBody);
            }
        });
    }

    loadData();

    // 2. TRIGGER TOMBOL TAMBAH (Reset Form & Tampilkan Modal)
    $('#btnTambah').click(function () {
        $('#artikelForm')[0].reset();
        $('#artikel_id').val(''); // Kosongkan ID menandakan mode "Tambah"
        $('#modalTitle').text('Tambah Artikel Baru');
        $('#artikelModal').modal('show');
    });

    // 3. ACTION SAVE (BISA INSERT MAUPUN UPDATE)
    $('#artikelForm').submit(function (e) {
        e.preventDefault();
        
        let id = $('#artikel_id').val();
        // Menentukan URL endpoint: kalau ada id berarti edit, kalau kosong berarti tambah
        let urlEndpoint = (id === '') ? "<?= base_url('ajax/save') ?>" : "<?= base_url('ajax/update') ?>";

        $.ajax({
            url: urlEndpoint,
            method: "POST",
            data: $(this).serialize(), // Mengirimkan seluruh inputan form secara otomatis
            dataType: "json",
            success: function (response) {
                if(response.status === 'OK') {
                    $('#artikelModal').modal('hide');
                    loadData(); // Refresh isi tabel tanpa reload halaman
                } else {
                    alert('Gagal menyimpan data');
                }
            }
        });
    });

    // 4. TRIGGER TOMBOL EDIT (Ambil Single Data & Masukkan ke Inputan Modal)
    $(document).on('click', '.btn-edit', function () {
        let id = $(this).data('id');
        
        $.ajax({
            url: "<?= base_url('ajax/getOne/') ?>" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                if(data) {
                    $('#artikel_id').val(data.id);
                    $('#judul').val(data.judul);
                    $('#isi').val(data.isi);
                    $('#status').val(data.status);
                    
                    $('#modalTitle').text('Ubah Artikel');
                    $('#artikelModal').modal('show');
                }
            }
        });
    });

    // 5. ACTION DELETE
    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        let id = $(this).data('id');

        if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
            $.ajax({
                url: "<?= base_url('ajax/delete/') ?>" + id,
                method: "POST", // Diubah ke POST agar seragam di server lokal tertentu
                dataType: "json",
                success: function (response) {
                    if(response.status === 'OK') {
                        loadData();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error menghapus artikel: ' + textStatus);
                }
            });
        }
    });

});
</script>

<?= $this->include('template/admin_footer'); ?>