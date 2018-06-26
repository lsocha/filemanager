gotowy pakiet angularfilemanager

1. Wyedytować ścieżkę do katalogu z plikami w bridges/php-local/index.php oraz w lib/pdf2jpeg.php, src/controllers/main.js basepath.
2. Folder z plikami musi zawierać katalog .pdf-thumbs do przechowywania miniatur podglądu plików pdf.

Po edycji src/templates należy odpalić komendę gulp build z katalogu plugins/ang-fm.

New features:
1. Dodano thumbnails (miniatury) plików obrazów i pdf.
2. Preview for first page of pdf files.
2. Poprawka dla wyświetlania plików "tif".
3. Wyświetlanie podglądu pierwszej strony pdf.
4. Dodano ikonkę obrazu dla obrazów w widoku listy.
5. In the file preview popup added buttons: 'open in new tab', 'download'.
6. File list view changed icons -> image, pdf or other document.
7. Larger icons with more modern layout. 
