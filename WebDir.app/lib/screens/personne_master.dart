import 'package:flutter/material.dart';
import 'package:web_directory/screens/filter_departement.dart';
import 'package:web_directory/screens/filter_service.dart';
import 'package:web_directory/models/personne.dart';
import 'package:web_directory/service/personne_service.dart';
import 'package:web_directory/screens/personne_preview.dart';
import 'package:web_directory/screens/personne_search.dart';

/// Widget principal des personnes
class PersonneMaster extends StatefulWidget {
  const PersonneMaster({super.key});

  @override
  State<PersonneMaster> createState() => _PersonneMasterState();
}

class _PersonneMasterState extends State<PersonneMaster> {
  final PersonneService _personneService = PersonneService();
  String? _selectedDepartement;
  String? _selectedService;
  bool _sortAsc = true; /// ordre de tri
  late Future<void> _chargerDataFuture; /// future final pour charger toutes les données
  List<Personne> _filteredPersonnes = []; /// liste des personnes filtrées

  @override
  void initState() {
    super.initState();
    _chargerDataFuture = _chargerData();
  }

  /// Fonction qui permet de charger les données et appliquer les filtres
  Future<void> _chargerData() async {
    await _personneService.fetchPersonnes();
    _applyFilters();
  }

  /// Fonction qui permet d'appliquer les filtres
  void _applyFilters() {
    List<Personne> filtered = _personneService.personnes;

    /// Filtrer par departement
    if (_selectedDepartement != null && _selectedDepartement != 'Tous les departements') {
      filtered = filtered.where((personne) => personne.departements.contains(_selectedDepartement)).toList();
    }

    /// Filtrer par service
    if (_selectedService != null && _selectedService != 'Tous les services') {
      filtered = filtered.where((personne) => personne.services.contains(_selectedService)).toList();
    }

    /// Trides personnes sur le nom
    filtered.sort((a, b) {
      if (_sortAsc) {
        return a.nom.compareTo(b.nom);
      } else {
        return b.nom.compareTo(a.nom);
      }
    });

    /// Mise a jour de la liste de personnes finale
    setState(() {
      _filteredPersonnes = filtered;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        actions: [
          FutureBuilder<void>(
            future: _chargerDataFuture, /// future pour charger les données
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return const CircularProgressIndicator();
              } else if (snapshot.hasError) {
                return Text('Erreur: ${snapshot.error}');
              } else {
                return Row(
                  children: [
                    /// Widget de filtre sur les départements
                    FilterDepartement(
                      selectedDepartement: _selectedDepartement,
                      departements: _personneService.departements,
                      onChanged: (String? value) {
                        setState(() {
                          _selectedDepartement = value;
                          _applyFilters();
                        });
                      },
                    ),
                    const SizedBox(width: 8),
                    /// Widget de filtre sur les services
                    FilterService(
                      selectedService: _selectedService,
                      services: _personneService.services,
                      onChanged: (String? value) {
                        setState(() {
                          _selectedService = value;
                          _applyFilters();
                        });
                      },
                    ),
                  ],
                );
              }
            },
          ),
          /// Bouton de recherche d'une personne
          IconButton(
            icon: const Icon(Icons.search),
            onPressed: () {
              showSearch(
                context: context,
                delegate: PersonneSearchDelegate(_personneService.personnes),
              );
            },
          ),
        ],
      ),
      body: _filteredPersonnes.isEmpty
          ? const Center(child: Text('Aucune personne trouvée avec les filtres sélectionnés'))
          : ListView(
              children: _filteredPersonnes.map((personne) => PersonnePreview(personne: personne)).toList(),
            ),
      /// Bouton pour trier les personnes
      floatingActionButton: FloatingActionButton(
        onPressed: () {
          setState(() {
            _sortAsc = !_sortAsc;
            _applyFilters();
          });
        },
        child: Icon(_sortAsc ? Icons.arrow_downward : Icons.arrow_upward),
      ),
    );
  }
}
