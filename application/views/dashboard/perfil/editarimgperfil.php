
<br><br>


<div class="col-md-7">
    <?php echo $error; ?>
    <?php echo form_open_multipart(base_url() . 'dashboard/do_upload'); ?>
    <div class="form-group">
        <label>Seleccionar imagen</label>
        <input type="file" name="userfile" size="20" required=""/>
    </div>
     <input type="submit" value="Cargar Foto" />
    <?= form_close() ?>    
</div>
