<table class="table table-sm table-striped table-bordered" id="example1" style="width: 100%; text-align:center; align-items:center; margin:auto;">
    <thead>
        <th style="width: 5%;">No</th>
        <th style="width: 30%;">No Resi</th>
        <th>Warehouse</th>
        <th>Status</th>
        <th>Created Date</th>
    </thead>
    <tbody>
        <?php 
            $no = 1;
            foreach($list as $x):
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $x->resi ?></td>
            <td><?= $x->nama_customer ?></td>
            <td><?= $x->desc ?></td>
            <td><?= $x->updated_at ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>