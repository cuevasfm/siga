<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<div class="row">
    <div class="col-md-12"><h1>Bienvenido <?php echo $_SESSION['usuario']; ?>!</h1></div>
    <div class="col-md-1"></div>
    <div class="col-md-11">
        <div class="col-md-12">
            <h2>Noticias</h2>
        </div>
        <div class="col-md-8">
            <h3>Segunda nota<small> 11/07/2016 - 15:23:04 hrs - Jorge M. </small></h3>
            <img src="<?php echo base_url(); ?>/media/blog/post1.jpg" class="img-responsive" alt="Responsive image">
            <p class="text-justify">Lorem Ipsum es simplemente el texto de relleno de las imprentas 
                y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar
                de las industrias desde el año 1500, cuando un impresor (N. del T.
                persona que se dedica a la imprenta) desconocido usó una galería de 
                textos y los mezcló de tal manera que logró hacer un libro de textos 
                especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como
                texto de relleno en documentos electrónicos, quedando esencialmente
                igual al original. Fue popularizado en los 60s con la creación de las
                hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más
                recientemente con software de autoedición, como por ejemplo Aldus
                PageMaker, el cual incluye versiones de Lorem Ipsum.</p>
        </div>
        <hr>
        <div class="col-md-8">
            <h3>Primera nota - Estilo blog <small> 07/07/2016 - 11:05:34 hrs - Miguel C. </small></h3>
            <img src="<?php echo base_url(); ?>/media/blog/post2.jpg" class="img-responsive" alt="Responsive image">
            <p class="text-justify">Esta sección se podría utulizarse para postear noticias
                y contenido que se necesite mostrar al usuario que hace algún trámite. 
                Se diseñará más adelante la sección para ingresar las noticias nuevas, 
                o los post, que tendrán como objetivo informar.</p>
            <p class="text-justify">Lorem Ipsum es simplemente el texto de relleno de las imprentas 
                y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar
                de las industrias desde el año 1500, cuando un impresor (N. del T.
                persona que se dedica a la imprenta) desconocido usó una galería de 
                textos y los mezcló de tal manera que logró hacer un libro de textos 
                especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como
                texto de relleno en documentos electrónicos, quedando esencialmente
                igual al original. Fue popularizado en los 60s con la creación de las
                hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más
                recientemente con software de autoedición, como por ejemplo Aldus
                PageMaker, el cual incluye versiones de Lorem Ipsum.</p>
        </div>
        <hr>
    </div>
</div>


