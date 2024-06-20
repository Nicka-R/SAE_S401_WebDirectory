import Handlebars from 'handlebars';
import {filterEmployees} from './js/SearchFilter.js';
import {showDynamicSelect} from './js/DynamicSelect.js';
import {apiBaseUrl} from './js/config.js';
import {fetchEntry} from './js/DirectoryApp.js';

document.addEventListener('DOMContentLoaded', function() {
    
    let currentSortType = '';

    document.querySelector('.searchInput').addEventListener('keyup', function(event) {
        const searchInput = event.target.value.trim();
        if (searchInput === '') {
            fetchEntry(currentSortType);
        } else {
            filterEmployees(searchInput);
        }
    });

    document.querySelectorAll('.option').forEach(option => {
        option.addEventListener('click', function() {
            const dynamicSelectContainer = document.querySelector('.dynamic-select-container');
            const selectBase = document.getElementById('classActive');
            const selectDynamic = document.getElementById('classActive2');
            const input = document.querySelector('.searchInput');
            const sortValue = option.dataset.sort;
            if (sortValue !== 'service' && sortValue !== 'departement') {
                const existingSelectContainer = document.querySelector('.dynamic-select-container .select-container');
                if (existingSelectContainer) {
                    dynamicSelectContainer.removeChild(existingSelectContainer);
                    selectBase.classList.remove('activeClass');
                    selectDynamic.classList.remove('activeClass2');
                }
            }

            if (sortValue === 'ascendant') {
                fetchEntry('/api/entrees?sort=nom-asc');
                currentSortType = '/api/entrees?sort=nom-asc';
            } else if (sortValue === 'descendant') {
                fetchEntry('/api/entrees?sort=nom-desc');
                currentSortType = '/api/entrees?sort=nom-desc';
            } else if (sortValue === 'service' || sortValue === 'departement') {
                showDynamicSelect(sortValue);
            } else {
                fetchEntry();
                currentSortType = '';
            }

            input.value = '';
        });
    });

    const menuItems = document.querySelectorAll('.dropdown-menu li');

    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            menuItems.forEach(menuItem => {
                menuItem.classList.remove('active');
            });
            item.classList.add('active');
        });
    });

    const departmentsLink = document.getElementById('departments-link');
    const servicesLink = document.getElementById('services-link');
    const departmentsContainer = document.getElementById('departments-container');
    const servicesContainer = document.getElementById('services-container');
    const departmentsList = document.getElementById('departments-list');
    const servicesList = document.getElementById('services-list');

    departmentsLink.addEventListener('click', function() {
        if (departmentsContainer.style.display === 'block') {
            departmentsContainer.style.display = 'none';
            departmentsLink.classList.remove('active'); 
        } else {
            fetch(`${apiBaseUrl}/api/departements`)
                .then(response => response.json())
                .then(data => {
                    departmentsList.innerHTML = '';
                    data.forEach(department => {
                        const li = document.createElement('li');
                        li.textContent = department.libelle;
                        departmentsList.appendChild(li);
                    });
                    departmentsContainer.style.display = 'block';
                    servicesContainer.style.display = 'none';
                    departmentsLink.classList.add('active'); 
                    servicesLink.classList.remove('active'); 
                })
                .catch(error => console.error('Erreur:', error));
        }
    });
    

    servicesLink.addEventListener('click', function() {
        if (servicesContainer.style.display === 'block') {
            servicesContainer.style.display = 'none';
            servicesLink.classList.remove('active'); 
        } else {
            fetch(`${apiBaseUrl}/api/services`)
                .then(response => response.json())
                .then(data => {
                    servicesList.innerHTML = '';
                    data.forEach(service => {
                        const li = document.createElement('li');
                        li.textContent = service.libelle;
                        servicesList.appendChild(li);
                    });
                    servicesContainer.style.display = 'block';
                    departmentsContainer.style.display = 'none';
                    servicesLink.classList.add('active'); 
                    departmentsLink.classList.remove('active'); 
                })
                .catch(error => console.error('Erreur:', error));
        }
    });
    

    fetchEntry();

});
