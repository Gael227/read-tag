// Dark Mode
function initDarkMode() {
    const toggle = document.getElementById("dark-mode-toggle");
    if (!toggle) return;

    const stored = localStorage.getItem("darkMode");
    let isDark =
        stored === "true"
            ? true
            : stored === "false"
              ? false
              : window.matchMedia("(prefers-color-scheme: dark)").matches;

    document.documentElement.classList.toggle("dark", isDark);
    toggle.innerHTML = isDark ? "☀️" : "🌙";

    toggle.addEventListener("click", function () {
        const dark = document.documentElement.classList.toggle("dark");
        localStorage.setItem("darkMode", dark);
        toggle.innerHTML = dark ? "☀️" : "🌙";
    });
}

// Book form toggle (halaman utama)
function initBookFormToggle() {
    const btn = document.getElementById("toggle-form-btn");
    const form = document.getElementById("book-input-form");
    const closeBtn = document.getElementById("close-form-btn");
    if (!btn || !form) return;

    btn.addEventListener("click", function () {
        const isOpen = form.classList.contains("open");
        form.classList.toggle("open", !isOpen);
        btn.textContent = isOpen ? "+ Tambah" : "✕ Tutup";
    });

    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            form.classList.remove("open");
            btn.textContent = "+ Tambah";
        });
    }
}

// Annotate form toggle (halaman detail)
function initAnnotateFormToggle() {
    const btn = document.getElementById("toggle-annotate-btn");
    const form = document.getElementById("annotate-form-wrap");
    const closeBtn = document.getElementById("close-annotate-btn");
    if (!btn || !form) return;

    btn.addEventListener("click", function () {
        const isOpen = form.classList.contains("open");
        form.classList.toggle("open", !isOpen);
        btn.textContent = isOpen ? "+ Tambah catatan" : "✕ Tutup";
    });

    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            form.classList.remove("open");
            btn.textContent = "+ Tambah catatan";
        });
    }
}

// Tag Suggestions
function initTagSuggestions() {
    const input = document.getElementById("search-input");
    const suggestions = document.getElementById("tag-suggestions");
    const allTags = Array.isArray(window.allTags) ? window.allTags : [];
    if (!input || !suggestions) return;

    function renderTags(tags) {
        suggestions.innerHTML = "";
        tags.forEach((tag) => {
            const li = document.createElement("li");
            li.textContent = tag;
            li.className =
                "px-3 py-1.5 cursor-pointer text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition";
            li.addEventListener("click", function () {
                input.value = tag;
                suggestions.innerHTML = "";
                suggestions.classList.add("hidden");
            });
            suggestions.appendChild(li);
        });
    }

    input.addEventListener("focus", function () {
        suggestions.classList.remove("hidden");
        renderTags(allTags);
    });

    input.addEventListener("input", function () {
        const typed = input.value.toLowerCase();
        if (typed === "") {
            suggestions.classList.add("hidden");
            return;
        }
        suggestions.classList.remove("hidden");
        renderTags(allTags.filter((tag) => tag.toLowerCase().includes(typed)));
    });

    input.addEventListener("blur", function () {
        setTimeout(() => suggestions.classList.add("hidden"), 150);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initDarkMode();
    initBookFormToggle();
    initAnnotateFormToggle();
    initTagSuggestions();
});
