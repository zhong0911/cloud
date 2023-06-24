import requests
import json


def get_balance(api_key):
    url = "https://api.openai-proxy.com/pro/balance"
    params = {'apiKey': api_key}

    response = requests.get(url, params=params)
    json_data = json.loads(response.text)

    if 'data' in json_data:
        data = json_data['data']
        return {"total": data['total'], "balance": data['balance'], "used": data['used']}
    else:
        return None


while True:
    api_key = input("请输入 OpenAI API 密钥：")
    balance = get_balance(api_key)
    if balance is not None:
        print("当前账户: 总共=${}, 剩余=${:.2f}, 已使用=${}".format(balance['total'], balance['balance'], balance['used']))
    else:
        print("发生错误：无法获取账户余额")
