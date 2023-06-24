import openai
import json

# 设置API密钥
openai.api_key = "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"


def image_genaration(prompt):
    response = openai.Image.create(
        prompt=prompt,
        n=1,
        size="1024x1024"
    )
    image_url = response['data'][0]['url']
    return image_url


if __name__ == '__main__':
    prompt = 'a delicious dessert'
    result = image_genaration(prompt)
    print(result)
