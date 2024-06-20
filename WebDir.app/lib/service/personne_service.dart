import 'dart:convert';
import 'package:web_directory/models/numero.dart';
import 'package:http/http.dart' as http;
import 'package:web_directory/models/personne.dart';

/// Service qui permet de récupérer les personnes
class PersonneService {
  final List<Personne> _personnes = []; /// liste des personnes
  List<Personne> get personnes => _personnes;

  final List<String> _departements = []; /// liste des départements
  List<String> get departements => _departements;

  final List<String> _services = []; /// liste des services
  List<String> get services => _services;

  final List<Numero> _numeros = []; /// liste des numéros
  List<Numero> get numeros => _numeros;

  Future<void> fetchPersonnes() async {
    try {
      /// Récupération des entrées depuis l'api
      final response = await http.get(Uri.parse('http://docketu.iutnc.univ-lorraine.fr:42190/api/entrees'));

      if (response.statusCode == 200) {
        List<dynamic> data = json.decode(response.body);
        /// Récupération des liens vers les détails d'une personne
        var liens = data.map((personneData) {
          return {
            'href': personneData['links']['self']['href'],
          };
        }).toList();

        List<Future<void>> fetchDetailsFutures = liens.map((lienData) async {
          final response = await http.get(Uri.parse('http://docketu.iutnc.univ-lorraine.fr:42190${lienData['href']}'));
          if (response.statusCode == 200) {
            final personneData = json.decode(response.body);

            List<String> departements = []; /// Incrémentation de la liste des départements pour la création d'une personne
            if (personneData['departement'] is List && personneData['departement'].isNotEmpty) {
              departements = (personneData['departement'] as List)
                  .map((dep) => dep['libelle'].toString())
                  .toList();
            } else {
              departements = ['Inconnu'];
            }

            List<String> services = []; /// Incrémentation de la liste des services pour la création d'une personne
            if (personneData['service'] is List && personneData['service'].isNotEmpty) {
              services = (personneData['service'] as List)
                  .map((serv) => serv['libelle'].toString())
                  .toList();
            } else {
              services = ['Inconnu'];
            }

            List<Numero> numeros = []; /// Incrémentation de la liste des numéros pour la création d'une personne
            if (personneData['numero'] is List && personneData['numero'].isNotEmpty) {
              numeros = (personneData['numero'] as List)
                  .map((numero) => Numero.fromJson(numero))
                  .toList();
            } else {
              numeros = [Numero(libelle: "Mobile", numero: 'Inconnu')];
            }

            
            String img = personneData['img'] != null ? 'http://docketu.iutnc.univ-lorraine.fr:42190/api/images/${personneData['img']}'
              : 'assets/images/icon.png';
              
            /// Ajout de la personne à la liste des personnes
            _personnes.add(Personne(
              id: personneData['id'],
              nom: personneData['nom'],
              prenom: personneData['prenom'],
              mail: personneData['mail'],
              numBureau: personneData['num_bureau'],
              img: img,
              statut: personneData['statut'] ?? 0,
              departements: departements,
              services: services,
              numeros: numeros,
            ));

            departements.forEach((dep) { /// Incrémentation l'attribut liste des départements
              if (!_departements.contains(dep)) {
                _departements.add(dep);
              }
            });

            services.forEach((serv) { /// Incrémentation l'attribut liste des services
              if (!_services.contains(serv)) {
                _services.add(serv);
              }
            });

            numeros.forEach((numero) { /// Incrémentation l'attribut liste des numéros
              if (!_numeros.contains(numero)) {
                _numeros.add(numero);
              }
            });
          } else {
            throw Exception('Impossible de récupérer les détails pour ${lienData['href']}');
          }
        }).toList();

        await Future.wait(fetchDetailsFutures); /// Attente de la fin de la récupération des détails des personnes        
        _personnes.sort((a, b) => a.nom.compareTo(b.nom)); /// Tri des personnes par ordre alphabétique sur le nom de base
      } else {
        throw Exception('Impossible de récupérer les entrées');
      }
    } catch (error) {
      throw Exception('Erreur lors de la récupération des personnes: $error');
    }
  }
}
