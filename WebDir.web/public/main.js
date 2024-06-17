import Handlebars from 'handlebars';

document.addEventListener('DOMContentLoaded', function() {
    const apiBaseUrl = 'http://docketu.iutnc.univ-lorraine.fr:42190';

    // Définir un helper Handlebars pour l'index
    Handlebars.registerHelper('incrementIndex', function(value) {
        return parseInt(value) + 1;
    });

    function fetchDirectory() {
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
    }

    // Fonction pour trier les données par ordre alphabétique
    function sortDirectoryData(order = 'asc') {
        const sortParam = order === 'asc' ? 'nom-asc' : 'nom-desc';
        fetch(`${apiBaseUrl}/api/entrees?sort=${sortParam}`)
            .then(response => response.json())
            .then(data => renderDirectory(data))
            .catch(error => console.error('Erreur:', error));
    }

    // Filtrer la liste par département
    function filterByDepartment(department) {
        fetch(`${apiBaseUrl}/api/entrees/search?critere=department:${department}`)
            .then(response => response.json())
            .then(data => renderDirectory(data))
            .catch(error => console.error('Erreur:', error));
    }

    // Rechercher une entrée par nom
    function searchByName(name) {
        fetch(`${apiBaseUrl}/api/entrees/search?critere=nom:${name}`)
            .then(response => response.json())
            .then(data => renderDirectory(data))
            .catch(error => console.error('Erreur:', error));
    }

    // Gestionnaire d'événements pour la recherche
    document.querySelector('.search button').addEventListener('click', function() {
        const searchInput = document.querySelector('.searchInput').value;
        searchByName(searchInput);
    });

    // Appeler la fonction pour afficher les données au chargement de la page
    fetchDirectory();
});
