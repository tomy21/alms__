<?= $this->extend('layout/index'); ?>
<?= $this->section('judul'); ?>
<h1>Seller</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Seller</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="btn btn-sm btn-primary p-2 m-2" id="tambahModal"><i class="fa fa-plus mr-3"></i> Tambah Data Seller</div>
        <table id="example1" class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">
                        No
                    </th>
                    <th style="width: 20%">
                        Seller Name
                    </th>
                    <th style="width: 22%;">
                        Address
                    </th>
                    <th>
                        Contact
                    </th>
                    <th>
                        Volume
                    </th>
                    <th>
                        Tagihan Ongkir
                    </th>
                    <th style="width: 8%" class="text-center">
                        Status
                    </th>
                    <th style="width: 9%">
                    </th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<div class="modalTambahSeller" style="display: none;"></div>
<div class="modalUpdate" style="display: none;"></div>

<script>
    function hapus(id) {
        Swal.fire({
            title: 'Hapus Data Seller',
            text: "Yakin untuk hapus Seller ini ? ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('CSellerList/hapusData') ?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.success,
                            showConfirmButton: false,
                            timer: 1000
                        });
                        play_notif();
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    }
                });
            }
        })
    }

    function detail(id) {
        $.ajax({
            url: "<?= site_url('CSellerList/modalUpdate') ?>",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.modalUpdate').html(response.data).show();
                    $('#updateSeller').modal('show');
                }
            }
        });
    }
    $(document).ready(function() {
        $("#tambahModal").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url() ?>CSellerList/modalTambah",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.modalTambahSeller').html(response.data).show();
                        $('#tambahSeller').modal('show');
                    }
                }
            });
        })
    })
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            "processing": true,
            searching: true,
            "serverSide": true,
            "responsive": true,
            "order": [],
            "info": true,
            "ajax": {
                "url": "<?php echo site_url('CSellerList/dataAjax') ?>",
                "type": "POST",
            },
            "lengthMenu": [10, 25, 50, 75, 100, 1000],
            dom: 'lBftip', // Add the Copy, Print and export to CSV, Excel and PDF buttons
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "columnDefs": [{
                    "targets": [4, 5],
                    "orderable": false,
                },
                {
                    targets: 4,
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                },
                {
                    targets: 5,
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                }
            ],
        });
    });
</script>

<?= $this->endsection('isi'); ?>