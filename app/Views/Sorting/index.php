<?= $this->extend('layout/index'); ?>
<?= $this->section('judul'); ?>
<h1>Sorting</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<button class="btn btn-danger mb-4" onclick="history.back()"><i class="fa fa-backward"></i> Back</button>
<div class="row">
    <div class="col-sm-2">
        <div class="small-box bg-success">
            <div class="inner">
                <h1 style="font-weight: 500;">1000</h1>
                <h5>Total Paket</h5>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="small-box bg-danger">
            <div class="inner">
                <h1 style="font-weight: 500;">10000</h1>
                <h5>Total JNT</h5>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="small-box bg-primary">
            <div class="inner">
                <h1 style="font-weight: 500;">10000</h1>
                <h5>Total JNE</h5>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="small-box bg-warning">
            <div class="inner">
                <h1 style="font-weight: 500;">10000</h1>
                <h5>Total Shopee Xpress</h5>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="small-box bg-danger">
            <div class="inner">
                <h1 style="font-weight: 500;">10000</h1>
                <h5>Total Sicepat</h5>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h1 style="font-weight: 500;">10000</h1>
                <h5>Total Manual</h5>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
        </div>
    </div>
</div>

<div class="card col-6">
    <div class="card-body">
        <input type="text" id="idSorting" name="idSorting" class="form-control mb-3 font-weight-bold" value="<?= $code ?>" readonly>
        <div class="row">
            <div class="form-group col-6">
                <select class="form-control select2bs4" id="ekspedisi" name="ekspedisi" style="width: 100%;" required>
                    <option value=""> -- Pilih Ekspedisi -- </option>
                    <?php
                    foreach ($ekspedisi as $data) :
                    ?>
                        <option value="<?= $data->id_ekspedisi ?>">
                            <?= $data->ekspedisi ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-6">
                <select class="form-control select2bs4" id="area" name="area" style="width: 100%;">
                </select>
            </div>
        </div>
        <input type="text" id="barcode" name="barcode" class="form-control mb-3 font-weight-bold" value="" placeholder="Scan Here" autofocus>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="float-left">Table List Resi</h5>
        <button class="btn btn-success float-sm-right" title="Simpan Manifest" id="simpanResi"><i class="fa fa-save"></i> Selesai</button>
    </div>
    <div class="card-body">
        <div class="row" id="tampilTableSorting">
        </div>
    </div>
</div>

<script>
    function kosong() {
        $('#barcode').val('');
        $('#barcode').focus();
    }
    $(document).ready(function() {
        $('#ekspedisi').change(function(e) {
            var id_eks = $("#ekspedisi").val();
            $.ajax({
                type: "post",
                url: "<?= site_url('CSorting/areaEkspedisi') ?>",
                data: {
                    id_eks: id_eks
                },
                success: function(response) {
                    $('#area').html(response);
                }
            });

        });
    });
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })

    function manifestTemp() {
        let manifest = $('#noawb').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('CSorting/tableSorting') ?>",
            data: {
                manifest: manifest
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#tampilTableSorting').html(response.data);
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
                let idIn = $("#idSorting").val();
                let ekspedisi = $("#ekspedisi").val();
                let area = $("#area").val();

                if (awb.length == 0) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Awb Tidak Boleh Kosong',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    play_notifSalah();
                } else if (ekspedisi.length == 0) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Ekspedisi Tidak Boleh Kosong',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    play_notifSalah();
                } else if (area.length == 0) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Area Tidak Boleh Kosong',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    play_notifSalah();
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('CSorting/addSorting') ?>",
                        data: {
                            awb: awb,
                            idIn: idIn,
                            area: area,
                            ekspedisi: ekspedisi,
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $("#barcode").html('<i class="fa fa-spin fa-spinner"</i>')
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
    });
    $("#simpanResi").click(function(e) {
        e.preventDefault();
        let codeSorting = $("#idSorting").val();
        let ekspedisi   = $("#ekspedisi").val();
        Swal.fire({
            title: 'Apakah yakin untuk menyimpan inbound ?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('CSorting/simpanSorting') ?>",
                    data: {
                        codeSorting: codeSorting,
                        ekspedisi: ekspedisi,
                    },
                    dataType: "json",
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
            }
        })
    });
</script>

<?= $this->endsection('isi'); ?>