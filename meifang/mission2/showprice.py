from multiprocessing import Process
from bs4 import BeautifulSoup
import requests
import re
import json
import os

#
#1.使用之前需要在主机中安装Python3和以下Python模块：beautifulsoup4 lxml requests 。
#Python模块安装方法
#在终端中输入：pip install 模块名 ，如：pip install beautifulsoup4 。
#注：确保Python版本为Python3；有些系统Python3的pip为pip3，根据情况输入。
#2.确保Python3的命令名为python3
#如果不是python3或为其他请到showcompare.php文件的load_data()函数中修改“shell_exec('python3 showprice.py');”这一行，否则php脚本无法运行。
#
comparelist = []
errorinfo = []
path = os.path.dirname(os.path.realpath(__file__))


class Compare:
    title = ''
    meifangprice = '待定'
    wofangprice = '待定'
    pinfangprice = '待定'
    hainanfzprice = '待定'

    def compare(self):
        try:
            result = False
            for i in range(3):
                otherprice = ''
                if i == 0:
                    otherprice = self.wofangprice
                elif i == 1:
                    otherprice = self.pinfangprice
                elif i == 2:
                    otherprice = self.hainanfzprice
                if(self.meifangprice == '待定' or otherprice == '待定'):
                    continue
                elif(int(self.meifangprice) > int(otherprice)):
                    result = True
            return result
        except:
            errorinfo.append(self.__dict__)
            return False


def getwofanginfo():
    '爬取我房网数据'
    wofanginfo = {}
    for i in range(201):
        try:
            url = 'http://www.wofang.com/building/p/%i/'
            html = requests.get(url % i)
            soup = BeautifulSoup(html.text, 'lxml')
            ul = soup.body.find('div', class_='m').ul
            for li in ul.find_all('li'):
                title = li.find('div', class_='title').a.get_text()
                price = li.find(
                    'div', class_='price').p.get_text()[1:-3]
                pattern = re.compile(r'无报价.+')
                price = pattern.sub(r'待定', price)
                # if('-' in price):
                #     print(title + ':' + price)
                wofanginfo[title] = price
        except:
            pass
    file_ = open(path + '/wofanginfo.txt', 'w', encoding='utf-8')
    file_.write(json.dumps(wofanginfo, ensure_ascii=False))
    file_.close()


def getpinfanginfo():
    '爬取品房网数据'
    pinfanginfo = {}
    for i in range(130):
        try:
            url = 'http://www.pinfangw.com/property.html?page=%i'
            html = requests.get(url % i)
            soup = BeautifulSoup(html.text, 'lxml')
            ul = soup.body.find('div', class_='newl-list').ul
            for li in ul.find_all('li'):
                tit = li.find('div', class_='newl-list-box').find('div',
                                                                  class_='newl-list-con').find('div', class_='newl-list-tit')
                title = tit.find(
                    'div', class_='newl-list-titname').a.get_text().replace('\t', '')
                price = str(tit.find(
                    'div', class_='newl-list-titnote').contents[1].string).replace('\n', '')
                # if('-' in price):
                #     print(title + ':' + price)
                pinfanginfo[title] = price
        except:
            pass
    file_ = open(path + '/pinfanginfo.txt', 'w', encoding='utf-8')
    file_.write(json.dumps(pinfanginfo, ensure_ascii=False))
    file_.close()


def gethainanfzinfo():
    '爬取旅居网数据'
    hainanfzinfo = {}
    for i in range(1, 116):
        try:
            url = 'http://www.hainanfz.com/house/y%i.html'
            html = requests.get(url % i)
            soup = BeautifulSoup(html.text, 'lxml')
            hitab = soup.body.find('div', class_='hiTab houseListA')
            houselists = hitab.find_all('div', class_='houseListItem')
            for houselist in houselists:
                dl = houselist.find('dl', class_='hiName')
                title = dl.a.get_text()
                title = title[:title.find('[')]
                pattern = re.compile(r'(在售)|(售完)|(未开售)|(未开盘)')
                title = pattern.sub(r'', title)
                price = dl.find_all('dd')[1].get_text()[3:-3]
                if(price == '0'):
                    price = '待定'
                # if(len(price) > 5):
                #     print(title + ':' + price)
                hainanfzinfo[title] = price
        except:
            pass
    file_ = open(path + '/hainanfzinfo.txt', 'w', encoding='utf-8')
    file_.write(json.dumps(hainanfzinfo, ensure_ascii=False))
    file_.close()


