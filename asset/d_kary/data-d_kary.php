<table border="1">
    <tr>
        <th>NIK</th>
        <th>Foto</th>
        <th>Nama Pegawai</th>
        <th>Tanggal Lahir</th>
        <th>No Telp</th>
        <th>Jenis Kelamin</th>
        <th>Agama</th>
        <th>Email</th>
        <th>Status Aktif</th>
        <th>Unit</th>
        <th>Jabatan</th>
        <th>Aksi</th>
    </tr>

    <?php
    
    $query = mysql_query("SELECT karyawan.*, unit.nm_unit, jabatan.nm_jabatan from karyawan join unit on karyawan.id_unit = unit.id_unit join jabatan on karyawan.id_jabatan = jabatan.id_jabatan order by nik ASC ");
    $tampil = mysql_query("select rekening.no_rek, rekening.atas_nama, bank.kd_bank from rekening join bank on rekening.kd_bank = bank.kd_bank");

    while ($data = mysql_fetch_array($query)) {
        ?>
        <tr>
            <td><?php echo $data['nik']; ?></td>
            <td><img src="./asset/img-user/<?php echo $data['foto'];?>" class="img-sm"></td>
            <td><?php echo $data['nama']; ?><?php ?></td>
            <td><?php echo $data['tgl_lhr']; ?><?php ?></td>
            <td><?php echo $data['tlp']; ?><?php ?></td>
            <td><?php echo $data['jk']; ?><?php ?></td>
            <td><?php echo $data['agama']; ?><?php ?></td>
            <td><?php echo $data['email']; ?><?php ?></td>
            <td><?php echo $data['status_aktf']; ?><?php ?></td>
            <td><?php echo $data['id_unit']; ?><?php ?></td>
            <td><?php echo $data['id_jabatan']; ?><?php ?></td>
            <td>
                <a href=<?php echo "detail-karyawan-".md5($data[0]); ?>><button class="btn-reg">Detail</button></a>
                <a href=<?php echo "change-karyawan-".md5($data[0]); ?>><button class="btn-reg">Edit</button></a>
                <a href=<?php echo "hapus-karyawan-".md5($data[0]); ?> onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><button class="btn-stop">Hapus</button></a>
            </td>
        </tr>
        <?php
    }
    echo $pager->show();
    ?>
</tr></table>