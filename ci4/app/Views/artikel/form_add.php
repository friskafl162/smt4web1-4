<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<form action="" method="post" enctype="multipart/form-data">

    <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input
            type="text"
            name="judul"
            id="judul"
            class="form-control"
            required
        >
    </div>

    <div class="mb-3">
        <label for="isi" class="form-label">Isi</label>
        <textarea
            name="isi"
            id="isi"
            cols="50"
            rows="10"
            class="form-control"
        ></textarea>
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
                <option value="<?= $k['id_kategori']; ?>">
                    <?= $k['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="gambar" class="form-label">Pilih Gambar Artikel</label>
        <input 
            type="file" 
            name="gambar" 
            id="gambar" 
            class="form-control"
            accept="image/*"
        >
        <div class="form-text">Format file harus berupa gambar (jpg, jpeg, png).</div>
    </div>

    <button type="submit" class="btn btn-primary">
        Kirim
    </button>

</form>
<br>
<?= $this->include('template/admin_footer'); ?>