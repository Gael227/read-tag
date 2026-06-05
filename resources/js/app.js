console.log("app.js loaded");
console.log(document.getElementById("search-input"));
const input = document.getElementById("search-input");
const suggestions = document.getElementById("tag-suggestions");

input.addEventListener("input", function () {
    const typed = input.value.toLowerCase();
    suggestions.innerHTML = ""; // kosongkan dropdown setiap kali user ketik

    if (typed === "") {
        suggestions.classList.add("hidden");
        return;
    }
    suggestions.classList.remove("hidden");

    const filtered = allTags.filter((tag) => tag.toLowerCase().includes(typed));

    filtered.forEach((tag) => {
        const li = document.createElement("li");
        li.textContent = tag;
        li.className =
            "px-4 py-2 text-sm text-slate-700 cursor-pointer hover:bg-sky-50";
        li.addEventListener("click", function () {
            input.value = tag;
            suggestions.innerHTML = "";
            suggestions.classList.add("hidden");
        });
        suggestions.appendChild(li);
    });
});

input.addEventListener("focus", function () {
    suggestions.innerHTML = "";
    suggestions.classList.remove("hidden");
    allTags.forEach((tag) => {
        const li = document.createElement("li");
        li.textContent = tag;
        li.className =
            "px-4 py-2 text-sm text-slate-700 cursor-pointer hover:bg-sky-50";
        li.addEventListener("click", function () {
            input.value = tag;
            suggestions.innerHTML = "";
            suggestions.classList.add("hidden");
        });
        suggestions.appendChild(li);
    });
});

input.addEventListener("blur", function () {
    setTimeout(() => {
        suggestions.classList.add("hidden");
    }, 150);
});
