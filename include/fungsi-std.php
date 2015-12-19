<?php
function r_dir($nmdir,$nmfile){
    include "../asset/$nmdir/$nmfile-$nmdir.php";
}

//direktori tema
function self_dir($nmfile){
    include_once "$nmfile.php";
}
//bulan format indonesia
function bln_indo($bulan) {
    $array_bulan = array("01" => "Januari",
        "02" => "Februari",
        "03" => "Maret",
        "04" => "April",
        "05" => "Mei",
        "06" => "Juni",
        "07" => "Juli",
        "08" => "Agustus",
        "09" => "September",
        "10" => "Oktober",
        "11" => "November",
        "12" => "Desember",);
    $bln_temp = explode("-", $bulan);
    $tgl = $bln_temp[2];
    $bln = $bln_temp[1];
    $thn = $bln_temp[0];
    $nama_bulan = $array_bulan[$bln];
    return $tgl . " " . $nama_bulan . " " . $thn;
}

//waktu relatif
function relative_format($time) {
    // ubah format input menjadi unix time
    $unix_time = strtotime($time);
    // simpan waktu sekarang
    $now = time();

    // hitung perbedaan waktu input dan waktu sekarang (satuan detik)
    $time_diff = $now - $unix_time;

    switch (TRUE) {
        case ($unix_time > strtotime('-1 min', $now)):
            // waktu input tidak sampai 1 menit yang lalu
            $relative_time = 'Beberapa waktu yang lalu';
            break;
        case ($unix_time > strtotime('-1 hour', $now)):
            // waktu input antara 1 menit - 1 jam yang lalu
            $relative_time = floor($time_diff / 60) . ' menit yang lalu';
            break;
        case ($unix_time > strtotime('-1 day', $now)):
            // waktu input antara 1 jam - 1 hari yang lalu
            $relative_time = floor($time_diff / 60 / 60) . ' jam yang lalu';
            break;
        default:
            // waktu input lebih dari 1 hari yang lalu
            $array_bulan = array("01" => "Januari",
                "02" => "Februari",
                "03" => "Maret",
                "04" => "April",
                "05" => "Mei",
                "06" => "Juni",
                "07" => "Juli",
                "08" => "Agustus",
                "09" => "September",
                "10" => "Oktober",
                "11" => "November",
                "12" => "Desember",);
            $bln_temp = explode("-", substr($time, 0, 10));
            $jam = substr($time, 11, 5);
            $tgl = $bln_temp[2];
            $bln = $bln_temp[1];
            $thn = $bln_temp[0];
            $nama_bulan = $array_bulan[$bln];
            $relative_time = $tgl . " " . $nama_bulan . " " . $thn . "  $jam";
    }

    return $relative_time;
}

