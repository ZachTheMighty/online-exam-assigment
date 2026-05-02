let form = document.querySelector("form");
let loginButton = document.querySelector("input[type='submit']");

loginButton.addEventListener("click", (e) => {
  e.preventDefault();
  if (form.username.value === "" || form.password.value === "")
    alert("Username and password fields are requried");
  else if (
    form.username.value === "Firas" &&
    form.password.value === "firas2013"
  )
    window.location.href = "teacher.html";
});
