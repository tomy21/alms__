<?= $this->extend('layout/index'); ?>
<?= $this->section('judul'); ?>
<h1>Inbound</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="card">
    <div class="card-header bg-white">
        <h5 class="float-left">Table List Resi</h5>
        <button class="btn btn-primary float-sm-right" onclick="location.href=('<?= site_url() ?>CInbound/createNewInbound')" title="Buat Inbound" id="simpanResi"><i class="fa fa-plus"></i> Buat Inbound</button>
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped table-bordered" id="example1" style="width: 100%; text-align:center; align-items:center; margin:auto;">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 30%;">No Inbound</th>
                    <th>Jumlah Paket</th>
                    <th>Created Date</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modalListResi" style="display: none;"></div>
<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            "processing": true,
            searching: true,
            "serverSide": true,
            "responsive": true,
            "order": [],
            "info": true,
            "ajax": {
                "url": "<?php echo site_url('CInbound/dataAjax') ?>",
                "type": "POST",
            },
            "lengthMenu": [10, 25, 50, 75, 100, 1000],
        });
    });

    function detail(id) {
        $.ajax({
            url: "<?= site_url('CInbound/modalList') ?>",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.modalListResi').html(response.data).show();
                    $('#modalList').modal('show');
                }
            }
        });
    }
</script>
<?= $this->endsection('isi'); ?>