//form tanggal
function tanggal($nm) {
    echo"<select name='hr$nm' class='inp-reg inp-sm'>";
    echo"<option value=''>Hari</option>";
    for ($h = 1; $h <= 31; $h++) {
        $hr = sprintf("%02d", $h);
        echo"<option value='$hr'>$hr</option>";
    }
    echo"</select>";
    echo"<select name='bln$nm' class='inp-reg inp-sm'>
                    <option value=''>Bulan</option>
                    <option value='01'>Januari</option>
                    <option value='02'>Februari</option>
                    <option value='03'>Maret</option>
                    <option value='04'>April</option>
                    <option value='05'>Mei</option>
                    <option value='06'>Juni</option>
                    <option value='07'>Juli</option>
                    <option value='08'>Agustus</option>
                    <option value='09'>September</option>
                    <option value='10'>Oktober</option>
                    <option value='11'>November</option>
                    <option value='12'>Desember</option>
                </select>";
    echo"<select name='thn$nm' class='inp-reg inp-sm'>";
    echo"<option value=''>Tahun</option>";
    $thnkrg = date("Y") - 45;
    $thnskg = date("Y") + 5;
    for ($th = $thnskg; $th >= $thnkrg; $th--) {
        echo"<option value='$th'>$th</option>";
    }
    echo"</select>";
}
function tanggalbln($nm) {
    $bln = date("m");
    $thn = date("Y");
     echo"<select name='bln$nm' class='inp-reg inp-sm'>
                    <option value=''>Bulan</option>
                    <option value='01'";
    if ($bln == "01") {
        echo"selected";
    }echo">Januari</option>
                    <option value='02'";
    if ($bln == "02") {
        echo"selected";
    }echo">Februari</option>
                    <option value='03'";
    if ($bln == "03") {
        echo"selected";
    }echo">Maret</option>
                    <option value='04'";
    if ($bln == "04") {
        echo"selected";
    }echo">April</option>
                    <option value='05'";
    if ($bln == "05") {
        echo"selected";
    }echo">Mei</option>
                    <option value='06'";
    if ($bln == "06") {
        echo"selected";
    }echo">Juni</option>
                    <option value='07'";
    if ($bln == "07") {
        echo"selected";
    }echo">Juli</option>
                    <option value='08'";
    if ($bln == "08") {
        echo"selected";
    }echo">Agustus</option>
                    <option value='09'";
    if ($bln == "09") {
        echo"selected";
    }echo">September</option>
                    <option value='10'";
    if ($bln == "10") {
        echo"selected";
    }echo">Oktober</option>
                    <option value='11'";
    if ($bln == "11") {
        echo"selected";
    }echo">November</option>
                    <option value='12'";
    if ($bln == "12") {
        echo"selected";
    }echo">Desember</option>
                </select>";
    echo"<select name='thn$nm' class='inp-reg inp-sm'>";
    echo"<option value=''>Tahun</option>";
    $thnkrg = date("Y") - 100;
    $thnskg = date("Y") + 5;
    for ($th = $thnskg; $th >= $thnkrg; $th--) {
        echo"<option value='$th'";
        if ($thn == $th) {
            echo "selected";
        }
        echo">$th</option>";
    }
    echo"</select>";
}

