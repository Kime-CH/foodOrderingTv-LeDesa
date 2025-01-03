@echo off
:: Meminta input pesan commit dari pengguna
set /p isiCommit=Masukkan pesan commit: 

:: Menjalankan Git add
git add .

:: Menjalankan Git commit dengan pesan dari input
git commit -m "%isiCommit%"

:: Menjalankan Git push ke branch master
git push -u origin master

:: Menampilkan pesan sukses
echo === Commit Success ===

pause
