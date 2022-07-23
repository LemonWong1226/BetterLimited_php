from flask import Flask

app = Flask(__name__)

@app.route("/api/<para1>/<para2>")
def process(para1=None, para2=None):
    # processing of request data goes here ...
    discount = int(para1)/100
    total_price = int(para2)
    ans = total_price - (discount * total_price)
    response_data = {"amount": ans}
    return response_data

if __name__ == "__main__":
    app.run(debug=True,
            host='127.0.0.1',
            port=8080)
