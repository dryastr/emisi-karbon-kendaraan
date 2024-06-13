<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_emisi_karbon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $jarak_tempuh_km = $_POST['jarak_tempuh_km'];
    $jumlah_orang = $_POST['jumlah_orang'];
    $frekuensi = $_POST['frekuensi'];
    $jejak_karbon = $_POST['jejak_karbon'];
    $hasil_emisi_kg = $_POST['hasil_emisi_kg'];

    $sql = "INSERT INTO carbonfootprint (jenis_kendaraan, jarak_tempuh_km, jumlah_orang, frekuensi, jejak_karbon, hasil_emisi_kg)
            VALUES ('$jenis_kendaraan', '$jarak_tempuh_km', '$jumlah_orang', '$frekuensi', '$jejak_karbon', '$hasil_emisi_kg')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
