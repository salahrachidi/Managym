/*=============== EMAIL JS ===============*/

const contactForm = document.getElementById("contact-form"),
    contactMessage = document.getElementById("contact-message"),
    contactUser = document.getElementById("contact-user");

const sendEmail = (e) => {
    e.preventDefault();
    // Check if the field has a value
    if (contactUser.value === "") {
        // Add and remove color
        contactMessage.classList.remove("color-green");
        contactMessage.classList.add("color-red");
        // Show message
        contactMessage.textContent = "You write something .. ☝️";
        // Remove message
        setTimeout(() => {
            contactMessage.textContent = "";
        }, 3000);
    } else {
        // serviceID - templateID - #form - publicKey
        emailjs.sendForm('service_5lhrrbp', 'template_sf8zapz', '#contact-form', 'W27cB9ksIywXWhkUW')
            .then(() => {
                // Show message and add color
                contactMessage.classList.add("color-green");
                contactMessage.textContent = "Report sent successfully 😎";
                // Remove message
                setTimeout(() => {
                    contactMessage.textContent = "";
                }, 3000);
            }, (err) => {
                // Mail sending error
                alert('OOPS! SOMETHING HAS FAILED...', err)
            })
        // To clear the input
        contactUser.value = "";
    }
};

contactForm.addEventListener("submit", sendEmail);
