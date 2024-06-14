const express = require('express');
const app = express();
const port = process.env.PORT || 3000;

// Définition du dossier des fichiers statiques
app.use(express.static('public'));

app.get('/', (req, res) => {
  res.send('Hello World!');
});

app.listen(port, () => {
  console.log(`App listening at http://localhost:${port}`);
});

