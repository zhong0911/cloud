import openai

# while True:
#     try:
#         # 设置OpenAI API Key
#         openai.api_key = [input("请输入APIKey: ")]
#         response = openai.Completion.create(
#             engine="davinci",
#             prompt="Hello, World!",
#             max_tokens=5
#         )
#         print("API Key有效")
#     except Exception as e:
#         print("API Key无效")


with open(r"C:\root\cloud\api\chat\src\keys", encoding='utf-8') as f:
    for (line) in f:
        if line:
            try:
                # 设置OpenAI API Key
                openai.api_key = [line]
                response = openai.Completion.create(
                    engine="davinci",
                    prompt="Hello, World!",
                    max_tokens=5
                )
                print("API Key有效: " + line)
            except Exception as e:
                print("API Key无效: " + line)

print("Done")
