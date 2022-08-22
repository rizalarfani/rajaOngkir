<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>Raja Ongkir</title>
</head>

<body>

    <?php

    use RajaOngkir\Config\Config;
    use RajaOngkir\service\Regions;

    require_once('../src/init.php');

    Config::$apiKey = 'bdb85102046029439d45ca5e400d6107';
    Config::$typeAccount = 'pro';

    $regions = new Regions();
    $getProvince = $regions->getprovince();
    ?>

    <div class="container">
        <h1 class="text-center">Example Raja Ongkir</h1>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Province</label>
                    <select class="form-control select2" id="province">
                        <option value="">--Pilih Province--</option>
                        <?php foreach ($getProvince['rajaongkir']['results'] as $hasil) : ?>
                            <option value="<?php echo $hasil['province_id'] ?>"><?php echo $hasil['province'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">City</label>
                    <select class="form-control select2" id="city">
                        <option value="">--Pilih City--</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Districts</label>
                    <select class="form-control select2" id="districts">
                        <option value="">--Pilih Districts--</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#province').change(function() {
                const id = $(this).val();
                $.ajax({
                    url: 'getCity.php?province=' + id,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response) {
                        let option = [];
                        option.push('<option value="">--Pilih City--</option>');
                        $.each(response, function(key, value) {
                            option.push('<option value="' + value.city_id + '">' + value.type + ' ' + value.city_name + '</option>');
                        });
                        $('#city').html(option.join(''));
                    }
                });
            });

            $('#city').change(function() {
                let id = $(this).val();
                console.log(id);
                $.ajax({
                    url: 'getDistricts.php?city=' + id,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response) {
                        let option = [];
                        option.push('<option value="">--Pilih Districts--</option>');
                        $.each(response, function(key, value) {
                            option.push('<option value="' + value.subdistrict_id + '">' + value.subdistrict_name + '</option>');
                        });
                        $('#districts').html(option.join(''));
                    }
                });
            });
        });
    </script>
</body>

</html>