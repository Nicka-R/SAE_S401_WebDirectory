class Personne {
  final String id;
  final String nom;
  final String prenom;
  final String mail;
  final String numBureau;
  final String img;
  final int statut;
  final List<String> departements;
  final List<String> services;
  final List<String> numeros;

  Personne({
    required this.id,
    required this.nom,
    required this.prenom,
    required this.mail,
    required this.numBureau,
    required this.img,
    required this.statut,
    required this.departements,
    required this.services,
    required this.numeros,
  });

//   factory Personne.fromJson(Map<String, dynamic> json) {
//     return switch (json) {
//       {
//         'id': String id,
//         'nom': String nom,
//         'prenom': String prenom,
//         'num_bureau': String numBureau,
//         'mail': String mail,
//         'img': String img,
//         'departement': String departement,
//       } =>
//         Personne(
//           id: id,
//           nom: nom,
//           prenom: prenom,
//           mail: mail,
//           numBureau: numBureau,
//           img: img,
//           departement: departement,
//         ),
//       _ => throw const FormatException('Erreur de chargement dune personne'),
//     };
// }
}