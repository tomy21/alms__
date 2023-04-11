<div class="col-sm-2">
    <div class="small-box bg-secondary">
        <div class="inner">
            <h1 style="font-weight: 500;"></h1>
            <h5>Total Paket : <?= $count ?></h5>
        </div>
        <div class="icon">
            <i class="ion ion-cube"></i>
        </div>
    </div>
</div>

<table class="table table-sm table-striped table-bordered" id="example1" style="width: 100%; text-align:center; align-items:center; margin:auto;">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 30%;">No Resi</th>
            <th>Brand Logistic</th>
            <th>Warehouse</th>
            <th>Status</th>
            <th>Created Date</th>
            <th style="width: 15%;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($query as $row) :
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->resi ?></td>
                <td><?= $row->namaEkspedisi ?></td>
                <td><?= $row->namaCustomer ?></td>
                <td><?= $row->desc == 1 ? '<span class="badge text-bg-success">In HUB</span>' : '<span class="badge text-bg-danger">Out HUB</span>'  ?></td>
                <td><?= $row->created_at ?></td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="hapus(<?= $row->id_inbound ?>)"><i class="fa fa-trash-alt"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function hapus(id) {
        Swal.fire({
            title: 'Hapus Data resi',
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
                    url: "<?= site_url('CInbound/hapusData') ?>",
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