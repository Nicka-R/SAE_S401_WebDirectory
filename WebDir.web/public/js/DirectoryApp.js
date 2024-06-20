import Handlebars from 'handlebars';
import { apiBaseUrl } from './config.js';

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

export { fetchEntry, renderDirectory, fetchDetails, renderDetails, directoryData};