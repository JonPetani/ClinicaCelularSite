<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<title>About Us : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
?>
<nav align=center>
<a href="Home.php">Home</a>
<a href="">Tech Services</a>
<a href="store.php">Online Tech Shop</a>
<a href="about.php">About Us</a>
<a href="">Contact Us</a>
<a href="register.php" id="register">Register Account</a>
<a href="login.php" id="login">Log In</a>
<?php
setAccountTabs();
?>
</nav>
<br clear=both>
<main>
<br>
<h1>About Clínica Celular</h1>
<dl>
<dt>
¿Quienes somos?
</dt>
<dd>
Somos una empresa con más de 16 años de experiencia en el campo de la reparación de electrónica, somos técnicos certificados y contamos con equipamiento profesional de primera línea para ofrecerte el mejor servicio posible y a bajo costo.
</dd>
</dl>
<h2>FAQ</h2>
<dl>
<dt>
¿Qué es una reparación a nivel componente y en qué casos aplica?
</dt>
<dd>
Se puede resumir que partimos del diagnóstico y la localización de mico componentes dañados, en corto o que han perdido la capacidad de procesar voltajes y debe(n) ser reemplazado(s) estos componentes impiden el correcto funcionamiento de su dispositivo, por ejemplo; una falla muy común en algunos iPhone que deja de funcionar el touch a pesar de que la pieza no está dañada, la perdida de la luz o imagen, la perdida de audio o del micrófono, indican que cargan pero no lo hacen y la batería está bien, estas fallas son muy comunes y poco reparadas por la ausencia de conocimientos en electrónica y de equipamiento profesional, la verdad es que la mayoría de negocios no los pueden reparar porque no cuentan con nuestra oferta de servicio técnico para realizar reparaciones complicadas de forma que el equipo pueda volver a funcionar
</dd>
<dt>
¿Qué es la micro soldadura?
</dt>
<dd>
La micro soldadura aplica a motherboard de teléfonos celulares que por su tamaño tan pequeño requiere del apoyo de un microscopio porque los trabajos de reparación no es posible realizarlos a simple vista, desoldar microcomponentes, rebalear el chip, volverlo a soldar en la placa base para que vuelva a funcionar correctamente requiere equipamiento profesional específico para este tema.
</dd>
<dt>
¿Qué es un reballing?
</dt>
<dd>
Durante este proceso se desolda el chip de vídeo de la laptop o la consola de vídeo juegos para cambiar las esferas de soldadura que lo sujetan a la motherboard, permitiendo recuperar la conductividad adecuada y necesaria para el correcto funcionamiento de la función de vídeo en la tarjeta de vídeo del dispositivo que perdió la capacidad de enviar luz y vídeo al lcd o pantalla.
</dd>
<dt>
¿Que calidad de refacciones se utilizan para los cambios de pieza?
</dt>
<dd>
Se utiliza la mayor calidad disponible en refacciones, en muchos casos piezas originales o de calidad AAA (fabricados bajo la licencia de las marcas originales de un costo ligeramente menor).
</dd>
<dt>
¿Si mi equipo no tiene reparación, se me cobrará el costo de la reparación aun así?
</dt>
<dd>
No, si no podemos reparar tu equipo se te hace una íntegra devolución de tu dinero.
</dd>
<dt>
¿Cuanto tiempo tengo de garantía?
</dt>
<dd>
Dependiendo la reparación realizada o lo que se te haya vendido, variando desde 30 días hasta 6 meses.(Consulta tu garantia con tu cotización).
</dd>
<dt>
¿Qué métodos de pago se aceptan?
</dt>
<dd>
Aceptamos pagos mediante PayPal, CoDI, Pago con terminal y Efectivo.
</dd>
<dt>
¿Cuanto tiempo tardan en reparar mis dispositivos?
</dt>
<dd>
Debido a la complejidad o simplicidad de diversas reparaciones se te dará un tiempo estimado basado en un tiempo aproximado que toma cada reparación, pero por cualquier imprevisto se tendrá abierta un chat en vivo de atencion a cliente.
</dd>
<dt>
¿En qué otras plataformas se encuentran?
</dt>
<dd>
En Facebook e Instagram, nuestras paginas oficiales se anexan mediante los siguientes enlaces (hiperlink to our Facebook with the text “Facebook”) Instagram (hiperlink to our instagram with the text “Instagram”).
</dd>
<dt>
¿Si mi telefono se rompio el cristal es posible cambiarlo sin necesidad de reemplazar todo el LCD?
</dt>
<dd>
Dependiendo algunos modelos es posible, para la disponibilidad de esa reparación (Cambio de gorilla glass) es necesario usar el chat de atención a clientes preguntando por su disponibilidad.
</dd>
<dt>
¿La batería de mi dispositivo rinde cada vez menos, que se puede hacer?
</dt>
<dd>
En algunas ocasiones se debe reemplazar, ya que las baterías tienen un ciclo de vida determinado por los ciclos de carga, pero la vida de la batería se determina por una test de medición de la batería pudiendo determinar si es necesario reemplazarla o que la motherboard tenga una fuga de voltaje y eso haga que se descargue la batería y no dure la carga.
</dd>
<dt>
¿Solo arreglan dispositivos de Apple?
</dt>
<dd>
No, nosotros tenemos una gama de servicios para toda marca en el mercado, aunque nuestra especialidad es Apple.
</dd>
<dt>
¿Se necesita mi contraseña para alguna reparación?
</dt>
<dd>
Solo necesitamos tu dispositivo desbloqueado para poder revisar en caso de alguna reparación relacionada al touch, audio y a la imagen, fuera de estas reparaciones, no necesitamos de tu contraseña, tu privacidad está a salvo con nosotros.
</dd>
<dt>
¿Se pierde mi información al reparar?
</dt>
<dd>
No, tu información está a salvo a no ser que sea una reparación del sistema operativo en cuyo caso en un 80% esta pérdida ya que se pierden las particiones de la información ingresada.
</dd>
</dl>
</main>
<script>
$("dt").css("font-size", "160%");
$("dd").after("<br>");
</script>
</body>
</html>