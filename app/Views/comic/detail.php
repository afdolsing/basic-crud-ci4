<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h3>Detail Komik</h3>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/<?= $komik['sampul'] ?>" class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $komik['judul'] ?></h5>
                            <p class="card-text"><b>Penulis : </b><?= $komik['penulis'] ?></p>
                            <p class="card-text"><small class="text-muted"><b><?= $komik['penerbit'] ?></b></small></p>

                            <a href="/comics/edit/<?= $komik['slug'] ?>" class="btn btn-warning">Edit</a>
                            <form action="/comics/<?= $komik['id'] ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('yakin delete bro?')">Delete</button>
                            </form>
                            <br><br>
                            <a href="/comics" class="btn btn-primary">Kembali ke daftar komik</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>