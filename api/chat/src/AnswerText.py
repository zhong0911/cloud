import openai
import json

# 设置API密钥
openai.api_key = "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"


def chat(prompt):
    response = openai.ChatCompletion.create(
        model="gpt-3.5-turbo",
        messages=[
            {"role": "user", "content": prompt}
        ]
    )
    answer = response.choices[0].message.content
    return answer


if __name__ == '__main__':
    # prompt='人口最多的国家'
    prompt = input("请输入你的问题： ")
    result = chat(prompt)
    print(result)
