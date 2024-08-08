function validateDishForm(event) {

    const name = document.forms['dishForm']['name'];
    const price = document.forms['dishForm']['price'];
    const image = document.forms['dishForm']['image'];
    const description = document.forms['dishForm']['description'];

    let pushForm = true;

    //name
    let nameHelp = document.getElementById('nameHelp');
    if (nameHelp) {
        nameHelp.remove();
        name.classList.remove('is-invalid');
    }
    name.classList.add('is-valid');
    if (!name.value) {
        name.insertAdjacentHTML('afterend', '<small id="nameHelp" class="text-danger d-block">Devi inserire un nome</small>');
        name.classList.remove('is-valid');
        name.classList.add('is-invalid');
        pushForm = false;
    }
    if (name.value.length > 100) {
        name.insertAdjacentHTML('afterend', '<small id="nameHelp" class="text-danger d-block">Il nome non puo avere piu di 100 caratteri</small>');
        name.classList.remove('is-valid');
        name.classList.add('is-invalid');
        pushForm = false;
    }

    //price
    let priceHelp = document.getElementById('priceHelp');
    if (priceHelp) {
        priceHelp.remove();
        price.classList.remove('is-invalid');
        document.getElementById('€').classList.remove('border-danger');
    }
    price.classList.add('is-valid');
    document.getElementById('€').classList.add('border-success');
    if (isNaN(price.value) || price.value < 0 || price.value > 999.99 || !price.value) {
        price.insertAdjacentHTML('afterend', '<small id="priceHelp" class="text-danger d-block">Devi inserire un prezzo (valore numerico tra 0 e 999.99)</small>');
        price.classList.remove('is-valid');
        document.getElementById('€').classList.remove('border-success');
        price.classList.add('is-invalid');
        document.getElementById('€').classList.add('border-danger');
        pushForm = false;
    }

    //image
    image.classList.remove('is-valid');
    if (image.value) {
        let imageFormattHelp = document.getElementById('imageFormattHelp');
        if (imageFormattHelp) {
            imageFormattHelp.remove();
            //devo prendere il tag genitore di image 
            image.classList.remove('is-invalid');
        }
        image.classList.add('is-valid');
        if (!image.value.endsWith('.jpg') && !image.value.endsWith('.png') && !image.value.endsWith('.jpeg') && !image.value.endsWith('.jfif') && !image.value.endsWith('.JPG') && !image.value.endsWith('.PNG') && !image.value.endsWith('.JPEG')) {
            image.insertAdjacentHTML('afterend', `<small id="imageFormattHelp" class="text-danger d-block">L'immagine non è valida, sono permessi solo jpg o png</small>`);
            image.classList.remove('is-valid');
            image.classList.add('is-invalid');
            pushForm = false;
        }
    }

    //description
    description.classList.remove('is-valid');
    if (description.value) {
        let descriptionLenghtHelp = document.getElementById('descriptionLenghtHelp');
        if (descriptionLenghtHelp) {
            descriptionLenghtHelp.remove();
            description.classList.remove('is-invalid');
        }
        description.classList.add('is-valid');
        if (description.value.length < 0 || description.value.length > 255) {
            description.insertAdjacentHTML('afterend', '<small id="descriptionLenghtHelp" class="text-danger d-block">La descrizione deve essere minore di 255 caratteri</small>');
            description.classList.remove('is-valid');
            description.classList.add('is-invalid');
            pushForm = false;
        }
    }

    //debug mode
    //event.preventDefault(event);

    //form validation !important: this must be the last validation
    if (pushForm === false) {
        event.preventDefault(event);
    } else {
        return true;
    }
}