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

    use RizalArfani\RajaOngkir\Config\Config;
    use RizalArfani\RajaOngkir\service\Regions;
    use RizalArfani\RajaOngkir\service\Couriers;

    require_once('../src/init.php');

    Config::$apiKey = 'bdb85102046029439d45ca5e400d6107';
    Config::$typeAccount = 'pro';

    $regions = new Regions();
    $getProvince = $regions->getprovince();

    $couriers = new Couriers();
    $getCouriers = $couriers->getCouriers();
    ?>

    <div class="container">
        <h1 class="text-center">Example Raja Ongkir</h1>
        <div class="row">
            <div class="col-sm-6">
                <h3 class="text-center">Tujuan</h3>
                <div class="form-group">
                    <label for="Berat Barang">Berat Barang</label>
                    <input type="number" class="form-control" placeholder="Berat Barang /Gram" id="weight">
                </div>
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
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Courier</label>
                    <select class="form-control select2" id="courier">
                        <option value="">--Pilih Courier--</option>
                        <?php foreach ($getCouriers as $courier) : ?>
                            <option value="<?php echo $courier ?>"><?php echo $courier ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <h3 class="text-center">Hasil Pengecekan</h3>
                <br>
                <div class="service"></div>
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

            /* Fungsi formatRupiah */
            function convertToRupiah(angka) {
                var rupiah = '';
                var angkarev = angka.toString().split('').reverse().join('');
                for (var i = 0; i < angkarev.length; i++)
                    if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
                return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
            }

            $('#courier').change(function() {
                let destination = $('#city').val();
                let weight = $('#weight').val();
                let courier = $(this).val();
                $.ajax({
                    url: 'getCost.php',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        city: destination,
                        weight: weight,
                        courier: courier,
                    },
                    success: function(response) {
                        if (response.status) {
                            var html = '';
                            var data = response.data;
                            $.each(data, function(index, value) {
                                var service = value.service + ' (' + value.description + ')';
                                var valueData = value.cost[0].value + ',' + service;
                                html += `
                                    <div class="custom-control custom-radio mr-3 ongkir">
                                        <input type="radio" name="ongkir" value="` + valueData + `" class="custom-control-input" id="` + value.service + `">
                                        <label class="custom-control-label text-red" for="` + value.service + `">` + value.service + ` (` + value.description + `)</label>
                                    </div>
                                    <label class="ml-4">Ongkir : ` + convertToRupiah(value.cost[0].value) + `</label>
                                `;
                            });
                            $('.service').append(html);
                        } else {
                            console.log('mene');
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            });
        });
    </script>
</body>

</html>