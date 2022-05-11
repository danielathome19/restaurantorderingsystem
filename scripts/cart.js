function removeItem(index) {
    if (confirm("Are you sure you want to remove this item from your cart? This action cannot be undone.")) {
        //Delete item from cart using session variable
        window.location.href = 'cart.php?removeitem=' + index;
    }
}

function editItem(index) {
    iname = document.getElementById("name" + index);
    irequests = document.getElementById("requests" + index);
    iquantity = document.getElementById("quantity" + index);
    ifood_index = document.getElementById("food_index" + index);
    ieditbtn = document.getElementById("edit" + index);
    idelbtn = document.getElementById("remove" + index);
    //idelbtn.remove();

    // Form
    forminput = document.createElement("form");
    forminput.setAttribute("action", "controllers/updatecart.php");
    forminput.setAttribute("method", "POST");
    forminput.setAttribute("name", "form" + index);
    forminput.setAttribute("id", "form" + index);
    iname.parentNode.parentNode.insertBefore(forminput, iname.parentNode);

    // Save
    ieditbtn.style.display = "none";
    editinput = document.createElement("input");
    editinput.type = "submit";
    editinput.setAttribute("form", "form" + index);
    editinput.setAttribute("class", "cartbutton");
    editinput.value = "Save";
    ieditbtn.parentNode.insertBefore(editinput, ieditbtn);
    ieditbtn.remove();
    
    // Session Index
    indexinput = document.createElement("input");
    indexinput.style.display = "none";
    indexinput.type = "number";
    indexinput.setAttribute("name", "s_index");
    indexinput.setAttribute("form", "form" + index);
    indexinput.value = index;
    forminput.appendChild(indexinput);

    // Table Index
    food_indexinput = document.createElement("input");
    food_indexinput.style.display = "none";
    food_indexinput.type = "number";
    food_indexinput.setAttribute("name", "menu_index");
    food_indexinput.setAttribute("form", "form" + index);
    food_indexinput.value = ifood_index.innerHTML;
    forminput.appendChild(food_indexinput);
    

    // Requests
    irequests.style.display = "none";
    requeststext = irequests.innerHTML;
    requestsinput = document.createElement("textarea");
    requestsinput.value = requeststext;
    requestsinput.setAttribute("name", "requests" + index);
    requestsinput.setAttribute("form", "form" + index);
    requestsinput.setAttribute("maxlength", "1024");
    irequests.parentNode.insertBefore(requestsinput, irequests);
    irequests.remove();

    // Quantity
    iquantity.style.display = "none";
    quantitytext = iquantity.innerHTML;
    quantityinput = document.createElement("input");
    quantityinput.type = "number";
    quantityinput.setAttribute("min", "0");
    quantityinput.setAttribute("max", "50");
    quantityinput.setAttribute("step", "any");
    quantityinput.setAttribute("name", "quantity" + index);
    quantityinput.setAttribute("form", "form" + index);
    quantityinput.value = quantitytext;
    iquantity.parentNode.insertBefore(quantityinput, iquantity);
    iquantity.remove();
}