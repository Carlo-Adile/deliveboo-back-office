function validateRegisterForm(event) {
    //Getting all form elements
    const name = document.forms['registerForm']['name'];
    const email = document.forms['registerForm']['email'];
    const restaurantName = document.forms['registerForm']['name_restaurant'];
    const address = document.forms['registerForm']['address'];
    const vat = document.forms['registerForm']['vat'];
    // const contactEmail = document.forms['registerForm']['contact_email'];
    const types = document.forms['registerForm']['typeList[]'];
    const phoneNumber = document.forms['registerForm']['phone_number'];
    const thumb = document.forms['registerForm']['thumb'];
    const logo = document.forms['registerForm']['logo'];
    const password = document.forms['registerForm']['password'];
    const passwordCheck = document.forms['registerForm']['password-confirm'];

    let pushForm = true;

    //name
    let nameHelp = document.getElementById('nameHelp');
    if (nameHelp) {
        nameHelp.remove();
        name.classList.remove('is-invalid');
    }
    name.classList.add('is-valid');
    if (!name.value) {
        name.insertAdjacentHTML('afterend', '<small id="nameHelp" class="text-danger">Devi inserire un nome</small>');
        name.classList.remove('is-valid');
        name.classList.add('is-invalid');
        pushForm = false;
    }

    //email
    let emailHelp = document.getElementById('emailHelp');
    if (emailHelp) {
        emailHelp.remove();
        email.classList.remove('is-invalid');
    }
    email.classList.add('is-valid');
    if (!email.value || !email.value.includes('@') || !email.value.includes('.')) {
        email.insertAdjacentHTML('afterend', '<small id="emailHelp" class="text-danger">Devi inserire un indirizzo email; es.. mail@example.com</small>');
        email.classList.remove('is-valid');
        email.classList.add('is-invalid');
        pushForm = false;
    }

    //restaurantName
    let restaurantNameHelp = document.getElementById('restaurantNameHelp');
    if (restaurantNameHelp) {
        restaurantNameHelp.remove();
        restaurantName.classList.remove('is-invalid');
    }
    restaurantName.classList.add('is-valid');
    if (!restaurantName.value || restaurantName.value.length < 4) {
        restaurantName.insertAdjacentHTML('afterend', '<small id="restaurantNameHelp" class="text-danger">Devi inserire un nome ristorante almeno 4 caratteri</small>');
        restaurantName.classList.remove('is-valid');
        restaurantName.classList.add('is-invalid');
        pushForm = false;
    }

    //address
    let addressHelp = document.getElementById('addressHelp');
    if (addressHelp) {
        addressHelp.remove();
        address.classList.remove('is-invalid');
    }
    address.classList.add('is-valid');
    if (!address.value || address.value.length < 4) {
        address.insertAdjacentHTML('afterend', '<small id="addressHelp" class="text-danger">Devi inserire un indirizzo</small>');
        address.classList.remove('is-valid');
        address.classList.add('is-invalid');
        pushForm = false;
    }

    //vat
    let vatHelp = document.getElementById('vatHelp');
    if (vatHelp) {
        vatHelp.remove();
        vat.classList.remove('is-invalid');
    }
    vat.classList.add('is-valid');
    if (!vat.value || vat.value.length !== 11 || isNaN(vat.value) || vat.value < 0) {
        vat.insertAdjacentHTML('afterend', '<small id="vatHelp" class="text-danger">Devi inserire un partita iva (11 numeri)</small>');
        vat.classList.remove('is-valid');
        vat.classList.add('is-invalid');
        pushForm = false;
    }

    //types
    let typesHelp = document.getElementById('typesHelp');
    if (typesHelp) {
        typesHelp.remove();
    }

    let atLeastOneChecked = false;
    types.forEach(type => {
        if (type.checked) {
            atLeastOneChecked = true;
        }
    });

    if (!atLeastOneChecked) {
        document.getElementById('type-error').insertAdjacentHTML('afterend', ' <small id="typesHelp" class="text-danger">Devi selezionare almeno un tipo</small>');
        pushForm = false;
    }

    //contactEmail
    /* let contactEmailHelp = document.getElementById('contactEmailHelp');
    if (contactEmailHelp) {
        contactEmailHelp.remove();
        contactEmail.classList.remove('is-invalid');
    }
    contactEmail.classList.add('is-valid');
    if (!contactEmail.value || !contactEmail.value.includes('@') || !contactEmail.value.includes('.')) {
        contactEmail.insertAdjacentHTML('afterend', '<small id="contactEmailHelp" class="text-danger">Devi inserire un indirizzo email di contatto</small>');
        contactEmail.classList.remove('is-valid');
        contactEmail.classList.add('is-invalid');
        pushForm = false;
    } */

    //phoneNumber
    if (phoneNumber.value) {
        let phoneNumberHelp = document.getElementById('phoneNumberHelp');
        if (phoneNumberHelp) {
            phoneNumberHelp.remove();
            phoneNumber.classList.remove('is-invalid');
        }
        phoneNumber.classList.add('is-valid');
        if (phoneNumber.value.length < 3 || phoneNumber.value.length > 20 || isNaN(phoneNumber.value) || phoneNumber.value < 0) {
            phoneNumber.insertAdjacentHTML('afterend', '<small id="phoneNumberHelp" class="text-danger">Devi inserire un numero di telefono valido</small>');
            phoneNumber.classList.remove('is-valid');
            phoneNumber.classList.add('is-invalid');
            pushForm = false;
        }
    }

    //thumb
    thumb.classList.remove('is-valid');
    if (thumb.value) {
        let thumbFormattHelp = document.getElementById('thumbFormattHelp');
        if (thumbFormattHelp) {
            thumbFormattHelp.remove();
            thumb.classList.remove('is-invalid');
        }
        thumb.classList.add('is-valid');
        if (!thumb.value.endsWith('.jpg') && !thumb.value.endsWith('.png') && !image.value.endsWith('.jfif') && !thumb.value.endsWith('.jpeg') && !thumb.value.endsWith('.JPG') && !thumb.value.endsWith('.PNG') && !thumb.value.endsWith('.JPEG')) {
            thumb.insertAdjacentHTML('afterend', '<small id="thumbFormattHelp" class="text-danger">Il thumb non è valido, sono permessi solo jpg o png</small>');
            thumb.classList.remove('is-valid');
            thumb.classList.add('is-invalid');
            pushForm = false;
        }
    }

    //logo
    logo.classList.remove('is-valid');
    if (logo.value) {
        let logoFormattHelp = document.getElementById('logoFormattHelp');
        if (logoFormattHelp) {
            logoFormattHelp.remove();
            logo.classList.remove('is-invalid');
        }
        logo.classList.add('is-valid');
        if (!logo.value.endsWith('.jpg') && !logo.value.endsWith('.png') && !image.value.endsWith('.jfif') && !logo.value.endsWith('.jpeg') && !logo.value.endsWith('.JPG') && !logo.value.endsWith('.PNG') && !logo.value.endsWith('.JPEG')) {
            logo.insertAdjacentHTML('afterend', '<small id="logoFormattHelp" class="text-danger">Il logo non è valido, sono permessi solo jpg o png</small>');
            logo.classList.remove('is-valid');
            logo.classList.add('is-invalid');
            pushForm = false;
        }
    }

    //password e passwordCheck uguale
    let passwordHelp = document.getElementById('passwordHelp');
    if (passwordHelp) {
        passwordHelp.remove();
        password.classList.remove('is-invalid');
    }
    password.classList.add('is-valid');

    let passwordCheckHelp = document.getElementById('passwordCheckHelp');
    if (passwordCheckHelp) {
        passwordCheckHelp.remove();
        passwordCheck.classList.remove('is-invalid');
    }
    passwordCheck.classList.add('is-valid');

    if (password.value !== passwordCheck.value) {
        password.insertAdjacentHTML('afterend', '<small id="passwordHelp" class="text-danger d-block">La password e la conferma della password non corrispondono</small>');
        passwordCheck.insertAdjacentHTML('afterend', '<small id="passwordCheckHelp" class="text-danger d-block">La password e la conferma della password non corrispondono</small>');

        password.classList.remove('is-valid');
        passwordCheck.classList.remove('is-valid');

        password.classList.add('is-invalid');
        passwordCheck.classList.add('is-invalid');

        pushForm = false;
    }

    //password
    let passwordLenghtHelp = document.getElementById('passwordLenghtHelp');
    if (passwordLenghtHelp) {
        passwordLenghtHelp.remove();
        password.classList.remove('is-invalid');
    }
    password.classList.add('is-valid');
    if (password.value.length < 8) {
        password.insertAdjacentHTML('afterend', '<small id="passwordLenghtHelp" class="text-danger d-block">La password deve avere almeno 8 caratteri</small>');
        password.classList.remove('is-valid');
        password.classList.add('is-invalid');
        pushForm = false;
    }

    //passwordCheck
    let passwordCheckLenghtHelp = document.getElementById('passwordCheckLenghtHelp');
    if (passwordCheckLenghtHelp) {
        passwordCheckLenghtHelp.remove();
        passwordCheck.classList.remove('is-invalid');
    }
    passwordCheck.classList.add('is-valid');
    if (passwordCheck.value.length < 8) {
        passwordCheck.insertAdjacentHTML('afterend', '<small id="passwordCheckLenghtHelp" class="text-danger d-block">La password deve avere almeno 8 caratteri</small>');
        passwordCheck.classList.remove('is-valid');
        passwordCheck.classList.add('is-invalid');
        pushForm = false;
    }


    // debug mode
    // event.preventDefault(event);

    //form validation !important: this must be the last validation
    if (pushForm === false) {
        event.preventDefault(event);
    } else {
        return true;
    }
}