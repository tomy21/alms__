<table class="table table-sm table-striped table-bordered" id="example1" style="width: 100%; text-align:center; align-items:center; margin:auto;">
    <thead>
        <th style="width: 5%;">No</th>
        <th style="width: 20%;">No Resi</th>
        <th>Ekspedisi</th>
        <th>Warehouse</th>
        <th>Status</th>
        <th>Created Date</th>
        <th style="width: 15%;">Aksi</th>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($data as $y) :
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $y->resi ?></td>
                <td><?= $y->ekspedisiName ?></td>
                <td><?= $y->nama_customer ?></td>
                <td><?= $y->status == 1 ? '<span class="badge text-bg-success">Sorting</span>' : '-' ?></td>
                <td><?= $y->created_at ?></td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="hapus(<?= $y->id_sorting ?>)"><i class="fa fa-trash-alt"></i></button>
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
                    url: "<?= site_url('CSOrting/hapusData') ?>",
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