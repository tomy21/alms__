<div class="modal fade" id="modalList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">List Resi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="viewStatus" class="table table-striped" style="width: 100%;">
                    <thead>
                        <th>No</th>
                        <th>No Resi</th>
                        <th>Ekspedisi</th>
                        <th>Warehouse</th>
                        <th>Input Date</th>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($listData as $x) :
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $x->resi; ?></td>
                                <td><?= $x->namaEkspedisi; ?></td>
                                <td><?= $x->namaCustomer; ?></td>
                                <td><?= $x->created_at; ?></td>
                            </tr>
                        <?php
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#viewStatus').DataTable({
            "lengthMenu": [10, 25, 50, 75, 100, 1000],
            bAutoWidth: false,
            aoColumns: [{
                    sWidth: '5%'
                },
                {
                    sWidth: '30%'
                },
                {
                    sWidth: '20%'
                },
                {
                    sWidth: '20%'
                },
                {
                    sWidth: '25%'
                }
            ]
        });

    });
</script>