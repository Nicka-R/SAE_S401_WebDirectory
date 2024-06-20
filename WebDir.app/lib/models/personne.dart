import 'package:web_directory/models/numero.dart';
/// Modèle de gestion d'une personne
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
  final List<Numero> numeros;

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
}