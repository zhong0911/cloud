import openai
import json

keys = ["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"]

for key in keys:
    # 设置OpenAI API密钥
    openai.api_key = "key"
    # 设置请求参数
    prompt = "Hello, how are you?"
    model = "text-davinci-002"
    temperature = 0.5
    max_tokens = 50

    # 发送请求
    response = openai.Completion.create(
        engine=model,
        prompt=prompt,
        temperature=temperature,
        max_tokens=max_tokens
    )

    # 解析响应
    output = response.choices[0].text.strip()

    # 打印输出
    print(output)
