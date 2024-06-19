import Handlebars from 'handlebars';

document.addEventListener('DOMContentLoaded', function() {
    const apiBaseUrl = 'http://docketu.iutnc.univ-lorraine.fr:42190';

    function fetchEntry() {
        fetch(`${apiBaseUrl}/api/entrees`)
            .then(response => response.json())
            .then(data => renderDirectory(data))
            .catch(error => console.error('Erreur:', error));
    }

    function renderDirectory(directory) {
        const directoryList = document.querySelector('.employee-grid');
        const source = document.getElementById('directory-template').innerHTML;
        const template = Handlebars.compile(source);
        const context = { directory };
        const html = template(context);
        directoryList.innerHTML = html;

        // Add click event listeners
        document.querySelectorAll('.employee-card').forEach(function(card) {
            card.addEventListener('click', function() {
                const uuid = card.getAttribute('data-uuid');
                fetchDetails(uuid);
            });
        });
    }

    function fetchDetails(uuid) {
        fetch(`${apiBaseUrl}${uuid}`)
            .then(response => response.json())
            .then(data => renderDetails(data))
            .catch(error => console.error('Erreur:', error));
    }

    function renderDetails(details) {
        const detailsDiv = document.querySelector('.employee-details');
        const source = document.getElementById('details-template').innerHTML;
        const template = Handlebars.compile(source);
        const context = { details };
        const html = template(context);
        detailsDiv.innerHTML = html;
        document.querySelector('.container').classList.add('details-visible');
        document.querySelector('.close-button').addEventListener('click', function() {
            detailsDiv.innerHTML = '';
            document.querySelector('.container').classList.remove('details-visible');
        });
    }

    function getDepartement() {
        fetch(`${apiBaseUrl}/api/departements`)
            .then(response => response.json())
            .catch(error => console.error('Erreur:', error));
    }


    function getServices() {
        fetch(`${apiBaseUrl}/api/services`)
            .then(response => response.json())
            .catch(error => console.error('Erreur:', error));
    }

    document.querySelector('.searchInput').addEventListener('keyup', function(event) {
        const searchInput = event.target.value.trim();
        if (searchInput === '') {
            fetchEntry();
        } else {
            filterEmployees(searchInput);
        }
    });

    function filterEmployees(searchInput) {
        const cards = document.querySelectorAll('.employee-card');
        const searchTerm = searchInput.toLowerCase().trim();

        cards.forEach(card => {
            const textContent = card.textContent.toLowerCase();
            if (textContent.includes(searchTerm)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    document.querySelector('.departement-option').addEventListener('click', function() {
        getDepartement();
        showDynamicSelect('departement');
    });

    // Écouteur pour le clic sur Service
    document.querySelector('.service-option').addEventListener('click', function() {
        getServices();
        showDynamicSelect('service');
    });

    function showDynamicSelect(type) {
        const dynamicSelectContainer = document.querySelector('.dynamic-select-container');
    
        // Vérifier si le select existe déjà, le supprimer s'il existe
        const existingSelect = document.querySelector('.new-select');
        if (existingSelect) {
            dynamicSelectContainer.removeChild(existingSelect);
        }
    
        // Créer un nouvel élément select
        const newSelect = document.createElement('select');
        newSelect.classList.add('new-select');
        newSelect.addEventListener('change', function() {
            const selectedValue = this.value;
            // Vérifier si la valeur sélectionnée est valide
            if (selectedValue === 'departement' || selectedValue === 'service') {
                // Faire quelque chose avec la valeur sélectionnée
                console.log('Selected value:', selectedValue);
            } else {
                // Si la valeur sélectionnée n'est pas valide, ne rien faire ou gérer l'erreur
                console.error('Invalid selection:', selectedValue);
                return; // Sortir de la fonction si la sélection n'est pas valide
            }
        });
    
        // Remplir le select en fonction du type (département ou service)
        if (type === 'departement') {
            fetch(`${apiBaseUrl}/api/departements`)
                .then(response => response.json())
                .then(data => populateSelect(newSelect, data))
                .catch(error => console.error('Erreur:', error));
        } else if (type === 'service') {
            fetch(`${apiBaseUrl}/api/services`)
                .then(response => response.json())
                .then(data => populateSelect(newSelect, data))
                .catch(error => console.error('Erreur:', error));
        }
    
        // Ajouter le nouveau select à la div .dynamic-select-container
        dynamicSelectContainer.appendChild(newSelect);
    }
    

    function populateSelect(selectElement, data) {
        // Créer les options à partir des données reçues
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.libelle;
            option.textContent = item.libelle;
            selectElement.appendChild(option);
        });
    }


    fetchEntry();
});