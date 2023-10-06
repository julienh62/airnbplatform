
console.log("cc apilocation");
// Sélectionnez l'élément par son ID
// Sélectionnez l'élément par son ID
const houseCityInput = document.querySelector(".city");

// Créez l'élément <datalist> et attribuez-lui un ID
const datalist = document.createElement("datalist");
datalist.id = "cities"; // comme dans le formType.php


// Fonction pour récupérer les données depuis votre API via fetch
function fetchOptionsFromApi(inputValue) {
    const urlApi = 'https://127.0.0.1:8000/api_city'; // URL de votre API Symfony

    // Utilisez fetch pour récupérer les données depuis votre API
    fetch(`${urlApi}/${inputValue}`)
        .then(response => response.json())
        .then(data => {
            // Une fois les données récupérées avec succès, créez les options dans le datalist
            data.forEach(function (item) {
                const option = document.createElement("option");
                option.value = item.ville_departement; // Utilisez la valeur appropriée depuis les données de l'API
              //  option.value = item.ville_latitude_deg;
               // option.value = item.ville_longitude_deg;
                option.textContent = `${item.ville_nom_simple}`; // Utilisez le texte approprié depuis les données de l'API
                datalist.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données depuis l\'API :', error);
        });
}

// Ajoutez un écouteur d'événement pour l'événement "input"
houseCityInput.addEventListener("input", function (event) {
    const enteredText = event.target.value;
    // Appelez la fonction pour récupérer les données depuis l'API en fonction de l'entrée de l'utilisateur
    fetchOptionsFromApi(enteredText);
});

// Ajoutez le datalist au parent de l'input
houseCityInput.parentElement.appendChild(datalist);



 