
// Fitur dashboard
const btn = document.querySelector(".fitur-btn");
const content = document.querySelector(".fitur-content");

btn.addEventListener("click", () => {
    content.classList.toggle("show");
});