function tanggalon($nm) {
    $hari = date("d");
    $bln = date("m");
    $thn = date("Y");
    echo"<select name='hr$nm' class='inp-reg inp-sm'>";
    echo"<option value=''>Hari</option>";
    for ($h = 1; $h <= 31; $h++) {
        $hr = sprintf("%02d", $h);
        echo"<option value='$hr'";
        if ($hari == $hr) {
            echo "selected";
        }
        echo">$hr</option>";
    }
    echo"</select>";
    echo"<select name='bln$nm' class='inp-reg inp-sm'>
                    <option value=''>Bulan</option>
                    <option value='01'";
    if ($bln == "01") {
        echo"selected";
    }echo">Januari</option>
                    <option value='02'";
    if ($bln == "02") {
        echo"selected";
    }echo">Februari</option>
                    <option value='03'";
    if ($bln == "03") {
        echo"selected";
    }echo">Maret</option>
                    <option value='04'";
    if ($bln == "04") {
        echo"selected";
    }echo">April</option>
                    <option value='05'";
    if ($bln == "05") {
        echo"selected";
    }echo">Mei</option>
                    <option value='06'";
    if ($bln == "06") {
        echo"selected";
    }echo">Juni</option>
                    <option value='07'";
    if ($bln == "07") {
        echo"selected";
    }echo">Juli</option>
                    <option value='08'";
    if ($bln == "08") {
        echo"selected";
    }echo">Agustus</option>
                    <option value='09'";
    if ($bln == "09") {
        echo"selected";
    }echo">September</option>
                    <option value='10'";
    if ($bln == "10") {
        echo"selected";
    }echo">Oktober</option>
                    <option value='11'";
    if ($bln == "11") {
        echo"selected";
    }echo">November</option>
                    <option value='12'";
    if ($bln == "12") {
        echo"selected";
    }echo">Desember</option>
                </select>";
    echo"<select name='thn$nm' class='inp-reg inp-sm'>";
    echo"<option value=''>Tahun</option>";
    $thnkrg = date("Y") - 100;
    $thnskg = date("Y") + 5;
    for ($th = $thnskg; $th >= $thnkrg; $th--) {
        echo"<option value='$th'";
        if ($thn == $th) {
            echo "selected";
        }
        echo">$th</option>";
    }
    echo"</select>";
}
function tanggalonFill($nm,$tgl) {
    $tgl= substr($tgl, 0,10);
    $extgl=  explode("-", $tgl);
    $hari = $extgl[2];
    $bln = $extgl[1];
    $thn = $extgl[0];
    echo"<select name='hr$nm' class='inp-reg inp-sm'>";
    echo"<option value=''>Hari</option>";
    for ($h = 1; $h <= 31; $h++) {
        $hr = sprintf("%02d", $h);
        echo"<option value='$hr'";
        if ($hari == $hr) {
            echo "selected";
        }
        echo">$hr</option>";
    }
    echo"</select>";
    echo"<select name='bln$nm' class='inp-reg inp-sm'>
                    <option value=''>Bulan</option>
                    <option value='01'";
    if ($bln == "01") {
        echo"selected";
    }echo">Januari</option>
                    <option value='02'";
    if ($bln == "02") {
        echo"selected";
    }echo">Februari</option>
                    <option value='03'";
    if ($bln == "03") {
        echo"selected";
    }echo">Maret</option>
                    <option value='04'";
    if ($bln == "04") {
        echo"selected";
    }echo">April</option>
                    <option value='05'";
    if ($bln == "05") {
        echo"selected";
    }echo">Mei</option>
                    <option value='06'";
    if ($bln == "06") {
        echo"selected";
    }echo">Juni</option>
                    <option value='07'";
    if ($bln == "07") {
        echo"selected";
    }echo">Juli</option>
                    <option value='08'";
    if ($bln == "08") {
        echo"selected";
    }echo">Agustus</option>
                    <option value='09'";
    if ($bln == "09") {
        echo"selected";
    }echo">September</option>
                    <option value='10'";
    if ($bln == "10") {
        echo"selected";
    }echo">Oktober</option>
                    <option value='11'";
    if ($bln == "11") {
        echo"selected";
    }echo">November</option>
                    <option value='12'";
    if ($bln == "12") {
        echo"selected";
    }echo">Desember</option>
                </select>";
    echo"<select name='thn$nm' class='inp-reg inp-sm'>";
    echo"<option value=''>Tahun</option>";
    $thnkrg = date("Y") - 100;
    $thnskg = date("Y") + 5;
    for ($th = $thnskg; $th >= $thnkrg; $th--) {
        echo"<option value='$th'";
        if ($thn == $th) {
            echo "selected";
        }
        echo">$th</option>";
    }
    echo"</select>";
}
function tanggaloncls($nm,$cls) {
    $hari = date("d");
    $bln = date("m");
    $thn = date("Y");
    echo"<select name='hr$nm' class='$cls'>";
    echo"<option value=''>Hari</option>";
    for ($h = 1; $h <= 31; $h++) {
        $hr = sprintf("%02d", $h);
        echo"<option value='$hr'";
        if ($hari == $hr) {
            echo "selected";
        }
        echo">$hr</option>";
    }
    echo"</select>";
    echo"<select name='bln$nm' class='$cls'>
                    <option value=''>Bulan</option>
                    <option value='01'";
    if ($bln == "01") {
        echo"selected";
    }echo">Januari</option>
                    <option value='02'";
    if ($bln == "02") {
        echo"selected";
    }echo">Februari</option>
                    <option value='03'";
    if ($bln == "03") {
        echo"selected";
    }echo">Maret</option>
                    <option value='04'";
    if ($bln == "04") {
        echo"selected";
    }echo">April</option>
                    <option value='05'";
    if ($bln == "05") {
        echo"selected";
    }echo">Mei</option>
                    <option value='06'";
    if ($bln == "06") {
        echo"selected";
    }echo">Juni</option>
                    <option value='07'";
    if ($bln == "07") {
        echo"selected";
    }echo">Juli</option>
                    <option value='08'";
    if ($bln == "08") {
        echo"selected";
    }echo">Agustus</option>
                    <option value='09'";
    if ($bln == "09") {
        echo"selected";
    }echo">September</option>
                    <option value='10'";
    if ($bln == "10") {
        echo"selected";
    }echo">Oktober</option>
                    <option value='11'";
    if ($bln == "11") {
        echo"selected";
    }echo">November</option>
                    <option value='12'";
    if ($bln == "12") {
        echo"selected";
    }echo">Desember</option>
                </select>";
    echo"<select name='thn$nm' class='$cls'>";
    echo"<option value=''>Tahun</option>";
    $thnkrg = date("Y") - 100;
    $thnskg = date("Y") + 5;
    for ($th = $thnskg; $th >= $thnkrg; $th--) {
        echo"<option value='$th'";
        if ($thn == $th) {
            echo "selected";
        }
        echo">$th</option>";
    }
    echo"</select>";
}
?>