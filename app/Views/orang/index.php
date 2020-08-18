<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-6">
            <h2 class="mt-1">Daftar Orang</h2>
            <form action="" method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari orang.." name="keyword">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 + (5 * ($curent_page - 1)) ?>
                    <?php foreach ($orang as $org) : ?>
                        <tr>
                            <th scope="row"><?= $no ?></th>
                            <td><?= $org['nama'] ?></td>
                            <td><?= $org['alamat'] ?></td>
                            <td>
                                <a href="" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                        <?php $no++ ?>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?= $pager->links('orang', 'orang_pagination') ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>