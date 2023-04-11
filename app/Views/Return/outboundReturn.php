<?= $this->extend('layout/index'); ?>
<?= $this->section('judul'); ?>
<h1>Outbound Return</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="row mb-2">
    <div class="col-6">
        <button class="btn btn-info mr-2" onclick="location.href=('<?= site_url() ?>CReturn/index')"><i class="fa fa-backward"></i> Back</button>
    </div>
</div>

<div class="card col-6">
    <div class="card-body">
        <input type="text" id="idReturn" name="idReturn" class="form-control mb-3 font-weight-bold" value="<?= $idReturn ?>" readonly>
        <input type="text" id="barcode" name="barcode" class="form-control mb-3 font-weight-bold" value="" placeholder="Scan Here" autofocus>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="float-left">Table List Resi</h5>
        <button class="btn btn-success float-sm-right" title="Simpan Manifest" id="simpanResi"><i class="fa fa-save"></i> Selesai</button>
    </div>
    <div class="card-body">
        <div class="row" id="tampilTableReturn">
        </div>
    </div>
</div>

<script>
    function kosong() {
        $('#barcode').val('');
        $('#barcode').focus();
    }

    function manifestTemp() {
        let manifest = $('#noawb').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('CReturn/tableReturn') ?>",
            data: {
                manifest: manifest
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#tampilTableReturn').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    $(document).ready(function() {
        manifestTemp();
        $("#barcode").keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                let awb = $("#barcode").val();
                let idReturn = $("#idReturn").val();
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
                        url: "<?= site_url('CReturn/addOutReturn') ?>",
                        data: {
                            awb: awb,
                            idReturn: idReturn,
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $("#noawb").html('<i class="fa fa-spin fa-spinner"</i>')
                        },
                        success: function(response) {
                            if (response.success) {
                                manifestTemp();
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
        $('#simpanResi').click(function(e) {
            e.preventDefault();
            let codeReturn = $('#idReturn').val();

            Swal.fire({
                title: 'Apakah yakin untuk menyimpan inbound ?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
            }).then((result) => {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('CReturn/simpanReturn') ?>",
                    data: {
                        codeReturn: codeReturn
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
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
                        if (response.error) {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: response.error,
                                showConfirmButton: false,
                                timer: 1000
                            });
                            play_notifSalah();
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        }
                    }
                });
            });
        });
    });
</script>

<?= $this->endsection('isi'); ?>