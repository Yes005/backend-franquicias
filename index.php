<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML('<style>
body {
  font-family: Arial, sans-serif;
  font-size: 10pt;
}
</style>');

$palabra = 'Hola mundo';

$x = 87;
$y = 50;
$mpdf->SetWatermarkImage('C:/Users/adelso/Downloads/escudo.png', 1, 'D', array($x, $y));

$mpdf->showWatermarkImage = true;


$mpdf->AliasNbPages('[pagetotal]');

$mpdf->DefHTMLFooterByName(
    'MyFooter1',
    '<div style="text-align: right; font-weight: bold; font-size: 8pt;">Página {PAGENO} de [pagetotal]</div>'
);

$mpdf->SetHTMLFooterByName('MyFooter1');

$mpdf->WriteHTML('<head>
  <style>
    .logo {
      max-width: 80px;
      margin-top: -70px;
      margin-bottom: 40px;
    }
    h1 {
      font-size: 18px;
      margin-top: 20px;
      text-align: center;
      text-transform: uppercase;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }

    table.table-imgs td {
      border: 1px solid black;
      text-align: center;
    }

  </style>
</head>
<body>
  
<h1>Reporte de Franquicia</h1>
<img src="C:/Users/adelso/Downloads/logotipo_goes_b.png" alt="Government Logo" class="logo">

  <table>
    <tr>
      <td style="text-align: left;">N° de franquicia: 2024-007-001-087</td>
        <td style="text-align: right;">Fecha de visita: viernes, 14 de junio de 2024</td>
    </tr>
  </table>
  <p>Categoría: Sin observación

      <p>Nombre(s) Jurídico/Natural</p>
        <ul>
          <li>Juan Carlos Pérez Pérez</li>
          <li>Juan Carlos Pérez Pérez</li>
        </ul>
</body>');

$mpdf->WriteHTML('<p><strong>Observación</strong></p>');
$mpdf->WriteHTML('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ac tellus arcu. Integer suscipit sollicitudin lacus, vel rutrum neque efficitur eu. Sed ut sapien lacinia quam sodales maximus. Nam sed efficitur leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vel erat arcu. Aenean id dui lorem. Suspendisse sapien mi, ullamcorper sit amet consectetur quis, iaculis in mi. In ac pulvinar ante. Curabitur eget porta sem, quis maximus felis. Cras a suscipit diam, ut pulvinar leo. Praesent euismod eu turpis in iaculis.

Morbi lectus nisi, posuere vitae placerat sodales, dictum vel purus. Sed quis felis aliquam nulla eleifend auctor. Mauris eu varius eros. Nunc faucibus neque nec ligula semper placerat. Nulla hendrerit magna eu orci accumsan, volutpat convallis tortor consequat. Donec eleifend fermentum massa, vel viverra enim dictum vitae. Nulla sagittis diam vitae eros mollis hendrerit. Ut eget hendrerit dolor. Quisque eget interdum quam, malesuada congue leo. Integer aliquam lectus sit amet augue elementum egestas. Sed scelerisque massa orci, sit amet aliquet ex viverra quis. Nullam sollicitudin, odio non condimentum maximus, mi nulla dignissim sem, in rhoncus lectus felis sed lorem. Pellentesque eu tortor pulvinar, pulvinar purus lobortis, maximus leo. Sed gravida ipsum ac eros elementum ultricies. Nunc vitae nunc eros. Quisque feugiat nisi condimentum dolor faucibus finibus.

Donec dignissim leo vel elit malesuada ultrices. Suspendisse pretium diam nec ligula congue laoreet in vel lorem. In sit amet varius nunc. Curabitur dictum nunc augue, porttitor interdum purus ultrices non. Curabitur hendrerit tortor lacus, eu cursus odio rutrum eu. Sed lacinia velit eget ligula maximus rutrum. Suspendisse quis varius enim. Praesent ac elementum lacus. Duis id quam aliquet, suscipit dui sed, hendrerit felis. Phasellus arcu leo, imperdiet ornare ipsum id, porta lacinia purus. Donec fermentum tempor mollis.

Donec euismod rhoncus faucibus. Nulla egestas tristique velit ut tempus. Duis diam tortor, faucibus pharetra vestibulum sed, fermentum eget quam. Mauris dictum sapien justo, finibus ultrices quam condimentum at. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus ornare tellus vel cursus semper. Mauris mattis ac nunc porttitor vulputate. Sed nec tortor libero. Vestibulum rutrum dapibus velit eget maximus. Sed egestas hendrerit feugiat. Ut pharetra fermentum neque, et semper lectus consequat sed. Donec nec risus nec diam porta sagittis. Curabitur consectetur tellus eget tincidunt tincidunt. In hac habitasse platea dictumst.

Ut id efficitur risus. Ut sodales ullamcorper ligula, at fermentum justo commodo quis. Aliquam sagittis finibus tincidunt. Quisque sed auctor mi. Pellentesque rutrum commodo turpis, vel semper ligula. Fusce non augue porta, vehicula ex tristique, scelerisque turpis. Praesent a erat massa. Curabitur nec ultrices turpis. Fusce cursus sagittis ante, eget ullamcorper odio suscipit a. Donec justo libero, ultrices ut sem sit amet, dignissim mattis felis. Vivamus gravida imperdiet diam quis aliquet.<p>');

$mpdf->WriteHTML('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ac tellus arcu. Integer suscipit sollicitudin lacus, vel rutrum neque efficitur eu. Sed ut sapien lacinia quam sodales maximus. Nam sed efficitur leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vel erat arcu. Aenean id dui lorem. Suspendisse sapien mi, ullamcorper sit amet consectetur quis, iaculis in mi. In ac pulvinar ante. Curabitur eget porta sem, quis maximus felis. Cras a suscipit diam, ut pulvinar leo. Praesent euismod eu turpis in iaculis.

Morbi lectus nisi, posuere vitae placerat sodales, dictum vel purus. Sed quis felis aliquam nulla eleifend auctor. Mauris eu varius eros. Nunc faucibus neque nec ligula semper placerat. Nulla hendrerit magna eu orci accumsan, volutpat convallis tortor consequat. Donec eleifend fermentum massa, vel viverra enim dictum vitae. Nulla sagittis diam vitae eros mollis hendrerit. Ut eget hendrerit dolor. Quisque eget interdum quam, malesuada congue leo. Integer aliquam lectus sit amet augue elementum egestas. Sed scelerisque massa orci, sit amet aliquet ex viverra quis. Nullam sollicitudin, odio non condimentum maximus, mi nulla dignissim sem, in rhoncus lectus felis sed lorem. Pellentesque eu tortor pulvinar, pulvinar purus lobortis, maximus leo. Sed gravida ipsum ac eros elementum ultricies. Nunc vitae nunc eros. Quisque feugiat nisi condimentum dolor faucibus finibus.

Donec dignissim leo vel elit malesuada ultrices. Suspendisse pretium diam nec ligula congue laoreet in vel lorem. In sit amet varius nunc. Curabitur dictum nunc augue, porttitor interdum purus ultrices non. Curabitur hendrerit tortor lacus, eu cursus odio rutrum eu. Sed lacinia velit eget ligula maximus rutrum. Suspendisse quis varius enim. Praesent ac elementum lacus. Duis id quam aliquet, suscipit dui sed, hendrerit felis. Phasellus arcu leo, imperdiet ornare ipsum id, porta lacinia purus. Donec fermentum tempor mollis.

Donec euismod rhoncus faucibus. Nulla egestas tristique velit ut tempus. Duis diam tortor, faucibus pharetra vestibulum sed, fermentum eget quam. Mauris dictum sapien justo, finibus ultrices quam condimentum at. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus ornare tellus vel cursus semper. Mauris mattis ac nunc porttitor vulputate. Sed nec tortor libero. Vestibulum rutrum dapibus velit eget maximus. Sed egestas hendrerit feugiat. Ut pharetra fermentum neque, et semper lectus consequat sed. Donec nec risus nec diam porta sagittis. Curabitur consectetur tellus eget tincidunt tincidunt. In hac habitasse platea dictumst.

Ut id efficitur risus. Ut sodales ullamcorper ligula, at fermentum justo commodo quis. Aliquam sagittis finibus tincidunt. Quisque sed auctor mi. Pellentesque rutrum commodo turpis, vel semper ligula. Fusce non augue porta, vehicula ex tristique, scelerisque turpis. Praesent a erat massa. Curabitur nec ultrices turpis. Fusce cursus sagittis ante, eget ullamcorper odio suscipit a. Donec justo libero, ultrices ut sem sit amet, dignissim mattis felis. Vivamus gravida imperdiet diam quis aliquet.<p>');

$mpdf->WriteHTML('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ac tellus arcu. Integer suscipit sollicitudin lacus, vel rutrum neque efficitur eu. Sed ut sapien lacinia quam sodales maximus. Nam sed efficitur leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vel erat arcu. Aenean id dui lorem. Suspendisse sapien mi, ullamcorper sit amet consectetur quis, iaculis in mi. In ac pulvinar ante. Curabitur eget porta sem, quis maximus felis. Cras a suscipit diam, ut pulvinar leo. Praesent euismod eu turpis in iaculis.

Morbi lectus nisi, posuere vitae placerat sodales, dictum vel purus. Sed quis felis aliquam nulla eleifend auctor. Mauris eu varius eros. Nunc faucibus neque nec ligula semper placerat. Nulla hendrerit magna eu orci accumsan, volutpat convallis tortor consequat. Donec eleifend fermentum massa, vel viverra enim dictum vitae. Nulla sagittis diam vitae eros mollis hendrerit. Ut eget hendrerit dolor. Quisque eget interdum quam, malesuada congue leo. Integer aliquam lectus sit amet augue elementum egestas. Sed scelerisque massa orci, sit amet aliquet ex viverra quis. Nullam sollicitudin, odio non condimentum maximus, mi nulla dignissim sem, in rhoncus lectus felis sed lorem. Pellentesque eu tortor pulvinar, pulvinar purus lobortis, maximus leo. Sed gravida ipsum ac eros elementum ultricies. Nunc vitae nunc eros. Quisque feugiat nisi condimentum dolor faucibus finibus.

Donec dignissim leo vel elit malesuada ultrices. Suspendisse pretium diam nec ligula congue laoreet in vel lorem. In sit amet varius nunc. Curabitur dictum nunc augue, porttitor interdum purus ultrices non. Curabitur hendrerit tortor lacus, eu cursus odio rutrum eu. Sed lacinia velit eget ligula maximus rutrum. Suspendisse quis varius enim. Praesent ac elementum lacus. Duis id quam aliquet, suscipit dui sed, hendrerit felis. Phasellus arcu leo, imperdiet ornare ipsum id, porta lacinia purus. Donec fermentum tempor mollis.

Donec euismod rhoncus faucibus. Nulla egestas tristique velit ut tempus. Duis diam tortor, faucibus pharetra vestibulum sed, fermentum eget quam. Mauris dictum sapien justo, finibus ultrices quam condimentum at. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus ornare tellus vel cursus semper. Mauris mattis ac nunc porttitor vulputate. Sed nec tortor libero. Vestibulum rutrum dapibus velit eget maximus. Sed egestas hendrerit feugiat. Ut pharetra fermentum neque, et semper lectus consequat sed. Donec nec risus nec diam porta sagittis. Curabitur consectetur tellus eget tincidunt tincidunt. In hac habitasse platea dictumst.

Ut id efficitur risus. Ut sodales ullamcorper ligula, at fermentum justo commodo quis. Aliquam sagittis finibus tincidunt. Quisque sed auctor mi. Pellentesque rutrum commodo turpis, vel semper ligula. Fusce non augue porta, vehicula ex tristique, scelerisque turpis. Praesent a erat massa. Curabitur nec ultrices turpis. Fusce cursus sagittis ante, eget ullamcorper odio suscipit a. Donec justo libero, ultrices ut sem sit amet, dignissim mattis felis. Vivamus gravida imperdiet diam quis aliquet.<p>');

$mpdf->WriteHTML('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ac tellus arcu. Integer suscipit sollicitudin lacus, vel rutrum neque efficitur eu. Sed ut sapien lacinia quam sodales maximus. Nam sed efficitur leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vel erat arcu. Aenean id dui lorem. Suspendisse sapien mi, ullamcorper sit amet consectetur quis, iaculis in mi. In ac pulvinar ante. Curabitur eget porta sem, quis maximus felis. Cras a suscipit diam, ut pulvinar leo. Praesent euismod eu turpis in iaculis.

Morbi lectus nisi, posuere vitae placerat sodales, dictum vel purus. Sed quis felis aliquam nulla eleifend auctor. Mauris eu varius eros. Nunc faucibus neque nec ligula semper placerat. Nulla hendrerit magna eu orci accumsan, volutpat convallis tortor consequat. Donec eleifend fermentum massa, vel viverra enim dictum vitae. Nulla sagittis diam vitae eros mollis hendrerit. Ut eget hendrerit dolor. Quisque eget interdum quam, malesuada congue leo. Integer aliquam lectus sit amet augue elementum egestas. Sed scelerisque massa orci, sit amet aliquet ex viverra quis. Nullam sollicitudin, odio non condimentum maximus, mi nulla dignissim sem, in rhoncus lectus felis sed lorem. Pellentesque eu tortor pulvinar, pulvinar purus lobortis, maximus leo. Sed gravida ipsum ac eros elementum ultricies. Nunc vitae nunc eros. Quisque feugiat nisi condimentum dolor faucibus finibus.

Donec dignissim leo vel elit malesuada ultrices. Suspendisse pretium diam nec ligula congue laoreet in vel lorem. In sit amet varius nunc. Curabitur dictum nunc augue, porttitor interdum purus ultrices non. Curabitur hendrerit tortor lacus, eu cursus odio rutrum eu. Sed lacinia velit eget ligula maximus rutrum. Suspendisse quis varius enim. Praesent ac elementum lacus. Duis id quam aliquet, suscipit dui sed, hendrerit felis. Phasellus arcu leo, imperdiet ornare ipsum id, porta lacinia purus. Donec fermentum tempor mollis.

Donec euismod rhoncus faucibus. Nulla egestas tristique velit ut tempus. Duis diam tortor, faucibus pharetra vestibulum sed, fermentum eget quam. Mauris dictum sapien justo, finibus ultrices quam condimentum at. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus ornare tellus vel cursus semper. Mauris mattis ac nunc porttitor vulputate. Sed nec tortor libero. Vestibulum rutrum dapibus velit eget maximus. Sed egestas hendrerit feugiat. Ut pharetra fermentum neque, et semper lectus consequat sed. Donec nec risus nec diam porta sagittis. Curabitur consectetur tellus eget tincidunt tincidunt. In hac habitasse platea dictumst.

Ut id efficitur risus. Ut sodales ullamcorper ligula, at fermentum justo commodo quis. Aliquam sagittis finibus tincidunt. Quisque sed auctor mi. Pellentesque rutrum commodo turpis, vel semper ligula. Fusce non augue porta, vehicula ex tristique, scelerisque turpis. Praesent a erat massa. Curabitur nec ultrices turpis. Fusce cursus sagittis ante, eget ullamcorper odio suscipit a. Donec justo libero, ultrices ut sem sit amet, dignissim mattis felis. Vivamus gravida imperdiet diam quis aliquet.<p>');

$mpdf->WriteHTML('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ac tellus arcu. Integer suscipit sollicitudin lacus, vel rutrum neque efficitur eu. Sed ut sapien lacinia quam sodales maximus. Nam sed efficitur leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vel erat arcu. Aenean id dui lorem. Suspendisse sapien mi, ullamcorper sit amet consectetur quis, iaculis in mi. In ac pulvinar ante. Curabitur eget porta sem, quis maximus felis. Cras a suscipit diam, ut pulvinar leo. Praesent euismod eu turpis in iaculis.

Morbi lectus nisi, posuere vitae placerat sodales, dictum vel purus. Sed quis felis aliquam nulla eleifend auctor. Mauris eu varius eros. Nunc faucibus neque nec ligula semper placerat. Nulla hendrerit magna eu orci accumsan, volutpat convallis tortor consequat. Donec eleifend fermentum massa, vel viverra enim dictum vitae. Nulla sagittis diam vitae eros mollis hendrerit. Ut eget hendrerit dolor. Quisque eget interdum quam, malesuada congue leo. Integer aliquam lectus sit amet augue elementum egestas. Sed scelerisque massa orci, sit amet aliquet ex viverra quis. Nullam sollicitudin, odio non condimentum maximus, mi nulla dignissim sem, in rhoncus lectus felis sed lorem. Pellentesque eu tortor pulvinar, pulvinar purus lobortis, maximus leo. Sed gravida ipsum ac eros elementum ultricies. Nunc vitae nunc eros. Quisque feugiat nisi condimentum dolor faucibus finibus.

Donec dignissim leo vel elit malesuada ultrices. Suspendisse pretium diam nec ligula congue laoreet in vel lorem. In sit amet varius nunc. Curabitur dictum nunc augue, porttitor interdum purus ultrices non. Curabitur hendrerit tortor lacus, eu cursus odio rutrum eu. Sed lacinia velit eget ligula maximus rutrum. Suspendisse quis varius enim. Praesent ac elementum lacus. Duis id quam aliquet, suscipit dui sed, hendrerit felis. Phasellus arcu leo, imperdiet ornare ipsum id, porta lacinia purus. Donec fermentum tempor mollis.

Donec euismod rhoncus faucibus. Nulla egestas tristique velit ut tempus. Duis diam tortor, faucibus pharetra vestibulum sed, fermentum eget quam. Mauris dictum sapien justo, finibus ultrices quam condimentum at. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus ornare tellus vel cursus semper. Mauris mattis ac nunc porttitor vulputate. Sed nec tortor libero. Vestibulum rutrum dapibus velit eget maximus. Sed egestas hendrerit feugiat. Ut pharetra fermentum neque, et semper lectus consequat sed. Donec nec risus nec diam porta sagittis. Curabitur consectetur tellus eget tincidunt tincidunt. In hac habitasse platea dictumst.

Ut id efficitur risus. Ut sodales ullamcorper ligula, at fermentum justo commodo quis. Aliquam sagittis finibus tincidunt. Quisque sed auctor mi. Pellentesque rutrum commodo turpis, vel semper ligula. Fusce non augue porta, vehicula ex tristique, scelerisque turpis. Praesent a erat massa. Curabitur nec ultrices turpis. Fusce cursus sagittis ante, eget ullamcorper odio suscipit a. Donec justo libero, ultrices ut sem sit amet, dignissim mattis felis. Vivamus gravida imperdiet diam quis aliquet.<p>');

$mpdf->WriteHTML('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ac tellus arcu. Integer suscipit sollicitudin lacus, vel rutrum neque efficitur eu. Sed ut sapien lacinia quam sodales maximus. Nam sed efficitur leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vel erat arcu. Aenean id dui lorem. Suspendisse sapien mi, ullamcorper sit amet consectetur quis, iaculis in mi. In ac pulvinar ante. Curabitur eget porta sem, quis maximus felis. Cras a suscipit diam, ut pulvinar leo. Praesent euismod eu turpis in iaculis.

Morbi lectus nisi, posuere vitae placerat sodales, dictum vel purus. Sed quis felis aliquam nulla eleifend auctor. Mauris eu varius eros. Nunc faucibus neque nec ligula semper placerat. Nulla hendrerit magna eu orci accumsan, volutpat convallis tortor consequat. Donec eleifend fermentum massa, vel viverra enim dictum vitae. Nulla sagittis diam vitae eros mollis hendrerit. Ut eget hendrerit dolor. Quisque eget interdum quam, malesuada congue leo. Integer aliquam lectus sit amet augue elementum egestas. Sed scelerisque massa orci, sit amet aliquet ex viverra quis. Nullam sollicitudin, odio non condimentum maximus, mi nulla dignissim sem, in rhoncus lectus felis sed lorem. Pellentesque eu tortor pulvinar, pulvinar purus lobortis, maximus leo. Sed gravida ipsum ac eros elementum ultricies. Nunc vitae nunc eros. Quisque feugiat nisi condimentum dolor faucibus finibus.

Donec dignissim leo vel elit malesuada ultrices. Suspendisse pretium diam nec ligula congue laoreet in vel lorem. In sit amet varius nunc. Curabitur dictum nunc augue, porttitor interdum purus ultrices non. Curabitur hendrerit tortor lacus, eu cursus odio rutrum eu. Sed lacinia velit eget ligula maximus rutrum. Suspendisse quis varius enim. Praesent ac elementum lacus. Duis id quam aliquet, suscipit dui sed, hendrerit felis. Phasellus arcu leo, imperdiet ornare ipsum id, porta lacinia purus. Donec fermentum tempor mollis.

Donec euismod rhoncus faucibus. Nulla egestas tristique velit ut tempus. Duis diam tortor, faucibus pharetra vestibulum sed, fermentum eget quam. Mauris dictum sapien justo, finibus ultrices quam condimentum at. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus ornare tellus vel cursus semper. Mauris mattis ac nunc porttitor vulputate. Sed nec tortor libero. Vestibulum rutrum dapibus velit eget maximus. Sed egestas hendrerit feugiat. Ut pharetra fermentum neque, et semper lectus consequat sed. Donec nec risus nec diam porta sagittis. Curabitur consectetur tellus eget tincidunt tincidunt. In hac habitasse platea dictumst.

Ut id efficitur risus. Ut sodales ullamcorper ligula, at fermentum justo commodo quis. Aliquam sagittis finibus tincidunt. Quisque sed auctor mi. Pellentesque rutrum commodo turpis, vel semper ligula. Fusce non augue porta, vehicula ex tristique, scelerisque turpis. Praesent a erat massa. Curabitur nec ultrices turpis. Fusce cursus sagittis ante, eget ullamcorper odio suscipit a. Donec justo libero, ultrices ut sem sit amet, dignissim mattis felis. Vivamus gravida imperdiet diam quis aliquet.<p>');

$mpdf->WriteHTML(
    '<table class="table-imgs">
        <tr>
            <td>
                <img src="C:/Users/adelso/Downloads/img_prueba/1.webp">
            </td>
            <td>
                <img src="C:/Users/adelso/Downloads/img_prueba/2.jpg">
            </td>
        </tr>
        <tr>
            <td>
                <img src="C:/Users/adelso/Downloads/img_prueba/3.jpg">
            </td>
            <td>
                <img src="C:/Users/adelso/Downloads/img_prueba/4.jpg">
            </td>
        </tr>
        <tr>
            <td>
                <img src="C:/Users/adelso/Downloads/img_prueba/5.jpeg">
            </td>
            <td>
                <img src="C:/Users/adelso/Downloads/img_prueba/6.tif">
            </td>
        </tr>
                <tr>
            <td>
                <img src="C:/Users/adelso/Downloads/img_prueba/7.tiff">
            </td>
        </tr>
    </table>'
);

// $path = $request->file('archivo')->storeAs('observaciones', $fileName, 'public');
// $mpdf->SetWatermarkText('PRUEBA', 0.1);


// $mpdf->showWatermarkText = true;

// $mpdf->watermarkTextAlpha = 0.1;
// $mpdf->watermarkImageAlpha = 0.5;



$mpdf->Output(__DIR__ . '/storage/app/public/test/hello.pdf');
