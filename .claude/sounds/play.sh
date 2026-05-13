#!/bin/bash
sounds_dir=".claude/sounds"
f=$(ls "$sounds_dir"/*.mp3 2>/dev/null | shuf -n1)
[ -n "$f" ] || exit 0
wpath=$(wslpath -w "$f")
powershell.exe -c "Add-Type -AssemblyName presentationCore; \$p = New-Object System.Windows.Media.MediaPlayer; \$p.Open([uri]'$wpath'); \$p.Volume = 1; \$p.Play(); Start-Sleep 2" 2>/dev/null || true
