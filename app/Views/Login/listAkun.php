<?= $this->extend('layout/index'); ?>
<?= $this->section('judul'); ?>
<h1>Account Users</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="card">
    <div class="card-header bg-white">
        <h5 class="float-left">List Acount Users</h5>
        <div class="float-right btn btn-sm btn-info" id="tambahModal"><i class="fa fa-plus-circle mr-2"></i> Tambah Users</div>
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped table-bordered" id="example1" style="width: 100%; text-align:center; align-items:center; margin:auto;">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 30%;">User Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modalTambahUsers" style="display: none;"></div>
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
                "url": "<?php echo site_url('CUsers/dataAjax') ?>",
                "type": "POST",
            },
            "lengthMenu": [10, 25, 50, 75, 100, 1000],
        });
    });

    $(document).ready(function() {
        $("#tambahModal").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url() ?>CUsers/modalTambah",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.modalTambahUsers').html(response.data).show();
                        $('#tambahUsers').modal('show');
                    }
                }
            });
        })
    })
</script>
<?= $this->endsection('isi'); ?>