let form = document.querySelector("form");

form.addEventListener("submit", (e) => {
  if (form.username.value === "" || form.password.value === "") {
    alert("Username and password fields are requried");
    e.preventDefault();
  } else if (
    form.username.value === "Faris" &&
    form.password.value === "faris2013"
  ) {
    window.location.href = "../html/teacher.html";
    e.preventDefault();
  }
});
