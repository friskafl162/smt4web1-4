<?= $this->include('template/admin_header'); ?>
<h2 class="mb-4">Daftar Artikel</h2>

<div class="row mb-3">
    <div class="col-md-6">
        <form id="search-form" class="d-flex gap-2">
            <input type="text" name="q" id="search-box" value="<?= $q; ?>" placeholder="Cari judul..." class="form-control">
            <select name="kategori_id" id="category-filter" class="form-control">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $k) : ?>
                    <option value="<?= $k['id_kategori']; ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>><?= $k['nama_kategori']; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>
</div>

<div id="article-container" class="table-responsive"></div>
<div id="pagination-container" class="mt-4 mb-5 custom-pager"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function fetchData(url) {
        $.ajax({
            url: url, type: 'GET', dataType: 'json',
            success: function(data) {
                let html = `<table class="table table-hover align-middle">
                    <thead><tr><th width="80">ID</th><th>Judul</th><th width="150">Status</th><th width="180">Aksi</th></tr></thead>
                    <tbody>`;
                
                let start = (data.current_page - 1) * data.per_page + 1;
                if(data.artikel.length > 0) {
                    data.artikel.forEach((row, i) => {
                        let status = row.status == 1 ? '<span class="badge bg-success">Publish</span>' : '<span class="badge bg-secondary">Draft</span>';
                        html += `<tr><td>${start + i}</td>
                            <td><strong>${row.judul}</strong><br><small class="text-muted">${row.isi.substring(0, 80)}...</small></td>
                            <td>${status}</td>
                            <td><a class="btn btn-warning btn-sm" href="<?= base_url('/admin/artikel/edit/') ?>/${row.id}">Ubah</a> 
                                <a class="btn btn-danger btn-sm" onclick="return confirm('Hapus?');" href="<?= base_url('/admin/artikel/delete/') ?>/${row.id}">Hapus</a></td></tr>`;
                    });
                } else { html += '<tr><td colspan="4" class="text-center">Belum ada data.</td></tr>'; }
                
                html += `</tbody><tfoot><tr><th>ID</th><th>Judul</th><th>Status</th><th>Aksi</th></tr></tfoot></table>`;
                $('#article-container').html(html);
                $('#pagination-container').html(data.pagination_html);
            }
        });
    }

    $(document).on('click', '.custom-pager a', function(e) { e.preventDefault(); fetchData($(this).attr('href')); });
    $('#search-form').on('submit', function(e) { e.preventDefault(); fetchData("<?= base_url('admin/artikel') ?>?" + $(this).serialize()); });
    fetchData("<?= base_url('admin/artikel') ?>");
});
</script>

<style>
    .custom-pager nav { background: transparent !important; }
    .custom-pager .pagination .active a { background-color: #2f6fb2 !important; color: #fff !important; }
    /* Styling untuk angka pagination yang TIDAK AKTIF (hanya teks biasa) */
    .custom-pager .pagination li span {
        background-color: #f8f9fa !important; /* Abu-abu sangat muda */
        color: #6c757d !important;             /* Warna teks abu-abu agar terlihat pasif */
        border: 1px solid #dee2e6 !important;
        cursor: not-allowed !important;       /* Kursor berubah jadi tanda dilarang */
        opacity: 0.7;
    }

    /* Memastikan link aktif tetap kontras */
    .custom-pager .pagination li a {
        color: #007bff !important;            /* Warna biru standar untuk link aktif */
    }
</style>
<?= $this->include('template/admin_footer'); ?>