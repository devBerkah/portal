<?php
    function tgl_indo6($tgl){
      $tanggal = substr($tgl,8,2);
      $bulan    = getBulan6(substr($tgl,5,2));
      $tahun    = substr($tgl,0,4);
      return $bulan.' '.$tahun;         
    }    
    function getBulan6($bln){
      switch ($bln){
        case 1: 
          return "Jan";
          break;
        case 2:
          return "Feb";
          break;
        case 3:
          return "Mar";
          break;
        case 4:
          return "Apr";
          break;
        case 5:
          return "Mei";
          break;
        case 6:
          return "Jun";
          break;
        case 7:
          return "Jul";
          break;
        case 8:
          return "Aug";
          break;
        case 9:
          return "Sep";
          break;
        case 10:
          return "Okt";
          break;
        case 11:
          return "Nov";
          break;
        case 12:
          return "Des";
          break;
    }
} 
?>