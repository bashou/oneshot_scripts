#!/bin/sh
# Script d'installation NodeJS
# Note: Ce script fonctionne uniquement en environnement Ubuntu/Debian

# Installation des pr<C3><A9>-requis
command apt-get install python build-essential libssl-dev

# Definition des variables 
# SOURCE_URL : Telechargement de la derniere version nodejs
# VERSION : Parse de la version selon le nom du fichier t<C3><A9>l<C3><A9>charg<C3><A9>
VERSION="0.8.12"
SOURCE_URL="http://nodejs.org/dist/v${VERSION}/node-v${VERSION}.tar.gz"

# Telechargement ...
command wget "${SOURCE_URL}" --output-document="/tmp/node.tar.gz"

# Decompression de l'archive telecharg<C3><A9>e
command tar --directory "/tmp" -xzf "/tmp/node.tar.gz"

# Placement dans le bon dossier en prevision de l'installation
command cd "/tmp/node-v${VERSION}"

# Compilation et installation de NodeJS
./configure
command make
command make install

# Sortie du dossier
command cd /usr/local/scripts

# Suppression des fichiers et dossiers temporaires t<C3><A9>l<C3><A9>charg<C3><A9>s
command rm "/tmp/node.tar.gz"
command rm -r "/tmp/node-v${VERSION}"