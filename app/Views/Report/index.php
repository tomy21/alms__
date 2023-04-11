<?= $this->extend('layout/index'); ?>
<?= $this->section('judul'); ?>
<h1>Report</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        Export Report Outbound
                    </div>
                    <div class="card-body">
                        <!-- <?= form_open(site_url('Laporan/cetakReportOutbound')) ?> -->
                        <!-- Date range -->
                        <div class="form-group">
                            <label>Date range:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right" id="exportOutbound">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group">
                            <button class="btn btn-info" id="btnOutbound"><i class="fa fa-download"></i> download data</button>
                        </div>
                    </div>
                    <!-- <?= form_close() ?> -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        Export Report Inbound
                    </div>
                    <div class="card-body">
                        <!-- <?= form_open(site_url('Laporan/cetakReportInbound')) ?> -->
                        <div class="form-group">
                            <label>Date range:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right" id="exportReturn">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info" id="btnOutbound"><i class="fa fa-download"></i> download data</button>
                        </div>
                    </div>
                    <!-- <?= form_close() ?> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        //Date range picker
        $('#exportOutbound').daterangepicker()
        $('#exportReturn').daterangepicker()

    })
</script>
<?= $this->endsection('isi'); ?>