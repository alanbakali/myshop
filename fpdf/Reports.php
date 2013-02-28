<?php
require('fpdfExtend.php');

$pdf=new PDF();

$pdf->AliasNbPages();
$pdf->SetTextColor(102,102,51); 
$pdf->SetFillColor(255,255,255);
/*-----SET MARGINS-------------------------------------------------*/
$pdf->SetDrawColor(153,153,153); 
$pdf->SetTopMargin(50);
$pdf->SetLeftMargin(70.14); 
$pdf->SetRightMargin(70.14);
/*----SET QUERY AND HEADER INFOR-----------------------------------------------------*/
$name = "Myshop";

if(isset($_GET['frmName']) && $_GET['frmName'] !=""){	
	$saleID 		= rawurldecode($_GET['saleID']);
	$frmName 		= rawurldecode($_GET['frmName']);
}

else{ $frmName = $_POST["frmName"];}
//$pdf->SetTitle($title.'_'.$titleDate);
$pdf->SetAuthor('Alan Bakali');
$pdf->AddPage();

if($frmName != 'printReciept'){
	$pdf->header2();
}
/*
This function creates the query for building stock report
*/
if($frmName=="stockReport" ||  $frmName=="viewStockItems"){
	$stockID 		= $_POST["stockID"];
	$availability	= $_POST["availability"];
	
	if($frmName=="viewStockItems"){ $availability ="Available";}
	$pdf->reportName 		= "Stock Report";
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B','14');
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(0,25,$pdf->reportName,'T B ',1,'C',true);
	
	if($stockID ==""){
		$stockIDs = array_values($pdf->getStockIDs());
		for($i = 0; $i < count($stockIDs); $i++){
			$pdf->SetFont('Arial','B','10');
			$pdf->SetFillColor(200,200,200);
			$pdf->Cell(120,20,"Stock ID: ".$stockIDs[$i],'T B L ',0,'L',true);
			$pdf->Cell(0,20,$pdf->titleDate,'T B R ',1,'R',true);
			$pdf->SetFillColor(255,255,255);
			if($availability =="Available"){
				$query = "SELECT * FROM stockitems WHERE quantity > 0 AND stockID = $stockIDs[$i] ORDER BY price DESC, stockID, itemID DESC";
				$pdf->Cell(0,16,'Available Items','L T B R',1,'C',true);
				$result=$pdf->queryDb($query);
				if($result==false) $pdf->criticalError();
				else $pdf->stockItems($result);
				$pdf->Ln();
			 }
			 if($availability =="Sold Items"){
				$query = "SELECT sa.itemID, SUM(sa.sellingPrice) AS sellingPrice, SUM(sa.quantity) AS quantity, SUM(sa.discount) AS discount,";
				$query .="sa.description from sales sa LEFT JOIN stockitems USING(itemID)";
				$query .="WHERE stockitems.stockID = '$stockIDs[$i]' GROUP BY sa.itemID";
				$pdf->Cell(0,16,'Sold Items','L T B R',1,'C',true);
				$result=$pdf->queryDb($query);
				if($result==false) $pdf->criticalError();
				else $pdf->sales($result);
				$pdf->Ln();
			 }
			 if($availability =="Installment"){
				$query = "SELECT ins.itemID, SUM(ins.totalCostPrice) AS totalCostPrice, SUM(ins.quantity) AS quantity, SUM(ins.balance) AS balance,";
				$query .="ins.description from installments ins LEFT JOIN stockitems USING(itemID)";
				$query .="WHERE stockitems.stockID = '$stockIDs[$i]' GROUP BY ins.itemID";
				$pdf->Cell(0,16,'Installment Items','L T B R',1,'C',true);
				$result=$pdf->queryDb($query);
				if($result==false) $pdf->criticalError();
				else $pdf->installments($result);
				$pdf->Ln();
			 }
		    if($availability ==""){
				$query = "SELECT * FROM stockitems WHERE quantity > 0 AND stockID = $stockIDs[$i] ORDER BY price DESC, stockID, itemID DESC";
				$pdf->Cell(0,16,"Available Items",'L T B R',1,'C',true);
				$result=$pdf->queryDb($query);
				if($result==false) $pdf->criticalError();
				else $pdf->stockItems($result);
				$pdf->Ln();
				
				
				$query = "SELECT sa.itemID, SUM(sa.sellingPrice) AS sellingPrice, SUM(sa.quantity) AS quantity, SUM(sa.discount) AS discount,";
				$query .="sa.description from sales sa LEFT JOIN stockitems USING(itemID)";
				$query .="WHERE stockitems.stockID = '$stockIDs[$i]' GROUP BY sa.itemID";
				$pdf->Cell(0,16,"Sold Items",'L T B R',1,'C',true);
				$result=$pdf->queryDb($query);
				if($result==false) $pdf->criticalError();
				else $pdf->sales($result);
				$pdf->Ln();
				
				$query = "SELECT ins.itemID, SUM(ins.totalCostPrice) AS totalCostPrice, SUM(ins.quantity) AS quantity, SUM(ins.balance) AS balance,";
				$query .="ins.description from installments ins LEFT JOIN stockitems USING(itemID)";
				$query .="WHERE stockitems.stockID = '$stockIDs[$i]' GROUP BY ins.itemID";
				$pdf->Cell(0,16,"Installment Items",'L T B R',1,'C',true);
				$result=$pdf->queryDb($query);
				if($result==false) $pdf->criticalError();
				else $pdf->installments($result);
				$pdf->Ln();
	 		}
		}
	}
	else{
		$pdf->SetFont('Arial','B','10');
		$pdf->SetFillColor(200,200,200);
		$pdf->Cell(120,20,"Stock ID: ".$stockID,'T B L ',0,'L',true);
		$pdf->Cell(0,20,$pdf->titleDate,'T B R ',1,'R',true);
		$pdf->SetFillColor(255,255,255);
		if($availability =="Available"){
			$query = "SELECT * FROM stockitems WHERE quantity > 0 AND stockID = $stockID ORDER BY price DESC, stockID, itemID DESC";
			$pdf->Cell(0,16,"Available Items",'L T B R',1,'C',true);
			$result=$pdf->queryDb($query);
			if($result==false) $pdf->criticalError();
			else $pdf->stockItems($result);
			$pdf->Ln();
		}
	 
	    if($availability =="Sold Items"){
			$query = "SELECT sa.itemID, SUM(sa.sellingPrice) AS sellingPrice, SUM(sa.quantity) AS quantity, SUM(sa.discount) AS discount,";
			$query .="sa.description from sales sa LEFT JOIN stockitems USING(itemID)";
			$query .="WHERE stockitems.stockID = '$stockID' GROUP BY sa.itemID";
			$pdf->Cell(0,16,"Sold Items",'L T B R',1,'C',true);
			$result=$pdf->queryDb($query);
			if($result==false) $pdf->criticalError();
			else $pdf->sales($result);
			$pdf->Ln();
	
	 	}
	   if($availability =="Installment"){
			$query = "SELECT ins.itemID, SUM(ins.totalCostPrice) AS totalCostPrice, SUM(ins.quantity) AS quantity, SUM(ins.balance) AS balance,";
			$query .="ins.description from installments ins LEFT JOIN stockitems USING(itemID)";
			$query .="WHERE stockitems.stockID = '$stockID' GROUP BY ins.itemID";
			$pdf->Cell(0,16,"Installment Items",'L T B R',1,'C',true);
			$result=$pdf->queryDb($query);
			if($result==false) $pdf->criticalError();
			else $pdf->installments($result);
			$pdf->Ln();
	  }
	 
	if($availability ==""){
		$query = "SELECT * FROM stockitems WHERE quantity > 0 AND stockID = $stockID ORDER BY price DESC, stockID, itemID DESC";
		$pdf->Cell(0,16,"Available Items",'L T B R',1,'C',true);
		$result=$pdf->queryDb($query);
		if($result==false) $pdf->criticalError();
		else $pdf->stockItems($result);
		$pdf->Ln();
		
		$query = "SELECT sa.itemID, SUM(sa.sellingPrice) AS sellingPrice, SUM(sa.quantity) AS quantity, SUM(sa.discount) AS discount,";
		$query .="sa.description from sales sa LEFT JOIN stockitems USING(itemID)";
		$query .="WHERE stockitems.stockID = '$stockID' GROUP BY sa.itemID";
		$pdf->Cell(0,16,"Sold Items",'L T B R',1,'C',true);
		$result=$pdf->queryDb($query);
		if($result==false) $pdf->criticalError();
		else $pdf->sales($result);
		$pdf->Ln();
		
		$query = "SELECT ins.itemID, SUM(ins.totalCostPrice) AS totalCostPrice, SUM(ins.quantity) AS quantity, SUM(ins.balance) AS balance,";
		$query .="ins.description from installments ins LEFT JOIN stockitems USING(itemID)";
		$query .="WHERE stockitems.stockID = '$stockID' GROUP BY ins.itemID";
		$pdf->Cell(0,16,"Installment Items",'L T B R',1,'C',true);
		$result=$pdf->queryDb($query);
		if($result==false) $pdf->criticalError();
		else $pdf->installments($result);
		$pdf->Ln();

	}
	
}
}
if($frmName=="viewSales"){
	$year 		= $_POST["year"];
	$month 		= $_POST["month"];
	
	$pdf->setMonth("________");
	$pdf->setYear("_______");
	
	$yearAndTime =="";
	
	if(($year !="") && ($month =="")){
		$yearAndTime = ' AND year(date)='.$year;
		$pdf->setYear($year);
	}
	if(($year =="") && ($month !="")){
		$yearAndTime = ' AND month(date)='.$month;
		$pdf->setMonth($month);
	}
	if(($year !="") && ($month !="")){
		$yearAndTime = ' AND (month(date)='.$month.'';
		$yearAndTime .= ' AND year(date)='.$year.')';
		$pdf->setMonth($month);
		$pdf->setYear($year);
	}

	
	
	$returned ="No";
	$query = 'SELECT * FROM sales WHERE returned="'.$returned.'"'.$yearAndTime.' ORDER BY saleID DESC';
	
	
	$pdf->titleDate = date("j F, Y");
	$pdf->reportName = "Sales Report";
	
	$result=$pdf->queryDb($query);
	if($result==false) $pdf->criticalError();
	else $pdf->sales($result);
	
}

