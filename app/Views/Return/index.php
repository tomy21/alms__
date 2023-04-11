<?= $this->extend('layout/index'); ?>
<?= $this->section('judul'); ?>
<h1>Return</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<div class="row row-cols-2 mb-3">
    <div class="col-6">
        <button class="btn btn-info mr-2" onclick="location.href=('<?= site_url() ?>CReturn/createOutbound')">Outbound Return</button>
        <!-- <button class="btn btn-warning mr-2" onclick="location.href=('<?= site_url() ?>CReturn/historyReturn')">History Return</button> -->
    </div>
</div>
<div class="card p-0" style="width: 30%;">
    <div class="card-header bg-cyan">
        <h6>Scan Terima Return</h6>
    </div>
    <div class="card-body">
        <input type="text" id="noawb" name="noawb" class="form-control" autofocus value="" placeholder="Scan awb here">
    </div>
</div>
<div class="card">
    <div class="card-header">
        Tabel Return
    </div>
    <div class="card-body">
        <table id="example1" class="table table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <!-- <th>Invoice</th> -->
                    <th>No AWB</th>
                    <th>Code Outbound</th>
                    <th>Warehouse</th>
                    <th>Ekspedisi</th>
                    <th>Agen</th>
                    <th>Status</th>
                    <th>Received Date</th>
                    <th>SLA</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
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
                "url": "<?php echo site_url('CReturn/dataAjax') ?>",
                "type": "POST",
            },
            "lengthMenu": [10, 25, 50, 100, 500],
        });

        $("#noawb").keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                let awb = $("#noawb").val();

                if (awb.length == 0) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Awb Tidak Boleh Kosong',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    play_notifSalah();
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('CReturn/addReturn') ?>",
                        data: {
                            awb: awb,
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $("#noawb").html('<i class="fa fa-spin fa-spinner"</i>')
                        },
                        success: function(response) {
                            if (response.success) {
                                play_notif();
                                kosong();
                            }
                            if (response.error) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: response.error,
                                    showConfirmButton: false,
                                    timer: 2300
                                });
                                play_notifSalah();
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + '\n' + thrownError);
                        }
                    });
                }
            }
        });
    });

    function hapus(id) {
        Swal.fire({
            title: 'Hapus resi ini',
            text: "Yakin untuk hapus resi ini ? ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('CReturn/hapusData') ?>",
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
</script>

<?= $this->endsection('isi'); ?>