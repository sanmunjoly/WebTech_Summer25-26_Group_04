const sections = document.querySelectorAll(".page-section");
const navItems = document.querySelectorAll(".nav-item");
const title = document.getElementById("pageTitle");

function showSection(id) {
    sections.forEach(section => {
        section.classList.toggle("active-section", section.id === id);
    });

    navItems.forEach(item => {
        item.classList.toggle("active", item.dataset.section === id);
    });

    const activeItem = document.querySelector(`[data-section="${id}"]`);
    if (activeItem) {
        title.textContent = activeItem.innerText.trim();
    }
}

navItems.forEach(item => {
    item.addEventListener("click", () => showSection(item.dataset.section));
});

const today = document.getElementById("today");
if (today) {
    today.textContent = new Date().toLocaleDateString("en-GB", {
        day: "2-digit",
        month: "short",
        year: "numeric"
    });
}

async function updateRequest(id, status, button) {
    button.disabled = true;

    try {
        const response = await fetch("update_request.php", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({id: id, status: status})
        });

        const result = await response.json();

        if (result.success) {
            const row = button.closest("tr");
            row.querySelector(".request-status").innerHTML =
                `<span class="badge ${status.toLowerCase()}">${status}</span>`;

            button.parentElement.innerHTML = `<button class="small">View</button>`;
        } else {
            alert(result.message || "Could not update request.");
            button.disabled = false;
        }
    } catch (error) {
        alert("Server connection error.");
        button.disabled = false;
    }
}
