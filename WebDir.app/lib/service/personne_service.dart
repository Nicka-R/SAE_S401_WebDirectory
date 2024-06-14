import 'package:WebDirectory/models/personne.dart';
import 'package:supabase_flutter/supabase_flutter.dart';

class PersonneService {
  List<Personne> _personnes = [];
  List<Personne> get personnes => _personnes;

  /// Methode pour récuperer les personnes
  Future<List<Personne>> fetchPersonnes() async {
    try {
      final data = await Supabase.instance.client.from('personne').select();
      
      _personnes = (data as List<dynamic>).map((personneData) {
        return Personne(
          id: personneData['id'] ?? '',
          nom: personneData['nom'] ?? 'Nom Inconnu',
          prenom: personneData['prenom'] ?? 'Prénom Inconnu',
          mail: personneData['mail'] ?? 'Email Inconnu',
          numBureau: (personneData['numBureau'] != null) ? int.parse(personneData['numBureau'].toString()) : 0,
          img: (personneData['img'] != null) ? personneData['img'] : 'assets/images/person.png',
        );
      }).toList();

      _personnes.sort((a, b) {
        int comparaison = a.nom.compareTo(b.nom);
        if (comparaison != 0) {
          return comparaison;
        } else {
          return a.prenom.compareTo(b.prenom);
        }
      });
      return _personnes;
    } catch (error) {
      throw Exception('Erreur lors de la récupération des personnes: $error');
    }
  }

  /// Methode pour récuperer les services d'une personne
  Future<List<String>> serviceById(String persoId) async {
    try {
      final datas = await Supabase.instance.client
          .from('perso2fonction')
          .select('id_fonction')
          .eq('id_perso', persoId);

      List<String> services = [];
      for (var data in datas) {
        final fonctionId = data['id_fonction'];
        final fonctiondata = await Supabase.instance.client
            .from('fonction')
            .select('id_service')
            .eq('id', fonctionId);  
        final serviceId = fonctiondata[0]['id_service'];
        final servicedata = await Supabase.instance.client
            .from('service')
            .select('libelle')
            .eq('id', serviceId);

        final serviceNom = servicedata[0]['libelle'];
        services.add(serviceNom);
      }
      return services;
    } catch (error) {
      throw Exception('Erreur lors de la récupération des services: $error');
    }
  }

  /// Methode pour récuperer le département d'une personne
  Future<String> departementById(String persoId) async {
    try {
      final datas = await Supabase.instance.client
          .from('perso2dept')
          .select('id_dept')
          .eq('id_perso', persoId);

      final departId = datas[0]['id_dept'];
      final departdata = await Supabase.instance.client
          .from('departement')
          .select('libelle')
          .eq('id', departId);
      
      final departementNom = departdata[0]['libelle'];
      return departementNom;
    } catch (error) {
      throw Exception('Erreur lors de la récupération des départements: $error');
    }
  }
}
