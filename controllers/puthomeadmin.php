<?php
function putHomeAdmin() {
    echo '
    <button id="editmotd" class="cartbutton" type="button" onclick=editMotd()>Edit</button>
    <script>
        function editMotd() {
            imotd = document.getElementById("homemotd");
            ieditbtn = document.getElementById("editmotd");

            imotd.style.display = "none";
            motdtext = imotd.innerHTML;
            motdinput = document.createElement("textarea");
            motdinput.setAttribute("name", "motd");
            motdinput.setAttribute("form", "form");
            motdinput.setAttribute("rows", "10");
            motdinput.setAttribute("cols", "100");
            motdinput.value = motdtext;
            imotd.parentNode.insertBefore(motdinput, imotd);

            forminput = document.createElement("form");
            forminput.setAttribute("action", "controllers/updatemotd.php");
            forminput.setAttribute("method", "POST");
            forminput.setAttribute("name", "form");
            forminput.setAttribute("id", "form");
            imotd.parentNode.parentNode.insertBefore(forminput, imotd.parentNode);
            indexinput = document.createElement("input");
            indexinput.style.display = "none";
            indexinput.type = "number";
            indexinput.setAttribute("name", "index");
            indexinput.setAttribute("form", "form");
            indexinput.value = 1;
            forminput.appendChild(indexinput);

            ieditbtn.style.display = "none";
            editinput = document.createElement("input");
            editinput.type = "submit";
            editinput.setAttribute("form", "form");
            editinput.setAttribute("class", "cartbutton");
            editinput.value = "Save";
            ieditbtn.parentNode.insertBefore(editinput, ieditbtn);
            ieditbtn.remove();
            imotd.remove();
        }
    </script>
    ';
}
?>