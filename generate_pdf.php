<?php
require('fpdf.php');
include('db.php');

$id = intval($_GET['id']);
$query = "SELECT * FROM notices WHERE id = $id AND is_deleted = 0";
$result = mysqli_query($conn, $query);
$notice = mysqli_fetch_assoc($result);

if (!$notice) {
    die("Notice not found.");
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(0, 10, $notice['title'], 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, "Description:\n" . $notice['description']);
$pdf->Ln(5);
$pdf->Cell(0, 10, "Category: " . $notice['category']);
$pdf->Ln(7);
$pdf->Cell(0, 10, "Created By: " . $notice['created_by']);
$pdf->Ln(7);
$pdf->Cell(0, 10, "Posted On: " . $notice['posted_at']);
$pdf->Ln(7);
$pdf->Cell(0, 10, "Expires On: " . $notice['expire_at']);
$pdf->Output('D', $notice['title'] . '.pdf'); // D = Download
exit;
