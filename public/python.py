import requests
from bs4 import BeautifulSoup
import time
import re
import os
import json
import sys


class ptt_spider:

    def __init__(self,page):
        self.result_list = []
        self.page=int(page)
        self.cookies = {'over18': '1'}
        self.last_page =''
        self.domain = 'https://www.ptt.cc'
        self.getPage()

    def getPage(self):
        page_list =[]
        post_list=[]

        for i in range(self.page):
            time.sleep(1)

            if self.last_page:
                url= self.domain + self.last_page
            else:
                url = self.domain + "/bbs/Gossiping/index.html"

            web = requests.get(url, cookies=self.cookies)
            soup = BeautifulSoup(web.text, 'lxml')

            if web.status_code == requests.codes.ok:
                target = soup.findAll('div', {'class': 'r-ent'})

                for index,tag in enumerate(target, start=0):

                    post_title = tag.find('div', {'class': 'title'})
                    post_url = post_title.find('a')
                    if post_url:
                        data = self.getPost(post_url .get('href'))
                        result = {
                            'post_index': index,
                            'url': post_url.get('href'),
                            'data': data
                        }
                        post_list.append(result)

            result = {
                'page_index': i,
                'page_url': url,
                'post_list': post_list
            }
            page_list.append(result)
            self.last_page = soup.select('a.wide')[1].get('href')

        print(json.dumps(page_list).encode('cp950').decode('UTF-8'))


    def getPost(self, post_url):
        url = self.domain+post_url
        post_web = requests.get(url, cookies=self.cookies)
        post_soup = BeautifulSoup(post_web.text, 'lxml')

        if post_web.status_code == requests.codes.ok:
            post_body = post_soup.find('div', {'id': 'main-content'})
            results = post_soup.select('span.article-meta-value')

            author = results[0].text
            board = results[1].text
            title = results[2].text
            time = results[3].text
            img_list =[]
            push_list =[]

            post_img = post_body.findAll('a', {'href': re.compile('https://imgur.*')})

            if  post_img :
                for img_item in post_img:
                    img_url=img_item.get('href').replace('https://imgur.com/', 'https://i.imgur.com/')+'.jpg'
                    img_name = img_url.replace('https://i.imgur.com/', '').replace('/', '').replace('\\', '')
                    self.download_img(img_url, img_name)
                    img_list.append(img_name)


            for pushitem in  post_body.findAll('div', {'class': 'push'},limit=5):

                push_tag =pushitem.find('span', {'class': 'push-tag'}).get_text()
                push_userid =pushitem.find('span', {'class': 'push-userid'}) .get_text()
                push_content =pushitem.find('span', {'class': 'push-content'}) .get_text()
                push_ipdatetime =pushitem.find('span', {'class': 'push-ipdatetime'}) .get_text()

                push = {
                    'push_tag': push_tag,
                    'push_userid': push_userid,
                    'push_content': push_content,
                    'push_ipdatetime': push_ipdatetime
                }
                push_list.append(push)

            for child in post_body.findAll():
                child.decompose()

            content = post_body.text.strip()

            result = {
                'author': author,
                'board': board,
                'title': title,
                'time': time,
                'content': content,
                'img_list':img_list,
                'push_list':push_list
            }

            return result

    def download_img(self,img_url, img_name):
        os.makedirs('./img/',exist_ok=True)
        r=requests.get(img_url)
        with open('./img/'+img_name,'wb') as f:
            f.write(r.content)



ptt_spider(sys.argv[1])
