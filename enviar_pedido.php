<?php
require('fpdf.php');

// Obtener datos del formulario
$producto = $_POST['producto'];
$cantidad = $_POST['cantidad'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];

// Crear mensaje para enviar a tu correo
$mensaje = "Nuevo pedido:\nProducto: $producto\nCantidad: $cantidad\nNombre: $nombre\nCorreo: $correo\nTeléfono: $telefono\nDirección: $direccion\nCiudad: $ciudad";
mail("polovitico@gmail.com", "Nuevo Pedido de $nombre", $mensaje);

// Generar PDF con FPDF
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'Factura de Pedido - Canedo Luxe',0,1,'C');
        $this->Ln(10);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,10,"Nombre: $nombre\nProducto: $producto\nCantidad: $cantidad\nDirección: $direccion\nCiudad: $ciudad\nTeléfono: $telefono\nCorreo: $correo");
$pdfPath = 'factura_' . time() . '.pdf';
$pdf->Output('F', $pdfPath);

// Mostrar confirmación en pantalla con enlace de descarga y botón de WhatsApp
echo "<h2>✅ Pedido confirmado</h2>";
echo "<p>Gracias por tu compra, <strong>$nombre</strong>. Hemos recibido tu pedido correctamente.</p>";
echo "<a href='$pdfPath' download>📄 Descargar Factura PDF</a><br><br>";

// Crear enlace de WhatsApp con mensaje
$mensajeWhatsapp = urlencode("Hola $nombre, gracias por tu pedido de $producto. Aquí puedes ver tu factura: localhost/canedoluxe/$pdfPath");
$telefono_limpio = preg_replace('/\D/', '', $telefono);
$numeroCompleto = "57" . $telefono_limpio;

echo "<a href='https://wa.me/$numeroCompleto?text=$mensajeWhatsapp' target='_blank'>
        📲 Enviar factura por WhatsApp
      </a>";
?>