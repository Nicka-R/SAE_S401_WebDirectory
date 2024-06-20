import 'dart:convert';
import 'package:web_directory/models/numero.dart';
import 'package:http/http.dart' as http;
import 'package:web_directory/models/personne.dart';

class PersonneService {
  final List<Personne> _personnes = [];
  List<Personne> get personnes => _personnes;

  final List<String> _departements = [];
  List<String> get departements => _departements;

  final List<String> _services = [];
  List<String> get services => _services;

  final List<Numero> _numeros = []; // Utilisation de List<Numero>
  List<Numero> get numeros => _numeros;

  Future<void> fetchPersonnes() async {
    try {
      final response = await http.get(Uri.parse('http://docketu.iutnc.univ-lorraine.fr:42190/api/entrees'));

      if (response.statusCode == 200) {
        List<dynamic> data = json.decode(response.body);
        var liens = data.map((personneData) {
          return {
            'href': personneData['links']['self']['href'],
          };
        }).toList();

        List<Future<void>> fetchDetailsFutures = liens.map((lienData) async {
          final response = await http.get(Uri.parse('http://docketu.iutnc.univ-lorraine.fr:42190${lienData['href']}'));
          if (response.statusCode == 200) {
            final personneData = json.decode(response.body);

            List<String> departements = [];
            if (personneData['departement'] is List && personneData['departement'].isNotEmpty) {
              departements = (personneData['departement'] as List)
                  .map((dep) => dep['libelle'].toString())
                  .toList();
            } else {
              departements = ['Inconnu'];
            }

            List<String> services = [];
            if (personneData['service'] is List && personneData['service'].isNotEmpty) {
              services = (personneData['service'] as List)
                  .map((serv) => serv['libelle'].toString())
                  .toList();
            } else {
              services = ['Inconnu'];
            }

            List<Numero> numeros = [];
            if (personneData['numero'] is List && personneData['numero'].isNotEmpty) {
              numeros = (personneData['numero'] as List)
                  .map((numero) => Numero.fromJson(numero))
                  .toList();
            } else {
              numeros = [Numero(libelle: "Mobile", numero: 'Inconnu')];
            }

            _personnes.add(Personne(
              id: personneData['id'],
              nom: personneData['nom'],
              prenom: personneData['prenom'],
              mail: personneData['mail'],
              numBureau: personneData['num_bureau'],
              img: personneData['img'] ?? 'Inconnu',
              statut: personneData['statut'] ?? 0,
              departements: departements,
              services: services,
              numeros: numeros,
            ));

            departements.forEach((dep) {
              if (!_departements.contains(dep)) {
                _departements.add(dep);
              }
            });

            services.forEach((serv) {
              if (!_services.contains(serv)) {
                _services.add(serv);
              }
            });

            numeros.forEach((numero) {
              if (!_numeros.contains(numero)) {
                _numeros.add(numero);
              }
            });
          } else {
            throw Exception('Impossible de récupérer les détails pour ${lienData['href']}');
          }
        }).toList();

        await Future.wait(fetchDetailsFutures);
        _personnes.sort((a, b) => a.nom.compareTo(b.nom));
      } else {
        throw Exception('Impossible de récupérer les entrées');
      }
    } catch (error) {
      throw Exception('Erreur lors de la récupération des personnes: $error');
    }
  }
}
