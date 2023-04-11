<?= $this->extend('layout/index'); ?>
<?= $this->section('judul'); ?>
<h1>Status</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="card">
    <div class="card-header">
        Tabel Transaksi
    </div>
    <div class="card-body">
        <table id="example1" class="table table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>No AWB</th>
                    <th>Warehouse</th>
                    <th>Ekspedisi</th>
                    <th>Status POD</th>
                    <th>Description</th>
                    <th>Status HUB</th>
                    <th>Ongkir</th>
                    <th>SLA</th>
                    <th>#</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modalList" style="display: none;"></div>
<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [],
            "info": true,
            "ajax": {
                "url": "<?php echo site_url('CStatus/dataAjax') ?>",
                "type": "POST",
            },
            "lengthMenu": [10, 25, 50, 75, 100, 1000],
            dom: 'lBftip', // Add the Copy, Print and export to CSV, Excel and PDF buttons
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }],
        });
    });

    function detail(id) {
        $.ajax({
            url: "<?= site_url('CStatus/modalTrack') ?>",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.modalList').html(response.data).show();
                    $('#modalList').modal('show');
                }
            }
        });
    }
</script>
<?= $this->endsection('isi'); ?>