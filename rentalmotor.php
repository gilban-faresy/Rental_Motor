<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Rental Motor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f7f7f7;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .transaction {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .transaction p {
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Rental Motor</h2>

    <form action="" method="post">
        <table>
            <tr>
                <th>Nama</th>
                <td><input type="text" name="nama" required></td>
            </tr>
            <tr>
                <th>Lama Waktu Rental (hari)</th>
                <td><input type="number" name="durasi" min="1" required></td>
            </tr>
            <tr>
                <th>Jenis Motor</th>
                <td>
                    <select name="jenis_motor" required>
                        <option value="">Pilih jenis motor</option>
                        <option value="Honda Beat">Honda Beat</option>
                        <option value="Yamaha NMAX">Yamaha NMAX</option>
                        <option value="Suzuki Address">Suzuki Address</option>
                        <option value="Kawasaki Ninja">Kawasaki Ninja</option>
                    </select>
                </td>
            </tr>
        </table>
        <input type="submit" value="Submit" class="btn">
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            class RentalMotor {
                protected $nama;
                protected $jenisMotor;
                protected $durasi;
                protected $hargaSewa;
                protected $pajak;
                protected $namaMember;

                public function __construct($nama, $jenisMotor, $durasi, $namaMember = '') {
                    $this->nama = $nama;
                    $this->jenisMotor = $jenisMotor;
                    $this->durasi = $durasi;
                    $this->pajak = 10000; // Pajak tambahan: Rp. 10.000
                    $this->namaMember = $namaMember;

                    // Harga sewa per jenis motor
                    $hargaSewaPerMotor = [
                        "Honda Beat" => 6000,
                        "Yamaha NMAX" => 12000,
                        "Suzuki Address" => 8000,
                        "Kawasaki Ninja" => 10000
                    ];

                    // Set harga sewa berdasarkan jenis motor
                    $this->hargaSewa = isset($hargaSewaPerMotor[$this->jenisMotor]) ? $hargaSewaPerMotor[$this->jenisMotor] : 0;
                }

                public function hitungTotal() {
                    $total = $this->hargaSewa * $this->durasi;
                    $total += $this->pajak;

                    // Potongan harga 5% jika pelanggan merupakan member
                    if ($this->isMember()) {
                        $total -= ($total * 0.05);
                    }

                    return $total;
                }

                protected function isMember() {
                    // Cek apakah nama pelanggan ada dalam daftar member
                    $member = ["Wahyu", "wahyu", "jodi", "Jodi", "asep", "Asep", "asep", "Bobi"];
                    return in_array($this->nama, $member);
                }

                public function buktiTransaksi() {
                    $total = $this->hitungTotal();
                    $potonganMember = $this->isMember() ? " (Potongan member 5%)" : "";
                    if ($this->isMember()) {
                        return "{$this->nama} berstatus sebagai Member mendapatkan diskon sebesar 5%. Jenis motor yang dirental adalah {$this->jenisMotor} selama {$this->durasi} hari. Harga rental per-harinya: {$this->hargaSewa} <br><br>Besar yang harus dibayarkan adalah Rp.{$total}";
                    } else {
                        return "{$this->nama} jenis motor yang dirental adalah {$this->jenisMotor} selama {$this->durasi} hari. Harga rental per-harinya: {$this->hargaSewa}<br><br>Besar yang harus dibayarkan adalah Rp.{$total}";
                    }
                }
            }

            $nama = $_POST["nama"];
            $durasi = $_POST["durasi"];
            $jenisMotor = $_POST["jenis_motor"];

            $rental = new RentalMotor($nama, $jenisMotor, $durasi);
            echo "<h2>Hasil Transaksi</h2>";
            echo "<div class='transaction'>";
            echo "<p>" . $rental->buktiTransaksi() . "</p>";
            echo "</div>";
        }
    ?>
</div>
</body>
</html>
