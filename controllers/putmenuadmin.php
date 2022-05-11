<?php
function putMenuAdmin() {
    echo '
    function removeItem(index) {
        if (confirm("Are you sure you want to remove this item from the menu? This action cannot be undone.")) {
            iname = document.getElementById("name" + index);
            forminput = document.createElement("form");
            forminput.setAttribute("action", "controllers/removeitem.php");
            forminput.setAttribute("method", "POST");
            forminput.setAttribute("name", "form" + index);
            forminput.setAttribute("id", "form" + index);
            iname.parentNode.parentNode.insertBefore(forminput, iname.parentNode);
            indexinput = document.createElement("input");
            indexinput.style.display = "none";
            indexinput.type = "number";
            indexinput.setAttribute("name", "index");
            indexinput.setAttribute("form", "form" + index);
            indexinput.value = index;
            forminput.appendChild(indexinput);
            forminput.submit();
        }
    }

    function editItem(index) {
        iname = document.getElementById("name" + index);
        iprice = document.getElementById("price" + index);
        iimage = document.getElementById("image" + index);
        idescription = document.getElementById("description" + index);
        iingredients = document.getElementById("ingredients" + index);
        ipreparation_time = document.getElementById("preparation_time" + index);
        ieditbtn = document.getElementById("edit" + index);
        idelbtn = document.getElementById("remove" + index);
        idelbtn.remove();
        icartbtn = document.getElementById("cartbtn" + index);
        icartbtn.disabled = true;
        irequests = document.getElementById("requests" + index);
        irequests.disabled = true;
        icartbtn.disabled = true;
        iquantity = document.getElementById("quantity" + index);
        iquantity.disabled = true;

        // Image
        iimage.style.display = "none";
        imagesource = iimage.src;
        imageinput = document.createElement("input");
        imageinput.type = "file";
        imageinput.setAttribute("id", "imagein" + index);
        imageinput.setAttribute("form", "form" + index);
        imageinput.setAttribute("onchange", "imgOnChange(" + index + ")");
        //
        imageimg = document.createElement("img");
        imageimg.src = imagesource;
        imageimg.setAttribute("id", "img" + index);
        imageimg.setAttribute("style", "width: 100px; height: 100px");
        //
        imagetext = document.createElement("textarea");
        imagetext.value = imagesource;
        imagetext.setAttribute("id", "base" + index);
        imagetext.setAttribute("name", "imageb64" + index);
        imagetext.setAttribute("class", "humans");
        imagetext.setAttribute("form", "form" + index);
        //
        iimage.parentNode.insertBefore(imageinput, iimage);
        iimage.parentNode.insertBefore(document.createElement("br"), iimage);
        iimage.parentNode.insertBefore(document.createElement("br"), iimage);
        iimage.parentNode.insertBefore(imageimg, iimage);
        iimage.parentNode.insertBefore(imagetext, iimage);
        iimage.remove();

        // Form
        forminput = document.createElement("form");
        forminput.setAttribute("action", "controllers/updateitem.php");
        forminput.setAttribute("method", "POST");
        forminput.setAttribute("name", "form" + index);
        forminput.setAttribute("id", "form" + index);
        iname.parentNode.parentNode.insertBefore(forminput, iname.parentNode);

        // Index
        indexinput = document.createElement("input");
        indexinput.style.display = "none";
        indexinput.type = "number";
        indexinput.setAttribute("name", "index");
        indexinput.setAttribute("form", "form" + index);
        indexinput.value = index;
        forminput.appendChild(indexinput);
        
        // Save
        ieditbtn.style.display = "none";
        editinput = document.createElement("input");
        editinput.type = "submit";
        editinput.setAttribute("form", "form" + index);
        editinput.setAttribute("class", "cartbutton");
        editinput.value = "Save";
        ieditbtn.parentNode.insertBefore(editinput, ieditbtn);
        ieditbtn.remove();
        
        // Name
        iname.style.display = "none";
        nametext = iname.innerHTML;
        nameinput = document.createElement("input");
        nameinput.type = "text";
        nameinput.setAttribute("name", "name" + index);
        nameinput.setAttribute("form", "form" + index);
        nameinput.value = nametext;
        iname.parentNode.insertBefore(nameinput, iname);
        iname.remove();

        // Price
        iprice.style.display = "none";
        pricetext = iprice.innerHTML;
        priceinput = document.createElement("input");
        priceinput.type = "number";
        priceinput.setAttribute("name", "price" + index);
        priceinput.setAttribute("min", "0");
        priceinput.setAttribute("max", "10000");
        priceinput.setAttribute("step", "any");
        priceinput.setAttribute("form", "form" + index);
        priceinput.value = pricetext.substring(1);
        iprice.parentNode.insertBefore(priceinput, iprice);
        iprice.remove();

        // Description
        idescription.style.display = "none";
        descriptiontext = idescription.innerHTML;
        descriptioninput = document.createElement("textarea");
        descriptioninput.value = descriptiontext;
        descriptioninput.setAttribute("name", "description" + index);
        descriptioninput.setAttribute("form", "form" + index);
        descriptioninput.setAttribute("maxlength", "1024");
        idescription.parentNode.insertBefore(descriptioninput, idescription);
        idescription.remove();

        // Ingredients
        iingredients.style.display = "none";
        ingredientstext = iingredients.innerHTML;
        ingredientsinput = document.createElement("textarea");
        ingredientsinput.value = ingredientstext;
        ingredientsinput.setAttribute("name", "ingredients" + index);
        ingredientsinput.setAttribute("form", "form" + index);
        ingredientsinput.setAttribute("maxlength", "1024");
        iingredients.parentNode.insertBefore(ingredientsinput, iingredients);
        iingredients.remove();

        // Preparation Time
        ipreparation_time.style.display = "none";
        preparation_timetext = ipreparation_time.innerHTML;
        preparation_timeinput = document.createElement("input");
        preparation_timeinput.type = "number";
        preparation_timeinput.setAttribute("min", "0");
        preparation_timeinput.setAttribute("max", "10000");
        preparation_timeinput.setAttribute("step", "any");
        preparation_timeinput.setAttribute("name", "preparation_time" + index);
        preparation_timeinput.setAttribute("form", "form" + index);
        preparation_timeinput.value = preparation_timetext;
        ipreparation_time.parentNode.insertBefore(preparation_timeinput, ipreparation_time);
        ipreparation_time.remove();
    }

    function imgOnChange(index) {
        $("#base" + index).val("");
        input = document.getElementById("imagein" + index);
        if (input.files && input.files[0]) {
            var FR= new FileReader();
            FR.onload = function(e) {
                $("#img" + index).attr( "src", e.target.result );
                $("#base" + index).val( e.target.result );
            };       
            FR.readAsDataURL( input.files[0] );
        }
    }
    ';
}
?>