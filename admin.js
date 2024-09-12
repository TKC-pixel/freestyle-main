document.addEventListener("DOMContentLoaded", function() {
    const sideMenuItems = document.querySelectorAll("#sidebar .side-menu.top li a");

    sideMenuItems.forEach(function(item) {
        item.addEventListener("click", function(event) {
            event.preventDefault();
            const sectionId = item.getAttribute("href");
            const contentSection = document.querySelector(sectionId);

            if (contentSection) {
                
                if (contentSection.style.display === "block") {
                    contentSection.style.display = "none";
                } else {
                    contentSection.style.display = "block";
                    console.log(contentSection);    
                }

                // Update breadcrumb link text
                const activeBreadcrumbLink = document.querySelector(".breadcrumb .active");
                const sideMenuText = item.querySelector(".text").textContent;
                activeBreadcrumbLink.textContent = sideMenuText;

                // Update href attribute of active breadcrumb link
                activeBreadcrumbLink.setAttribute("href", sectionId);

                // Hide other sections
                const otherSections = document.querySelectorAll(".table-data > .order > div:not(" + sectionId + ")");
                otherSections.forEach(function(section) {
                    section.style.display = "none";
                });
            }
        });
    });

    const humIcon = document.getElementById("hum");
    humIcon.addEventListener('click', function () {
        document.getElementById("back").style.opacity = "0";
        console.log("Hello");
    });

    const subscriptionFilter = document.getElementById("subscriptionFilter");
    const subscriptionTable = document.getElementById("subscriptionTable");

    subscriptionFilter.addEventListener('change', function() {
        if (subscriptionFilter.value === "Filter") {
            subscriptionTable.style.display = "none";
        } else {
            subscriptionTable.style.display = "block";
        }
    });
});
