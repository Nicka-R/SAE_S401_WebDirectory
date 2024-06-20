import 'package:web_directory/screens/personne_master.dart';
import 'package:flutter/material.dart';

class WebDirectoryApp extends StatefulWidget {
  const WebDirectoryApp({super.key});

  @override
  State<WebDirectoryApp> createState() => _WebDirectoryAppState();
}

class _WebDirectoryAppState extends State<WebDirectoryApp> {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      theme: ThemeData(
        scaffoldBackgroundColor: const Color(0xFFEFF0F3),
        appBarTheme: const AppBarTheme(
          backgroundColor : Color(0xFFb8c1ec),
        ),
      ),
      title: 'Web Directory App',
      home: Scaffold(
        appBar: AppBar(
          title: const Center(child: Text('Web Directory',
          style: TextStyle(
            color: Color(0xFF0d0d0d),
            fontFamily: 'ProximaNova-Bold',
            fontSize: 30,))),
        ),
        body: const PersonneMaster(), 
        ),
      );
  }
}
 
