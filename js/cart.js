(function() {
  var items_in_card = document.getElementsByClassName("item-card");
  for (item of items_in_card) {
    let item_desc = item.children;
    // add event listen to input element
    item_desc[1].addEventListener("input", function(){
      // get quantity
      let quantity = parseInt(item_desc[1].value);
      // get base price in type double
      let base_price = parseFloat(item_desc[2].textContent);
      // display the price
      item_desc[3].innerHTML = "$" + (quantity * base_price);
    });

    // default value for quantity is 1
    item_desc[1].value = 1;
    item_desc[1].dispatchEvent(new Event('input'));
  }
})();