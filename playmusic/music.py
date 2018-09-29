# coding=utf-8

import requests
import re
import os
import sys

headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'}


proxies = {
    'http' : '124.231.50.205:9000',
    'https' : '124.231.50.205:9000',
}


def getVkey(mid):
    url = 'https://c.y.qq.com/base/fcgi-bin/fcg_music_express_mobile3.fcg?g_tk=5381&format=json&inCharset=utf8&outCharset=utf-8&platform=yqq&cid=205361747&songmid=%s&filename=C400%s.m4a&guid=9391879250'
    song_url = url % (mid, mid)
    result = requests.get(song_url, headers=headers, proxies=proxies)
    print(result.text)
    result = re.findall(r'"vkey":"(.*)"', result.text)
    vkey = result[0]
    if vkey == None or len(vkey) == 0:
        song_url = url % ('004a4HGb2jHj1K', '004a4HGb2jHj1K')
        result = requests.get(song_url, headers=headers, proxies=proxies)
        result = re.findall(r'"vkey":"(.*)"', result.text)
        vkey = result[0]
    return vkey


def getMusic(mid, vkey):
    url = 'http://dl.stream.qqmusic.qq.com/M500%s.mp3?vkey=%s&guid=9391879250&fromtag=27'
    if mid and vkey:
        url = url % (mid, vkey)
        return url


param = sys.argv[1]
music = getMusic(param, getVkey(param))
print(music)
