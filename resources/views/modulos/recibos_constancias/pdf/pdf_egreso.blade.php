<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Constancia de Egreso</title>
    <style>
        @page { margin: 1cm 2.5cm 1.5cm 2.5cm; }
        body { 
            font-family: 'Arial', sans-serif; 
            font-size: 11pt; 
            line-height: 1.5; 
            color: #000;
        }
        .header-image { text-align: center; margin-bottom: 10px; }
        .header-image img { width: 100%; height: auto; }
        
        .title {
            text-align: center; font-weight: bold; font-size: 14pt;
            text-decoration: underline; margin-bottom: 30px; margin-top: 10px;
        }
        
        .content { text-align: justify; margin-bottom: 12px; }
        .bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        
        .footer { text-align: center; width: 100%; margin-top: 20px; }
        
        .table-firma {
            width: 50%;
            margin: 0 auto 5px auto;
            border-collapse: collapse;
        }
        .table-firma td { width: 50%; vertical-align: middle; text-align: center; }
        .img-firma-sello { height: 95px; width: auto; }

        .table-info-final {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-info-qr { width: 100%; margin-top: 10px; border-collapse: collapse; }
        
        .td-espacio-izq { width: 20%; } 
        
        .td-director {
            width: 60%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.2;
        }

        .td-qr {
            width: 20%;
            text-align: center;
            vertical-align: middle;
        }

        .nombre-director { font-weight: bold; font-size: 12pt; }
        .cargo-director { font-weight: bold; font-size: 10pt; text-transform: uppercase; }
        .resolucion { font-style: italic; font-size: 9pt; }

        /* AJUSTE CLAVE: Forzamos dimensiones cuadradas para el escaneo */
        .img-qr {
            width: 110px !important;
            height: 110px !important;
            display: block;
            margin: 0 auto;
        }

        .qr-label {
            font-size: 6pt;
            text-align: center;
            display: block;
            margin-top: 2px;
            color: #444;
        }

        .legal-notice {
            text-align: justify;
            font-size: 8.5pt;
            line-height: 1.3;
            margin-top: 30px;
            border-top: 0.5px solid #ccc;
            padding-top: 10px;
        }

        .address-footer {
            text-align: center;
            font-size: 7.5pt;
            margin-top: 15px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>

    <style>
        @page { margin: 1cm 2.5cm 1.5cm 2.5cm; }
        body { font-family: 'Arial', sans-serif; font-size: 11pt; line-height: 1.5; color: #000; }
        .header-image { text-align: center; margin-bottom: 10px; }
        .header-image img { width: 100%; height: auto; }
        .title { text-align: center; font-weight: bold; font-size: 14pt; text-decoration: underline; margin-bottom: 30px; margin-top: 10px; }
        .content { text-align: justify; margin-bottom: 12px; }
        .bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .footer { text-align: center; width: 100%; margin-top: 20px; }
        .table-firma { width: 50%; margin: 0 auto 5px auto; border-collapse: collapse; }
        .table-firma td { width: 50%; vertical-align: middle; text-align: center; }
        .img-firma-sello { height: 95px; width: auto; }
        .info-director { text-align: center; line-height: 1.2; margin-bottom: 20px; }
        .nombre-director { font-weight: bold; font-size: 12pt; }
        .cargo-director { font-weight: bold; font-size: 10pt; text-transform: uppercase; }
        .resolucion { font-style: italic; font-size: 9pt; }
        .table-info-qr { width: 100%; margin-top: 10px; border-collapse: collapse; }
        .td-texto { width: 75%; text-align: center; padding-left: 50px; vertical-align: middle; }
        .td-qr { width: 25%; text-align: center; vertical-align: middle; }
        .img-qr { width: 90px; height: 90px; }
        .legal-notice { text-align: justify; font-size: 8.5pt; line-height: 1.3; margin-top: 30px; border-top: 0.5px solid #ccc; padding-top: 10px; }
        .address-footer { text-align: center; font-size: 7.5pt; margin-top: 15px; border-top: 1px solid #000; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header-image">
        <img src="{{ $cintillo }}" alt="Cintillo">
    </div>

    <div class="title">CONSTANCIA</div>

    <div class="content">
        Quien suscribe, el <span class="bold">Director General</span> de la <span class="bold">Oficina de Gestión Humana del 
        Ministerio del Poder Popular para el Proceso Social de Trabajo</span>, hace constar 
        por medio de la presente que {{ $ciudadano }} <span class="bold uppercase">{{ $nombre_completo }}</span>, 
        titular de la cédula de identidad Nro. <span class="bold">{{ $nacionalidad }}.-{{ $cedula }}</span>, 
        prestó sus servicios en este Organismo como <span class="bold uppercase">{{ $figura }}</span>, 
        desempeñando el cargo de <span class="bold uppercase">{{ $cargo }}</span>, en la 
        <span class="bold uppercase">{{ $dependencia }}</span>, desde el <span class="bold">{{ $fecha_ingreso }}</span> 
        hasta el <span class="bold">{{ $fecha_egreso }}</span>, en el horario comprendido desde las {{ $horario }}.
    </div>

    <div class="content">
        Constancia que se expide a petición de la parte interesada en Caracas a los <span class="bold">{{ $dia }}</span> 
        días del mes de <span class="bold">{{ $mes }}</span> de <span class="bold">{{ $ano }}</span>.
    </div>

    <div class="footer">
        <p class="bold" style="font-style: italic; margin-bottom: 5px;">Atentamente,</p>

        <table class="table-firma">
            <tr>
                <td><img src="{{ $firma }}" class="img-firma-sello"></td>
                <td><img src="{{ $sello }}" class="img-firma-sello"></td>
            </tr>
        </table>

        {{-- <table class="table-info-final">
            <tr>
                <td class="td-espacio-izq"></td>
                
                <td class="td-director">
                    <div class="nombre-director">CARLOS JAVIER FONSECA TOVAR</div>
                    <div class="cargo-director">DIRECTOR GENERAL DE LA OFICINA DE GESTIÓN HUMANA</div>
                    <div class="resolucion">
                        Según Resolución N° 031 de fecha 24/09/2024<br>
                        Gaceta Oficial N° 42.971 de fecha 25/09/2024
                    </div>
                </td>

                <td class="td-qr">
                    @if($qrCode)
                        <div style="text-align: center;">
                            <img src="{{ $qrCode }}" class="img-qr">
                            <span class="qr-label" style="display:block; width:100%;">VALIDACIÓN DIGITAL</span>
                        </div>
                    @endif
                </td>
            </tr>
        </table> --}}


        <table class="table-info-final">
            <tr>
                <td class="td-texto">
                    <div class="info-director">
                        <div class="nombre-director">CARLOS JAVIER FONSECA TOVAR</div>
                        <div class="cargo-director">DIRECTOR GENERAL DE LA OFICINA DE GESTIÓN HUMANA</div>
                        <div class="resolucion">
                            Según Resolución N° 031 de fecha 24/09/2024<br>
                            Gaceta Oficial N° 42.971 de fecha 25/09/2024
                        </div>
                    </div>
                </td>
                <td class="td-qr">
                    @if($qrCode)
                        <div style="text-align: center;">
                            <img src="{{ $qrCode }}" style="width: 105px; height: 105px; display: block; margin: 0 auto;">
                            {{-- <span style="font-size: 6pt; display: block; margin-top: 2px;">VALIDACIÓN DIGITAL</span> --}}
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        
    </div>

    <div class="legal-notice" style="text-align: center;">
        Esta constancia es válida hasta el <span class="bold">{{ $fec_caducidad }}</span>. 
        No requiere sello húmedo. Según Ley de Simplificación de Trámites Administrativos y Ley de Infogobierno.
    </div>

    <div class="address-footer">
        Av. Baralt. Edif. Sur, Centro Simón Bolívar, piso 4. Urb. Santa Teresa. Caracas. Distrito Capital. Apartado Postal 1010.<br>
        Rif G-20000012-0. Para Cualquier información podrá comunicarse por los números telefónicos: (0212)-408 4366, 4372.
    </div>

</body>
</html>