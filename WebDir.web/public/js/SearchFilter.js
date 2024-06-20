import { renderDirectory, directoryData } from './DirectoryApp.js';


function filterEmployeesByDepartment(departmentOrService) {
    const filteredData = directoryData.filter(employee => {
        for (let i = 0; i < employee.departement.length; i++) {
            if (employee.departement[i].libelle.toLowerCase() === departmentOrService.toLowerCase()) {
                return true;
            }
        }
        return false;
    });

    renderDirectory(filteredData);
}

function filterEmployeesByService(departmentOrService) {
    const filteredData = directoryData.filter(employee => {
        for (let i = 0; i < employee.service.length; i++) {
            if (employee.service[i].libelle.toLowerCase() === departmentOrService.toLowerCase()) {
                return true;
            }
        }
        return false;
    });

    renderDirectory(filteredData);
}

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

export { filterEmployeesByDepartment, filterEmployeesByService, filterEmployees};