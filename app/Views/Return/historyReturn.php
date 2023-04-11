<?= $this->extend('layout/index'); ?>
<?= $this->section('judul'); ?>
<h1>Hitory Return</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="row mb-2">
    <div class="col-6">
        <button class="btn btn-info mr-2" onclick="location.href=('<?= site_url() ?>CReturn/index')"><i class="fa fa-backward"></i> Back</button>
    </div>
</div>
adsasdasd
<?= $this->endsection('isi'); ?>