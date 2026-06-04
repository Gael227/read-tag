console.log("app.js loaded");
console.log(document.getElementById("search-input"));
const input = document.getElementById("search-input");
const suggestions = document.getElementById("tag-suggestions");

input.addEventListener("input", function () {
    const typed = input.value.toLowerCase();
    suggestions.innerHTML = ""; // kosongkan dropdown setiap kali user ketik

    if (typed === "") return; // kalau input kosong, stop

    const filtered = allTags.filter((tag) => tag.toLowerCase().includes(typed));

    filtered.forEach((tag) => {
        const li = document.createElement("li");
        li.textContent = tag;
        li.addEventListener("click", function () {
            input.value = tag;
            suggestions.innerHTML = "";
        });
        suggestions.appendChild(li);
    });
});

input.addEventListener("focus", function () {
    suggestions.innerHTML = "";
    allTags.forEach((tag) => {
        const li = document.createElement("li");
        li.textContent = tag;
        li.addEventListener("click", function () {
            input.value = tag;
            suggestions.innerHTML = "";
        });
        suggestions.appendChild(li);
    });
});
