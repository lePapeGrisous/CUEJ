document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type-select');
    const encadrerField = document.getElementById('encadrer');
    const textInput = document.querySelector('textarea[name="contenu"]');
    const imageField = document.querySelector('input[name="image"]');
    const sonField = document.querySelector('input[name="son"]');
    const altField = document.querySelector('input[name="alt"]');
    const carrouselField = document.getElementById('carrousel');
    const legendelField = document.getElementById('legende');
    const auteurlField = document.getElementById('auteur');
    const videoField = document.querySelector('input[name="video"]');
   
    console.log(altField);



    function updateForm() {
        const selectedType = typeSelect.value;

        // Reset all fields
        typeSelect.parentElement.style.display = 'block';
        textInput.parentElement.style.display = 'block';
        encadrerField.parentElement.style.display = 'none';
        imageField.parentElement.style.display = 'none';
        sonField.parentElement.style.display = 'none';
        altField.parentElement.style.display = 'none';
        carrouselField.parentElement.style.display = 'none';
        legendelField.parentElement.style.display = 'none';
        auteurlField.parentElement.style.display = 'none';
        videoField.parentElement.style.display = 'none';

        if (selectedType === 'son' ) {

            sonField.parentElement.style.display = 'block';
            textInput.parentElement.style.display = 'none';

        }

        if (selectedType === 'p' ) {
            encadrerField.parentElement.style.display = 'block';


        }
        if (selectedType === 'citation' ) {
            encadrerField.parentElement.style.display = 'block';
            auteurlField.parentElement.style.display = 'block';


        }

        if (selectedType === 'imtxt_d'|| selectedType === 'imtxt_g') {

            imageField.parentElement.style.display = 'block';
            legendelField.parentElement.style.display = 'block';

            altField.parentElement.style.display = 'block';
        }
        if (selectedType === 'image') {

            imageField.parentElement.style.display = 'block';
            altField.parentElement.style.display = 'block';
            legendelField.parentElement.style.display = 'block';
            carrouselField.parentElement.style.display = 'block';
            textInput.parentElement.style.display = 'none';
        }

        if (selectedType === 'sontxt') {

            sonField.parentElement.style.display = 'block';
        }
        if (selectedType === 'video') {

            videoField.parentElement.style.display = 'block';
            textInput.parentElement.style.display = 'none';
        }


    }

    typeSelect.addEventListener('change', updateForm);
    updateForm();
});