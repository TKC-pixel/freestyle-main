const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});




// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
    
});

document.getElementById("hum").addEventListener('click', function () {
    document.getElementById("back").style.opacity = "0";
    console.log("Hello");
});








const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})





if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})

// JavaScript to toggle visibility of content sections based on sidebar item clicked

document.addEventListener("DOMContentLoaded", function() {
    const sideMenuItems = document.querySelectorAll(".side-menu a");

    sideMenuItems.forEach(function(item) {
        item.addEventListener("click", function(event) {
            event.preventDefault();
            const sectionId = item.getAttribute("href").substring(1);
            const contentSections = document.querySelectorAll(".content-section");

            contentSections.forEach(function(section) {
                if (section.id === sectionId) {
                    section.style.display = "block";
                } else {
                    section.style.display = "none";
                }
            });
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const sideMenuItems = document.querySelectorAll(".side-menu a");

    sideMenuItems.forEach(function(item) {
        item.addEventListener("click", function(event) {
            event.preventDefault();
            const sectionId = item.getAttribute("href");
            const contentSection = document.querySelector(sectionId);

            if (contentSection) {
                // Toggle section visibility
                if (contentSection.style.display === "block") {
                    contentSection.style.display = "none";
                } else {
                    contentSection.style.display = "block";
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
});



