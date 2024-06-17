import 'dart:convert';
import 'package:WebDirectory/models/personne.dart';
import 'package:http/http.dart' as http;

class PersonneService {
  final List<Personne> _personnes = [];
  List<Personne> get personnes => _personnes;

  List<String> services = [];
  List<String> get service => services;

  /// Methode pour récuperer les personnes
  Future<List<Personne>> fetchPersonnes() async {
    try {
      final response = await http.get(Uri.parse('http://docketu.iutnc.univ-lorraine.fr:42190/api/entrees'));

      if (response.statusCode == 200) {
        List<dynamic> data = json.decode(response.body);
        var liens = data.map((personneData) {
          return {
            'href': personneData['links']['self']['href'],
            'departement': personneData['departement'][0]['libelle']
          };
        }).toList();

        for (var lienData in liens) {
          final response = await http.get(Uri.parse('http://docketu.iutnc.univ-lorraine.fr:42190${lienData['href']}'));
          if (response.statusCode == 200) {
            final personneData = json.decode(response.body);
            _personnes.add(Personne(
              id: personneData['id'],
              nom: personneData['nom'],
              prenom: personneData['prenom'],
              mail: personneData['mail'],
              numBureau: personneData['num_bureau'],
              img: personneData['img'],
              departement: lienData['departement'].toString(),
            ));

            _personnes.sort((a, b) {
              int nameComparison = a.nom.compareTo(b.nom);
              if (nameComparison != 0) {
                return nameComparison;
              } else {
                return a.prenom.compareTo(b.prenom);
              }
            });
          } else {
            throw Exception('Impossible de récuperer les détails pour ${lienData['href']}');
          }
        }
        return _personnes;
      } else {
        throw Exception('Impossible de récuperer les entrées');
      }
    } catch (error) {
      throw Exception('Erreur lors de la récupération des personnes: $error');
    }
  }

  /// Methode pour récuperer les services d'une personne
  Future<List<String>> servicesById(String persoId) async {
    List<String> serviceNames = [];
    try {
      final response = await http.get(Uri.parse('http://docketu.iutnc.univ-lorraine.fr:42190/api/services'));
      if (response.statusCode == 200) {
        final services = List<Map<String, dynamic>>.from(json.decode(response.body));
        for (var service in services) {
          final serviceId = service['id'];
          final personneResponse = await http.get(Uri.parse('http://docketu.iutnc.univ-lorraine.fr:42190/api/services/$serviceId/entrees'));
          if (personneResponse.statusCode == 200) {
            final personnes = List<Map<String, dynamic>>.from(json.decode(personneResponse.body));
            for (var personne in personnes) {
              if (personne['id'] == persoId) {
                serviceNames.add(service['libelle'] ?? 'Service inconnu');
              }
            }
          } else {
            throw Exception('Erreur lors de la récupération des personnes pour le service $serviceId: ${personneResponse.statusCode}');
          }
        }
      } else {
        throw Exception('Erreur lors de la récupération des services: ${response.statusCode}');
      }
      return serviceNames;
    } catch (error) {
      throw Exception('Erreur lors de la récupération des services: $error');
    }
  }
}
