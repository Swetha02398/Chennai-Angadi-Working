$files = Get-ChildItem -Path "c:\xampp\htdocs\chennais\adminpanel\public\uploads\Sliders" -File
Add-Type -AssemblyName System.Drawing
foreach ($file in $files) {
    if ($file.Extension -match "\.(jpg|jpeg|png|gif)$") {
        $img = [System.Drawing.Image]::FromFile($file.FullName)
        Write-Output "$($file.Name): $($img.Width)x$($img.Height)"
        $img.Dispose()
    }
}
