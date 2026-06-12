// Dark Mode Toggle
function initDarkMode() {
    const darkModeToggle = document.getElementById("dark-mode-toggle");
    if (!darkModeToggle) return;

    const isDark = localStorage.getItem("darkMode") === "true" ||
                   window.matchMedia("(prefers-color-scheme: dark)").matches;

    if (isDark) {
        document.documentElement.classList.add("dark");
        darkModeToggle.innerHTML = '☀️';
    }

    darkModeToggle.addEventListener("click", function () {
        const isDarkMode = document.documentElement.classList.toggle("dark");
        localStorage.setItem("darkMode", isDarkMode);
        darkModeToggle.innerHTML = isDarkMode ? '☀️' : '🌙';
    });
}

// Form Toggle for Book Input
function initFormToggle() {
    const toggleBtn = document.getElementById("toggle-form-btn");
    const formContainer = document.getElementById("book-input-form");

    if (!toggleBtn || !formContainer) return;

    toggleBtn.addEventListener("click", function () {
        const isHidden = formContainer.classList.contains("hidden");
        if (isHidden) {
            formContainer.classList.remove("hidden");
            toggleBtn.textContent = "✕ Tutup Form";
            toggleBtn.classList.remove("bg-sky-600", "hover:bg-sky-700");
            toggleBtn.classList.add("bg-slate-600", "hover:bg-slate-700");
        } else {
            formContainer.classList.add("hidden");
            toggleBtn.textContent = "+ Tambah Buku";
            toggleBtn.classList.add("bg-sky-600", "hover:bg-sky-700");
            toggleBtn.classList.remove("bg-slate-600", "hover:bg-slate-700");
        }
    });
}

// Tag Suggestions
function initTagSuggestions() {
    const input = document.getElementById("search-input");
    const suggestions = document.getElementById("tag-suggestions");

    if (!input || !suggestions) return;

    input.addEventListener("input", function () {
        const typed = input.value.toLowerCase();
        suggestions.innerHTML = "";

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
                "px-4 py-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-sky-50 dark:hover:bg-slate-700";
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
                "px-4 py-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-sky-50 dark:hover:bg-slate-700";
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
}

// Initialize all functions
document.addEventListener("DOMContentLoaded", function () {
    initDarkMode();
    initFormToggle();
    initTagSuggestions();
});
