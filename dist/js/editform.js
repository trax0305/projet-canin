
function editRecord(event, customerId) {
    event.preventDefault();

    var lastNameElement = document.getElementById('lastname_' + customerId);
    var firstNameElement = document.getElementById('firstname_' + customerId);
    var mailElement = document.getElementById('mail_' + customerId);
    var nameElement = document.getElementById('name_' + customerId);
    var breedElement = document.getElementById('breed_' + customerId);

    // Récupérez les valeurs actuelles
    var lastName = lastNameElement.innerHTML;
    var firstName = firstNameElement.innerHTML;
    var mail = mailElement.innerHTML;
    var name = nameElement.innerHTML;
    var breed = breedElement.innerHTML;

    // Remplacez les éléments d'affichage par des champs de saisie
    lastNameElement.innerHTML = '<input type="text" id="edit_lastname_' + customerId + '" value="' + lastName + '" data-customer-id="' + customerId + '">';
    firstNameElement.innerHTML = '<input type="text" id="edit_firstname_' + customerId + '" value="' + firstName + '" data-customer-id="' + customerId + '">';
    mailElement.innerHTML = '<input type="text" id="edit_mail_' + customerId + '" value="' + mail + '" data-customer-id="' + customerId + '">';
    nameElement.innerHTML = '<input type="text" id="edit_name_' + customerId + '" value="' + name + '" data-customer-id="' + customerId + '">';
    breedElement.innerHTML = '<input type="text" id="edit_breed_' + customerId + '" value="' + breed + '" data-customer-id="' + customerId + '">';

    // Ajoutez un bouton "Enregistrer" avec un identifiant unique
    var saveButtonId = 'save_button_' + customerId;
    breedElement.innerHTML += '<i class="fas fa-save" id="' + saveButtonId + '" style="cursor: pointer; margin-left: 15px; font-size: 20px;"></i>';

    // Ajoutez l'ID du client comme attribut de données aux champs de saisie
    document.getElementById('edit_lastname_' + customerId).dataset.customerId = customerId;
    document.getElementById('edit_firstname_' + customerId).dataset.customerId = customerId;
    document.getElementById('edit_mail_' + customerId).dataset.customerId = customerId;
    document.getElementById('edit_name_' + customerId).dataset.customerId = customerId;
    document.getElementById('edit_breed_' + customerId).dataset.customerId = customerId;

    // Ajoutez un auditeur d'événements au bouton "Enregistrer"
    var saveButton = document.getElementById(saveButtonId);
    console.log(saveButton);
    saveButton.addEventListener('click', function(event) {
        console.log('Bouton "Enregistrer" cliqué !'); // Vérifiez si ce message s'affiche dans la console
        saveRecord(event, customerId);
    });
}

function saveRecord(event, customerId) {
    // Empêchez le comportement par défaut du formulaire
    event.preventDefault();

    // Récupérez les valeurs éditées depuis les champs de saisie en utilisant l'ID du client
    var editedLastName = document.getElementById('edit_lastname_' + customerId).value;
    var editedFirstName = document.getElementById('edit_firstname_' + customerId).value;
    var editedMail = document.getElementById('edit_mail_' + customerId).value;
    var editedName = document.getElementById('edit_name_' + customerId).value;
    var editedBreed = document.getElementById('edit_breed_' + customerId).value;

// Remplacez les champs de saisie par leur valeur actuelle
    document.getElementById('edit_lastname_' + customerId).innerHTML = editedLastName;
    document.getElementById('edit_firstname_' + customerId).innerHTML = editedFirstName;
    document.getElementById('edit_mail_' + customerId).innerHTML = editedMail;
    document.getElementById('edit_name_' + customerId).innerHTML = editedName;
    document.getElementById('edit_breed_' + customerId).innerHTML = editedBreed;

    // Supprimez le bouton "Enregistrer"
    var saveButtonId = 'save_button_' + customerId;
    var saveButton = document.getElementById(saveButtonId);
    if (saveButton) {
        saveButton.parentNode.removeChild(saveButton);
    }

    // Envoyez une requête AJAX au script PHP côté serveur pour effectuer la mise à jour
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/dist/php/updatecustomerclass.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Mise à jour réussie, actualisez la page
                window.location.reload();
            } else {
                // Gérer les cas d'erreur ici, si nécessaire
            }
        }
    };

    // Utilisez l'ID du client pour récupérer les valeurs mises à jour
    xhr.send('customerId=' + customerId + '&lastname=' + editedLastName + '&firstname=' + editedFirstName + '&mail=' + editedMail + '&name=' + editedName + '&breed=' + editedBreed);
}
