const textarea = document.getElementById('content');
    const insertImageButton = document.getElementById('insert-image-button');
    const imageModal = document.getElementById('imageModal');
    const imageUrlInput = document.getElementById('imageUrl');

    insertImageButton.addEventListener('click', () => {
        const imageUrl = imageUrlInput.value;
        textarea.value += `[image url="${imageUrl}"]`;
    });

    imageModal.addEventListener('shown.bs.modal', () => {
        imageUrlInput.focus()
    });

    const insertGalleryButton = document.getElementById('insert-gallery-button');
    const galleryModal = document.getElementById('galleryModal');
    const url1Input = document.getElementById('url1');
    const url2Input = document.getElementById('url2');
    const url3Input = document.getElementById('url3');
    const url4Input = document.getElementById('url4');

    insertGalleryButton.addEventListener('click', () => {
        const url1 = url1Input.value;
        const url2 = url2Input.value;
        const url3 = url3Input.value;
        const url4 = url4Input.value;
        textarea.value += `[gallery url1="${url1}" url2="${url2}" url3="${url3}" url4="${url4}"]`;
    });

    galleryModal.addEventListener('shown.bs.modal', () => {
        url1Input.focus()
    });