// Récupérez la référence à la div et au bouton
let divElement = document.getElementById("d1");
let buttonElement = document.getElementById("blockBtn");
// let buttonElement2 = document.getElementById("blockBtn2");

// Écoutez l'événement de clic sur le bouton
buttonElement.addEventListener("click", function(event) {
    // Empêchez le comportement par défaut du bouton (qui peut provoquer un rechargement de la page)
    event.preventDefault();

    // Modifiez la propriété "display" de la div pour la rendre visible
    divElement.style.display = "block"; // ou "divElement.style.display = "inline-block"; selon votre besoin
    buttonElement.style.display = "none";
    // buttonElement2.style.display = "none";
});
// document.getElementById('customerForm').addEventListener('submit', function(event) {
//     // event.preventDefault(); // Empêche l'action par défaut

//     if (event.submitter && event.submitter.name === 'search') {
//         // Action de recherche en GET
//         this.method = 'get';
//         this.submit();
//     }

//     if (event.submitter && event.submitter.name === 'update') {
//         // Action de mise à jour en POST
//         this.method = 'post';
//         this.submit();
//     }
// });
// Fonction pour soumettre les deux formulaires 
// function submitBothForms() {
// // Soumettre le premier formulaire (client)
// document.querySelector('.customer-form').submit();
// console.log("Table 1 soumise")

// // Soumettre le deuxième formulaire (animal)
// document.querySelector('.animal-form').submit();
// console.log("Table 2 soumise")
// }
