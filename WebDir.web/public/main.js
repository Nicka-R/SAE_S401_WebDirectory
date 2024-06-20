import Handlebars from 'handlebars';

document.addEventListener('DOMContentLoaded', function() {
    const apiBaseUrl = 'http://docketu.iutnc.univ-lorraine.fr:42190';
    let currentSortType = '';
    let directoryData = []; 

    function fetchEntry(sortUrl = '') {
        let url = apiBaseUrl + '/api/entrees'; 
    

        if (sortUrl && typeof sortUrl === 'string') {
            url = apiBaseUrl + sortUrl;
        }
    
        fetch(url)
            .then(response => response.json())
            .then(data => {
                directoryData = data; 
                console.log(directoryData);  
                renderDirectory(data);
            })
            .catch(error => console.error('Erreur:', error));
            
            
         
    }
    

    function renderDirectory(directory) {
        const directoryList = document.querySelector('.employee-grid');
        const source = document.getElementById('directory-template').innerHTML;
        const template = Handlebars.compile(source);
        const context = { directory };
        const html = template(context);
        directoryList.innerHTML = html;

    
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
            fetchEntry(currentSortType); 
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

    document.querySelectorAll('.option').forEach(option => {
        option.addEventListener('click', function() {
            const dynamicSelectContainer = document.querySelector('.dynamic-select-container');
            const selectBase = document.getElementById('classActive');
            const selectDynamic = document.getElementById('classActive2');
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
        });
    });
    

    function showDynamicSelect(type) {
        const dynamicSelectContainer = document.querySelector('.dynamic-select-container');
    
        // Vérifier si le select existe déjà, le supprimer s'il existe
        const existingSelectContainer = document.querySelector('.dynamic-select-container .select-container');
        if (existingSelectContainer) {
            dynamicSelectContainer.removeChild(existingSelectContainer);
        }
    
        // Créer un nouvel élément select-container
        const newSelectContainer = document.createElement('div');
        newSelectContainer.classList.add('select-container');
        const selectBase = document.getElementById('classActive');
        const selectDynamic = document.getElementById('classActive2');
    
        const newSelect = document.createElement('div');
        newSelect.classList.add('select');
        newSelect.innerHTML = '<input type="text" id="input" placeholder="Options" onfocus="this.blur();">';
    
        const newOptionContainer = document.createElement('div');
        newOptionContainer.classList.add('option-container');
    
        // Remplir le select en fonction du type (département ou service)
        if (type === 'departement') {
            fetch(`${apiBaseUrl}/api/departements`)
                .then(response => response.json())
                .then(data => populateOptions(newOptionContainer, data))
                .then(() => addDynamicSelectEventListeners(newSelectContainer, 'departement'))
                .catch(error => console.error('Erreur:', error));
        } else if (type === 'service') {
            fetch(`${apiBaseUrl}/api/services`)
                .then(response => response.json())
                .then(data => populateOptions(newOptionContainer, data))
                .then(() => addDynamicSelectEventListeners(newSelectContainer, 'service')) 
                .catch(error => console.error('Erreur:', error));
        }
    
        
        newSelectContainer.appendChild(newSelect);
        newSelectContainer.appendChild(newOptionContainer);

        selectBase.classList.add('activeClass');
        selectDynamic.classList.add('activeClass2');
    
        dynamicSelectContainer.appendChild(newSelectContainer);
    }

    function populateOptions(optionContainer, data) {
        data.forEach(item => {
            const option = document.createElement('div');
            option.classList.add('option');
            option.dataset.sort = item.libelle;
            option.innerHTML = `<label>${item.libelle}</label>`;
            optionContainer.appendChild(option);
        });
    }

    document.querySelector('.departement-option').addEventListener('click', function() {
        getDepartement();
        showDynamicSelect('departement');
    });

    document.querySelector('.service-option').addEventListener('click', function() {
        getServices();
        showDynamicSelect('service');
    });

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

    function filterEmployeesByService(service) {
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

    function addDynamicSelectEventListeners(selectContainer, type) {
        const select = selectContainer.querySelector('.select');
        const input = selectContainer.querySelector('#input');
        const options = selectContainer.querySelectorAll('.option');

        select.onclick = () => {
            selectContainer.classList.toggle("active");
        };

        options.forEach((option) => {
            option.addEventListener("click", () => {
                const selectedOption = option.dataset.sort;
                console.log(selectedOption);
                if (type === 'departement') {
                    filterEmployeesByDepartment(selectedOption);
                } else if (type === 'service') {
                    filterEmployeesByService(selectedOption);
                }
                input.value = option.innerText;
                selectContainer.classList.remove("active");
                options.forEach((opt) => {
                    opt.classList.remove("selected");
                });
                option.classList.add("selected");
            });
        });
    }

    fetchEntry();

});
