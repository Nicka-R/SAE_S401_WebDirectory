import 'package:flutter/material.dart';

class FilterDepartement extends StatelessWidget {
  final String? selectedDepartement;
  final List<String> departements;
  final ValueChanged<String?> onChanged;

  const FilterDepartement({super.key, required this.selectedDepartement, required this.departements, required this.onChanged});

  @override
  Widget build(BuildContext context) {
    return DropdownButton<String>(
      hint: const Text('Par departement', style: TextStyle(
        fontSize: 19, 
        color: Color(0xFF2a2a2a),
        fontFamily: 'ProximaNova-Medium',
        )),
      value: selectedDepartement,
      items: [
        const DropdownMenuItem<String>(
          value: 'Tous les departements',
          child: Text('Tous les departements', style: TextStyle(
            fontSize: 17,
            fontFamily: 'ProximaNova-Regular',
            fontWeight: FontWeight.bold
            )),
        ),
        ...departements.map((departement) {
          return DropdownMenuItem<String>(
            value: departement,
            child: Text(departement, style: const TextStyle(
              fontSize: 16,
              fontFamily: 'ProximaNova-Regular'
              )),
          );
        })
      ],
      onChanged: onChanged,
    );
  }
}
