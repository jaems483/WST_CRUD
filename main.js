function show_form() {
    var form = document.getElementsByClassName("add_admin")[0];
    if (form.style.display === "none") {
        form.style.display = "flex";
        document.getElementById("s_form").style.display = "none";
    } else {
        form.style.display = "none";
    }
}

function close_admin() {
    var form = document.getElementsByClassName("add_admin")[0];
    form.style.display = "none";
    document.getElementById("s_form").style.display = "block";
}

function add_form() {
    document.getElementById("add_myForm").style.display = "flex";
    document.getElementById("add_myForm").style.flexDirection = "column";
}
function del_form() {
    document.getElementById("del_myForm").style.display = "flex";
    document.getElementById("del_myForm").style.flexDirection = "column";
}
function edit_form() {
    document.getElementById("edit_myForm").style.display = "flex";
    document.getElementById("edit_myForm").style.flexDirection = "column";
}

function close_form() {
    document.getElementById("add_myForm").style.display = "none";
}

function show_admin() {
    var admin_list = document.getElementById("admin_list").style.display = "block";
}

function unshow_admin() {
    var admin_list = document.getElementById("admin_list").style.display = "none";
}

function show_aboutus() {
    var admin_list = document.getElementById("about_us_frame").style.display = "block";
}

function unshow_aboutus() {
    var admin_list = document.getElementById("about_us_frame").style.display = "none";
}