
var rollImage_Next = new Image;
var defaultImage_Next = new Image;

var rollImage_Previous = new Image;
var defaultImage_Previous = new Image;

rollImage_Next.src = "/Myshop/images/raw/next2.png";
rollImage_Previous.src = "/Myshop/images/raw/previous2.png";

defaultImage_Next.src = "/Myshop/images/raw/next.png";
defaultImage_Previous.src = "/Myshop/images/raw/previous.png";

function calculateTotalPrice(salesForm){
	
	var costPrice = salesForm.price.value;
	var quantity = salesForm.quantity.value;
	salesForm.totalCostPrice.value = costPrice * quantity;
	
}


function calculateDiscount(salesForm){
	
	var totalCostPrice = salesForm.totalCostPrice.value;
	var sellingPrice = salesForm.sellingPrice.value;
	salesForm.discount.value = totalCostPrice - sellingPrice;
	
	if(salesForm.discount.value < 0){
		salesForm.discount.value = 0;
	}
	
}

function calculateBalance(salesForm){
	
	var totalCostPrice = salesForm.totalCostPrice.value;
	var firstPayment = salesForm.firstPayment.value;
	if(salesForm.lastPayment){
		var lastPayment = salesForm.lastPayment.value;
		salesForm.balance.value = totalCostPrice - firstPayment - lastPayment;
	}
	else {
		salesForm.balance.value = totalCostPrice - firstPayment;
	}
	if(salesForm.lastBalance){
		salesForm.lastBalance.value = totalCostPrice - firstPayment - lastPayment;
	}
	
	if(salesForm.lastBalance.value < 0){
		salesForm.lastBalance.value = 0;
	}
}

	

