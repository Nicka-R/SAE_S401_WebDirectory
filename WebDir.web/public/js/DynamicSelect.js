import { filterEmployeesByDepartment, filterEmployeesByService } from './SearchFilter.js';
import { apiBaseUrl } from './config.js';

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


function showDynamicSelect(type) {
    const dynamicSelectContainer = document.querySelector('.dynamic-select-container');

    const existingSelectContainer = document.querySelector('.dynamic-select-container .select-container');
    if (existingSelectContainer) {
        dynamicSelectContainer.removeChild(existingSelectContainer);
    }

    const newSelectContainer = document.createElement('div');
    newSelectContainer.classList.add('select-container');
    const selectBase = document.getElementById('classActive');
    const selectDynamic = document.getElementById('classActive2');

    const newSelect = document.createElement('div');
    newSelect.classList.add('select');
    newSelect.innerHTML = '<input type="text" id="input" placeholder="Options" onfocus="this.blur();">';

    const newOptionContainer = document.createElement('div');
    newOptionContainer.classList.add('option-container');

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

export { addDynamicSelectEventListeners, showDynamicSelect, populateOptions };