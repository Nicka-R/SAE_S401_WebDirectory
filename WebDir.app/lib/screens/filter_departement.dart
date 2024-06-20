import 'package:flutter/material.dart';

/// Widget qui permet de filtrer les personnes leurs departements
class FilterDepartement extends StatefulWidget {
  final String? selectedDepartement;
  final List<String> departements;
  final ValueChanged<String?> onChanged;

  const FilterDepartement({super.key, required this.selectedDepartement, required this.departements, required this.onChanged});

  @override
  State<FilterDepartement> createState() => _FilterDepartementState();
  }

  class _FilterDepartementState extends State<FilterDepartement> {
    @override
  Widget build(BuildContext context) {
    return DropdownButton<String>(
      hint: const Text('Par departement', style: TextStyle(
        fontSize: 19, 
        color: Color(0xFF2a2a2a),
        fontFamily: 'ProximaNova-Medium',
        )),
      value: widget.selectedDepartement,
      items: [
        const DropdownMenuItem<String>(
          value: 'Tous les departements',
          child: Text('Tous les departements', style: TextStyle(
            fontSize: 17,
            fontFamily: 'ProximaNova-Regular',
            fontWeight: FontWeight.bold
            )),
        ),
        ...widget.departements.map((departement) { /// parcours et affichage de la liste des departements
          return DropdownMenuItem<String>(
            value: departement,
            child: Text(departement, style: const TextStyle(
              fontSize: 16,
              fontFamily: 'ProximaNova-Regular'
              )),
          );
        })
      ],
      onChanged: widget.onChanged,
    );
  }
  }
  
  

