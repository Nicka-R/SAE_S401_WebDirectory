import 'package:flutter/material.dart';
import 'package:web_directory/models/personne.dart';
import 'package:web_directory/screens/personne_preview.dart';

class PersonneSearchDelegate extends SearchDelegate<List<Personne>> {
  final List<Personne> personnes;

  PersonneSearchDelegate(this.personnes);

  @override
  List<Widget> buildActions(BuildContext context) {
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
  Widget buildLeading(BuildContext context) {
    return IconButton(
      icon: const Icon(Icons.arrow_back),
      onPressed: () {
        close(context, []);
      },
    );
  }

  @override
  Widget buildResults(BuildContext context) {
    final List<Personne> results = personnes
        .where((personne) => personne.nom.toLowerCase().contains(query.toLowerCase()))
        .toList();

    return ListView.builder(
      itemCount: results.length,
      itemBuilder: (context, index) {
        return GestureDetector(
          child: PersonnePreview(personne: results[index]),
        );
      },
    );
  }

  @override
  Widget buildSuggestions(BuildContext context) {
    final List<Personne> suggestionList = query.isEmpty
        ? []
        : personnes
            .where((personne) => personne.nom.toLowerCase().contains(query.toLowerCase()))
            .toList();

    return ListView.builder(
      itemCount: suggestionList.length,
      itemBuilder: (context, index) {
        return GestureDetector(
          child: PersonnePreview(personne: suggestionList[index]),
        );
      },
    );
  }
}