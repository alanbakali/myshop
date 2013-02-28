<?php
require('fpdf.php');
class PDF extends FPDF
{
var $titleDate;
var $boxNumber;
var $town;
var $website;
var $phone;
var $subTitle;
var $reportName;
var $myMonth = "";
var $myYear;
var $stockID;
var $availability;
var $queryNumber;
var $message;


function PDF($orientation='P',$unit='pt',$format='A4')
{
	$this->titleDate = date("j F, Y");
    $this->title = 'Myshop';
	$this->subTitle = 'Computers and Electronics';
	$this->boxNumber = 'P.O. Box 280';
	$this->town = 'Zomba';
	$this->phone = 'Phone: 0888 733 190';
	$this->website = 'www.Myshop.com';
	$this->SetDrawColor(0,0,0);
	
	//$this->titleDate = date("j F, Y");
	//Call parent constructor
    $this->FPDF($orientation,$unit,$format);
    //Initialization
	$var=0;
}


function header()
{		
	
}

function header2()
{	
	//print Top Header
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->SetFont('Times','B','8');

	
	
	
	
}


function Footer()
{
	//Go to 1.5 cm from bottom
	$this->SetY(-15);
	//Select Arial italic 8
	$this->SetFont('Arial','',8);
	//Select black as text color
	$this->SetTextColor(0,0,0);
	//Print Current And Total page Numbers
	$this->Cell(0,13,' Myshop  '.date("Y"),0,0,'L');
	$this->Cell(0,13,'Page '.$this->PageNo().'/{nb}',0,0,'R');
	
}


function stockReport($result)
{
	$this->SetFillColor(255,255,255);
	$this->SetFont('Arial','B','14');
	$this->SetTextColor(0,0,0);
	$this->Cell(0,24,$this->reportName,'T L R ',1,'C',true);
	$this->SetFont('Arial','B','10');
	$this->Cell(120,20,$this->stockID,'T B L ',0,'L',true);
	$this->Cell(0,20,$this->titleDate,'T B R ',1,'R',true);
	$this->Cell(0,16,$this->availability,'L T B R',1,'C',true);
	
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(0,0,0);
	$this->Cell(280,13,'Item',1,0,'L');
	$this->Cell(45,13,'Quantity',1,0,'R');
	$this->Cell(60,13,'Price (K)',1,0,'R');
	$this->Cell(70,13,'Total Price (K)',1,0,'R');
	$this->Ln();
	
	$sumQuantity		=0;  // Total Debit
	$sumTotalCost		=0;  // Total Credit
	$sumGrandTotalCost	=0;  // Total Credit
	
	$rows = mysql_num_rows($result);
	$this->SetFont('Arial','',8);
	if($rows == 0){
		$this->Cell(280,13,'',1,0,'L');
		$this->Cell(45,13,'',1,0,'R');
		$this->Cell(60,13,'',1,0,'R');
		$this->Cell(70,13,'',1,0,'R');
		$this->Ln();
	}
	else{
		
		for($i = 0;$i < $rows; $i++){
			$stockItems			= mysql_fetch_array($result); // fetch the next row from the table extracted
			$stockID 			=htmlspecialchars(stripslashes($stockItems["stockID"]));
			$itemID 			=htmlspecialchars(stripslashes($stockItems["itemID"]));
			$serial 			=htmlspecialchars(stripslashes($stockItems["serial"]));
			$description 		 =htmlspecialchars(stripslashes($stockItems["description"]));
			$quantity 			=htmlspecialchars(stripslashes($stockItems["quantity"]));
			$price				=htmlspecialchars(stripslashes($stockItems["price"]));
			$user				=htmlspecialchars(stripslashes($stockItems["user"]));
			if(strlen($description) > 69){$description = substr($description, 0, 68)."...";}
			$sumQuantity += $quantity;
			$SumTotalCost += $price;
			$sumGrandTotalCost +=$price * $quantity;
			
			$totalCost 	=number_format($price * $quantity, 2, '.', ',');
			$price 		= number_format($price, 2, '.', ',');
			

			$this->Cell(280,13,$description ,1,0,'L');
			$this->Cell(45,13,$quantity ,1,0,'R');
			$this->Cell(60,13,$price,1,0,'R');
			$this->Cell(70,13,$totalCost,1,0,'R');
			$this->Ln();
		}
	}
	$sumGrandTotalCost	= number_format($sumGrandTotalCost, 2, '.', ',');
	$SumTotalCost		= number_format($SumTotalCost, 2, '.', ',');
	
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->SetFont('Times','B','10');
	
	$this->Cell(280,13,'Total' ,1,0,'R');
	$this->Cell(45,13,$sumQuantity ,1,0,'R');
	$this->Cell(60,13,$SumTotalCost,1,0,'R');
	$this->Cell(70,13,$sumGrandTotalCost,1,0,'R');
	$this->Ln();
}
function stockItems($result)
{
	
	
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(0,0,0);
	$this->Cell(280,13,'Item',1,0,'L');
	$this->Cell(45,13,'Quantity',1,0,'R');
	$this->Cell(60,13,'Price (K)',1,0,'R');
	$this->Cell(70,13,'Total Price (K)',1,0,'R');
	$this->Ln();
	
	$sumQuantity		=0;  // Total Debit
	$sumTotalCost		=0;  // Total Credit
	$sumGrandTotalCost	=0;  // Total Credit
	
	$rows = mysql_num_rows($result);
	$this->SetFont('Arial','',8);
	if($rows == 0){
		$this->Cell(280,13,'',1,0,'L');
		$this->Cell(45,13,'',1,0,'R');
		$this->Cell(60,13,'',1,0,'R');
		$this->Cell(70,13,'',1,0,'R');
		$this->Ln();
	}
	else{
		
		for($i = 1;$i <= $rows; $i++){
			$stockItems			= mysql_fetch_array($result); // fetch the next row from the table extracted
			$stockID 			=htmlspecialchars(stripslashes($stockItems["stockID"]));
			$itemID 			=htmlspecialchars(stripslashes($stockItems["itemID"]));
			$serial 			=htmlspecialchars(stripslashes($stockItems["serial"]));
			$description 		 =htmlspecialchars(stripslashes($stockItems["description"]));
			$quantity 			=htmlspecialchars(stripslashes($stockItems["quantity"]));
			$price				=htmlspecialchars(stripslashes($stockItems["price"]));
			$user				=htmlspecialchars(stripslashes($stockItems["user"]));
			if(strlen($description) > 69){$description = substr($description, 0, 68)."...";}
			$sumQuantity += $quantity;
			$SumTotalCost += $price;
			$sumGrandTotalCost +=$price * $quantity;
			
			$totalCost 	=number_format($price * $quantity, 2, '.', ',');
			$price 		= number_format($price, 2, '.', ',');
			

			$this->Cell(280,13,$description ,1,0,'L');
			$this->Cell(45,13,$quantity ,1,0,'R');
			$this->Cell(60,13,$price,1,0,'R');
			$this->Cell(70,13,$totalCost,1,0,'R');
			$this->Ln();
		}
	}
	$sumGrandTotalCost	= number_format($sumGrandTotalCost, 2, '.', ',');
	$SumTotalCost		= number_format($SumTotalCost, 2, '.', ',');
	
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->SetFont('Times','B','10');
	
	$this->Cell(280,13,'Total','T R ',0,'R',true);
	$this->Cell(45,13,$sumQuantity ,1,0,'R');
	$this->Cell(60,13,$SumTotalCost,1,0,'R');
	$this->Cell(70,13,$sumGrandTotalCost,1,0,'R');
	$this->Ln();
	$this->Ln();
}


function printReciept($result){
	$this->SetDrawColor(0,0,0); 
	
	$rows = mysql_num_rows($result);
	$this->SetFont('Arial','',8);

	$sumQuantity	 = 0;
	$sumPrice	 = 0;
	$sales[][] = array();
	
	for($i = 0; $i < $rows; $i++){
		$stockItems							= mysql_fetch_array($result); // fetch the next row from the table extracted
		$sales[$i][saleID] 					=htmlspecialchars(stripslashes($stockItems["saleID"]));
		$sales[$i][serial] 					=htmlspecialchars(stripslashes($stockItems["serial"]));
		$sales[$i][description] 				=htmlspecialchars(stripslashes($stockItems["description"]));
		$sales[$i][quantity] 				=htmlspecialchars(stripslashes($stockItems["quantity"]));
		$sales[$i][sellingPrice]				=htmlspecialchars(stripslashes($stockItems["sellingPrice"]));
		$sales[$i][title]					=htmlspecialchars(stripslashes($stockItems["title"]));
		$sales[$i][customerName]				=htmlspecialchars(stripslashes($stockItems["customerName"]));
		$sales[$i][recieptNumber]			=htmlspecialchars(stripslashes($stockItems["recieptNumber"]));
		if(strlen($sales[$i][description]) > 69){$sales[$i][description] = substr($sales[$i][description], 0, 68)."...";}
		$sales[$i][costPrice] = $sales[$i][sellingPrice]/$sales[$i][quantity];
		$sumPrice +=$sales[$i][sellingPrice];
		$sales[$i][costPrice] 	=  number_format( $sales[$i][costPrice], 2, '.', ',');
		$sales[$i][sellingPrice] =  number_format( $sales[$i][sellingPrice], 0, '.', ',');
		$sales[$i][tambala] =  "00";
		
	}
	
	$sumPrice = number_format($sumPrice, 0, '.', ',');
	
	$this->SetFillColor(255,255,255);
	$this->SetFont('Arial','','8');
	$this->SetTextColor(0,0,0);
	$this->Cell(50,8,'',' ',0,'L',true);
	$this->Cell(150,8,'CASH SALE No.  '.$sales[0][recieptNumber],' ',1,'L',true);
	$this->SetFont('Arial','B','17');
	$this->Cell(0,17,'Myshop Computers & Electronics',' ',1,'L',true);
	$this->SetFont('Arial','','7');
	$this->Cell(120,10,'P.O Box 1042,',' ',0,'L',true);
	$this->Cell(100,10,'TPIN 30812789',' ',0,'L',true);
	$this->Cell(0,10,'Cell: 0999 168 875',' ',1,'R',true);
	$this->Cell(0,10,'ZOMBA-Malawi.',' ',0,'L',true);
	$this->Cell(0,10,'Date: '.$this->titleDate,' ',1,'R',true);
	$this->Cell(0,10,'Website: http://Myshop.com',' ',1,'L',true);
	$this->SetFont('Arial','B','8');
	$this->Cell(70,13,'Customer Name:  ',' ',0,'L',true);
	$this->SetFont('Arial','','8');
	$this->Cell(0,10,$sales[0][title].' '.$sales[0][customerName],' ',1,'L',true);
	
	$this->SetLineWidth(1);
	$this->Cell(3,0,'',0,0,'C');
	$this->Cell(0,1,'','B',1,'C');
	$this->SetLineWidth(0.2);
	
	$this->SetFillColor(255,255,255);
	$this->SetFont('Arial','B','7');
	$this->Cell(4,13,'',0,0,'C');
	$this->Cell(20,13,'QTY','R',0,'C');
	$this->Cell(178,13,'DESCRIPTION' ,'R',0,'C');
	$this->Cell(37,13,'@','',0,'C');
	$this->SetLineWidth(0.5);
	$this->Cell(1,13,'',1,0,'C');
	$this->SetLineWidth(0.2);
	$this->Cell(30,13,'K','R',0,'C');
	$this->Cell(20,13,'t',0,1,'C');
	
	$this->SetLineWidth(1);
	$this->Cell(3,0,'',0,0,'C');
	$this->Cell(0,1,'','B',1,'C');
	$this->SetLineWidth(0.2);
	
	for($i = 0; $i < 5; $i++){
		$this->SetFont('Arial','','7');
		$this->Cell(4,13,'',0,0,'C');
		$this->Cell(20,13,$sales[$i][quantity],'R B',0,'L');
		$this->Cell(178,13,$sales[$i][description],'R B',0,'C');
		$this->Cell(37,13,$sales[$i][costPrice],'B',0,'C');
		$this->SetLineWidth(0.5);
		$this->Cell(1,13,'',1,0,'C');
		$this->SetLineWidth(0.2);
		$this->Cell(30,13,$sales[$i][sellingPrice],'R B',0,'C');
		$this->Cell(20,13,$sales[$i][tambala],'B',1,'C');
	}
	
	$this->Cell(4,13,'',0,0,'C');
	$this->Cell(20,13,$sales[5][quantity],'R',0,'L');
	$this->Cell(178,13,$sales[5][description],'R',0,'C');
	$this->Cell(37,13,$sales[5][costPrice],'',0,'C');
	$this->SetLineWidth(0.5);
	$this->Cell(1,13,'',1,0,'C');
	$this->SetLineWidth(0.2);
	$this->Cell(30,13,$sales[5][sellingPrice],'R',0,'C');
	$this->Cell(20,13,$sales[5][tambala],'',1,'C');
	$this->SetLineWidth(1);
	$this->Cell(5,0,'',0,0,'C');
	$this->Cell(0,1,'','B',1,'C');
	$this->SetLineWidth(0.2);
	
	$this->SetFont('Arial','B','8');
	$this->Cell(239,13,'Grand Total','',0,'R');
	$this->Cell(1,13,'',1,0,'C');
	$this->Cell(30,13,$sumPrice,'R',0,'C');
	$this->Cell(20,13,'00','',1,'C');
	
	$this->SetFillColor(0,0,0);
	$this->Cell(239,0,'',0,0,'C');
	$this->Cell(0,1,'','1',1,'C');
	$this->SetFillColor(255,255,255);
	
	$this->SetFont('Arial','I','7');
	$this->Cell(239,13,'Goods once purchased are not returnable','',0,'L');
	$this->Cell(60,13,' Thank You','',1,'C');
}
function sales($result)
{
	if($this->reportName == "Sales Report"){
		$this->SetFillColor(255,255,255);
		$this->SetFont('Arial','B','10');
		$this->SetTextColor(0,0,0);
		$this->Cell(251,20,$this->reportName,'T B ',0,'L',true);
		$this->Cell(0,20,$this->myMonth." ".$this->myYear,'T B ',1,'R',true);
	}
	else{
	
	}
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(0,0,0);
	$this->Cell(280,13,'Item',1,0,'L');
	$this->Cell(40,13,'Quantity',1,0,'R');
	$this->Cell(75,13,'Selling Price (K)',1,0,'R');
	$this->Cell(60,13,'Discount (K)',1,0,'R');
	$this->Ln();
	
	
	$rows = mysql_num_rows($result);
	$this->SetFont('Arial','',8);

	$sumQuantity	 = 0;
	$sumPrice	 = 0;
	if($rows == 0){
		$this->Cell(280,13,'',1,0,'L');
		$this->Cell(40,13,'',1,0,'R');
		$this->Cell(75,13,'',1,0,'R');
		$this->Cell(60,13,'',1,0,'R');
		$this->Ln();
	}
	else{
		for($i = 1;$i <= $rows; $i++){
			$stockItems			= mysql_fetch_array($result); // fetch the next row from the table extracted
			$saleID 			=htmlspecialchars(stripslashes($stockItems["saleID"]));
			$itemID 			=htmlspecialchars(stripslashes($stockItems["itemID"]));
			$serial 			=htmlspecialchars(stripslashes($stockItems["serial"]));
			$description 		=htmlspecialchars(stripslashes($stockItems["description"]));
			$quantity 			=htmlspecialchars(stripslashes($stockItems["quantity"]));
			$sellingPrice		=htmlspecialchars(stripslashes($stockItems["sellingPrice"]));
			$discount			=htmlspecialchars(stripslashes($stockItems["discount"]));
			if(strlen($description) > 69){$description = substr($description, 0, 68)."...";}
			$sumQuantity += $quantity;
			$sumPrice +=$sellingPrice;
			$sumDiscount +=$discount;
			$sellingPrice =  number_format($sellingPrice, 2, '.', ',');
			$discount     = number_format($discount, 2, '.', ',');
			$this->Cell(280,13,$description ,1,0,'L');
			$this->Cell(40,13,$quantity ,1,0,'R');
			$this->Cell(75,13,$sellingPrice,1,0,'R');
			$this->Cell(60,13,$discount,1,0,'R');
			$this->Ln();
		}
	}
	$sumPrice = number_format($sumPrice, 2, '.', ',');
	$sumDiscount = number_format($sumDiscount, 2, '.', ',');
	
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->SetFont('Times','B','10');

	$this->Cell(280,13,'Total','T R ',0,'R',true);
	$this->Cell(40,13,$sumQuantity,1,0,'R');
	$this->Cell(75,13,$sumPrice,1,0,'R');
	$this->Cell(60,13,$sumDiscount,1,0,'R');
	$this->Ln();
	$this->Ln();

	
}

function installments($result)
{
	if($this->reportName == "Installments Report"){
		$this->SetFillColor(255,255,255);
		$this->SetFont('Arial','B','10');
		$this->SetTextColor(0,0,0);
		$this->Cell(251,20,$this->reportName,'T B ',0,'L',true);
		$this->Cell(0,20,$this->myMonth." ".$this->myYear,'T B ',1,'R',true);
	}
	else{
	
	}
	
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(0,0,0);
	$this->Cell(280,13,'Item',1,0,'L');
	$this->Cell(40,13,'Quantity',1,0,'R');
	$this->Cell(75,13,'Total Cost (K)',1,0,'R');
	$this->Cell(60,13,'Balance (K)',1,0,'R');
	$this->Ln();
		
	$rows = mysql_num_rows($result);
	$this->SetFont('Arial','',8);
	$sumQuantity		 = 0;
	$sumTotalCost		 = 0;
	$SumBalance		 = 0;
	if($rows == 0){
		$this->Cell(280,13,'',1,0,'L');
		$this->Cell(40,13,'',1,0,'R');
		$this->Cell(75,13,'',1,0,'R');
		$this->Cell(60,13,'',1,0,'R');
		$this->Ln();
	}
	else{
		for($i = 1;$i <= $rows; $i++){
			$stockItems			= mysql_fetch_array($result); // fetch the next row from the table extracted
			$installmentID 		=htmlspecialchars(stripslashes($stockItems["installmentID"]));
			$itemID 			=htmlspecialchars(stripslashes($stockItems["itemID"]));
			$customerName 		=htmlspecialchars(stripslashes($stockItems["customerName"]));
			$title 				=htmlspecialchars(stripslashes($stockItems["title"]));
			$description 		=htmlspecialchars(stripslashes($stockItems["description"]));
			$quantity 			=htmlspecialchars(stripslashes($stockItems["quantity"]));
			$totalCostPrice 	=htmlspecialchars(stripslashes($stockItems["totalCostPrice"]));
			$firstPayment		=htmlspecialchars(stripslashes($stockItems["firstPayment"]));
			$lastPayment		=htmlspecialchars(stripslashes($stockItems["lastPayment"]));
			$balance 		=htmlspecialchars(stripslashes($stockItems["balance"]));
			
			if(strlen($description) > 69){$description = substr($description, 0, 68)."...";}
			$sumQuantity 		 += $quantity;
			$sumTotalCost	 	 += $totalCostPrice;
			$sumBalance		 += $balance;

			$totalCostPrice =  number_format($totalCostPrice, 2, '.', ',');
			$balance	= number_format($balance, 2, '.', ',');

			$this->Cell(280,13,$description ,1,0,'L');
			$this->Cell(40,13,$quantity ,1,0,'R');
			$this->Cell(75,13,$totalCostPrice,1,0,'R');
			$this->Cell(60,13,$balance,1,0,'R');
			$this->Ln();
		}
	}
	$sumTotalCost = number_format($sumTotalCost, 2, '.', ',');
	$sumBalance = number_format($sumBalance, 2, '.', ',');
	
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->SetFont('Times','B','10');
	
	$this->Cell(280,13,'Total','T R ',0,'R',true);
	$this->Cell(40,13,$sumQuantity ,1,0,'R');
	$this->Cell(75,13,$sumTotalCost,1,0,'R');
	$this->Cell(60,13,$sumBalance,1,0,'R');
	$this->Ln();
	$this->Ln();
}

function downPayments($result)
{
	$this->SetFillColor(255,255,255);
	$this->SetFont('Arial','B','10');
	$this->SetTextColor(0,0,0);
	$this->Cell(251,20,$this->reportName,'T B ',0,'L',true);
	$this->Cell(0,20,$this->myMonth.$this->myYear,'T B ',1,'R',true);
	
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(0,0,0);
	$this->Cell(280,13,'Item',1,0,'L');
	$this->Cell(40,13,'Quantity',1,0,'R');
	$this->Cell(75,13,'Total Cost (K)',1,0,'R');
	$this->Cell(60,13,'Balance (K)',1,0,'R');
	$this->Ln();
		
	$rows = mysql_num_rows($result);
	$this->SetFont('Arial','',8);
	$sumQuantity		 = 0;
	$sumTotalCost		 = 0;
	$SumBalance		 = 0;
	if($rows == 0){
		$this->Cell(280,13,'',1,0,'L');
		$this->Cell(40,13,'',1,0,'R');
		$this->Cell(75,13,'',1,0,'R');
		$this->Cell(60,13,'',1,0,'R');
		$this->Ln();
	}
	else{
		for($i = 1;$i <= $rows; $i++){
			$stockItems			= mysql_fetch_array($result); // fetch the next row from the table extracted
			$downPaymentID 		=htmlspecialchars(stripslashes($stockItems["installmentID"]));
			$customerName 		=htmlspecialchars(stripslashes($stockItems["customerName"]));
			$title 				=htmlspecialchars(stripslashes($stockItems["title"]));
			$description 		=htmlspecialchars(stripslashes($stockItems["description"]));
			$quantity 			=htmlspecialchars(stripslashes($stockItems["quantity"]));
			$totalCostPrice 	=htmlspecialchars(stripslashes($stockItems["totalCostPrice"]));
			$firstPayment		=htmlspecialchars(stripslashes($stockItems["firstPayment"]));
			$lastPayment		=htmlspecialchars(stripslashes($stockItems["lastPayment"]));
			$balance 		=htmlspecialchars(stripslashes($stockItems["balance"]));
			
			if(strlen($description) > 69){$description = substr($description, 0, 68)."...";}
			$sumQuantity 		 += $quantity;
			$sumTotalCost	 	 += $totalCostPrice;
			$sumBalance		 += $balance;

			$totalCostPrice =  number_format($firstPayment, 2, '.', ',');
			$balance	= number_format($balance, 2, '.', ',');

			$this->Cell(280,13,$description ,1,0,'L');
			$this->Cell(40,13,$quantity ,1,0,'R');
			$this->Cell(75,13,$totalCostPrice,1,0,'R');
			$this->Cell(60,13,$balance,1,0,'R');
			$this->Ln();
		}
	}
	$sumTotalCost = number_format($sumTotalCost, 2, '.', ',');
	$sumBalance = number_format($sumBalance, 2, '.', ',');
	
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->SetFont('Times','B','10');
	
	$this->Cell(280,13,'Total','T R ',0,'R',true);
	$this->Cell(40,13,$sumQuantity ,1,0,'R');
	$this->Cell(75,13,$sumTotalCost,1,0,'R');
	$this->Cell(60,13,$sumBalance,1,0,'R');
	$this->Ln();
	$this->Ln();
}

function expenses($result)
{
	$this->SetFillColor(255,255,255);
	$this->SetFont('Arial','B','10');
	$this->SetTextColor(0,0,0);
	$this->Cell(251,20,$this->reportName,'T B ',0,'L',true);
	$this->Cell(0,20,$this->myMonth.$this->myYear,'T B ',1,'R',true);
	
	$this->SetFont('Arial','B',9);
	$this->SetTextColor(0,0,0);
	$this->Cell(115,13,'Expense',1,0,'L');
	$this->Cell(280,13,'Comment',1,0,'L');
	$this->Cell(60,13,'Amount (K)',1,0,'R');
	$this->Ln();
		
	$rows = mysql_num_rows($result);
	$this->SetFont('Arial','',8);
	$sumQuantity		 = 0;
	$sumTotalCost		 = 0;
	$SumBalance		 = 0;
	if($rows == 0){
		$this->Cell(115,13,'',1,0,'L');
		$this->Cell(280,13,'',1,0,'R');
		$this->Cell(60,13,'',1,0,'R');
		$this->Ln();
	}
	else{
		for($i = 1;$i <= $rows; $i++){
			$stockItems			= mysql_fetch_array($result); // fetch the next row from the table extracted
			$expenseName 		=htmlspecialchars(stripslashes($stockItems["expenseName"]));
			$comment 		=htmlspecialchars(stripslashes($stockItems["comment"]));
			$amount 				=htmlspecialchars(stripslashes($stockItems["amount"]));
			
			
			if(strlen($description) > 69){$description = substr($description, 0, 68)."...";}
			$sumAmount 		 += $amount;
			
			$amount =  number_format($amount, 2, '.', ',');

			$this->Cell(115,13,$expenseName ,1,0,'L');
			$this->Cell(280,13,$comment ,1,0,'L');
			$this->Cell(60,13,$amount,1,0,'R');
			$this->Ln();
		}
	}
	$sumAmount = number_format($sumAmount, 2, '.', ',');

	
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->SetFont('Times','B','10');
	
	
	$this->Cell(115,13,'',0,0,'L');
	$this->Cell(280,13,'Total','T R ',0,'R',true);
	$this->Cell(60,13,$sumAmount,1,0,'R');
	$this->Ln();
	$this->Ln();
}


function criticalError(){
	//$this->Image('warning_icon.png');
	$this->SetTextColor(255,0,0);
	$this->SetFont('Arial','',8);
	$this->Cell(0,40,$this->message,'R L B T',1,'C');
}

function queryDb($query){

	@ $link = mysql_connect("localhost","root","");
	if (!$link){
		$this->message = "Database Error: Could not connect to central database. Please contact our System Developer";
	return false;
		}
	@ $link2 = mysql_select_db("Myshop");
	if(!$link2){
		$this->message ="Database Error: Could not select the database. Please contact our System Developer.";
		return false;
	}
	// Performing SQL query
	@ $result = mysql_query($query);
	if(!$result){
		$this->message = "Database Error: Query failed. Please contact our System Developer.";
		return false;
		}
		mysql_close($link);
	return $result;
}

function setMonth($month){
	
	if(($month == "01") || ($month == "1")){$this->myMonth = "January";} 
	if(($month == "02") || ($month == "2")){$this->myMonth = "February";} 
	if(($month == "03") || ($month == "3")){$this->myMonth = "March";} 
	if(($month == "04") || ($month == "4")){$this->myMonth = "April";} 
	if(($month == "05") || ($month == "5")){$this->myMonth = "May";} 
	if(($month == "06") || ($month == "6")){$this->myMonth = "June";} 
	if(($month == "07") || ($month == "7")){$this->myMonth = "July";} 
	if(($month == "08") || ($month == "8")){$this->myMonth = "August";} 
	if(($month == "09") || ($month == "9")){$this->myMonth = "September";} 
	if($month == "10"){$this->myMonth = "October";} 
	if($month == "11"){$this->myMonth = "November";} 
	if($month == "12"){$this->myMonth = "December";} 
}

function setYear($year){
	if($year)
	{	$this->myYear = " ".$year; }
	else
	{$this->myYear = ""; }
}
 function getStockIDs(){
	 $query = "SELECT stockID FROM stock ORDER BY stockID DESC";
	 $result=$this->queryDb($query);
	 if($result==false) $this->criticalError();
	 else{
	 	$stockIDArray = array();
		$rows = mysql_num_rows($result);
	 	for($i = 0; $i < $rows; $i++){
		$stockIDs	= mysql_fetch_array($result); // fetch the next row from the table extracted
	 	$stockIDArray[$i]	= htmlspecialchars(stripslashes($stockIDs["stockID"]));
		}
	}
	return $stockIDArray;
}	 	
 	
}
?>