<div class="modal fade" id="tambahAgen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Tambah Agen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('CListAgen/addAgen', ['class' => 'formAgen']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="idAgen">ID Agen</label>
                    <input type="text" class="form-control" name="idAgen" aria-describedby="CodeAgen" value="<?= $idAgen ?>" readonly>
                </div>
                <div class="form-group row">
                    <label for="nameAgen" class="col-sm-3 col-form-label">Agen Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="nameAgen" class="form-control" id="nameAgen" value="">
                        <div class="invalid-feedback errorNamaAgen">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" id="email" class="form-control" value="">
                        <div class="invalid-feedback errorEmail">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-9">
                        <input type="text" name="address" id="address" class="form-control" value="">
                        <div class="invalid-feedback errorAddress">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label">Phone Number</label>
                    <div class="col-sm-9">
                        <input type="text" name="phone" id="phone" class="form-control" value="">
                        <div class="invalid-feedback errorPhone">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="long" class="col-sm-3 col-form-label">Longitude</label>
                    <div class="col-sm-9">
                        <input type="text" name="long" id="long" class="form-control" value="">
                        <div class="invalid-feedback errorLong">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lat" class="col-sm-3 col-form-label">Latitude</label>
                    <div class="col-sm-9">
                        <input type="text" name="lat" id="lat" class="form-control" value="">
                        <div class="invalid-feedback errorLat">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="owner" class="col-sm-3 col-form-label">Owner Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="owner" id="owner" class="form-control" value="">
                        <div class="invalid-feedback errorOwner">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-simpan">Submit</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    $('.formAgen').submit(function(e) {
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
                    if (response.error.nameAgen) {
                        $('#nameAgen').addClass('is-invalid');
                        $('.errorNamaAgen').html(response.error.nameAgen);
                    } else {
                        $('#nameAgen').removeClass('is-invalid');
                        $('#nameAgen').addClass('is-valid');
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
                    if (response.error.owner) {
                        $('#owner').addClass('is-invalid');
                        $('.errorOwner').html(response.error.owner);
                    } else {
                        $('#owner').removeClass('is-invalid');
                        $('#owner').addClass('is-valid');
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