(function () {
	
var ui = window.ui = (window.ui || {});
var cart = ui.cart = (ui.cart || {});
var Storage = window.localStorage = (window.localStorage || {});
var myLib = window.myLib = (window.myLib || {});

function updateHTML(){
	var list = Storage.getItem('pidlist');
	if (list){
		list = list && JSON.parse(list);
	
		myLib.post2({action:'prod_list_fetch', list_of_pid:JSON.stringify(list)},function(json){
	for(var i =0, prodItems = [], prod, total=0; prod = json[i]; i++){
	//alert(Storage.getItem('item'+parseInt(prod.pid)));
	if(Storage.getItem('item'+parseInt(prod.pid))!=0)
	{
		prodItems.push('<li>');
		prodItems.push('<input type="hidden" name="item_number_',i+1,'" value="'+prod.pid+'">'+prod.name.escapeHTML());
		prodItems.push('<input type="hidden" name="item_name_',i+1,'" value="'+prod.name.escapeHTML()+'">');
			//prodItems.push('<input type="number" id="quantity_',i+1,'" onblur="cart.setQty(',parseInt(prod.pid),',this.value)" value="',encodeURIComponent(Storage.getItem('item'+parseInt(prod.pid))),'" maxlength="2" max="99" min="0" size="2">');
		prodItems.push('<input type="number" class="qty" id="quantity_',i+1,'" name="quantity_',i+1,'" onchange="ui.cart.setQty(',parseInt(prod.pid),',this.value)" value="',encodeURIComponent(Storage.getItem('item'+parseInt(prod.pid))),'" maxlength="2" max="99" min="0" size="2">');
		prodItems.push('<input type="hidden" name="amount_',i+1,'" value="'+parseFloat(prod.price)+'">');
		prodItems.push('<span> $',parseFloat(prod.price),'</span>');
		prodItems.push('</li>');
		total+=parseInt(Storage.getItem('item'+prod.pid))*parseFloat(prod.price);
	}
	}

	document.getElementById("shopping-list").innerHTML = prodItems.join("");
	//document.getElementById("Total").innerHTML = "<p>"+"hello";
	e = document.getElementById("Total");
	e.innerHTML=total;
	//alert(e);
});
	}
}

updateHTML();

cart.add = function(pid){
	myLib.post2({action:'prod_fetch', pid:pid}, function(json){
				
				var list = Storage.getItem('pidlist');
				if (list){
					list = list && JSON.parse(list);
					var exist=false;
					for (var i=0;i<list.length;i++){
						if (pid==list[i]){exist=true;break;}
					}
					if (!exist){
						list.push(pid);
						Storage.setItem('item'+pid, 1);
					}else{
						var qty = Storage.getItem('item'+pid);
						var new_qty=parseInt(qty)+1;
						Storage.setItem('item'+pid, new_qty);
						if(new_qty>0){
                                        //              Storage.removeItem('item'+pid);
                                                        document.getElementById("remove_"+pid).disabled=false;
                                                }
					}
				}
				else{
						list=[pid];
						Storage.setItem('item'+pid, 1);
					}
				
				Storage.setItem('pidlist', JSON.stringify(list));
				updateHTML();
			});
}

cart.setQty=function(pid,qty){
	var regex=/^\d*$/; // input validation of quantoty
	if (regex.test(qty)&&(parseInt(qty)>-1||parseInt(qty)<100)){
		if (parseInt(qty)==0){
				Storage.removeItem('item'+pid);
				var list = Storage.getItem('pidlist');
				list = list && JSON.parse(list);
				for(var i in list){
					if (parseInt(list[i])==parseInt(pid)){
						list.splice(i,1);
						Storage.setItem('pidlist', JSON.stringify(list));
						break;
					}
				}
			}else Storage.setItem('item'+pid, qty);
			updateHTML();
	}else { //clear the quantity if user input non-integer
		Storage.removeItem('item'+pid);
		var list = Storage.getItem('pidlist');
		list = list && JSON.parse(list);
		for(var i in list){
			if (parseInt(list[i])==parseInt(pid)){
				list.splice(i,1);
				Storage.setItem('pidlist', JSON.stringify(list));
				break;
			}
		}
		updateHTML();
	};
}

cart.submit=function(form){
	var buyList={};
	var list = Storage.getItem('pidlist');
	list = list && JSON.parse(list);
	for(var i in list){
		buyList[[list[i]]]=parseInt(Storage.getItem('item'+list[i])); //combine the pid and quantity into array
	}
	updateHTML();
	myLib.processJSON(
		    "checkout-process.php",                                     
		    {action: "handle_checkout", list:JSON.stringify(buyList)},   //the product's list
		    function(returnValue){   //respond digest and invoice values; Fill into the forms;Submit to Paypal
				form.custom.value=returnValue.digest;
				form.invoice.value=returnValue.invoice;
				form.submit();
				for (var i in list)                    //remove local storage
					Storage.removeItem('item'+list[i]);
				Storage.removeItem('pidlist'); //remove the local storage
			},
		    {method:"POST"});                                            //para 4
	updateHTML();
	return false;
} 



cart.del=function(pid){
	myLib.post2({action:'prod_fetch', pid:pid}, function(json){
				
				var list = Storage.getItem('pidlist');
				if (list){
					list = list && JSON.parse(list);
					var exist=false;
					for (var i=0;i<list.length;i++){
						if (pid==list[i]){exist=true;break;}
					}
					if (!exist){						
						alert("We don't find it in your shopping cart!");
					}else{
						var qty = Storage.getItem('item'+pid);
						var new_qty=parseInt(qty)-1;
					//	alert(new_qty);
						if(new_qty<=0){
					//		Storage.removeItem('item'+pid);
							document.getElementById("remove_"+pid).disabled=true;
							Storage.setItem('item'+pid,new_qty);
						}
						else{
						Storage.setItem('item'+pid, new_qty);
				//		document.getElementById("remove_"+pid).disabled=false;
						}
					}
				}
				else{
						alert("Your shopping cart is empty!");
						list.length=0;
					}
			//alert("alalalal");	
				Storage.setItem('pidlist', JSON.stringify(list));
				updateHTML();
			});
}
})();
