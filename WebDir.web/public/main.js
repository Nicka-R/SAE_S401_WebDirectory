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

    // Fonction pour trier les données
    function sortDirectoryData(sortBy) {
        let sortParam = '';
        switch (sortBy) {
            case 'asc':
                sortParam = 'nom-asc';
                break;
            case 'desc':
                sortParam = 'nom-desc';
                break;
            case 'departement':
                // Filtre par département
                const selectedDept = document.querySelector('.search .searchInput').value;
                filterByDepartment(selectedDept);
                return; // Sortie anticipée, car filterByDepartment se charge du rendu
            default:
                return; // Pour toute autre sélection, ne rien faire
        }

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

    // Gestionnaire d'événements pour la recherche et le tri
    document.querySelector('.search .searchInput').addEventListener('keyup', function(event) {
        const searchInput = event.target.value;
        searchByName(searchInput);
    });

    document.querySelector('.search .sort-dropdown').addEventListener('change', function(event) {
        const sortBy = event.target.value;
        sortDirectoryData(sortBy);
    });

    // Appeler la fonction pour afficher les données au chargement de la page
    fetchDirectory();
});
