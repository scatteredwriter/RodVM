import re
import requests

resp = requests.get('http://jwzx.cqu.pt/kebiao/index.php')
resp = resp.text
result = re.findall(
    r'(<div id="kbTabs-bj".+)<div id="kbTabs-kc"', resp, re.RegexFlag.DOTALL)
print(result[0])
