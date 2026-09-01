let toggleBtn = document.getElementById("toggleAvailabilityBtn");
if (toggleBtn) {
    toggleBtn.addEventListener("click", function () {
        toggleBtn.disabled = true;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4) {
                toggleBtn.disabled = false;

                if (this.status === 200) {
                    let data = JSON.parse(this.responseText);
                    if (data.success) {
                        let banner = document.getElementById("availabilityBanner");
                        if (data.availability === "available") {
                            banner.textContent = "You are currently marked as available for blood donation.";
                            toggleBtn.textContent = "Mark as Unavailable";
                        } else {
                            banner.textContent = "You are currently marked as unavailable for blood donation.";
                            toggleBtn.textContent = "Mark as Available";
                        }
                    } else {
                        alert(data.message || "Could not update availability.");
                    }
                } else {
                    alert("Something went wrong. Please try again.");
                }
            }
        };
        xhttp.open("POST", "../Controller/ToggleAvailabilityController.php", true);
        xhttp.send();
    });
}

document.querySelectorAll(".btn-accept").forEach(function (btn) {
    btn.addEventListener("click", function () {
        let requestId = btn.getAttribute("data-request-id");
        btn.disabled = true;
        btn.textContent = "Sending...";

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    let data = JSON.parse(this.responseText);
                    if (data.success) {
                        btn.outerHTML = '<span class="btn btn-accepted">Accepted &#10003;</span>';
                    } else {
                        btn.disabled = false;
                        btn.textContent = "Accept";
                        alert(data.message || "Could not accept this request.");
                    }
                } else {
                    btn.disabled = false;
                    btn.textContent = "Accept";
                    alert("Something went wrong. Please try again.");
                }
            }
        };
        xhttp.open("POST", "../Controller/AcceptRequestController.php", true);
        xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        xhttp.send("request_id=" + encodeURIComponent(requestId));
    });
});

document.querySelectorAll(".btn-view").forEach(function (btn) {
    btn.addEventListener("click", function () {
        alert(btn.getAttribute("data-detail"));
    });
});
