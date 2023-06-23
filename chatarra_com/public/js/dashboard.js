// Calll buttons with thier IDs
const Dashboard_Btn = document.getElementById('Dashboard');
const Customers_Btn = document.getElementById('Customers');
const Products_Btn = document.getElementById('Products');
const Orders_Btn = document.getElementById('Orders');
const Accounts_Btn = document.getElementById('Accounts');
const Passwords_Btn = document.getElementById('Passwords');
// Call Sections with thier IDs 
const Top_Products_Section = document.getElementById('Top_Products_Section');
const customers_section =document.getElementById('customers_section');
const products_section = document.getElementById('products_section');
const orders_section = document.getElementById('orders_section');
const accounts_section = document.getElementById('accounts_section');
const full_data_section = document.getElementById('full_data_section');
const password_section = document.getElementById('password_section');

Dashboard_Btn.addEventListener('click', (e) => {
    e.preventDefault();
    Top_Products_Section.classList.remove('hide');
    customers_section.classList.add('hide');
    products_section.classList.add('hide');
    orders_section.classList.add('hide');
    full_data_section.classList.remove('hide');
    password_section.classList.add('hide');
    accounts_section.classList.add('hide');
});
Customers_Btn.addEventListener('click', (e)=> {
    e.preventDefault();
    Top_Products_Section.classList.add('hide');
    customers_section.classList.remove('hide');
    products_section.classList.add('hide');
    full_data_section.classList.remove('hide');
    orders_section.classList.add('hide');
    password_section.classList.add('hide');
    accounts_section.classList.add('hide');
});
Products_Btn.addEventListener('click' , (e) => {
    e.preventDefault();
    Top_Products_Section.classList.add('hide');
    customers_section.classList.add('hide');
    products_section.classList.remove('hide');
    full_data_section.classList.add('hide');
    orders_section.classList.add('hide');
    password_section.classList.add('hide');
    accounts_section.classList.add('hide');
})
Orders_Btn.addEventListener('click' , (e) => {
    e.preventDefault();
    Top_Products_Section.classList.add('hide');
    customers_section.classList.add('hide');
    products_section.classList.add('hide');
    orders_section.classList.remove('hide');
    full_data_section.classList.add('hide');
    password_section.classList.add('hide');
    accounts_section.classList.add('hide');
}) 
Accounts_Btn.addEventListener('click' , (e) => {
    e.preventDefault();
    Top_Products_Section.classList.add('hide');
    customers_section.classList.add('hide');
    products_section.classList.add('hide');
    orders_section.classList.add('hide');
    accounts_section.classList.remove('hide');
    full_data_section.classList.add('hide');
    password_section.classList.add('hide');
})
Passwords_Btn.addEventListener('click' , (e) => {
    e.preventDefault();
    Top_Products_Section.classList.add('hide');
    customers_section.classList.add('hide');
    products_section.classList.add('hide');
    orders_section.classList.add('hide');
    accounts_section.classList.add('hide');
    full_data_section.classList.add('hide');
    password_section.classList.remove('hide');
})