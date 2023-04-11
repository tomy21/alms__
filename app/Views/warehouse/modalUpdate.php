<div class="modal fade" id="updateAgen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Warehouse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('CWarehouseList/updateWarehouse', ['class' => 'formWarehouse']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="idWarehouse">ID Warehouse</label>
                    <input type="text" class="form-control" name="idWarehouse" id="idWarehouse" aria-describedby="IdWarehouse" value="<?= $idWarehouse ?>" readonly>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Warehouse Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" id="name" value="<?= $name ?>">
                        <div class="invalid-feedback errorNama">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" class="form-control" id="email" value="<?= $email ?>">
                        <div class="invalid-feedback errorEmail">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-9">
                        <input type="text" name="address" class="form-control" id="address" value="<?= $address ?>" min="0">
                        <div class="invalid-feedback errorAddress">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label">Phone Number</label>
                    <div class="col-sm-9">
                        <input type="text" name="phone" class="form-control" id="phone" value="<?= $phone ?>" min="0">
                        <div class="invalid-feedback errorPhone">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lat" class="col-sm-3 col-form-label">Latitude</label>
                    <div class="col-sm-9">
                        <input type="text" name="lat" class="form-control" id="lat" value="<?= $lat ?>" min="0">
                        <div class="invalid-feedback errorLat">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="long" class="col-sm-3 col-form-label">Longitude</label>
                    <div class="col-sm-9">
                        <input type="text" name="long" class="form-control" id="long" value="<?= $long ?>" min="0">
                        <div class="invalid-feedback errorLong">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pic" class="col-sm-3 col-form-label">PIC Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="pic" class="form-control" id="pic" value="<?= $pic ?>" min="0">
                        <div class="invalid-feedback errorPic">

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-submit">Update</button>

            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    $('.formWarehouse').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $(".btn-simpan").attr('disable', 'disabled');
                $(".btn-simpan").html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $(".btn-simpan").removeAttr('disable');
                $(".btn-simpan").html('Submit');
            },
            success: function(response) {
                if (response.error) {
                    if (response.error.name) {
                        $('#name').addClass('is-invalid');
                        $('.errorNama').html(response.error.name);
                    } else {
                        $('#name').removeClass('is-invalid');
                        $('#name').addClass('is-valid');
                    }
                    if (response.error.email) {
                        $('#email').addClass('is-invalid');
                        $('.errorEmail').html(response.error.email);
                    } else {
                        $('#email').removeClass('is-invalid');
                        $('#email').addClass('is-valid');
                    }
                    if (response.error.address) {
                        $('#address').addClass('is-invalid');
                        $('.errorAddress').html(response.error.address);
                    } else {
                        $('#address').removeClass('is-invalid');
                        $('#address').addClass('is-valid');
                    }
                    if (response.error.phone) {
                        $('#phone').addClass('is-invalid');
                        $('.errorPhone').html(response.error.phone);
                    } else {
                        $('#phone').removeClass('is-invalid');
                        $('#phone').addClass('is-valid');
                    }
                    if (response.error.long) {
                        $('#long').addClass('is-invalid');
                        $('.errorLong').html(response.error.long);
                    } else {
                        $('#long').removeClass('is-invalid');
                        $('#long').addClass('is-valid');
                    }
                    if (response.error.lat) {
                        $('#lat').addClass('is-invalid');
                        $('.errorLat').html(response.error.lat);
                    } else {
                        $('#lat').removeClass('is-invalid');
                        $('#lat').addClass('is-valid');
                    }
                    if (response.error.pic) {
                        $('#pic').addClass('is-invalid');
                        $('.errorPic').html(response.error.pic);
                    } else {
                        $('#pic').removeClass('is-invalid');
                        $('#pic').addClass('is-valid');
                    }
                }
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
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });
</script>