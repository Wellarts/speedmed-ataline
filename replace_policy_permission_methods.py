from pathlib import Path

policy_dir = Path('app/Policies')
for policy_file in policy_dir.glob('*.php'):
    text = policy_file.read_text(encoding='utf-8')
    if 'hasPermissionTo(' in text:
        new_text = text.replace('hasPermissionTo(', 'checkPermissionTo(')
        if new_text != text:
            policy_file.write_text(new_text, encoding='utf-8')
            print(f'Updated {policy_file}')
print('Done')
