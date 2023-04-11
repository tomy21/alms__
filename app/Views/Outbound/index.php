<?= $this->extend('layout/index'); ?>
<?= $this->section('judul'); ?>
<h1>Outbound</h1>
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
                <h5>JNT Gateway</h5>
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
                <h5>JNT Palmerah</h5>
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
                <h5>Galur</h5>
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
                <h5>SPX SLA</h5>
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
                <h5>JNE Gateway</h5>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
        </div>
    </div>
</div>

<div class="card col-6">
    <div class="card-body">
        <input type="text" id="idOutbound" name="idOutbound" class="form-control mb-3 font-weight-bold" value="<?= $idOutbound ?>" readonly>
        <div class="row">
            <div class="form-group col-6">
                <select class="form-control select2bs4" id="sorting" name="sorting" style="width: 100%;" required>
                    <option value=""> -- Pilih Baging Sorting -- </option>
                    <?php
                    foreach ($listSorting as $x) :
                    ?>
                        <option value="<?= $x->id_sorting ?>">
                            <?= $x->code_sorting ?> | <?= $x->namaEkspedisi ?> |
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-6">
                <select class="form-control select2bs4" id="agen" name="agen" style="width: 100%;">
                    <option value=""> -- Pilih Agen -- </option>
                    <?php
                    foreach ($agen as $x) :
                    ?>
                        <option value="<?= $x->id_agen ?>">
                            <?= $x->nama_agen ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button id="btnSubmit" type="submit" class="btn btn-success float-right"> <i class="fa fa-save"></i> Simpan </button>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="float-left">Table List Resi</h5>
        <button class="btn btn-success float-sm-right" title="Simpan Manifest" id="simpanResi"><i class="fa fa-save"></i> Selesai</button>
    </div>
    <div class="card-body">
        <div class="row" id="tampilTableOutbound">
        </div>
    </div>
</div>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })

    function kosong() {
        $('#sorting').val('');
        $('#sorting').focus();
    }

    function tampilTabel() {
        $.ajax({
            type: "post",
            url: "<?= site_url('COutbound/tableOutbound') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#tampilTableOutbound').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }


    $('#btnSubmit').click(function() {

        let idSorting = $('#sorting').val();
        let agen = $('#agen').val();
        let idOutbound = $('#idOutbound').val();

        if (idSorting.length == 0) {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'No Sorting Tidak Boleh Kosong',
                showConfirmButton: false,
                timer: 1000
            });
            play_notifSalah();
        } else if (agen.length == 0) {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Agen harus diisi',
                showConfirmButton: false,
                timer: 1000
            });
            play_notifSalah();
        } else {
            $.ajax({
                type: "post",
                url: "<?= site_url('COutbound/addOutbound') ?>",
                data: {
                    idSorting: idSorting,
                    agen: agen,
                    idOutbound: idOutbound,
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        tampilTabel();
                        play_notif();
                        window.location.reload();
                    };
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
                }
            });
        }
    });

    $('#simpanResi').click(function(e) {
        e.preventDefault();
        let codeOutbound = $('#idOutbound').val();

        Swal.fire({
            title: 'Apakah yakin untuk menyimpan inbound ?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            $.ajax({
                type: "post",
                url: "<?= site_url('COutbound/simpanOutbound') ?>",
                data: {
                    codeOutbound: codeOutbound
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

    $(document).ready(function() {
        tampilTabel();
    });
</script>

<?= $this->endsection('isi'); ?>