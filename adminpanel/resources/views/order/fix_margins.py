import os
import re

FILES = [
    r"c:\xampp\htdocs\chennais\adminpanel\resources\views\order\order-view.blade.php",
    r"c:\xampp\htdocs\chennais\adminpanel\resources\views\order\billing-table.blade.php",
    r"c:\xampp\htdocs\chennais\adminpanel\resources\views\order\billing-invoice-modal.blade.php",
]

for filepath in FILES:
    if not os.path.exists(filepath):
        continue
    
    with open(filepath, "r", encoding="utf-8") as f:
        content = f.read()

    # Fix modal max-width (420px -> 360px to tightly hug buttons)
    # 360px handles both buttons smoothly.
    content = re.sub(
        r'style="max-width:\s*420px', 
        r'style="max-width: 360px', 
        content
    )
    content = re.sub(
        r'style="max-width: 420px', 
        r'style="max-width: 360px', 
        content
    )

    # Fix header padding (p-4 -> py-3 px-3)
    # For billing-table
    content = content.replace(
        '<div class="text-center p-4" style="background: linear', 
        '<div class="text-center p-3" style="background: linear'
    )
    # For order-view
    content = content.replace(
        '<div class="text-center py-4" style="background: linear', 
        '<div class="text-center p-3" style="background: linear'
    )

    # Print page margin: 8mm -> 3mm
    content = content.replace('margin: 8mm;', 'margin: 3mm;')
    content = content.replace('margin: 0;', 'margin: 3mm;')

    # Ensure box-sizing border-box in print media
    if '@media print {' in content:
        # we will add box-sizing: border-box to html, body or * selector
        if 'box-sizing: border-box !important;' not in content:
            content = content.replace(
                'background-color: transparent !important;',
                'background-color: transparent !important; box-sizing: border-box !important;'
            )

    # In billing-invoice-modal and order-view, make sure the width of the table doesn't overflow
    if 'width: 100%; border-collapse: collapse; margin-bottom: 0;' in content:
        content = content.replace(
            'width: 100%; border-collapse: collapse; margin-bottom: 0;',
            'width: 100%; border-collapse: collapse; margin-bottom: 0; box-sizing: border-box;'
        )

    with open(filepath, "w", encoding="utf-8") as f:
        f.write(content)

print("Updates applied to views.")
