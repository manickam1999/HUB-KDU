<?php
require('fpdf17/fpdf.php');
//The pdf generator file
include_once("connection.php");
$db = db_connect();

//get invoices data
$query = mysqli_query($db,"SELECT * FROM students
	INNER JOIN course
	ON students.CourseId = course.CourseId
	WHERE
	StudentId = '".$_GET['studentId']."'");
$invoice = mysqli_fetch_array($query);

$query = mysqli_query($db,"SELECT * FROM semesterCount
	WHERE
	StudentId = '".$invoice['StudentId']."' AND SemNo=".$_GET['semNo']);
$semesterCount = mysqli_fetch_array($query);
$amount = 0;
//A4 width : 219mm
//default amrgin : 10mm each side
//writable horizontal : 219-(10*2) = 189mm

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

//set font to arial,bold,8pt , Title
//Cell(width,height,text,border,end line, [align](left is L, C is center,R is right))

$pdf ->SetFont('Arial','B',6);
$pdf ->Cell (100,3,'',0,0);
$pdf ->Cell (89,3,'KDU University College (PG) Sdn Bhd (879357-X)',0,1,'R');

$pdf ->SetFont('Arial','',6);
$pdf ->Cell (79,3,'',0,0);
$pdf ->Cell (110,3,'32, Jalan Anson,10400 Georgetown, Pulau Pinang,Malaysia',0,1,'R');
$pdf ->Cell (59,3,'',0,0);
$pdf ->Cell (130,3,'Tel :04-2386368 Fax:04-2280362 Email:best@kdupg.edu.my Website:kdupg.edu.my',0,1,'R');

$pdf ->Cell (189,3,'_______________________________________________________________________________________________________________________________________________________________',0,1);

$pdf ->SetFont('Arial','',10);
$pdf ->Cell (189,2,'',0,1);
$pdf ->Cell (189,5,'INVOICE',0,1,'R');
$pdf ->Cell (189,2,'',0,1);

$pdf ->Cell (100,5,$invoice['StudentFirstName'].' '.$invoice['StudentMidName'].' '.$invoice['StudentLastName'],0,1);

$pdf ->Cell (100,5,'',0,0);
$pdf ->Cell (25,5,'Invoice Date',0,0);
$pdf ->Cell (5,5,' : ',0,0);
$pdf ->Cell (59,5,date("d-m-Y",strtotime($semesterCount['PayStartDate'])),0,1);

$pdf ->Cell (100,5,'',0,0);
$pdf ->Cell (25,5,'Student No',0,0);
$pdf ->Cell (5,5,' : ',0,0);
$pdf ->Cell (59,5,$invoice['StudentId'],0,1);

$pdf ->Cell (100,5,'',0,0);
$pdf ->Cell (25,5,'Programme',0,0);
$pdf ->Cell (5,5,' : ',0,0);
$pdf ->Cell (59,5,$invoice['CourseName'],0,1);

$pdf ->Cell (100,5,'',0,0);
$pdf ->Cell (25,5,'Intake',0,0);
$pdf ->Cell (5,5,' : ',0,0);
$pdf ->Cell (59,5,$invoice['IntakeDate'],0,1);

$pdf ->Cell (100,5,'',0,0);
$pdf ->Cell (25,5,'Semester',0,0);
$pdf ->Cell (5,5,' : ',0,0);
$pdf ->Cell (59,5,date("d-m-Y",strtotime($semesterCount['SemStartDate'])).'  -  '.date("d-m-Y",strtotime($semesterCount['SemEndDate'])),0,1);

$pdf ->Cell (189,5,'',0,1);


$pdf ->Cell (159,5,'Item Description',1,0);
$pdf ->Cell (30,5,'Amount (RM)',1,1,'R');

$query = mysqli_query($db,"SELECT * 
		FROM semester
		INNER JOIN subjects
		ON semester.SubId = subjects.SubId
		WHERE semester.StudentId ='".$invoice['StudentId']."' AND semester.SemNo=".$_GET['semNo']);


while ($items = mysqli_fetch_array($query))
{
	$pdf ->Cell (159,5,$items['SubCode'].' - '.$items['SubName'],1,0);
	$pdf ->Cell (30,5,$items['SubPrice'],1,1,'R');	
	$amount += $items['SubPrice'];
}

$pdf ->Cell (159,5,'Resource Fee',1,0);
$pdf ->Cell (30,5,'650',1,1,'R');
$amount += 650;

$pdf ->Cell (159,5,'Total Amount',1,0,'R');
$pdf ->Cell (30,5,$amount,1,1,'R');

$pdf ->Cell (189,15,'',0,1);

$pdf ->Cell(94.5,5,'Payment Due Date',1,0,'C');
$pdf ->Cell(94.5,5,'Payment Due Amount (RM)',1,1,'C');

$pdf ->Cell(94.5,5,date("d-m-Y",strtotime($semesterCount['PayEndDate'])),1,0,'C');
$pdf ->Cell(94.5,5,$amount,1,1,'C');

$pdf ->Cell (189,5,'',0,1);

$pdf ->SetFont('Arial','B',6);
$pdf ->Cell (189,3,'Payment of Fees',0,1);

$pdf ->SetFont('Arial','',6);
$pdf ->Cell (189,3,'Payment can be made via the following in favour of KDU University College(PG) Sdn. Bhd',0,1);
$pdf ->Cell (5,3,'1',0,0);
$pdf ->Cell (184,3,'Online banking / Bill payment (Maybank2u, CIMBClicks, RHBNow)',0,1);

$pdf ->Cell (5,3,'2',0,0);
$pdf ->Cell (184,3,'Cash / crossed cheque/ bankers cheque',0,1);

$pdf ->Cell (5,3,'3',0,0);
$pdf ->Cell (184,3,'Debit card/ Credit card (Visa/Master/Amex)',0,1);

$pdf ->Cell (5,3,'4',0,0);
$pdf ->Cell (184,3,'Local online/telegraphic transfer and cash deposit machine shall be made to the following accounts ONLY',0,1);

$pdf ->Cell (189,3,'',0,1);
$pdf->Cell (94.5,3,'Malaysian Students',1,0);
$pdf->Cell (94.5,3,'International Students',1,1);
$pdf->Cell (94.5,3,'Maybank (A/C No :507013013331/CIMB (A/C No:8601003506)',1,0);
$pdf->Cell (94.5,3,'Citibank(A/C No:0165148002',1,1);

$pdf ->Cell (189,3,'',0,1);

$pdf ->SetFont('Arial','B',6);
$pdf ->Cell (189,3,'Payments using credit card or online banking can be carried out using this app or can be performed at the counters in the bursary',0,1);
$pdf ->Cell (189,3,'',0,1);
$pdf ->Cell (189,3,'Please fax a copy of payment advice together with Student Number, Name and Contact Number to the Bursarys Office at (604)227-6368 ',0,1);
$pdf ->Cell (189,3,'or email payment @kdupg.edu.my for transcation which are carried out using the deposit machines ',0,1);

$pdf ->Cell (189,3,'',0,1);
$pdf ->Cell (189,3,'A late payment penalty of RM10 per day (including Saturdays,Sundays, and Public holidays) ',0,1);
$pdf ->Cell (189,3,'will be imposed on ALL outstanding fees after the payment due date stated in the invoice. ',0,1);

$pdf ->Cell (189,3,'',0,1);
$pdf ->Cell (189,3,'If fees remain unpaid,students will be barred from suing the KDU University College facilities, ',0,1);
$pdf ->Cell (189,3,'classes and examinations and may be terminated from their studies ',0,1);

$pdf ->Cell (189,3,'',0,1);
$pdf ->Cell (189,3,'Bursary operating hours 9am to 5.30pm (Mon-Fri,except Public Holidays) ',0,1);
if($_GET['phpType'] == "view")
{
	$pdf->Output("invoice.pdf","I");
}
else
{
	$pdf->Output("invoice.pdf","D");
}
?>
