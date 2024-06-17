import Handlebars from 'handlebars';

document.addEventListener('DOMContentLoaded', function() {
    const directoryData = [
        { id: 1, name: 'Nino', firstname: 'Arcelin', department: 'Département 1', description: 'Description 1', email: 'nino.arcelin@gmail.com' },
        { id: 2, name: 'Nicka', firstname: 'Ratovobode', department: 'Département 2', description: 'Description 2', email: 'nicka.ratovobodo@gmail.com' },
        // Ajoutez plus de données fictives si nécessaire
    ];

    // Définir un helper Handlebars pour l'index
    Handlebars.registerHelper('incrementIndex', function(value) {
        return parseInt(value) + 1;
    });

    function renderDirectory(directory) {
        const directoryList = document.getElementById('directory-list');
        const source = document.getElementById('directory-template').innerHTML;
        const template = Handlebars.compile(source);
        const context = { directory };
        const html = template(context);
        directoryList.innerHTML = html;
    }

    // Appeler la fonction pour afficher les données
    renderDirectory(directoryData);

    // Fonction pour trier les données par ordre alphabétique
    function sortDirectoryData(order = 'asc') {
        return directoryData.sort((a, b) => order === 'asc' ? a.name.localeCompare(b.name) : b.name.localeCompare(a.name));
    }

    // Filtrer la liste par département
    function filterByDepartment(department) {
        return directoryData.filter(entry => entry.department === department);
    }

    // Rechercher une entrée par nom
    function searchByName(name) {
        return directoryData.filter(entry => entry.name.includes(name));
    }

    // Vous pouvez ajouter des gestionnaires d'événements ici pour utiliser les fonctions de tri, de filtrage et de recherche
});
