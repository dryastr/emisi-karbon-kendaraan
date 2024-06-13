<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Jejak Karbon</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script>
        function calculateCarbonFootprint() {
            const emisiPerKm = {
                'bus sedang': 90,
                'kereta listrik': 118,
                'minibus': 120,
                'mobil diesel': 150,
                'mobil gasoline': 180,
                'sepeda motor': 100
            };

            const jenisKendaraan = document.getElementById('jenis_kendaraan').value;
            const jarakTempuhKm = parseFloat(document.getElementById('jarak_tempuh_km').value);
            const jumlahOrang = parseInt(document.getElementById('jumlah_orang').value);
            const frekuensi = document.getElementById('frekuensi').value;
            const jejakKarbon = document.getElementById('jejak_karbon').value;

            if (isNaN(jarakTempuhKm) || jarakTempuhKm <= 0 || isNaN(jumlahOrang) || jumlahOrang <= 0) {
                document.getElementById('hasil_emisi_kg').innerText = "Jarak tempuh dan jumlah orang harus lebih dari 0.";
                return;
            }

            let factor;
            switch (frekuensi) {
                case '7Hari':
                    factor = 7;
                    break;
                case 'Mingguan':
                    factor = 1;
                    break;
                case 'Bulanan':
                    factor = 4;
                    break;
                case 'Tahunan':
                    factor = 52;
                    break;
                default:
                    factor = 1;
            }

            const emisiPerKmTotal = emisiPerKm[jenisKendaraan] * jarakTempuhKm * jumlahOrang * factor;

            let hasilEmisiKg;
            switch (jejakKarbon) {
                case 'Harian':
                    hasilEmisiKg = emisiPerKmTotal / 1000;
                    break;
                case 'Bulanan':
                    hasilEmisiKg = (emisiPerKmTotal * 4) / 1000;
                    break;
                case 'Tahunan':
                    hasilEmisiKg = (emisiPerKmTotal * 52) / 1000;
                    break;
                default:
                    hasilEmisiKg = emisiPerKmTotal / 1000;
            }

            document.getElementById('hasil_emisi_kg').innerText = hasilEmisiKg.toFixed(2) + " kg CO2";
        }

        function saveData() {
            const jenisKendaraan = document.getElementById('jenis_kendaraan').value;
            const jarakTempuhKm = document.getElementById('jarak_tempuh_km').value;
            const jumlahOrang = document.getElementById('jumlah_orang').value;
            const frekuensi = document.getElementById('frekuensi').value;
            const jejakKarbon = document.getElementById('jejak_karbon').value;
            const hasilEmisi = document.getElementById('hasil_emisi_kg').innerText.split(" ")[0];

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "save_emisi.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    alert(xhr.responseText);
                }
            }
            xhr.send("jenis_kendaraan=" + encodeURIComponent(jenisKendaraan) +
                "&jarak_tempuh_km=" + encodeURIComponent(jarakTempuhKm) +
                "&jumlah_orang=" + encodeURIComponent(jumlahOrang) +
                "&frekuensi=" + encodeURIComponent(frekuensi) +
                "&jejak_karbon=" + encodeURIComponent(jejakKarbon) +
                "&hasil_emisi_kg=" + encodeURIComponent(hasilEmisi));
        }
    </script>
</head>

<body>
    <div class="card-container">
        <div class="d-flex flex-column align-items-center justify-content-center">
            <div class="card-body card-body-custom">
                <h1 class="title-carbon mb-4">Perhitungan Jejak Karbon Kendaraan</h1>
                <form onsubmit="return false;">
                    <div class="form-group">
                        <label for="jenis_kendaraan">Jenis Kendaraan</label><label for="" class="text-danger">*</label>
                        <select class="form-control" style="height: calc(2.5em + .75rem + 2px);" id="jenis_kendaraan" name="jenis_kendaraan" onchange="calculateCarbonFootprint()">
                            <option selected="true" disabled="disabled" value="">Pilih Kendaraan</option>
                            <option value="bus sedang">Bus Sedang</option>
                            <option value="kereta listrik">Kereta Listrik</option>
                            <option value="minibus">Minibus</option>
                            <option value="mobil diesel">Mobil Diesel</option>
                            <option value="mobil gasoline">Mobil Gasoline</option>
                            <option value="sepeda motor">Sepeda Motor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jarak_tempuh_km">Jarak Tempuh (km)</label><label for="" class="text-danger">*</label>
                        <input type="number" class="form-control" style="height: calc(2.5em + .75rem + 2px);" id="jarak_tempuh_km" name="jarak_tempuh_km" oninput="calculateCarbonFootprint()" placeholder="Jarak Tempuh">
                    </div>

                    <div class="form-group">
                        <label for="jumlah_orang">Jumlah Orang</label><label for="" class="text-danger">*</label>
                        <input type="number" class="form-control" style="height: calc(2.5em + .75rem + 2px);" id="jumlah_orang" name="jumlah_orang" oninput="calculateCarbonFootprint()" placeholder="Jumlah Orang">
                    </div>

                    <div class="form-group">
                        <label for="frekuensi">Frekuensi</label><label for="" class="text-danger">*</label>
                        <select class="form-control" style="height: calc(2.5em + .75rem + 2px);" id="frekuensi" name="frekuensi" onchange="calculateCarbonFootprint()">
                            <option value="7Hari">Hari / Minggu</option>
                            <option value="Mingguan">Mingguan</option>
                            <option value="Bulanan">Bulanan</option>
                            <option value="Tahunan">Tahunan</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <label for="jejak_karbon">Jejak Karbon</label>
                        <div class="form-group" style="border: none;">
                            <select class="form-control" style="padding: 0; height: calc(1em + .75rem + 2px); border: none;" id="jejak_karbon" name="jejak_karbon" onchange="calculateCarbonFootprint()">
                                <option value="Harian">Harian</option>
                                <option value="Bulanan">Bulanan</option>
                                <option value="Tahunan">Tahunan</option>
                            </select>
                        </div>
                    </div>
                    <div class="group-results">
                        <div class="d-flex flex-column align-items-end">
                            <div class="border-up-line"></div>
                            <p id="hasil_emisi_kg" class="float-end mt-1">0 kg CO2</p>
                        </div>
                    </div>
                    <button class="btn btn-save mt-2" type="button" onclick="saveData()">Save</button>
                    <button class="btn btn-reset mt-2" type="reset" onclick="document.getElementById('hasil_emisi_kg').innerText = '0 kg CO2';">Reset</button>
                </form>
            </div>
        </div>
    </div>
    <!-- <div class="container mt-5">
    </div> -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>