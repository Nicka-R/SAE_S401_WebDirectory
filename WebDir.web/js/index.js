// index.js
var directoryData = [
  { id: 1, name: "Service 1", department: "D\xE9partement 1", description: "Description 1" },
  { id: 2, name: "Service 2", department: "D\xE9partement 2", description: "Description 2" }
  // Ajoutez plus de données fictives si nécessaire
];
function displayDirectoryData() {
  const directoryList = document.getElementById("directory-list");
  directoryData.forEach((entry) => {
    const entryDiv = document.createElement("div");
    entryDiv.innerHTML = `
          <h2>${entry.name}</h2>
          <p>${entry.department}</p>
          <p>${entry.description}</p>
      `;
    directoryList.appendChild(entryDiv);
  });
}
displayDirectoryData();
directoryData.sort((a, b) => a.name.localeCompare(b.name));
function displayDirectoryData(data = directoryData, order = "asc") {
  const directoryList = document.getElementById("directory-list");
  directoryList.innerHTML = "";
  const sortedData = data.sort((a, b) => order === "asc" ? a.name.localeCompare(b.name) : b.name.localeCompare(a.name));
  sortedData.forEach((entry) => {
    const entryDiv = document.createElement("div");
    entryDiv.innerHTML = `
            <h2>${entry.name}</h2>
            <p>${entry.department}</p>
            <p>${entry.description}</p>
            <a href="mailto:${entry.email}">${entry.email}</a>
            ${entry.image ? `<img src="${entry.image}" alt="${entry.name}">` : ""}
        `;
    directoryList.appendChild(entryDiv);
  });
}
//# sourceMappingURL=index.js.map
