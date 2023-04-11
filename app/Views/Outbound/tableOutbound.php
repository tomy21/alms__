<table class="table table-sm table-striped table-bordered" id="example1" style="width: 100%; text-align:center; align-items:center; margin:auto;">
    <thead>
        <th style="width: 5%;">No</th>
        <th style="width: 15%;">No Sorting</th>
        <th style="width: 15%;">No Resi</th>
        <th>Brand Logistic</th>
        <th>Warehouse</th>
        <th>Status</th>
        <th>Created Out</th>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($data as $y) :
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $y->code_sorting ?></td>
                <td><?= $y->resi_out ?></td>
                <td><?= $y->namaEkspedisi ?></td>
                <td><?= $y->namaCustomer ?></td>
                <td><?= $y->status == 1 ? '<span class="badge text-bg-warning">Process</span>' : '<span class="badge text-bg-danger">Out HUB</span>'  ?></td>
                </td>
                <td><?= $y->created_at ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>