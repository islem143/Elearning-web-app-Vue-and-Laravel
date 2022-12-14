from datetime import datetime

now=datetime.now()
print(now)
s=0
for j in range(0,100000000):
    s=s+j

print("finish")


now=datetime.now()
print(now)