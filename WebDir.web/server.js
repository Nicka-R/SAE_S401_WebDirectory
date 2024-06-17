const express = require('express');
const path = require('path');
const app = express();
const port = process.env.PORT || 3000;

// Définition du dossier des fichiers statiques
app.use(express.static(path.join(__dirname, 'public')));

app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

app.listen(port, () => {
  console.log(`App listening at http://localhost:${port}`);
});

// Données fictives
const directoryData = [
  { id: 1, name: 'Service 1', department: 'Département 1', description: 'Description 1' },
  { id: 2, name: 'Service 2', department: 'Département 2', description: 'Description 2' },
  // Ajoutez plus de données fictives si nécessaire
];

// Exporter les données pour être utilisées par le client si nécessaire
app.get('/api/directory', (req, res) => {
  res.json(directoryData);
});
