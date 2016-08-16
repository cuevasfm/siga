<?php
$this->load->helper('url');
?>
<style type="text/css">
    body {
        background-color: #9a1463;
        color: black;

    }
    .bgimage {
        background-image: url(<?php echo base_url(); ?>wall/wall1.jpg);
        background-size: 100%;
    }
</style>
<div class="row" style="margin: 0 auto">
    <div class="col-md-4 "></div>
    <div class="col-md-4 ">
<!--        <img src="<?php echo base_url(); ?>media/logomenuintrosiga.png" alt="..." class="img-rounded img-responsive" width="30%">-->

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-12">
                    <img src="<?php echo base_url(); ?>media/wall/logoinca1.gif" alt="" class="img-rounded img-responsive">
                    <br>
                </div>

                <form method="post" action="<?php echo base_url(); ?>index.php/sesion/signin">
                    <div class="form-group">
                        <label>Nombre de usuario</label>
                        <input type="text" name="usuario" class="form-control"  placeholder="Usuario">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <button type="submit" value="submit" class="btn btn-default btn-lg btn-block">Ingresar</button>

                </form>
            </div>
        </div>

    </div>

    <div class="col-md-4"></div>
</div>

