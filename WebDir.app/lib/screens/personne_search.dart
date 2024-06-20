import 'package:flutter/material.dart';
import 'package:web_directory/models/personne.dart';
import 'package:web_directory/screens/personne_preview.dart';

/// Widget qui permet de rechercher une personne
class PersonneSearchDelegate extends SearchDelegate<List<Personne>> {
  final List<Personne> personnes;

  PersonneSearchDelegate(this.personnes);

  @override
  List<Widget> buildActions(BuildContext context) { /// icone de suppression
    return [
      IconButton(
        icon: const Icon(Icons.clear),
        onPressed: () {
          query = '';
        },
      ),
    ];
  }

  @override
  Widget buildLeading(BuildContext context) { /// icone de retour
    return IconButton(
      icon: const Icon(Icons.arrow_back),
      onPressed: () {
        close(context, []);
      },
    );
  }

  @override
  Widget buildResults(BuildContext context) { /// affichage des resultats
    final List<Personne> results = personnes
        .where((personne) => personne.nom.toLowerCase().contains(query.toLowerCase()))
        .toList();

    return ListView(
      children: results.map((personne) => GestureDetector( /// affichage de la personne recherchée
        child: PersonnePreview(personne: personne))).toList(),
    );
  }

  @override
  Widget buildSuggestions(BuildContext context) { /// affichage des suggestions
    final List<Personne> suggestionList = query.isEmpty ? []
        : personnes
            .where((personne) => personne.nom.toLowerCase().contains(query.toLowerCase()))
            .toList();

    return ListView(
      children: suggestionList.map((personne) => GestureDetector( /// affichage de la suggestion recherchée
        child: PersonnePreview(personne: personne))).toList()
    );
  }
}
