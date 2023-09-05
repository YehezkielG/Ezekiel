<?php
session_start();
include 'koneksi.php';
if(!isset($_SESSION['nama'])){
    header("location:login.php");
  }
  if(isset($_POST['submit'])){
    $nim = htmlentities(strip_tags(trim($_POST["nim"])));
    $nama = htmlentities(strip_tags(trim($_POST["nama"])));
    $tempat_lahir = htmlentities(strip_tags(trim($_POST["tempat_lalhir"])));
    $fakulitas = htmlentities(strip_tags(trim($_POST["fakulitas"])));
    $jurusan = htmlentities(strip_tags(trim($_POST["jurusan"])));
    $ipk = htmlentities(strip_tags(trim($_POST["ipk"])));
    $tgl = htmlentities(strip_tags(trim($_POST["tgl"])));
    $bln = htmlentities(strip_tags(trim($_POST["bln"])));
    $thn = htmlentities(strip_tags(trim($_POST["thn"])));
    $pesan_error = "";
    if (empty($nim)) {
        $pesan_error .= "Nim belum di isi ";
        # code...
    }
    else if(!preg_match("/^[0-9]{8}$/", $nim)){
        $pesan_error .= "Nim harus berupa 8 digit angka <br>";
    }
    $nim = mysqli_real_escape_string($link,$nim);
    $query = "select * from mahasiswa where nim = '$nim'";
    $hasil_query = mysqli_query($link,$query);
    $jumlah_data = mysqli_num_rows($hasil_query);
    $jumlah_data = mysqli_num_rows($hasil_query);
if($jumlah_data >= 1){
    $pesan_error .= "nim yg sama sudah digunakan <br>";
}
// cek apakah "nama" sudah diisi atau tidak 
if (empty($nama)){
    $pesan_error .= "nama blum diisi<br>";

}
//cek apakah "tempat lahir" sudah diisi atau tidak
if(empty($tempat_lahir)){
    $pesan_error .= "tempat lahir blum diisi <br>";
}
//cek apakah "jurusan" sudah diisi atau tidak
if(empty($jurusan)){
    $pesan_error .= "Jurusan blum diisi <br>";
}
//siapk
    $select_kedokteran = "";
    $select_fmipa = "";
    $select_teknik = "";
    $select_ekonomi = "";
    $select_sastra = "";
    $select_fasilkom = "";
switch ($fakulitas){
    case "kedokteran":
        $select_kedokteran = "selected";
        break;
    case "FMIPA":
        $select_fmipa = "selected";
        break;   
    case "Ekonomi":
        $select_ekonomi = "selected";
        break;
    case "Teknik":
        $select_teknik = "selected";
        break;
    case "Sastra":
        $select_sastra = "selected";
        break;
    case "Fasilkom":
        $select_fasilkom = "selected";
        break;
}
//ipk harus berupa angka dan tidak boleh negatif
if(!is_numeric($ipk) or ($ipk <= 0)){
    $pesan_error .= "IPK harus diisi dengan angka";
}
//jika tidk ada error, input ke database
if ($pesan_error === ""){
    //filter semua data
    $nim = mysqli_real_escape_string($link, $nim);
    $nama = mysqli_real_escape_string($link, $nama);
    $tempat_lahir = mysqli_real_escape_string($link, $tempat_lahir);
    $fakulitas = mysqli_real_escape_string($link, $fakulitas);
    $jurusan = mysqli_real_escape_string($link, $jurusan);
    $tgl = mysqli_real_escape_string($link, $tgl);
    $bln = mysqli_real_escape_string($link, $bln);
    $thn = mysqli_real_escape_string($link, $thn);
    $ipk = (float) $ipk;
    //gabungkan format tanggal agar sesuai dengan data mysql
    $tgl_lhr = $thn . "-" . $bln . "-" . $tgl;
    //buat dan jalankan query insert
    $query = "insert into mahasiswa values";
    $query .= "('$nim','$nama','$tempat_lahir',";
    $query .= "'$tgl_lhr','$fakulitas','$jurusan',$ipk)";
    $result = mysqli_query($link, $query);
    //periksa hasil query
    if ($result){
        //insert berhasil, redirect ke tampil_mahasiswa.php + pesan
        $pesan = "mahasiswa dengan nama = \"<b>$nama</b>\" sudah berhasil di tambah";
        $pesan = urlencode($pesan);
        header("Location: tampil_mahasiswa.php?pesan={$pesan}");
    }else{
        die("query gagal dijalankan: " . mysqli_errno($link) .
        "-" . mysqli_error($link));
    }
}
}else{
    $pesan_error = "";
    $nim = "";
    $nama = "";
    $tempat_lahir = "";
    $select_kedokteran = "selected";
    $select_fmipa = "";
    $select_ekonomi = "";
    $select_teknik = "";
    $select_sastra = "";
    $select_fasilkom = "";
    $jurusan = "";
    $ipk = "";
    $tgl = 1;
    $bln = "1";
    $thn = 1996;
}
    //siapkan array untuk nama bulan
    $arr_bln = array(
        "1" => "Januari",
        "2" => "Februari",
        "3" => "Maret",
        "4" => "April",
        "5" => "Mei",
        "6" => "Juni",
        "7" => "Juli",
        "8" => "Agustus",
        "9" => "September",
        "10" => "Oktober",
        "11" => "November",
        "12" => "Desember",
    );

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="tambahs.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 id="logo">Sistem informasi <span>kampusku</span></h1>
            <p id="tanggal"><?php echo date("d M Y"); ?></p>
        </div>
        <hr>
        <div class="atas">
            <nav class="nav">
                <ul>
                    <li><a href="tampil_mahasiswa.php">Tampil</a></li>
                    <li><a href="tambahmahasiswa.php">Tambah</a></li>
                    <li><a href="edit_mahasiswa.php">Edit</a></li>
                    <li><a href="hapus_mahasiswa.php">Hapus</a></li>
                    <li><a href="logout.php">logout</a></li>
                </ul>
            </nav>
            <span>
                <h2>Tambah data mahasiswa</h2>
                <?php
        if($pesan_error !== ""){
            echo "<div class = \"error\">$pesan_error</div>";
        }
        ?>

                <form action="tampil_mahasiswa.php" method="get">
                    <label for="nim">Nama : </label>
                    <input type="text" name="nama" id="nama " placeholder="Search...">
                    <input type="submit" name="submit" value="search">
                </form>
            </span>
        </div>
        <h2>Tambah data mahasiswa</h2>
        <form action="" id="formmahasiswa" method="post">
            <fieldset class="fd">
                <legend>Mahasiswa baru</legend>
                <p><label for="nim">NIM : </label><input type="text" name="nim" id="nim" value="<?php echo $nim?>"></p>
                <p><label for="nama" name="nama" id="nama">Nama : </label><input type="text" name="nama" id="nama"value="<?php echo $nama ?> "></p>
                <p><label for="tempat_lahir" name="tempat_lahir" id="tempat_lahir"> tempat_lahir : </label><input type="text" name="tempat_lahir" id="tempat_lahir"value="<?php echo $tempat_lahir?>" ></p>
                <p>
                    <label>Tangal lahir</label>
                    <select name="tgl">
                        <?php
                for($i=1; $i <= 31; $i++){
                    if($i == $tgl){
                        echo "<option value = $i selected>";
                    }
                    else{
                        echo "<option value = $i >";
                    }
                    echo str_pad($i,2,"0", STR_PAD_LEFT);
                    echo "</option>";
                }
                ?>
                    </select>

                    <select name="bln">
                        <?php
                foreach($arr_bln as $key => $value){
                    if($key == $bln){
                        echo "<option value= \"{$key}\"> <selected>{$value}";
                    }
                    else{
                        echo "<option value= \"{$key}\"> <selected>{$value}";
                    }
                }
                ?>
                    </select>
                    <select name="thn" id="">
                        <?php
                    for ($i=1990; $i <=2005 ; $i++) { 
                        # code...
                        if($i == $thn){
                            echo "<option value=$i selected>";
                        }
                        else{
                            echo "<option value=$i>";
                        }
                        echo "$i </option>";
                    }
                    ?>
                    </select>
                <p>  <label>Fakulitas : </label>
                    <select name="fakulitas"><option value="Kedokteran" value="<?php echo $select_kedokteran?>">Kedokteran</option>
                    <option value="FMIPA" value="<?php echo $select_fmipa?>">FMIPA</option>
                    <option value="Ekonomi" value="<?php echo $select_ekonomi?>">Ekonomi</option>
                    <option value="Teknik" value="<?php echo $select_teknik?>">Teknik</option>
                    <option value="Sastra" value="<?php echo $select_sastra?>">Sastra</option>
                    <option value="FASILKOM" value="<?php echo $select_fasilkom?>">FASILKOM</option>
</select>
                </p>
                  </p>
                <p>
                    <label for="jurusan">jurusan : </label><input type="text" name="jurusan" id="jurusan"
                        value="<?php echo $jurusan?>">
                </p>
                <p>
                    <label for="ipk">IPK : </label><input type="text" name="ipk" id="ipk" placeholder="Contoh:2.75"
                        value="<?php echo $jurusan?>">(angka desimal dipisah dengan karakter titik ".")
                </p>

            </fieldset>
        </form>
        <input type="submit" name="submit" value="Tambah data">
        <div class="footer">
            copyright &copy; <?php echo date("Y");?> Yehezkiel Haganta
        </div>
    </div>
</body>

</html>
