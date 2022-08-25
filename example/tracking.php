<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        ul.timeline {
            list-style-type: none;
            position: relative;
        }

        ul.timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 29px;
            width: 2px;
            height: 100%;
            z-index: 400;
        }

        ul.timeline>li {
            margin: 20px 0;
            padding-left: 20px;
        }

        ul.timeline>li:before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #22c0e8;
            left: 20px;
            width: 20px;
            height: 20px;
            z-index: 400;
        }
    </style>

    <title>Raja Ongkir</title>
</head>

<body>

    <?php

    use RizalArfani\RajaOngkir\Config\Config;
    use RizalArfani\RajaOngkir\service\Couriers;

    require_once('../src/init.php');

    Config::$apiKey = '';
    Config::$typeAccount = 'pro';

    $couriers = new Couriers();
    $getCouriers = $couriers->getCouriers();
    ?>

    <div class="container">
        <h1 class="text-center">Example Tracking Raja Ongkir</h1>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="Nomor Resi">Masukan Nomor Resi</label>
                    <input type="text" class="form-control" placeholder="Nomor Resi Pengiriman" id="receipt_number">
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
                <div class="form-group">
                    <button class="btn btn-primary btn-sm" id="track_package">Lacak Paket</button>
                </div>
            </div>
            <div class="col-sm-8">
                <h3 class="text-center">Hasil Pengecekan</h3>
                <br>
                <div class="results"></div>
                <!-- <div class="time_line"></div> -->
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#track_package').click(function(e) {
                e.preventDefault();
                let receipt_number = $('#receipt_number').val();
                let courier = $('#courier').val();

                $.ajax({
                    url: 'getTrackPackage.php',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        receipt_number: receipt_number,
                        courier: courier,
                    },
                    async: true,
                    beforeSend: function() {
                        $('#track_package').text('loading');
                    },
                    success: function(response) {
                        var html = '';
                        var html_timeline = '';
                        if (response.status) {
                            $('.table').remove();
                            $('.timeline').remove();
                            let data = response.data;
                            html += `
                            <table class="table table-striped">
                                <tr>
                                    <th>Nomor Resi</th>
                                    <th>` + data.summary.waybill_number + `</th>
                                </tr>
                                <tr>
                                    <th>Waktu Pengiriman</th>
                                    <th>` + data.summary.waybill_date + `</th>
                                </tr>
                                <tr>
                                    <th>Status Pengiriman</th>
                                    <th>` + data.summary.status + `</th>
                                </tr>
                                <tr>
                                    <th>Nama Pengirim</th>
                                    <th>` + data.summary.shipper_name + `</th>
                                </tr>
                                <tr>
                                    <th>Nama Penerima</th>
                                    <th>` + data.summary.receiver_name + `</th>
                                </tr>
                            </table>
                            `;
                            if (data.manifest != null) {
                                html += `<ul class="timeline">`;
                                $.each(data.manifest, function(index, value) {
                                    html += `
                                    <li>
                                        <a href="#">` + (value.city_name == '' ? '..' : value.city_name) + `</a>
                                        <a href="#" class="float-right">` + value.manifest_date + `</a>
                                        <p>` + value.manifest_description + `</p>
                                    </li>`;
                                });
                                html += `</ul>`;
                            }
                        } else {
                            html += '<div class="alert alert-warning">' + response.message + '</div>';
                        }
                        $('.results').html(html);
                    },
                    complete: function() {
                        $('#track_package').text('Lacak paket');
                    }
                });
            });
        });
    </script>
</body>

</html>