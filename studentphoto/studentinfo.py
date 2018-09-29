import requests
import json
import sys


def SearchStudent(searchkey):
    url = 'http://jwzx.cqu.pt/data/json_StudentSearch.php?searchKey=%s'
    url = url % searchkey
    response = requests.get(url)
    print(response.text)
    # response = json.loads(response.text)
    # for i in range(len(response['returnData'])):
    #     print('第%i位：姓名：%s\t年级：%s\t性别：%s\t学号：%s\t班级：%s\t专业：%s\t学院：%s' % (
    #         i, response['returnData'][i]['xm'], response['returnData'][i]['nj'], response['returnData'][i]['xb'], response['returnData'][i]['xh'], response['returnData'][i]['bj'], response['returnData'][i]['zym'], response['returnData'][i]['yxm']))


def GetStudentPhoto(studentId):
    url = 'http://jwzx.cqu.pt/showstuPic.php?xh=%s'
    print(url % studentId)


def GetCETPhoto(studentId):
    url = 'http://172.22.80.212.cqu.pt/PHOTO0906CET/%s.JPG'
    print(url % studentId)


argv1 = sys.argv[1]
argv2 = sys.argv[2]
if argv1 == 'search' and argv2 is not None:
    SearchStudent(argv2)
elif argv1 == 'student' and argv2 is not None:
    GetStudentPhoto(argv2)
elif argv1 == 'cet' and argv2 is not None:
    GetCETPhoto(argv2)
