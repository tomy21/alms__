<?= $this->extend('layout/index'); ?>
<?= $this->section('judul'); ?>
<h1>Inbound</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<button class="btn btn-danger mb-4" onclick="history.back()"><i class="fa fa-backward"></i> Back</button>
<div class="row justify-content-between pl-2 pr-2">
    <div class="card p-0" style="width: 30%;">
        <div class="card-header bg-cyan">
            <h6>Scan Inbound</h6>
        </div>
        <div class="card-body">
            <input type="text" name="idInbound" id="idInbound" class="form-control mb-3 font-weight-bold" value="<?= $idInbound ?>" readonly>
            <div class="row">
                <div class="form-group col-6">
                    <select class="form-control select2bs4" id="warehouse" name="warehouse" style="width: 100%;" required>
                        <option value=""> -- Pilih Warehouse -- </option>
                        <?php
                        foreach ($data as $data) :
                        ?>
                            <option value="<?= $data->id_customer ?>">
                                <?= $data->nama_customer ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-6">
                    <select class="form-control select2bs4" id="ekspedisi" name="ekspedisi" style="width: 100%;">
                        <option value=""> -- Pilih Ekspedisi -- </option>
                        <?php
                        foreach ($ekspedisi as $x) :
                        ?>
                            <option value="<?= $x->id_ekspedisi ?>">
                                <?= $x->ekspedisi ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <input type="text" id="noawb" name="noawb" class="form-control" autofocus value="" placeholder="Scan awb here">
            <p class="mt-3 mb-0 font-italic font-weight-bold">NB : Pilih warehouse dulu</p>
        </div>
    </div>

    <div class="card card-cyan p-0" style="width: 30%;">
        <div class="card-header">
            <h3 class="card-title">Import Data Manifest</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="row">
                <?= form_open_multipart('CInbound/Upload') ?>
                <?= session()->getFlashdata('error'); ?>
                <?= session()->getFlashdata('success'); ?>
                <input type="text" name="barcode" class="form-control mb-3 font-weight-bold" value="<?= $idInbound ?>" readonly>
                <div class="form-group">
                    <select class="form-control select2bs4" name="warehouse" style="width: 100%;" required>
                        <option value=""> -- Pilih Warehouse -- </option>
                        <?php
                        foreach ($wh as $i) :
                        ?>
                            <option value="<?= $i->id_customer ?>">
                                <?= $i->nama_customer ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <label for="fileInput">File input</label>
                <div class="input-group row">
                    <div class="form-group col-md-12">
                        <input type="file" class="form-control" name="fileimport" accept=".xls,.xlsx ">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-success form-control">Upload</button>
                    </div>
                    <?= form_close(); ?>
                    <?= form_open('CInbound/download') ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info form-control"> <i class="fa fa-download"></i>
                            download tamplate</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-cyan p-0" style="width: 30%;">
        <div class="card-header">
            <h6>Total Proses</h6>
        </div>
        <div class="card-body row">
            <h3 style="margin-right: 30%;">Total Hari ini</h3>
            <h3><?= number_format($total, 0, ',', '.') ?></h3>
        </div>
        <div class="card-body row">
            <h3 style="margin-right: 12%;">Scan Current</h3>
            <h3><?= number_format($count, 0, ',', '.') ?></h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="float-left">Table List Resi</h5>
        <button class="btn btn-success float-sm-right" title="Simpan Manifest" id="simpanResi"><i class="fa fa-save"></i> Selesai</button>
    </div>
    <div class="card-body">
        <div class="row" id="tampilTableInbound">
        </div>
    </div>
</div>

<script>
    function kosong() {
        $('#noawb').val('');
        $('#noawb').focus();
    }
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
            url: "<?= site_url('CInbound/tableInbound') ?>",
            data: {
                manifest: manifest
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#tampilTableInbound').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    $(document).ready(function() {
        manifestTemp();
        $("#noawb").keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                let awb = $("#noawb").val();
                let idIn = $("#idInbound").val();
                let warehouse = $("#warehouse").val();
                let ekspedisi = $("#ekspedisi").val();

                if (awb.length == 0) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Awb Tidak Boleh Kosong',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    play_notifSalah();
                    kosong()
                } else if (warehouse.length == 0) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Warehouse Tidak Boleh Kosong',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    play_notifSalah();
                    kosong()
                } else if (ekspedisi.length == 0) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Logistik Tidak Boleh Kosong',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    play_notifSalah();
                    kosong()
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('CInbound/addInbound') ?>",
                        data: {
                            awb: awb,
                            idIn: idIn,
                            warehouse: warehouse,
                            ekspedisi: ekspedisi,
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
                                kosong()
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
        let codeInbound = $("#idInbound").val();
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
                    url: "<?= site_url('CInbound/submitInbound') ?>",
                    data: {
                        codeInbound: codeInbound
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