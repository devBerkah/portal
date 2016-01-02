<div>
    <label class="headlabel"><i class="fa fa-image"></i> Ubah foto tampilan</label> 
    <div class="alt-war">
        Pilih Foto dan drag di area foto untuk memotong foto
    </div>
</div>
<div class="wrap">
	<!-- image preview area-->
	<img id="uploadPreview" style="display:none;"/>
	
	<!-- image uploading form -->
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<input id="uploadImage" type="file" accept="image/jpeg" name="image" />
                <button class="btn-reg" type="submit">Ganti</button>
                <a href="profil"><button class="btn-stop">Batal</button></a>

		<!-- hidden inputs -->
		<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />
	</form>
</div><!--wrap-->