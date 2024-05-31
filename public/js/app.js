
const menuItems = document.querySelectorAll('.nav-item');
// Dropdown constants
const dropdownBtn = document.querySelector('#drp-btn');
const dropdownContainer = document.querySelector('.dropdown-container');

const links = {
    "USER": "/configuration/user",
    "SCRIPTS": "/configuration/scripts",
    "SERVERS": "/configuration/servers",
    "USER-LIST": "/configuration/userlist",
    "LOGS": "/configuration/logs",
}

const handleLinks = () => {
    const items = document.querySelectorAll('.nav-link');

    items.forEach(e => {
        e.addEventListener("click", function (event) {
            event.preventDefault();
            items.forEach(item => item.parentElement.classList.remove('active'));
            this.parentElement.classList.add('active');
            const link = this.dataset.link;
            document.querySelector('#current-page').src = links[link];
        });
    });
}

const handleDropdown = () => {
    dropdownBtn.addEventListener('click', function () {
        if (dropdownContainer.style.display === 'none') {
            dropdownContainer.style.display = 'block'

        } else { dropdownContainer.style.display = 'none' }
    });

    document.addEventListener('click', function (event) {
        if (!dropdownBtn.contains(event.target) && !dropdownContainer.contains(event.target)) {
            dropdownContainer.style.display = 'none';
        }
    });
}


const handleClickViews = () => {

    // Questionmark container dropdown
    document.querySelector('.fa-circle-question').addEventListener('click', function () {
        const tooltiptext = document.querySelector('.tooltiptext');
        if (tooltiptext.style.display == "none") {
            tooltiptext.style.display = "block";
        } else {
            tooltiptext.style.display = "none"
        }
    });

    // View script content
    document.querySelectorAll('.fa-eye').forEach(function (button) {
        button.addEventListener('click', function () {

            const scriptContentContainer = button.parentElement.querySelector('.script-view-container');
            const closeBtn = document.querySelectorAll('#close-btn');

            if (scriptContentContainer.style.display === "none") {
                scriptContentContainer.style.display = "block";

                closeBtn.forEach(btn => {
                    btn.addEventListener('click', function () {
                        scriptContentContainer.style.display = "none";
                    });
                });

            } else {
                scriptContentContainer.style.display = "none";
            }
        })
    });

    // Add server form btn
    document.querySelector('.fa-circle-plus').addEventListener('click', function () {
        const addServerFormContainer = document.querySelector('.add-server-form');
        if (addServerFormContainer.style.display == "none") {
            addServerFormContainer.style.display = "block";
        } else {
            addServerFormContainer.style.display = "none";
        }
    });

}

const logout = () => {
        window.location.href = "/logout";
    }

const init = () => {
    handleLinks();
    handleDropdown();
    handleClickViews();

    // PrismJS initialization
    document.addEventListener('DOMContentLoaded', function () {
        Prism.highlightAll();
    });
};

init();