if($frmName=="printReciept"){
	$pdf->SetLeftMargin(153.14);
	$pdf->SetRightMargin(153.14);
	
	$query = "SELECT * FROM sales WHERE saleID ='".$saleID."'";
	
	
	$result=$pdf->queryDb($query);
	if($result==false) $pdf->criticalError();
	else $pdf->printReciept($result);
	
}
if($frmName=="viewInstallments"){
	$year 		= $_POST["year"];
	$month 		= $_POST["month"];
	
	if(($year !="") && ($month =="")){
		$yearAndTime = ' AND year(date)='.$year;
	}
	else{
		if(($year =="") && ($month !="")){
		$yearAndTime = ' AND month(date)='.$month;
		}
		else{
			if(($year !="") && ($month !="")){
			$yearAndTime = ' AND (month(date)='.$month.'';
			$yearAndTime .= ' AND year(date)='.$year.')';
			}
			else {$yearAndTime =="";}
		}
	}
	$pdf->setMonth($month);
	$pdf->setYear($year);
	
	$returned ="No";
	$query = 'SELECT * FROM installments WHERE returned="'.$returned.'"'.$yearAndTime.' ORDER BY installmentID DESC';
	
	
	$pdf->titleDate = date("j F, Y");
	$pdf->reportName = "Installments Report";
	
	$result=$pdf->queryDb($query);
	if($result==false) $pdf->criticalError();
	else $pdf->installments($result);
	
}
if($frmName=="viewDownPayments"){
	$year 		= $_POST["year"];
	$month 		= $_POST["month"];
	
	if(($year !="") && ($month =="")){
		$yearAndTime = ' AND year(date)='.$year;
	}
	else{
		if(($year =="") && ($month !="")){
		$yearAndTime = ' AND month(date)='.$month;
		}
		else{
			if(($year !="") && ($month !="")){
			$yearAndTime = ' AND (month(date)='.$month.'';
			$yearAndTime .= ' AND year(date)='.$year.')';
			}
			else {$yearAndTime =="";}
		}
	}
	$pdf->setMonth($month);
	$pdf->setYear($year);
	
	$returned ="No";
	$query = 'SELECT * FROM downpayments WHERE returned="'.$returned.'"'.$yearAndTime.' ORDER BY downPaymentID DESC';
	
	
	$pdf->titleDate = date("j F, Y");
	$pdf->reportName = "DownPayments Report";
	
	$result=$pdf->queryDb($query);
	if($result==false) $pdf->criticalError();
	else $pdf->downPayments($result);
	
}


if($frmName=="viewExpenses"){
	$year 		= $_POST["year"];
	$month 		= $_POST["month"];
	
	if(($year !="") && ($month =="")){
		$yearAndTime = ' AND year='.$year;
	}
	else{
		if(($year =="") && ($month !="")){
		$yearAndTime = ' AND month='.$month;
		}
		else{
			if(($year !="") && ($month !="")){
			$yearAndTime = ' AND (month='.$month.'';
			$yearAndTime .= ' AND year='.$year.')';
			}
			else {$yearAndTime =="";}
		}
	}
	$pdf->setMonth($month);
	$pdf->setYear($year);
	
	$amount =0;
	$query = 'SELECT * FROM expenses WHERE amount > "'.$amount.'"'.$yearAndTime.' ORDER BY expenseID DESC';
	
	
	$pdf->titleDate = date("j F, Y");
	$pdf->reportName = "Expenses Report";
	
	$result=$pdf->queryDb($query);
	if($result==false) $pdf->criticalError();
	else $pdf->expenses($result);
	
}

$pdf->Output();
?>