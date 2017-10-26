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
})();
