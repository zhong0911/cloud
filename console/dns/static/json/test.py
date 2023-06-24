import requests as rq
import time as t
import string
import random


def main():
    num = 0
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'
    }
    for i in range(1, 257):
        for j in range(1, 257):
            for k in range(1, 257):
                for l in range(1, 257):
                    if num == 1000:
                        exit()
                    else:
                        url = f'https://dns.api.cloud.antx.cc/api/record/?action=addrecord&domainName=rwx.asia&RR={generate_random_string(5)}&type=A&value='
                        ip = f"{i}.{j}.{k}.{l}"
                        get = rq.get(url + ip, headers=headers)
                        print(get.text)
                        num += 1


def generate_random_string(length):
    letters = string.ascii_letters + string.digits
    return ''.join(random.choice(letters) for i in range(length))


if __name__ == '__main__':
    main()