def getmeifanginfo():
    '爬取美房网数据，并将按整套售卖的单独提取'
    meifanginfo = {}
    meifanginfo_ = {}
    for i in range(1, 69):
        try:
            url = 'http://hn.meifang.com/list-10-%i.html'
            html = requests.get(url % i)
            soup = BeautifulSoup(html.text, 'lxml')
            list_house = soup.body.find(
                'div', id='list-house').find_all('a', recursive=False)
            for a in list_house:
                title = a['title']
                price = a.div.contents[11].get_text()
                pattern = re.compile(r'(含精装修)|(元/m²)|(元/㎡)')
                price = pattern.sub(r'', price)
                # if(len(price.strip()) > 5):
                #     print(title + ':' + price.strip())
                if('万元/套' in price):
                    meifanginfo_[title] = price.strip()
                else:
                    meifanginfo[title] = price.strip()
        except:
            pass
    file_ = open(path + '/meifanginfo.txt', 'w', encoding='utf-8')
    file_.write(json.dumps(meifanginfo, ensure_ascii=False))
    file_.close()
    file_ = open(path + '/meifanginfo_.txt', 'w', encoding='utf-8')
    file_.write(json.dumps(meifanginfo_, ensure_ascii=False))
    file_.close()


def getdifference():
    '获取美房网价格高于其他网站价格的楼盘列表'
    p1 = Process(target=getmeifanginfo)
    p2 = Process(target=getwofanginfo)
    p3 = Process(target=getpinfanginfo)
    p4 = Process(target=gethainanfzinfo)
    p1.start()
    p2.start()
    p3.start()
    p4.start()
    while True:
        if(not p1.is_alive() and not p2.is_alive() and not p3.is_alive() and not p4.is_alive()):
            file_ = open(path + '/wofanginfo.txt',
                         'r', encoding='utf-8')
            wofanginfo = json.loads(file_.read())
            file_.close()
            file_ = open(path + '/pinfanginfo.txt',
                         'r', encoding='utf-8')
            pinfanginfo = json.loads(file_.read())
            file_.close()
            file_ = open(path + '/hainanfzinfo.txt',
                         'r', encoding='utf-8')
            hainanfzinfo = json.loads(file_.read())
            file_.close()
            file_ = open(path + '/meifanginfo.txt',
                         'r', encoding='utf-8')
            meifanginfo = json.loads(file_.read())
            file_.close()
            for item in meifanginfo:
                compare = Compare()
                compare.title = item
                compare.meifangprice = meifanginfo[item]
                if(item in wofanginfo):
                    compare.wofangprice = wofanginfo[item]
                if(item in pinfanginfo):
                    compare.pinfangprice = pinfanginfo[item]
                if(item in hainanfzinfo):
                    compare.hainanfzprice = hainanfzinfo[item]
                if(compare.compare()):
                    comparelist.append(compare.__dict__)
            break
    file_ = open(path + '/comparelist.txt', 'w', encoding='utf-8')
    file_.write(json.dumps(comparelist, ensure_ascii=False))
    file_.close()
    file_ = open(path + '/errorinfo.txt', 'w', encoding='utf-8')
    file_.write(json.dumps(errorinfo, ensure_ascii=False))
    file_.close()
    # print(json.dumps(comparelist, ensure_ascii=False))
    # print('\n错误信息列表：\n')
    # print(errorinfo)


if __name__ == '__main__':
    getdifference()
