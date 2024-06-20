import 'package:web_directory/screens/filter_departement.dart';
import 'package:web_directory/screens/filter_service.dart';
import 'package:flutter/material.dart';
import 'package:web_directory/screens/personne_search.dart';
import 'package:web_directory/models/personne.dart';
import 'package:web_directory/service/personne_service.dart';
import 'package:web_directory/screens/personne_preview.dart';

class PersonneMaster extends StatefulWidget {
  const PersonneMaster({super.key});

  @override
  State<PersonneMaster> createState() => _PersonneMasterState();
}

class _PersonneMasterState extends State<PersonneMaster> {
  final PersonneService _personneService = PersonneService();
  String? _selectedDepartement;
  String? _selectedService;

  late Future<void> _chargerDataFuture;
  List<Personne> _filteredPersonnes = [];

  @override
  void initState() {
    super.initState();
    _chargerDataFuture = _chargerData();
  }

  Future<void> _chargerData() async {
    await _personneService.fetchPersonnes();
    _applyFilters();
  }

  void _applyFilters() {
    List<Personne> filtered = _personneService.personnes;

    if (_selectedDepartement != null && _selectedDepartement != 'Tous les départements') {
      filtered = filtered.where((personne) => personne.departements.contains(_selectedDepartement)).toList();
    }

    if (_selectedService != null && _selectedService != 'Tous les services') {
      filtered = filtered.where((personne) => personne.services.contains(_selectedService)).toList();
    }

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
            future: _chargerDataFuture,
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return const CircularProgressIndicator();
              } else if (snapshot.hasError) {
                return Text('Erreur: ${snapshot.error}');
              } else {
                return Row(
                  children: [
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
      : ListView(children: _filteredPersonnes.map((personne) => PersonnePreview(personne: personne)).toList())
    );
  }
}