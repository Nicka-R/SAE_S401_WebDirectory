import 'package:WebDirectory/sreens/personne_master.dart';
import 'package:flutter/material.dart';

class WebDirectoryApp extends StatefulWidget {
  WebDirectoryApp({super.key});

  @override
  State<WebDirectoryApp> createState() => _WebDirectoryAppState();
}

class _WebDirectoryAppState extends State<WebDirectoryApp> {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Material App',
      home: Scaffold(
        appBar: AppBar(
          title: const Text('Web Directory'),
        ),
        body: PersonneMaster(), 
        ),
      );
  }
}
 
