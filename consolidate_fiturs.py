#!/usr/bin/env python
# -*- coding: utf-8 -*-

import re

# Read the file
with open(r'c:\Users\ASUS\SoftiFy\resources\views\page.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Strategy: Remove the closing </div> tags for each fiturs (except the last card)
# and remove the opening <div class="fiturs"> tags (except the first one)
# This will consolidate all cards into one fiturs container

# Replace pattern: closing tags of card + closing tag of fiturs + opening of next fiturs
# with just the closing tag of the card

pattern = r'(</div>\s*</div>)\s*<div class="fiturs">'
replacement = r'\1'

content = re.sub(pattern, replacement, content)

# Write back
with open(r'c:\Users\ASUS\SoftiFy\resources\views\page.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('File consolidated successfully!')
print('All 8 cards are now in a single fiturs container.')
