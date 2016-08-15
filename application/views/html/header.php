<html lang="es" ng-app>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SIGA -INCA</title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url()?>boostrap/css/bootstrap.min.css" rel="stylesheet">
        <style media="print">
            .print_ignore {
                display: none;
            }

            body, table, th, td {
                -webkit-print-color-adjust: exact; 
                color:             #000000;
                background-color:  #000;
                font-size:         8pt;
            }

            img {
                border: 0;
            }

            table, th, td {
                border-width:      0.1em;
                border-color:      #000000;
                border-style:      solid;
            }

            table {
                border-collapse:   collapse;
                border-spacing:    0;
            }

            th, td {
                padding:           0.2em;
            }

            th {
                font-weight:       bold; 
                background-color:  #000;
            }

            @media print  {
                

                body, table, td {
                    -webkit-print-color-adjust: exact; 
                    color:             #000000;
                    background-color:  #000;
                    font-size:         8pt;
                }

                img {
                    border: 0;
                }

                table, th, td {
                    border-width:      1px;
                    border-color:      #000;
                    border-style:      solid;
                }

                table {
                    border-collapse:   collapse;
                    border-spacing:    0;
                }

                th, td {
                    padding:           0.2em;
                }

                th {
                    font-weight:       bold;
                    background-color:  #000000;
                }
                caption{
                    background-color: #ffffff;
                }
            }
        </style>
    </head>
    <body style="background:url('<?php echo base_url(); ?>/media/wall/backgroundflorinca450.png') no-repeat  ">
        <div class="container">
