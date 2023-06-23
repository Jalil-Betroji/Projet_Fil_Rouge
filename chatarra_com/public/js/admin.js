// call dropdown btns

const confirm_Reservations_Btn = document.getElementById(
  "confirm_Reservations"
);

const confirmed_Reservations_Btn = document.getElementById(
  "confirmed_Reservations"
);

const collection_List_Btn = document.getElementById("collection_List");

// call sections to hide according to button click

const reservation_List_Section = document.getElementById("reservation_List");

const confirmed_Reservations_Section = document.getElementById(
  "confirmed_Reservations_List"
);

const collection_List_Section = document.getElementById("full_Collection_List");

// hide sections while i make an action to show specific section

confirm_Reservations_Btn.addEventListener("click", (e) => {
  e.preventDefault();
  reservation_List_Section.classList.remove("profile_hide");
  confirmed_Reservations_Section.classList.add("profile_hide");
  collection_List_Section.classList.add("profile_hide");
});

confirmed_Reservations_Btn.addEventListener("click", (e) => {
  e.preventDefault();
  reservation_List_Section.classList.add("profile_hide");
  confirmed_Reservations_Section.classList.remove("profile_hide");
  collection_List_Section.classList.add("profile_hide");
});

collection_List_Btn.addEventListener("click", (e) => {
  e.preventDefault();
  reservation_List_Section.classList.add("profile_hide");
  confirmed_Reservations_Section.classList.add("profile_hide");
  collection_List_Section.classList.remove("profile_hide");
});
