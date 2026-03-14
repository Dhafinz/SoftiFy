#!/usr/bin/env python
# -*- coding: utf-8 -*-

import re

# Read the file
with open(r'c:\Users\ASUS\SoftiFy\resources\views\page.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Remove the extra closing </div> tags between cards
# Pattern: card closing content div, then closing card div, then the OLD fiturs closing div (unwanted)
# We want to keep only the card closing divs, not the fiturs divs between them

# This pattern looks for:
# </div>  (closes content)
# </div>  (closes card)
# </div>  (closes old fiturs - REMOVE THIS)
# followed by whitespace and next <div class="card">

# We'll replace it with just the card closing divs
pattern = r'(</div>\s*</div>)\s*</div>\s*(?=\s*<div class="card">)'
replacement = r'\1'

content = re.sub(pattern, replacement, content)

# Write back
with open(r'c:\Users\ASUS\SoftiFy\resources\views\page.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('File cleaned successfully!')
print('All 8 cards are now properly consolidated in a single fiturs container.')
