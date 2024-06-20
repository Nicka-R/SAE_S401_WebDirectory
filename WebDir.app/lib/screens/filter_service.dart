import 'package:flutter/material.dart';

class FilterService extends StatelessWidget {
  final String? selectedService;
  final List<String> services;
  final ValueChanged<String?> onChanged;

  const FilterService({super.key, required this.selectedService, required this.services, required this.onChanged});

  @override
  Widget build(BuildContext context) {
    return DropdownButton<String>(
      hint: const Text('Par service', style: TextStyle(
        fontSize: 19, 
        color: Color(0xFF2a2a2a),
        fontFamily: 'ProximaNova-Medium',
        )),
      value: selectedService,
      items: [
        const DropdownMenuItem<String>(
          value: 'Tous les services',
          child: Text('Tous les services', style: TextStyle(
            fontSize: 17,
            fontFamily: 'ProximaNova-Regular',
            fontWeight: FontWeight.bold
            )),
        ),
        ...services.map((service) {
          return DropdownMenuItem<String>(
            value: service,
            child: Text(service, style: const TextStyle(
              fontSize: 16,
              fontFamily: 'ProximaNova-Regular',
              ))
          );
        })
      ],
      onChanged: onChanged,
    );
  }
}