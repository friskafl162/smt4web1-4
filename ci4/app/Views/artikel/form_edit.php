<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<form action="" method="post">

    <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input
            type="text"
            name="judul"
            id="judul"
            class="form-control"
            value="<?= $artikel['judul']; ?>"
            required
        >
    </div>

    <div class="mb-3">
        <label for="isi" class="form-label">Isi</label>
        <textarea
            name="isi"
            id="isi"
            rows="10"
            class="form-control"
        ><?= $artikel['isi']; ?></textarea>
    </div>

    <div class="mb-3">
        <label for="id_kategori" class="form-label">Kategori</label>
        <select
            name="id_kategori"
            id="id_kategori"
            class="form-select"
            required
        >
            <?php foreach ($kategori as $k) : ?>
                <option
                    value="<?= $k['id_kategori']; ?>"
                    <?= ($artikel['id_kategori'] == $k['id_kategori']) ? 'selected' : ''; ?>
                >
                    <?= $k['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Simpan Perubahan
    </button>

</form>

<?= $this->include('template/admin_footer'); ?>