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
            <td style="width: 200px;"><a>Distribusi</a></td>
            <td><a href="cekstok.php">Cek Stock</a></td>
        </tr>
    </table>

    <p><strong>Distribusi LKS</strong></p>
    <?php
    if(isset($_POST['submit'])){
        $kelas = $_POST['kelas'];
        $jumlah = $_POST['jumlah'];
        $sekolah = $_POST['sekolah'];

        $sql = "insert into distribusi (kelas, jumlah, sekolah) values('$kelas', '$jumlah', '$sekolah')";
        $query = mysqli_query($db, $sql);
        if($query){
            echo "<em>Data berhasil disimpan.</em>";
        }else{
            echo "<em>Data gagal disimpan.</em>";
        }

        // $jumlah = $jumlah * (-1);

        // $sql = "insert into stok (kelas, jumlah) values('$kelas', '$jumlah')";
        // $query = mysqli_query($db, $sql);
    }

    if(isset($_POST['edit'])){
        $id = $_POST['id'];
        $kelas = $_POST['kelas'];
        $jumlah = $_POST['jumlah'];
        $sekolah = $_POST['sekolah'];

        $sql = "update distribusi set kelas='$kelas', jumlah='$jumlah', sekolah='$sekolah' where id='$id'";
        $query = mysqli_query($db, $sql);
        if($query){
            echo "<em>Data berhasil disimpan.</em>";
        }else{
            echo "<em>Data gagal disimpan.</em>";
        }
    }

    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $sql = "delete from distribusi where id='$id'";
        $query = mysqli_query($db, $sql);
        if($query){
            echo "<em>Data berhasil dihapus.</em>";
        }else{
            echo "<em>Data gagal dihapus.</em>";
        }
    }

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $sql = "select * from distribusi where id='$id'";
        $query = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($query);
    }
    ?>
    <form action="distribusi.php" method="POST">
        <?php if(isset($_GET['edit'])) : ?>
        <input type="hidden" name="id" value="<?=$_GET['edit'];?>">
        <?php endif; ?>
        <table>
            <tr>
                <td>Nama Sekolah</td>
                <td>
                    <input type="text" name="sekolah" id="sekolah" min="1" value="<?=$row['sekolah'] ?? '';?>" required>
                </td>
            </tr>
            <tr>
                <td style="width: 150px;">Kelas</td>
                <td>
                    <?php for($i = 1; $i <= 6; $i++) : ?>
                    <input type="radio" name="kelas" id="kelas" value="<?=$i;?>"
                            <?php if(isset($_GET['edit'])){ ?>
                            <?php if($i == $row['kelas']) : ?> checked <?php endif; ?>
                            <?php }else{ ?>
                            <?php if($i == 1) echo "checked"; ?>
                            <?php } ?>
                    ><?=$i;?>
                    <?php endfor; ?>
                </td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>
                    <input type="number" name="jumlah" id="jumlah" min="1" value="<?=$row['jumlah'] ?? '';?>" required>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <?php if(isset($_GET['edit'])){ ?>
                    <input type="submit" name="edit" id="edit" value="Simpan">
                    <?php }else{ ?>
                    <input type="submit" name="submit" id="submit" value="Simpan">
                    <?php } ?>
                </td>
            </tr>
        </table>
    </form>

    <p><strong>Data Distribusi</strong></p>
    <table  id="customers">
        <tr>
            <th>No.</th>
            <th>Nama Sekolah</th>
            <th>Kelas</th>
            <th>Jumlah</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        $sql = "select * from distribusi where jumlah > 0";
        $query = mysqli_query($db, $sql);
        $i = 1;
        while($row = mysqli_fetch_assoc($query)) :
        ?>
        <tr>
            <td><?=$i++;?></td>
            <td><?=$row['sekolah'];?></td>
            <td><?=$row['kelas'];?></td>
            <td><?=number_format($row['jumlah'], 0, ',', '.');?></td>
            <td><a href="distribusi.php?edit=<?=$row['id'];?>">edit</a></td>
            <td><a href="distribusi.php?delete=<?=$row['id'];?>" onclick="return confirm('Anda yakin ingin menghapus ini?')">hapus</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>