const my_Account_btn = document.getElementById("setting_btn");
const change_password_btn = document.getElementById("change_password_btn");
const my_orders_btn = document.getElementById("my_orders_btn");
const my_products_btn = document.getElementById("my_products_btn");

const setting_section = document.getElementById("setting_section");
const password_section = document.getElementById("password_section");
const order_section = document.getElementById("order_section");
const products_section = document.getElementById("products_section");
const prodile_image = document.getElementById("prodile_image");

my_Account_btn.addEventListener("click", () => {
  setting_section.classList.remove("hide");
  password_section.classList.add("hide");
  order_section.classList.add("hide");
  prodile_image.classList.remove("hide");
  products_section.classList.add("hide");
});

change_password_btn.addEventListener("click", () => {
  password_section.classList.remove("hide");
  setting_section.classList.add("hide");
  order_section.classList.add("hide");
  prodile_image.classList.remove("hide");
  products_section.classList.add("hide");
});
// Check if the order button exists, and add an event listener if it does
if (my_orders_btn !== null) {
  my_orders_btn.addEventListener("click", () => {
    order_section.classList.remove("hide");
    password_section.classList.add("hide");
    setting_section.classList.add("hide");
    prodile_image.classList.add("hide");
  });
}

// Check if the product button exists, and add an event listener if it does
if (my_products_btn !== null) {
  my_products_btn.addEventListener("click", () => {
    products_section.classList.remove("hide");
    password_section.classList.add("hide");
    setting_section.classList.add("hide");
    prodile_image.classList.add("hide");
  });
}

var loadFile = function (event) {
  var image = document.getElementById("output");
  image.src = URL.createObjectURL(event.target.files[0]);
};

// Get the edit button by their IDs
const edit_Fname_Btn = document.getElementById("edit_Fname");
const edit_Lname_Btn = document.getElementById("edit_Lname");
const edit_Phone_Btn = document.getElementById("edit_Phone");
const edit_Cin_Btn = document.getElementById("edit_Cin");
const edit_Account_Type_Btn = document.getElementById("edit_Account_Type");

// Get the inputs by thier IDs
const first_Name_Input = document.getElementById("f_Name");
const last_Name_Input = document.getElementById("l_Name");
const phone_Input = document.getElementById("phone");
const cin_Input = document.getElementById("cin");
const account_Type_Input = document.getElementById("account_type");

// Add an event listener to the edit button
edit_Fname_Btn.addEventListener("click", function () {
  // Remove the readonly attribute from the input element
  first_Name_Input.removeAttribute("readonly");
});
// Add an event listener to the edit button
edit_Lname_Btn.addEventListener("click", function () {
  // Remove the readonly attribute from the input element
  last_Name_Input.removeAttribute("readonly");
});

edit_Phone_Btn.addEventListener("click", function () {
  // Remove the readonly attribute from the input element
  phone_Input.removeAttribute("readonly");
});

edit_Cin_Btn.addEventListener("click", function () {
  // Remove the readonly attribute from the input element
  cin_Input.removeAttribute("readonly");
});
edit_Account_Type_Btn.addEventListener("click", function () {
  // Remove the readonly attribute from the input element
  account_Type_Input.removeAttribute("readonly");
});
