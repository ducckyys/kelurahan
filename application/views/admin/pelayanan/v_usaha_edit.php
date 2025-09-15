<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Surat Izin Usaha</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Formulir Edit Data</div>
                </div>
                <form action="<?= base_url('admin/surat_usaha/update/' . $surat->id); ?>" method="POST">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Pemohon</label><input type="text" name="nama_pemohon" class="form-control" value="<?= html_escape($surat->nama_pemohon); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK Pemohon</label><input type="text" name="nik_pemohon" class="form-control" value="<?= html_escape($surat->nik_pemohon); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Email Pemohon</label><input type="email" name="email_pemohon" class="form-control" value="<?= html_escape($surat->email_pemohon); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Alamat Domisili</label><input type="text" name="alamat_domisili" class="form-control" value="<?= html_escape($surat->alamat_domisili); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Usaha</label><input type="text" name="nama_usaha" class="form-control" value="<?= html_escape($surat->nama_usaha); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Alamat Usaha</label><input type="text" name="alamat_usaha" class="form-control" value="<?= html_escape($surat->alamat_usaha); ?>" required></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="<?= base_url('admin/surat_usaha'); ?>" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>