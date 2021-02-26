<?php include "database.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Logistik LKS</title>
    <style>
    /**
        Sumber
        https://www.w3schools.com/css/css_link.asp
     */
    /* unvisited link */
    a:link {
    color: blue;
    }

    /* visited link */
    a:visited {
    color: blue;
    }

    /* mouse over link */
    a:hover {
    color: blue;
    }

    /* selected link */
    a:active {
    color: blue;
    }

    /**
        Sumber
        https://www.w3schools.com/css/tryit.asp?filename=trycss_table_fancy
     */
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 50%;
    }

    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        color: black;
    }
    </style>
</head>
<body>
    <p><strong>DATA LOGISTIK LEMBAR KERJA SISWA (LKS)</strong></p>
    <p>Programmer : <strong>Salapi Muhamad</strong> (192101045)</p>

    <table>
        <tr>
            <td style="width: 200px;"><a href="index.php">Input Stock</a></td>
            <td style="width: 200px;"><a href="distribusi.php">Distribusi</a></td>
            <td><a>Cek Stock</a></td>
        </tr>
    </table>

    <p><strong>Cek Stock LKS</strong></p>
    <table  id="customers">
        <tr>
            <th>No.</th>
            <th>Kelas</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Nilai Persediaan</th>
        </tr>
        <?php
        $sql = "select stok.kelas, sum(stok.jumlah)-sum(dis.jumlah) jumlah, stok.harga from stok left join distribusi dis on dis.kelas=stok.kelas group by stok.kelas";
        $query = mysqli_query($db, $sql);
        $i = 1;
        while($row = mysqli_fetch_assoc($query)) :
            if(is_null($row['jumlah'])){
                $kelas = $row['kelas'];
                $s = "select sum(jumlah) jumlah from stok where kelas='$kelas'";
                $q = mysqli_query($db, $s);
                $r = mysqli_fetch_assoc($q);
                $row['jumlah'] = $r['jumlah'];
            }
        ?>
        <tr>
            <td><?=$i++;?></td>
            <td><?=$row['kelas'];?></td>
            <td><?=number_format($row['jumlah'], 0, ',', '.');?></td>
            <td><?=number_format($row['harga'], 0, ',', '.');?></td>
            <td><?=number_format($row['jumlah'] * $row['harga'], 0, ',', '.');?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>